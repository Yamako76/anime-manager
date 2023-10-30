import React, { useState } from "react";
import Box from "@mui/material/Box";
import DeleteButton from "@/Components/Button/DeleteButton";
import axios from "axios";
import ApiCommunicationSuccess from "@/Components/common/ApiCommunicationSuccess";
import ApiCommunicationFailed from "@/Components/common/ApiCommunicationFailed";
import { Folder } from "@/Components/Folder";

interface Props {
    handleReload: () => void;
    folder: Folder;
}

// フォルダ削除機能
// フォルダの削除ボタンを押すと削除画面が表示され
// 閉じるまたは削除ボタンを押すと削除のキャンセルまたは削除が完了する
const DeleteFolder = ({ handleReload, folder }: Props) => {
    const [open, setOpen] = useState<boolean>(false);
    const [isSuccessSnackbar, setIsSuccessSnackbar] = useState<boolean>(false);
    const [isFailedSnackbar, setIsFailedSnackbar] = useState<boolean>(false);

    const handleClickOpen = () => {
        setOpen(true);
    };

    const handleClose = () => {
        setOpen(false);
    };

    const handleSubmit = () => {
        deleteFolder();
        handleClose();
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

    const deleteFolder = () => {
        const abortCtrl = new AbortController();
        const timeout = setTimeout(() => {
            abortCtrl.abort();
        }, 10000);
        axios
            .delete(`/api/folders/${folder.id}`, { signal: abortCtrl.signal })
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
                <DeleteButton
                    taskName="フォルダの削除"
                    contentText="本当にフォルダの削除を行いますか？"
                    open={open}
                    handleClickOpen={handleClickOpen}
                    handleClose={handleClose}
                    handleSubmit={handleSubmit}
                    aria_label="delete item"
                    size="small"
                />
            </Box>
            {isSuccessSnackbar && (
                <ApiCommunicationSuccess
                    message={`フォルダ(${folder.name})の削除が完了しました`}
                    handleSnackbarClose={handleSuccessSnackbarClose}
                    isSnackbar={isSuccessSnackbar}
                />
            )}
            {isFailedSnackbar && (
                <ApiCommunicationFailed
                    message={`フォルダ(${folder.name})の削除に失敗しました`}
                    handleSnackbarClose={handleFailedSnackbarClose}
                    isSnackbar={isFailedSnackbar}
                />
            )}
        </>
    );
};

export default DeleteFolder;
