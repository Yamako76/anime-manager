import React from "react";
import {Box, Grid} from "@mui/material";
import Typography from "@mui/material/Typography";

interface Props {
}

const AllAnime = ({}: Props) => {
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
    ];

    return (
        <Box sx={{marginLeft: "50px", marginRight: "50px"}}>
            <Grid
                container
                alignItems={"center"}
                justifyContent={"flex-start"}
                marginTop={3}
                direction={"row"}
                spacing={2}
            >
                {animeList.map((anime, index) => (
                    <Grid item key={index} xs={12} sm={6} md={4} lg={3} xl={2}>
                        <div
                            style={{
                                backgroundColor: "gray",
                                width: "200px",
                                height: "160px",
                                borderRadius: 5,
                                margin: 3,
                                display: "flex",
                                alignItems: "center",
                                justifyContent: "center",
                            }}
                        >
                            <Typography>{anime}</Typography>
                        </div>
                    </Grid>
                ))}
            </Grid>
        </Box>
    );
};

export default AllAnime;
