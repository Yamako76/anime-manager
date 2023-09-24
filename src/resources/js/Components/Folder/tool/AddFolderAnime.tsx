import React, { useContext, useState } from "react";
import Box from "@mui/material/Box";
import { value_validation } from "../../common/tool";
import { NoticeContext } from "../../common/Notification";
import axios from "axios";
import AddButton from "@/Components/Button/AddButton";

interface Props {
    folderName: string;
    handleReload: () => void;
}

const AddFolderAnime = ({ handleReload, folderName }: Props) => {
    const [open, setOpen] = useState(false);
    const [error, setError] = useState(false);
    const [animeNameValue, setAnimeNameValue] = useState("");
    const [errorText, setErrorText] = useState("");
    const [state, dispatch] = useContext(NoticeContext);
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
        setAnimeNameValue("");
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
        setAnimeNameValue(e.target.value);
        if (value_validation(e.target.value)) {
            handleErrorRefresh();
        } else {
            handleError(errorMessage);
        }
    };

    const handleSubmit = () => {
        if (value_validation(animeNameValue)) {
            createAnime();
            handleClose();
        } else {
            handleError(errorMessage);
        }
    };

    // const ApiAfterAction = (payload) => {
    //     dispatch({ type: "update_message", payload: payload });
    //     dispatch({ type: "handleNoticeOpen" });
    //     handleReload();
    // };

    const createAnime = () => {
        const abortCtrl = new AbortController();
        const timeout = setTimeout(() => {
            abortCtrl.abort();
        }, 10000);
        axios
            .post(
                // TODO ${folderId}に変更
                `/api/folders/1/anime-list`,
                {
                    folderName: folderName,
                    animeName: animeNameValue,
                },
                { signal: abortCtrl.signal }
            )
            .then(() => {
                // ApiAfterAction("アニメの追加が完了しました");
            })
            .catch(() => {
                // ApiAfterAction("アニメの追加に失敗しました");
            })
            .finally(() => {
                clearTimeout(timeout);
            });
    };

    return (
        <Box>
            <AddButton
                button_name="アニメの追加"
                task_name="フォルダにアニメの追加"
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
                value={animeNameValue}
                submit_button_name="追加"
            />
        </Box>
    );
};

export default AddFolderAnime;
