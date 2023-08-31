import React from "react";
import Skeleton from "@mui/material/Skeleton";
import { getBoxWidth } from "@/Components/AllAnime/tool/tool";

// フォルダタイトルのロード中に表示
const LoadingTitle = () => {
    const BoxWidth = getBoxWidth();
    return (
        <Skeleton
            variant="rectangular"
            sx={{
                height: "40px",
                width: BoxWidth,
                marginTop: "40px",
                marginBottom: "5px",
            }}
        ></Skeleton>
    );
};

export default LoadingTitle;
