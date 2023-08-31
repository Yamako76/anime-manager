import React from "react";
import Box from "@mui/material/Box";
import Grid from "@mui/material/Grid";
import Typography from "@mui/material/Typography";
import { getBodyHeight, getBoxWidth } from "@/Components/AllAnime/tool/tool";

// 検索後に該当するアイテムが存在しない場合に表示する画面
const NotExistFolders = () => {
    const bodyHeight = getBodyHeight();
    const BoxWidth = getBoxWidth();
    const textList = [
        "該当するフォルダが存在しません",
        "(フォルダの作成を行ってください)",
    ];

    const box_sx = {
        height: bodyHeight,
        width: BoxWidth,
        display: "flex",
        justifyContent: "center",
        alignItems: "center",
    };

    const grid_sx = {
        display: "flex",
        alignItems: "center",
        justifyContent: "center",
    };

    return (
        <Box sx={box_sx}>
            <Grid container direction="column" sx={{ width: BoxWidth }}>
                {textList.map((text, index) => {
                    return (
                        <Grid key={index} container item sx={grid_sx}>
                            <Typography fontWeight="bold">{text}</Typography>
                        </Grid>
                    );
                })}
            </Grid>
        </Box>
    );
};

export default NotExistFolders;
