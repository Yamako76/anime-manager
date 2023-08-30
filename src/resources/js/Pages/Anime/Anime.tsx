import { Head } from "@inertiajs/react";
import React from "react";
import { Box } from "@mui/material";
import AnimeHeader from "../../Components/Header/AnimeHeader";
import AnimeDetail from "@/Components/AnimeDetail/AnimeDetail";

interface AnimeProps {
    name: string;
}

const Anime = ({ name }: AnimeProps) => {
    return (
        <>
            <Head title="Anime" />
            <AnimeHeader />
            <Box
                sx={{
                    width: "100%",
                    minWidth: "300px",
                    justifyContent: "center",
                    alignItems: "center",
                    display: "flex",
                }}
            >
                <AnimeDetail name={name} />
            </Box>
        </>
    );
};

export default Anime;
