import React, { useContext, useState } from "react";
import Box from "@mui/material/Box";
import DeleteButton from "@/Components/Button/DeleteButton";
import { NoticeContext } from "@/Components/common/Notification";

const DeleteFolder = (handleReload) => {
    const [open, setOpen] = useState(false);
    const [state, dispatch] = useContext(NoticeContext);

    const handleClickOpen = () => {
        setOpen(true);
    };

    const handleClose = () => {
        setOpen(false);
    };

    const handleSubmit = () => {
        handleClose();
    };

    // const ApiAfterAction = (payload) => {
    //     dispatch({ type: "update_message", payload: payload });
    //     dispatch({ type: "handleNoticeOpen" });
    //     handleReload();
    // };

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