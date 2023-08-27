import React from "react";
import Box from "@mui/material/Box";
import Tooltip from "@mui/material/Tooltip";
import Grid from "@mui/material/Grid";
import AddButton from "@/Components/Button/AddButton";
// import SortItem from '../tool/SortItem';
import { getBoxWidth } from "@/Components/AllAnime/tool";

interface Props {
    open: boolean;
    handleOpen: () => void;
    handleClose: () => void;
}

// コンテンツMain部分
const Main = ({ open, handleOpen, handleClose, titleWidth }) => {
    const contentList = [
        {
            body: (
                <Tooltip title={`アニメ一覧`} placement="bottom-end">
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
                        {`アニメ一覧`}
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
            body: (
                <AddButton
                    open={open}
                    handleOpen={handleOpen}
                    handleClose={handleClose}
                />
            ),
            sx: {
                width: "50px",
                display: "flex",
                justifyContent: "center",
                alignItems: "flex-end",
            },
        },
        // {
        //     "body": <SortItem/>,
        //     "sx": {width: "50px", display: "flex", justifyContent: "center", alignItems: "flex-end"},
        // }
    ];

    return (
        <Grid
            container
            sx={{ height: "60px", marginBottom: "5px", marginTop: "20px" }}
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

const AnimeListTitle = ({ open, handleOpen, handleClose }: Props) => {
    const titleWidth = getBoxWidth() - 100;

    return (
        <Box>
            <Main
                titleWidth={titleWidth}
                open={open}
                handleOpen={handleOpen}
                handleClose={handleClose}
            />
        </Box>
    );
};

export default AnimeListTitle;
