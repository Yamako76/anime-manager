import React from "react";
import Box from "@mui/material/Box";
import {IconButton} from "@mui/material";
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
    size: "small" | "medium" | "large"; // サイズの選択肢に合わせて調整してください
}

const DeleteButton = ({
                          taskName,
                          contentText,
                          open,
                          handleClickOpen,
                          handleClose,
                          handleSubmit,
                          aria_label,
                          size,
                      }: Props, sx) => {
    return (
        <Box>
            <IconButton
                onClick={handleClickOpen}
                aria-label={aria_label}
                disableFocusRipple={true}
                size={size}
                sx={sx}
            >
                <DeleteIcon/>
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
