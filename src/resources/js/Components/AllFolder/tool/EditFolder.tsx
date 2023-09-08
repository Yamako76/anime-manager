import React, { useContext, useState } from "react";
import Box from "@mui/material/Box";
import EditButton from "@/Components/Button/EditButton";
import { value_validation } from "@/Components/common/tool";
import { NoticeContext } from "@/Components/common/Notification";
import {grey} from "@mui/material/colors";

// フォルダ編集機能 //
// フォルダの編集ボタンを押すとフォルダを編集する画面が表示され
// 閉じるまたは編集ボタンを押すとフォルダ編集のキャンセルまたはフォルダ編集が完了する
// 入力は1字以上200字以下で制限する
interface Props {
    folder: string;
}

const EditFolder = ({ folder }: Props) => {
    const [open, setOpen] = useState(false);
    const [error, setError] = useState(false);
    const [value, setValue] = useState(folder);
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
        setValue("");
        handleErrorRefresh();
    };

    const handleClickOpen = () => {
        setOpen(true);
    };

    const handleClose = () => {
        setOpen(false);
        setValue(folder);
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
            handleClose();
        } else {
            handleError(errorMessage);
        }
    };

    return (
        <Box>
            <EditButton
                task_name="フォルダの編集"
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
                submit_button_name="完了"
                aria_label="edit_folder"
                size="small"
                sx={{ "&:hover": { color: grey[900] } }}
            />
        </Box>
    );
};

export default EditFolder;
