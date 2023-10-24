import React, {useState} from "react";
import Box from "@mui/material/Box";
import DeleteButton from "@/Components/Button/DeleteButton";
import axios from "axios";
import ApiCommunicationSuccess from "@/Components/common/ApiCommunicationSuccess";
import ApiCommunicationFailed from "@/Components/common/ApiCommunicationFailed";

type Anime = {
    created_at: string;
    deleted_at: string | null;
    id: number;
    latest_changed_at: string;
    memo: string;
    name: string;
    status: "active" | "deleted";
    updated_at: string;
    user_id: number;
};

interface Props {
    handleReload: () => void;
    anime: Anime;
}

const DeleteAnime = ({handleReload, anime}: Props) => {
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
        deleteAnime();
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
    }

    const handleSnackbarFailed = () => {
        setIsFailedSnackbar(true);
    }

    const deleteAnime = () => {
        const abortCtrl = new AbortController()
        const timeout = setTimeout(() => {
            abortCtrl.abort()
        }, 10000);
        axios
            .delete(`/api/anime-list/${anime.id}`, {signal: abortCtrl.signal})
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
                <DeleteButton
                    taskName="アニメの削除"
                    contentText="本当にアニメの削除を行いますか？"
                    open={open}
                    handleClickOpen={handleClickOpen}
                    handleClose={handleClose}
                    handleSubmit={handleSubmit}
                    aria_label="delete item"
                    size="small"
                />
            </Box>
            {isSuccessSnackbar && <ApiCommunicationSuccess message={`アニメ(${anime.name})の削除が完了しました`}
                                                           handleSnackbarClose={handleSuccessSnackbarClose}
                                                           isSnackbar={isSuccessSnackbar}
            />}
            {isFailedSnackbar && <ApiCommunicationFailed message={`アニメ(${anime.name})の削除に失敗しました`}
                                                         handleSnackbarClose={handleFailedSnackbarClose}
                                                         isSnackbar={isFailedSnackbar}
            />}
        </>
    );
};

export default DeleteAnime;
