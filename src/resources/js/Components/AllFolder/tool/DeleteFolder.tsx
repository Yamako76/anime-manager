import React, { useState } from "react";
import Box from "@mui/material/Box";
import DeleteButton from "@/Components/Button/DeleteButton";

const DeleteFolder = () => {
    const [open, setOpen] = useState(false);

    const handleClickOpen = () => {
        setOpen(true);
    };

    const handleClose = () => {
        setOpen(false);
    };

    const handleSubmit = () => {
        handleClose();
    };

    return (
        <Box>
            <DeleteButton
                task_name="フォルダの削除"
                content_text="本当にフォルダの削除を行いますか？"
                open={open}
                handleClickOpen={handleClickOpen}
                handleClose={handleClose}
                handleSubmit={handleSubmit}
                aria_label="delete item"
                size="small"
            />
        </Box>
    );
};

export default DeleteFolder;
