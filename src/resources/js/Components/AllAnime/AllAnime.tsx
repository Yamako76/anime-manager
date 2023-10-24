import React from "react";
import {Box, Grid} from "@mui/material";
import Tooltip from "@mui/material/Tooltip";
import Paper from "@mui/material/Paper";
import {grey} from "@mui/material/colors";
import {getBoxWidth} from "@/Components/AllAnime/tool/tool";
import DeleteAnime from "@/Components/AllAnime/tool/DeleteAnime";
import {InertiaLink} from "@inertiajs/inertia-react";

interface Props {
    handleReload: () => void;
    items: any[];
}

interface Prop {
    item: any;
}

const AllAnime = ({handleReload, items}: Props) => {
    const BoxWidth: number = getBoxWidth();
    const titleWidth: number = BoxWidth - 50;

    const PaperContent = ({item}: Prop) => {
        const contentList = [
            {
                body: (
                    <Tooltip title={item.name + "の詳細"} placement="bottom-end">
                        <Box
                            textOverflow="ellipsis"
                            overflow="hidden"
                            fontSize={20}
                            as={InertiaLink}
                            href={`/anime-list/${item.id}`}
                            sx={{
                                margin: "0px 5px",
                                width: String(titleWidth - 10) + "px",
                                color: grey[900],
                                textDecoration: "none",
                                "&:hover": {color: grey[900]},
                            }}
                        >
                            {item.name}
                        </Box>
                    </Tooltip>
                ),
                sx: {
                    width: String(titleWidth) + "px",
                    display: "flex",
                    justifyContent: "flex-start",
                    alignItems: "flex-end",
                },
            },
            {
                body: <DeleteAnime handleReload={handleReload} item={item}/>,
                sx: {
                    width: "40px",
                    display: "flex",
                    justifyContent: "center",
                    alignItems: "flex-end",
                },
            },
        ];

        return (
            <Paper
                variant="outlined"
                sx={{
                    width: "100%",
                    height: "50px",
                    display: "flex",
                    alignItems: "center",
                    color: grey[900],
                    textDecoration: "none",
                    "&:hover": {
                        color: grey[900],
                        outline: "solid",
                        outlineColor: grey[900],
                    },
                }}
            >
                <Grid container>
                    {contentList.map((content, index) => {
                        return (
                            <Grid key={index} container item sx={content.sx}>
                                {content.body}
                            </Grid>
                        );
                    })}
                </Grid>
            </Paper>
        );
    };

    // アイテム一覧
    const ItemList = () => {
        return (
            <Box
                sx={{
                    width: "100%",
                    display: "flex",
                    justifyContent: "center",
                    marginTop: "10px",
                }}
            >
                <Grid container direction="column" spacing={1}>
                    {items.map((item, index) => (
                        <Grid key={index} container item>
                            <PaperContent item={item}/>
                        </Grid>
                    ))}
                </Grid>
            </Box>
        );
    };

    return (
        <Box>
            <ItemList/>
        </Box>
    );
};

export default AllAnime;
