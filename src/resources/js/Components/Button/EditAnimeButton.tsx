import React from "react";
import Box from "@mui/material/Box";
import EditAnimeDialog from "@/Components/Button/EditAnimeDialog";
import Button from "@mui/material/Button";


interface Props {
    taskName: string;
    id: string;
    label: string;
    open: boolean;
    error: boolean;
    errorText: string;
    handleClickOpen: () => void;
    handleChange: (event: React.ChangeEvent<HTMLInputElement>) => void;
    handleClose: () => void;
    handleSubmit: () => void;
    handleRefresh: () => void;
    nameValue: string;
    submitButtonName: string;
    ariaLabel: string;
    size: "small";
    memoId: string;
    memoLabel: string;
    memoValue: string;
    memoHandleChange: (event: React.ChangeEvent<HTMLInputElement>) => void;
    startIcon: React.ReactElement;
    sx: Record<string, any>;
}

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
                         }: Props) => {
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
