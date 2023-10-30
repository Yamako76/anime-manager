import React from "react";
import Box from "@mui/material/Box";
import Button from "@mui/material/Button";
import TextField from "@mui/material/TextField";
import Dialog from "@mui/material/Dialog";
import DialogActions from "@mui/material/DialogActions";
import DialogContent from "@mui/material/DialogContent";
import DialogTitle from "@mui/material/DialogTitle";
import ClearButton from "./ClearButton";
import { pressEnter } from "@/Components/common/tool";

interface Props {
    taskName: string;
    id: string;
    label: string;
    open: boolean;
    error: boolean;
    errorText: string;
    handleChange: (e) => void;
    handleClose: () => void;
    handleSubmit: () => void;
    handleRefresh: () => void;
    value: string;
    submitButtonName: string;
}

// Objectの追加・編集する画面
// Objectの追加・編集ボタンを押すと新しいObject作成する画面が表示され
// 閉じるまたは追加・編集ボタンを押すと新しいObject作成のキャンセルまたは新しいObject作成が完了する
// @taskName: 実行するtask  (例: 新しいフォルダの作成)
// @submitButtonName: objectの追加・編集の完了するボタンの名前  (例: 追加)
const EditDialog = ({
    taskName,
    id,
    label,
    open,
    error,
    errorText,
    handleChange,
    handleClose,
    handleSubmit,
    handleRefresh,
    value,
    submitButtonName,
}: Props) => {
    return (
        <Box>
            <Dialog open={open} onClose={handleClose}>
                <DialogTitle>{taskName}</DialogTitle>
                <DialogContent>
                    <TextField
                        autoFocus
                        margin="dense"
                        id={id}
                        label={label}
                        fullWidth
                        variant="outlined"
                        helperText={errorText}
                        error={error}
                        onChange={handleChange}
                        onKeyDown={(e) => {
                            pressEnter(e, handleSubmit);
                        }}
                        value={value}
                        InputProps={{
                            endAdornment:
                                value === "" ? null : (
                                    <ClearButton
                                        title="入力のクリア"
                                        handleRefresh={handleRefresh}
                                        fontSize="small"
                                    />
                                ),
                        }}
                    />
                </DialogContent>
                <DialogActions>
                    <Button onClick={handleClose}>閉じる</Button>
                    <Button onClick={handleSubmit}>{submitButtonName}</Button>
                </DialogActions>
            </Dialog>
        </Box>
    );
};

export default EditDialog;
