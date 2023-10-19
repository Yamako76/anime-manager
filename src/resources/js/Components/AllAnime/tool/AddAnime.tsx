import React, {useState} from "react";
import Box from "@mui/material/Box";
import AddAnimeButton from "@/Components/Button/AddAnimeButton";
import {value_validation} from "../../common/tool";
import axios from "axios";
import ApiCommunicationSuccess from "@/Components/common/ApiCommunicationSuccess";
import ApiCommunicationFailed from "@/Components/common/ApiCommunicationFailed";

interface Props {
    handleReload: () => void;
}

const AddAnime = ({handleReload}: Props) => {
    const [open, setOpen] = useState(false);
    const [error, setError] = useState(false);
    const [nameValue, setNameValue] = useState("");
    const [memoValue, setMemoValue] = useState("");
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
        setNameValue("");
        handleErrorRefresh();
    };

    const memoHandleRefresh = () => {
        setMemoValue("");
    };

    const handleClickOpen = () => {
        setOpen(true);
    };

    const handleClose = () => {
        setOpen(false);
        handleRefresh();
        memoHandleRefresh();
        handleErrorRefresh();
    };

    const handleChange = (e) => {
        setNameValue(e.target.value);
        if (value_validation(e.target.value)) {
            handleErrorRefresh();
        } else {
            handleError(errorMessage);
        }
    };

    const memoHandleChange = (e) => {
        setMemoValue(e.target.value);
    };

    const handleSubmit = () => {
        if (value_validation(nameValue)) {
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
    }

    const handleSnackbarFailed = () => {
        setIsFailedSnackbar(true);
    }

    const createAnime = () => {
        const abortCtrl = new AbortController();
        const timeout = setTimeout(() => {
            abortCtrl.abort();
        }, 10000);
        axios
            .post(
                `/api/anime-list/`,
                {
                    name: nameValue.trim(),
                    memo: memoValue,
                },
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
                <AddAnimeButton
                    taskName="新しいアニメの作成"
                    id="newItemName"
                    label="新しいアニメ名"
                    open={open}
                    error={error}
                    errorText={errorText}
                    handleClickOpen={handleClickOpen}
                    handleChange={handleChange}
                    handleClose={handleClose}
                    handleSubmit={handleSubmit}
                    handleRefresh={handleRefresh}
                    nameValue={nameValue}
                    submitButtonName="追加"
                    memoId="newMemoName"
                    memoLabel="メモ"
                    memoValue={memoValue}
                    memoHandleChange={memoHandleChange}
                    memoHandleRefresh={memoHandleRefresh}
                />
            </Box>
            {isSuccessSnackbar && <ApiCommunicationSuccess message={"アニメの追加が完了しました"}
                                                           handleSnackbarClose={handleSuccessSnackbarClose}
                                                           isSnackbar={isSuccessSnackbar}
            />}
            {isFailedSnackbar && <ApiCommunicationFailed message={"アニメの追加に失敗しました"}
                                                         handleSnackbarClose={handleFailedSnackbarClose}
                                                         isSnackbar={isFailedSnackbar}
            />}
        </>
    );
};

export default AddAnime;
