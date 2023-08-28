import React from "react";
import Box from "@mui/material/Box";
import Button from "@mui/material/Button";
import EditDialog from "./EditDialog";

const AddButton = ({
    startIcon,
    button_name,
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
            <Button
                startIcon={startIcon}
                onClick={handleClickOpen}
                disableFocusRipple={true}
                sx={sx}
            >
                {button_name}
            </Button>

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
