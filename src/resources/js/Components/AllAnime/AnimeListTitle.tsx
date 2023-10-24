import React from "react";
import Box from "@mui/material/Box";
import Tooltip from "@mui/material/Tooltip";
import Grid from "@mui/material/Grid";
import {getBoxWidth} from "@/Components/AllAnime/tool/tool";
import AddAnime from "@/Components/AllAnime/tool/AddAnime";
import SortAnime from "@/Components/AllAnime/tool/SortAnime"

interface Props {
    handleReload: () => void;
    isLoading: boolean;
}

interface MainProps {
    titleWidth: number;
    handleReload: () => void;
    isLoading: boolean;
}

// コンテンツMain部分
const Main = ({titleWidth, handleReload, isLoading}: MainProps) => {
    const contentList = [
        {
            body: (
                <Tooltip title={"アニメ一覧"} placement="bottom-end">
                    <Box
                        component="div"
                        textOverflow="ellipsis"
                        overflow="hidden"
                        fontSize={15}
                        fontWeight="bold"
                        sx={{
                            width: "100%",
                            height: "20px",
                            marginBottom: "10px",
                        }}
                    >
                        {"アニメ一覧"}
                    </Box>
                </Tooltip>
            ),
            sx: {
                width: titleWidth,
                display: "flex",
                justifyContent: "flex-start",
                alignItems: "flex-end",
            },
        },
        {
            body: <AddAnime handleReload={handleReload}/>,
            sx: {
                width: "50px",
                display: "flex",
                justifyContent: "center",
                alignItems: "flex-end",
            },
        },
        {
            "body": <SortAnime isLoading={isLoading}/>,
            "sx": {width: "50px", display: "flex", justifyContent: "center", alignItems: "flex-end"},
        }
    ];

    return (
        <Grid
            container
            sx={{height: "60px", marginBottom: "5px", marginTop: "20px"}}
        >
            {contentList.map((content, index) => {
                return (
                    <Grid key={index} container item sx={content.sx}>
                        {content.body}
                    </Grid>
                );
            })}
        </Grid>
    );
};

const AnimeListTitle = ({handleReload, isLoading}: Props) => {
    const titleWidth = getBoxWidth() - 100;

    return (
        <Box>
            <Main titleWidth={titleWidth} handleReload={handleReload} isLoading={isLoading}/>
        </Box>
    );
};

export default AnimeListTitle;
