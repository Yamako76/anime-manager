import React, { createContext, ReactNode, useReducer } from "react";

// アイテムの並べ替えStateを管理する
// 0:  作成順
// 1:  最新順
// 2:  タイトル順
// でSortする

type Props = {
    children: ReactNode;
};

const initialState = {
    sortIndex: 0,
};

export const SortContext = createContext(initialState);

const SortManagement = ({ children }: Props) => {
    // @ts-ignore
    const [state, dispatch] = useReducer((state, action) => {
        switch (action.type) {
            case "setSortIndex":
                return { ...state, sortIndex: action.payload };

            default:
                return state;
        }
    }, initialState);
    // @ts-ignore
    return (
        <SortContext.Provider value={[state, dispatch]}>
            {children}
        </SortContext.Provider>
    );
};

export default SortManagement;
