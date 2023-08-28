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
    submit_button_name,
}) => {
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
                    <Button onClick={handleSubmit}>{submit_button_name}</Button>
                </DialogActions>
            </Dialog>
        </Box>
    );
};

export default EditDialog;
