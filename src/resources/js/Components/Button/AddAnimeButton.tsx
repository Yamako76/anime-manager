import React from "react";
import Box from "@mui/material/Box";
import IconButton from "@mui/material/IconButton";
import Tooltip from "@mui/material/Tooltip";
import AddIcon from "@mui/icons-material/Add";
import EditAnimeDialog from "./EditAnimeDialog";

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
    nameValue: string;
    submitButtonName: string;
    memoId: string;
    memoLabel: string;
    memoValue: string;
    memoHandleChange: (e) => void;
    memoHandleRefresh: () => void;
}

const AddAnimeButton = ({
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
                            sx,
                            memoId,
                            memoLabel,
                            memoValue,
                            memoHandleChange,
                            memoHandleRefresh,
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
                memoLabel={memoLabel}
                memoValue={memoValue}
                memoId={memoId}
                memoHandleChange={memoHandleChange}
                memoHandleRefresh={memoHandleRefresh}
            />
        </Box>
    );
};

export default AddAnimeButton;
