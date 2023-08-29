import React from "react";
import { Box, Grid, IconButton } from "@mui/material";
import Tooltip from "@mui/material/Tooltip";
import Paper from "@mui/material/Paper";
// import DeleteItem from '../tool/DeleteItem';
import { grey } from "@mui/material/colors";
import DeleteIcon from "@mui/icons-material/Delete";
import { getBoxWidth } from "@/Components/AllAnime/tool/tool";
import DeleteButton from "@/Components/Button/DeleteButton";
import DeleteAnime from "@/Components/AllAnime/tool/DeleteAnime";

interface Props {}

const AnimeList = ({}: Props) => {
    const BoxWidth = getBoxWidth();
    const titleWidth = BoxWidth - 50;

    const animeList: string[] = [
        "銀魂",
        "ドラえもん",
        "ドラゴンボール",
        "ワンピース",
        "アンパンマン",
        "スラムダンク",
        "あの日見た花の名前は忘れない",
        "てんぷる",
        "ぐらんぶる",
        "ニセコイ",
        "俺ガイル",
        "咲",
        "リセス",
        "転したらスライムだった件",
        "精霊幻想紀",
        "ぼっちざろっく",
        "けいおん",
        "ラブライブ",
        "ホリミヤ",
    ];

    const PaperContent = ({ item }) => {
        const contentList = [
            {
                body: (
                    <Tooltip title={item + "の詳細"} placement="bottom-end">
                        <Box
                            textOverflow="ellipsis"
                            overflow="hidden"
                            fontSize={20}
                            // component={Link}
                            sx={{
                                margin: "0px 5px",
                                width: String(titleWidth - 10) + "px",
                                color: grey[900],
                                textDecoration: "none",
                                "&:hover": { color: grey[900] },
                            }}
                        >
                            {item}
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
                body: <DeleteAnime />,
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
                    {animeList.map((item, index) => (
                        <Grid key={index} container item>
                            <PaperContent item={item} />
                        </Grid>
                    ))}
                </Grid>
            </Box>
        );
    };

    return (
        <Box>
            <ItemList />
        </Box>
    );
};

export default AnimeList;
