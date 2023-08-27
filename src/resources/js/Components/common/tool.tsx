import { useEffect, useState } from "react";

// 画面のwidthとheightを取得する関数 //
export const useWindowDimensions = () => {
    const getWindowDimensions = () => {
        const { innerWidth: width, innerHeight: height } = window;
        return {
            width,
            height,
        };
    };

    const [windowDimensions, setWindowDimensions] = useState(
        getWindowDimensions()
    );
    useEffect(() => {
        const onResize = () => {
            setWindowDimensions(getWindowDimensions());
        };
        window.addEventListener("resize", onResize);
        return () => window.removeEventListener("resize", onResize);
    }, []);
    return windowDimensions;
};

// フォルダとアイテムの追加・更新時に行う入力値のバリデーション
//  1文字以上200以内で制限する
const inputProps = {
    maxLength: 200,
};

export const value_validation = (target_value) => {
    target_value = target_value.trim();
    return target_value.length <= inputProps.maxLength &&
        target_value.length > 0
        ? true
        : false;
};

// Enter入力の判定
export const pressEnter = (e, handleSubmit) => {
    if (e.key === "Enter") {
        e.preventDefault();
        handleSubmit();
    }
};
