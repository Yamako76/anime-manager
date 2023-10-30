import React from "react";
import Box from "@mui/material/Box";
import Button from "@mui/material/Button";
import Dialog from "@mui/material/Dialog";
import DialogActions from "@mui/material/DialogActions";
import DialogContent from "@mui/material/DialogContent";
import DialogContentText from "@mui/material/DialogContentText";
import DialogTitle from "@mui/material/DialogTitle";

interface Props {
    taskName: string;
    contentText: string;
    open: boolean;
    handleClose: () => void;
    handleSubmit: () => void;
}

// Object削除の確認Dialog
// 閉じるを押せば削除キャンセル
// 削除を押せば選択objectを削除
// @content_text: Dialogに表示する説明文
const DeleteDialog = ({
                          taskName,
                          contentText,
                          open,
                          handleClose,
                          handleSubmit,
                      }: Props) => {
    return (
        <Box>
            <Dialog open={open} onClose={handleClose}>
                <DialogTitle>{taskName}</DialogTitle>
                <DialogContent>
                    <DialogContentText>{contentText}</DialogContentText>
                </DialogContent>
                <DialogActions>
                    <Button onClick={handleClose}>閉じる</Button>
                    <Button onClick={handleSubmit}>削除</Button>
                </DialogActions>
            </Dialog>
        </Box>
    );
};

export default DeleteDialog;
