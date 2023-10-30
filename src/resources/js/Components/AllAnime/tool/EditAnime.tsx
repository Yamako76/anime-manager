import React, { useState } from "react";
import Box from "@mui/material/Box";
import EditAnimeButton from "@/Components/Button/EditAnimeButton";
import { value_validation } from "../../common/tool";
import EditIcon from "@mui/icons-material/Edit";
import { grey } from "@mui/material/colors";
import axios from "axios";
import ApiCommunicationSuccess from "@/Components/common/ApiCommunicationSuccess";
import ApiCommunicationFailed from "@/Components/common/ApiCommunicationFailed";

interface AnimeProps {
    name: string;
    memo: string;
    id: number;
}

// アニメ編集機能
// アニメの編集ボタンを押すとアニメを編集する画面が表示され
// 閉じるまたは編集ボタンを押すとアニメ編集のキャンセルまたはアニメ編集が完了する
// 入力は1字以上200字以下で制限する
const EditAnime = ({ name, memo, id }: AnimeProps) => {
    const [open, setOpen] = useState<boolean>(false);
    const [error, setError] = useState<boolean>(false);
    const [nameValue, setNameValue] = useState<string>(name);
    const [memoValue, setMemoValue] = useState<string>(memo);
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
        setNameValue("");
        handleErrorRefresh();
    };

    const handleClickOpen = () => {
        setOpen(true);
    };

    const handleClose = () => {
        setOpen(false);
        setNameValue(name);
        setMemoValue(memo);
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
            updateAnime();
            handleClose();
        } else {
            handleError(errorMessage);
        }
    };

    const handleSuccessSnackbarClose = () => {
        setIsSuccessSnackbar(false);
        location.reload();
    };

    const handleFailedSnackbarClose = () => {
        setIsFailedSnackbar(false);
        location.reload();
    };

    const handleSnackbarSuccess = () => {
        setIsSuccessSnackbar(true);
    };

    const handleSnackbarFailed = () => {
        setIsFailedSnackbar(true);
    };

    const updateAnime = () => {
        const abortCtrl = new AbortController();
        const timeout = setTimeout(() => {
            abortCtrl.abort();
        }, 10000);
        axios
            .put(
                `/api/anime-list/${id}`,
                {
                    name: nameValue.trim(),
                    memo: memoValue,
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
                <EditAnimeButton
                    taskName="アニメの編集"
                    id="edit item"
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
                    submitButtonName="完了"
                    ariaLabel="edit_item"
                    size="small"
                    memoId="edit memo"
                    memoLabel="メモ"
                    memoValue={memoValue}
                    memoHandleChange={memoHandleChange}
                    startIcon={<EditIcon />}
                    sx={{ "&:hover": { color: grey[900] } }}
                />
            </Box>
            {isSuccessSnackbar && (
                <ApiCommunicationSuccess
                    message={`アニメ(${name})の更新が完了しました`}
                    handleSnackbarClose={handleSuccessSnackbarClose}
                    isSnackbar={isSuccessSnackbar}
                />
            )}
            {isFailedSnackbar && (
                <ApiCommunicationFailed
                    message={`アニメ(${name})の更新が失敗しました`}
                    handleSnackbarClose={handleFailedSnackbarClose}
                    isSnackbar={isFailedSnackbar}
                />
            )}
        </>
    );
};

export default EditAnime;
