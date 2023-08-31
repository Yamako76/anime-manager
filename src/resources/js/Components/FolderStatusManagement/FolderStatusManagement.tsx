import React, { createContext, useContext, useEffect, useReducer } from "react";
import { useNavigate } from "react-router-dom";
import { NoticeContext } from "../common/Notification";

// フォルダの読み込み管理
// Mountされた時点でフォルダ一覧の読み込みを開始し
// reRenderがtrueになるたびにフォルダの再読み込みを行う
// @current_folderIdで現在選択されているフォルダを管理する

const initialState = {
    reRender: true,
    isLoading: true,
    all_folders: null,
    current_folderId: null,
};

export const FolderStatusManagementContext = createContext(initialState);

const FolderStatusManagement = ({ children }) => {
    const [notice_state, notice_dispatch] = useContext(NoticeContext);
    const navigate = useNavigate();
    const [state, dispatch] = useReducer((state, action) => {
        switch (action.type) {
            case "handleReRenderOn":
                return { ...state, reRender: true };

            case "handleReRenderOff":
                return { ...state, reRender: false };

            case "handleIsLoadingOn":
                return { ...state, isLoading: true };

            case "handleIsLoadingOff":
                return { ...state, isLoading: false };

            case "setFolders":
                return { ...state, all_folders: action.payload };

            case "setCurrentFolder":
                return { ...state, current_folderId: action.payload };

            default:
                return state;
        }
    }, initialState);

    const failedToLoad = () => {
        notice_dispatch({
            type: "update_message",
            payload: "フォルダの読み込みに失敗しました",
        });
        notice_dispatch({ type: "handleNoticeOpen" });
        dispatch({ type: "setFolders", payload: [] });
        dispatch({ type: "handleIsLoadingOff" });
        dispatch({ type: "handleReRenderOff" });
        navigate("/app/home", { replace: true });
    };

    useEffect(() => {
        const abortCtrl = new AbortController();
        const fetchFolders = async () => {
            const timeout = setTimeout(() => {
                abortCtrl.abort();
            }, 10000);
            try {
                const res = await fetch("/api/folders", {
                    signal: abortCtrl.signal,
                });
                if (!res.ok) {
                    throw new Error(res.statusText);
                }
                const data = await res.json();
                dispatch({ type: "setFolders", payload: data });
                dispatch({ type: "handleIsLoadingOff" });
                dispatch({ type: "handleReRenderOff" });
            } catch (error) {
                failedToLoad();
            } finally {
                clearTimeout(timeout);
            }
        };

        if (state.reRender) {
            dispatch({ type: "handleIsLoadingOn" });
            fetchFolders();
        }

        return () => {
            abortCtrl.abort();
        };
    }, [state.reRender]);

    return (
        <FolderStatusManagementContext.Provider value={[state, dispatch]}>
            {children}
        </FolderStatusManagementContext.Provider>
    );
};

export default FolderStatusManagement;
