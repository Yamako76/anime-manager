import React from "react";
import Dialog from "@mui/material/Dialog";
import DialogTitle from "@mui/material/DialogTitle";
import DialogContent from "@mui/material/DialogContent";
import DialogActions from "@mui/material/DialogActions";
import Button from "@mui/material/Button";


interface Props {
    isDialog: boolean;
    handleDialogClose: () => void;
    message: string;
}

// API通信時に失敗したときにDialogを表示
const ApiErrorDialog = ({isDialog, handleDialogClose, message}: Props) => {
    return (
        <div>
            <Dialog open={isDialog} onClose={handleDialogClose}>
                <DialogTitle>通信エラー</DialogTitle>
                <DialogContent>
                    <p>{message}</p>
                </DialogContent>
                <DialogActions>
                    <Button onClick={handleDialogClose} color="primary">
                        閉じる
                    </Button>
                </DialogActions>
            </Dialog>
        </div>
    );
};

export default ApiErrorDialog;
