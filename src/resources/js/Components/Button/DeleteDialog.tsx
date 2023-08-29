import React from "react";
import Box from "@mui/material/Box";
import Button from "@mui/material/Button";
import Dialog from "@mui/material/Dialog";
import DialogActions from "@mui/material/DialogActions";
import DialogContent from "@mui/material/DialogContent";
import DialogContentText from "@mui/material/DialogContentText";
import DialogTitle from "@mui/material/DialogTitle";

const DeleteDialog = ({
    task_name,
    content_text,
    open,
    handleClose,
    handleSubmit,
}) => {
    return (
        <Box>
            <Dialog open={open} onClose={handleClose}>
                <DialogTitle>{task_name}</DialogTitle>
                <DialogContent>
                    <DialogContentText>{content_text}</DialogContentText>
                </DialogContent>
                <DialogActions>
                    <Button onClick={handleClose}>閉じる</Button>
                    {/*{*/}
                    {/*    (state.current_folderId === String(folder_key))*/}
                    {/*        ? <Button component={Link} to="/app/home" onClick={handleSubmit}>削除</Button>*/}
                    {/*        : <Button onClick={handleSubmit}>削除</Button>*/}
                    {/*}*/}
                    <Button onClick={handleSubmit}>削除</Button>
                </DialogActions>
            </Dialog>
        </Box>
    );
};

export default DeleteDialog;
