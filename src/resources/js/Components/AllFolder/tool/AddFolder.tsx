import React, {useState} from "react";
import Box from "@mui/material/Box";
import AddButton from "@/Components/Button/AddButton";
import {value_validation} from "@/Components/common/tool";
import axios from "axios";
import ApiCommunicationSuccess from "@/Components/common/ApiCommunicationSuccess";
import ApiCommunicationFailed from "@/Components/common/ApiCommunicationFailed";

// フォルダ追加機能
// フォルダの追加ボタンを押すと新しいフォルダ作成する画面が表示され
// 閉じるまたは追加ボタンを押すと新しいフォルダ作成のキャンセルまたは新しいフォルダ作成が完了する
// 入力は1字以上200字以下で制限する
const AddFolder = ({handleReload}) => {
    const [open, setOpen] = useState(false);
    const [error, setError] = useState(false);
    const [value, setValue] = useState("");
    const [errorText, setErrorText] = useState("");
    const [isSuccessSnackbar, setIsSuccessSnackbar] = useState(false);
    const [isFailedSnackbar, setIsFailedSnackbar] = useState(false);
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
            createFolder();
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

    const createFolder = () => {
        const abortCtrl = new AbortController();
        const timeout = setTimeout(() => {
            abortCtrl.abort();
        }, 10000);
        axios
            .post(
                "/api/folders",
                {name: value.trim()},
                {signal: abortCtrl.signal}
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
                    button_name="フォルダの追加"
                    task_name="新しいフォルダの作成"
                    id="new_folder_name"
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
                    submit_button_name="追加"
                />
            </Box>
            {isSuccessSnackbar && <ApiCommunicationSuccess message={"フォルダの追加が完了しました"}
                                                           handleSnackbarClose={handleSuccessSnackbarClose}
                                                           isSnackbar={isSuccessSnackbar}
            />}
            {isFailedSnackbar && <ApiCommunicationFailed message={"フォルダの追加に失敗しました"}
                                                         handleSnackbarClose={handleFailedSnackbarClose}
                                                         isSnackbar={isFailedSnackbar}
            />}
        </>
    );
};

export default AddFolder;
