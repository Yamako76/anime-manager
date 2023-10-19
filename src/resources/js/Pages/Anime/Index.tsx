import {Head} from "@inertiajs/react";
import React from "react";
import {Box} from "@mui/material";
import AnimeHeader from "../../Components/Header/AnimeHeader";
import SortManagement from "@/Components/common/SortManagement"
import AnimeManagement from "@/Components/AllAnime/AnimeManagement";

const Index = () => {


    return (
        <>
            <Head title="Anime"/>
            <AnimeHeader/>
            <Box sx={{display: "flex", justifyContent: "center"}}>
                <SortManagement>
                    <AnimeManagement/>
                </SortManagement>
            </Box>
        </>
    );
};

export default Index;
