import React from "react";
import Box from "@mui/material/Box";
import {IconButton} from "@mui/material";
import EditIcon from "@mui/icons-material/Edit";
import EditDialog from "./EditDialog";

interface Props {
    taskName: string;
    id: string;
    label: string;
    open: boolean;
    error: boolean;
    errorText: string;
    handleClickOpen: () => void;
    handleChange: (e) => void;
    handleClose: () => void;
    handleSubmit: () => void;
    handleRefresh: () => void;
    value: string;
    submitButtonName: string;
    aria_label: string;
    size: "small";
    sx: { [key: string]: any };
}

const EditButton = ({
                        taskName,
                        id,
                        label,
                        open,
                        error,
                        errorText,
                        handleClickOpen,
                        handleChange,
                        handleClose,
                        handleSubmit,
                        handleRefresh,
                        value,
                        submitButtonName,
                        aria_label,
                        size,
                        sx,
                    }: Props) => {
    return (
        <Box>
            <IconButton
                onClick={handleClickOpen}
                aria-label={aria_label}
                disableFocusRipple={true}
                size={size}
                sx={sx}
            >
                <EditIcon/>
            </IconButton>
            <EditDialog
                taskName={taskName}
                id={id}
                label={label}
                open={open}
                error={error}
                errorText={errorText}
                handleChange={handleChange}
                handleClose={handleClose}
                handleSubmit={handleSubmit}
                handleRefresh={handleRefresh}
                value={value}
                submitButtonName={submitButtonName}
            />
        </Box>
    );
};

export default EditButton;
