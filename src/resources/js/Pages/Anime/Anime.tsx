import {Head} from "@inertiajs/react";
import React from "react";
import {Box} from "@mui/material";
import AnimeHeader from "../../Components/Header/AnimeHeader";
import AnimeDetail from "@/Components/AnimeDetail/AnimeDetail";

//　/anime-list/animeIdの画面へ出力する要素
// animeIdによって選択されたアニメ詳細画面を表示

interface AnimeProps {
    name: string;
    memo: string;
    id: number;
}

const Anime = ({name, memo, id}: AnimeProps) => {
    return (
        <>
            <Head title="Anime"/>
            <AnimeHeader/>
            <Box
                sx={{
                    width: "100%",
                    minWidth: "300px",
                    justifyContent: "center",
                    alignItems: "center",
                    display: "flex",
                }}
            >
                <AnimeDetail name={name} memo={memo} id={id}/>
            </Box>
        </>
    );
};

export default Anime;
