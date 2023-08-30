import React, { useState } from "react";
import Box from "@mui/material/Box";
import AddButton from "@/Components/Button/AddButton";
import { value_validation } from "@/Components/common/tool";

// フォルダ追加機能
// フォルダの追加ボタンを押すと新しいフォルダ作成する画面が表示され
// 閉じるまたは追加ボタンを押すと新しいフォルダ作成のキャンセルまたは新しいフォルダ作成が完了する
// 入力は1字以上200字以下で制限する
const AddFolder = ({ handleReload }) => {
    const [open, setOpen] = useState(false);
    const [error, setError] = useState(false);
    const [value, setValue] = useState("");
    const [errorText, setErrorText] = useState("");
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
            handleClose();
        } else {
            handleError(errorMessage);
        }
    };

    return (
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
    );
};

export default AddFolder;
