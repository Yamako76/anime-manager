import React, { createContext, Fragment, useReducer } from "react";
import Snackbar from "@mui/material/Snackbar";
import Slide from "@mui/material/Slide";
import IconButton from "@mui/material/IconButton";
import CloseIcon from "@mui/icons-material/Close";

// API通信時におけるStateの通知
// 例: フォルダの読み込みに失敗した場合 => フォルダの読み込みに失敗しました とSnackBarで通知をする

const SlideTransition = (props) => {
    return <Slide {...props} direction="up" />;
};

const initialState = {
    isNotice: false,
    NoticeMessage: "",
};

export const NoticeContext = createContext(initialState);

const Notification = ({ children }) => {
    // @ts-ignore
    const [state, dispatch] = useReducer((state, action) => {
        switch (action.type) {
            case "handleNoticeOpen":
                return { ...state, isNotice: true };

            case "handleNoticeClose":
                return { ...state, isNotice: false };

            case "update_message":
                return { ...state, NoticeMessage: action.payload };

            default:
                return state;
        }
    }, initialState);
    // @ts-ignore
    const action = (
        <Fragment>
            <IconButton
                size="small"
                aria-label="close"
                color="inherit"
                onClick={() => dispatch({ type: "handleNoticeClose" })}
            >
                <CloseIcon fontSize="small" />
            </IconButton>
        </Fragment>
    );
    // @ts-ignore
    return (
        <NoticeContext.Provider value={[state, dispatch]}>
            {children}
            <Snackbar
                open={state.isNotice}
                anchorOrigin={{ vertical: "bottom", horizontal: "center" }}
                onClose={() => dispatch({ type: "handleNoticeClose" })}
                TransitionComponent={SlideTransition}
                message={state.NoticeMessage}
                autoHideDuration={5000}
                action={action}
            />
        </NoticeContext.Provider>
    );
};

export default Notification;
