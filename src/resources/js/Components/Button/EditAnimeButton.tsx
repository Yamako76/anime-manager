import React from "react";
import Box from "@mui/material/Box";
import EditAnimeDialog from "@/Components/Button/EditAnimeDialog";
import Button from "@mui/material/Button";

const EditAnimeButton = ({
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
    nameValue,
    submitButtonName,
    ariaLabel,
    size,
    sx,
    memoId,
    memoValue,
    memoLabel,
    memoHandleChange,
    startIcon,
}) => {
    return (
        <Box>
            <Button
                onClick={handleClickOpen}
                aria-label={ariaLabel}
                disableFocusRipple={true}
                size={size}
                sx={sx}
                startIcon={startIcon}
                color="inherit"
            >
                編集
            </Button>
            <EditAnimeDialog
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
                nameValue={nameValue}
                submitButtonName={submitButtonName}
                memoId={memoId}
                memoValue={memoValue}
                memoLabel={memoLabel}
                memoHandleChange={memoHandleChange}
            />
        </Box>
    );
};

export default EditAnimeButton;
