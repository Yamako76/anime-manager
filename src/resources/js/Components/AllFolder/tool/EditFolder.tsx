import React, {useState} from "react";
import Box from "@mui/material/Box";
import EditButton from "@/Components/Button/EditButton";
import {value_validation} from "@/Components/common/tool";
import {grey} from "@mui/material/colors";
import axios from "axios";
import ApiCommunicationSuccess from "@/Components/common/ApiCommunicationSuccess";
import ApiCommunicationFailed from "@/Components/common/ApiCommunicationFailed";
import {Folder} from "@/Components/Folder";

// フォルダ編集機能
// フォルダの編集ボタンを押すとフォルダを編集する画面が表示され
// 閉じるまたは編集ボタンを押すとフォルダ編集のキャンセルまたはフォルダ編集が完了する
// 入力は1字以上200字以下で制限する


interface Props {
    folder: Folder;
    handleReload: () => void;
}

const EditFolder = ({folder, handleReload}: Props) => {
    const [open, setOpen] = useState<boolean>(false);
    const [error, setError] = useState<boolean>(false);
    const [value, setValue] = useState<string>(folder.name);
    const [errorText, setErrorText] = useState<string>("");
    const [isSuccessSnackbar, setIsSuccessSnackbar] = useState<boolean>(false);
    const [isFailedSnackbar, setIsFailedSnackbar] = useState<boolean>(false);
    const errorMessage = "1字以上200字以下で記入してください。";

    const handleErrorRefresh = () => {
        setErrorText("");
        setError(false);
    };

    const handleError = (errorMessage) => {
        setErrorText(errorMessage);
        setError(true);
    };

    const handleRefresh = () => {
        setValue("");
        handleErrorRefresh();
    };

    const handleClickOpen = () => {
        setOpen(true);
    };

    const handleClose = () => {
        setOpen(false);
        setValue(folder.name);
        handleRefresh();
        handleErrorRefresh();
    };

    const handleChange = (e) => {
        setValue(e.target.value);
        if (value_validation(e.target.value)) {
            handleErrorRefresh();
        } else {
            handleError(errorMessage);
        }
    };

    const handleSubmit = () => {
        if (value_validation(value)) {
            updateFolder();
            handleClose();
        } else {
            handleError(errorMessage);
        }
    };

    const handleSuccessSnackbarClose = () => {
        setIsSuccessSnackbar(false);
        handleReload();
    };

    const handleFailedSnackbarClose = () => {
        setIsFailedSnackbar(false);
        handleReload();
    };

    const handleSnackbarSuccess = () => {
        setIsSuccessSnackbar(true);
    }

    const handleSnackbarFailed = () => {
        setIsFailedSnackbar(true);
    }

    const updateFolder = () => {
        const abortCtrl = new AbortController()
        const timeout = setTimeout(() => {
            abortCtrl.abort()
        }, 10000);
        axios
            .put(`/api/folders/${folder.id}`, {
                name: value.trim(),
            }, {signal: abortCtrl.signal})
            .then(() => {
                handleSnackbarSuccess();
            })
            .catch(() => {
                handleSnackbarFailed();
            })
            .finally(() => {
                clearTimeout(timeout);
            })
    }

    return (
        <>
            <Box>
                <EditButton
                    taskName="フォルダの編集"
                    id="edit folder"
                    label="新しいフォルダ名"
                    open={open}
                    error={error}
                    errorText={errorText}
                    handleClickOpen={handleClickOpen}
                    handleChange={handleChange}
                    handleClose={handleClose}
                    handleSubmit={handleSubmit}
                    handleRefresh={handleRefresh}
                    value={value}
                    submitButtonName="完了"
                    aria_label="edit_folder"
                    size="small"
                    sx={{"&:hover": {color: grey[900]}}}
                />
            </Box>
            {isSuccessSnackbar && <ApiCommunicationSuccess message={`フォルダ(${folder.name})の更新が完了しました`}
                                                           handleSnackbarClose={handleSuccessSnackbarClose}
                                                           isSnackbar={isSuccessSnackbar}
            />}
            {isFailedSnackbar && <ApiCommunicationFailed message={`フォルダ(${folder.name})の更新が失敗しました`}
                                                         handleSnackbarClose={handleFailedSnackbarClose}
                                                         isSnackbar={isFailedSnackbar}
            />}
        </>
    );
};

export default EditFolder;
