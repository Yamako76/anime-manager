import React from "react";
import Box from "@mui/material/Box";
import { IconButton } from "@mui/material";
import DeleteIcon from "@mui/icons-material/Delete";
import DeleteDialog from "./DeleteDialog";

interface Props {
    taskName: string;
    contentText: string;
    open: boolean;
    handleClickOpen: () => void;
    handleClose: () => void;
    handleSubmit: () => void;
    aria_label: string;
    size: "small";
}

// Objectの削除を行う画面を表するためのボタン
// ボタンを押すと削除画面を表示し
// 再度, ボタンを押すと閉じる
const DeleteButton = (
    {
        taskName,
        contentText,
        open,
        handleClickOpen,
        handleClose,
        handleSubmit,
        aria_label,
        size,
    }: Props,
    sx
) => {
    return (
        <Box>
            <IconButton
                onClick={handleClickOpen}
                aria-label={aria_label}
                disableFocusRipple={true}
                size={size}
                sx={sx}
            >
                <DeleteIcon />
            </IconButton>
            <DeleteDialog
                taskName={taskName}
                contentText={contentText}
                open={open}
                handleClose={handleClose}
                handleSubmit={handleSubmit}
            />
        </Box>
    );
};

export default DeleteButton;
