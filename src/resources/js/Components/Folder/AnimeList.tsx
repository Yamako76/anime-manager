import React from "react";
import {Box, Grid} from "@mui/material";
import Tooltip from "@mui/material/Tooltip";
import Paper from "@mui/material/Paper";
import {grey} from "@mui/material/colors";
import {getBoxWidth} from "@/Components/AllAnime/tool/tool";
import {InertiaLink} from "@inertiajs/inertia-react";
import DeleteFolderAnime from "@/Components/Folder/tool/DeleteFolderAnime";

interface Props {
    handleReload: () => void;
    id: number;
    animes: any[];
}

const AnimeList = ({handleReload, id, animes}: Props) => {
    const BoxWidth: number = getBoxWidth();
    const titleWidth: number = BoxWidth - 50;

    const PaperContent = ({anime}) => {
        const contentList = [
            {
                body: (
                    <Tooltip title={anime.name + "の詳細"} placement="bottom-end">
                        <Box
                            textOverflow="ellipsis"
                            overflow="hidden"
                            fontSize={20}
                            as={InertiaLink}
                            href={`/anime-list/${anime.anime_id}`}
                            sx={{
                                margin: "0px 5px",
                                width: String(titleWidth - 10) + "px",
                                color: grey[900],
                                textDecoration: "none",
                                "&:hover": {color: grey[900]},
                            }}
                        >
                            {anime.name}
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
                body: <DeleteFolderAnime handleReload={handleReload} anime={anime} id={id}/>,
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
                    {animes.map((anime, index) => (
                        <Grid key={index} container item>
                            <PaperContent anime={anime}/>
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

export default AnimeList;
