import React from "react";
import Box from "@mui/material/Box";
import Button from "@mui/material/Button";
import EditDialog from "./EditDialog";
import IconButton from "@mui/material/IconButton";
import AddIcon from "@mui/icons-material/Add";
import Tooltip from "@mui/material/Tooltip";

const AddButton = ({
    task_name,
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
    submit_button_name,
    sx,
}) => {
    return (
        <Box>
            <Tooltip title={task_name}>
                <IconButton
                    onClick={handleClickOpen}
                    disableFocusRipple={true}
                    sx={sx}
                >
                    <AddIcon />
                </IconButton>
            </Tooltip>

            <EditDialog
                task_name={task_name}
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
                submit_button_name={submit_button_name}
            />
        </Box>
    );
};

export default AddButton;
