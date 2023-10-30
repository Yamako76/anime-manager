import React, { useState } from "react";
import Box from "@mui/material/Box";
import { value_validation } from "../../common/tool";
import axios from "axios";
import AddButton from "@/Components/Button/AddButton";
import ApiCommunicationSuccess from "@/Components/common/ApiCommunicationSuccess";
import ApiCommunicationFailed from "@/Components/common/ApiCommunicationFailed";

interface Props {
    folderName: string;
    id: number;
    handleReload: () => void;
}

// フォルダ内のアニメ追加機能
// アニメの追加ボタンを押すと新しいアニメを作成する画面が表示され
// 閉じるまたは追加ボタンを押すと新しいアニメ作成のキャンセルまたは新しいアニメ作成が完了する
// 入力は1字以上200字以下で制限する
const AddFolderAnime = ({ handleReload, folderName, id }: Props) => {
    const [open, setOpen] = useState<boolean>(false);
    const [error, setError] = useState<boolean>(false);
    const [value, setValue] = useState<string>("");
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
            createAnime();
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
    };

    const handleSnackbarFailed = () => {
        setIsFailedSnackbar(true);
    };

    const createAnime = () => {
        const abortCtrl = new AbortController();
        const timeout = setTimeout(() => {
            abortCtrl.abort();
        }, 10000);
        axios
            .post(
                `/api/folders/${id}/anime-list`,
                {
                    folderName: folderName,
                    animeName: value,
                },
                { signal: abortCtrl.signal }
            )
            .then(() => {
                handleSnackbarSuccess();
            })
            .catch(() => {
                handleSnackbarFailed();
            })
            .finally(() => {
                clearTimeout(timeout);
            });
    };

    return (
        <>
            <Box>
                <AddButton
                    taskName="フォルダにアニメの追加"
                    id="new_folder_name"
                    label="新しいアニメ名"
                    open={open}
                    error={error}
                    errorText={errorText}
                    handleClickOpen={handleClickOpen}
                    handleChange={handleChange}
                    handleClose={handleClose}
                    handleSubmit={handleSubmit}
                    handleRefresh={handleRefresh}
                    value={value}
                    submitButtonName="追加"
                />
            </Box>
            {isSuccessSnackbar && (
                <ApiCommunicationSuccess
                    message={"アニメの追加が完了しました"}
                    handleSnackbarClose={handleSuccessSnackbarClose}
                    isSnackbar={isSuccessSnackbar}
                />
            )}
            {isFailedSnackbar && (
                <ApiCommunicationFailed
                    message={"アニメの追加に失敗しました"}
                    handleSnackbarClose={handleFailedSnackbarClose}
                    isSnackbar={isFailedSnackbar}
                />
            )}
        </>
    );
};

export default AddFolderAnime;
