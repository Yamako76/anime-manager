import React from "react";
import Box from "@mui/material/Box";
import { IconButton } from "@mui/material";
import DeleteIcon from "@mui/icons-material/Delete";
import DeleteDialog from "./DeleteDialog";

const DeleteButton = ({
    task_name,
    content_text,
    open,
    handleClickOpen,
    handleClose,
    handleSubmit,
    aria_label,
    size,
    folder_key,
    sx,
}) => {
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
                task_name={task_name}
                content_text={content_text}
                open={open}
                handleClose={handleClose}
                handleSubmit={handleSubmit}
                folder_key={folder_key}
            />
        </Box>
    );
};

export default DeleteButton;
