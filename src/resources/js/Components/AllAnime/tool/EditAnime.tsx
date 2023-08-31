import React, { useContext, useState } from "react";
import Box from "@mui/material/Box";
import EditAnimeButton from "@/Components/Button/EditAnimeButton";
import { value_validation } from "../../common/tool";
import EditIcon from "@mui/icons-material/Edit";
import { grey } from "@mui/material/colors";
import { NoticeContext } from "@/Components/common/Notification";

const EditAnime = ({ name, memo }) => {
    const [open, setOpen] = useState(false);
    const [error, setError] = useState(false);
    const [nameValue, setNameValue] = useState(name);
    const [memoValue, setMemoValue] = useState(memo);
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
            handleClose();
        } else {
            handleError(errorMessage);
        }
    };

    return (
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
    );
};

export default EditAnime;
