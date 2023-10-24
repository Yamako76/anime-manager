import React from "react";
import Box from "@mui/material/Box";
import EditDialog from "./EditDialog";
import IconButton from "@mui/material/IconButton";
import AddIcon from "@mui/icons-material/Add";
import Tooltip from "@mui/material/Tooltip";

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
}

const AddButton = ({
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
                       sx,
                   }: Props) => {
    return (
        <Box>
            <Tooltip title={taskName}>
                <IconButton
                    onClick={handleClickOpen}
                    disableFocusRipple={true}
                    sx={sx}
                >
                    <AddIcon/>
                </IconButton>
            </Tooltip>

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

export default AddButton;
