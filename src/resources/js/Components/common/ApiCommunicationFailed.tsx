import React, { Fragment } from "react";
import Slide from "@mui/material/Slide";
import Snackbar from "@mui/material/Snackbar";
import IconButton from "@mui/material/IconButton";
import CloseIcon from "@mui/icons-material/Close";

interface Props {
    message: string;
    handleSnackbarClose: () => void;
    isSnackbar: boolean;
}

// API通信時における失敗の通知
// 例: フォルダの読み込みに失敗した場合 => フォルダの読み込みに失敗しました とSnackBarで通知をする
const ApiCommunicationFailed = ({
    message,
    handleSnackbarClose,
    isSnackbar,
}: Props) => {
    const SlideTransition = (props) => {
        return <Slide {...props} direction="up" />;
    };

    const action = (
        <Fragment>
            <IconButton
                size="small"
                aria-label="close"
                color="inherit"
                onClick={handleSnackbarClose}
            >
                <CloseIcon fontSize="small" />
            </IconButton>
        </Fragment>
    );

    return (
        <>
            <Snackbar
                open={isSnackbar}
                anchorOrigin={{ vertical: "bottom", horizontal: "center" }}
                onClose={handleSnackbarClose}
                TransitionComponent={SlideTransition}
                message={message}
                autoHideDuration={5000}
                action={action}
            />
        </>
    );
};

export default ApiCommunicationFailed;
