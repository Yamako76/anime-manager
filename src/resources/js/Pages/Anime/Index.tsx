import { Head } from "@inertiajs/react";
import React, { useState } from "react";
import { Box, Divider, Grid } from "@mui/material";
import AnimeHeader from "../../Components/Header/AnimeHeader";
import AllAnime from "@/Components/AllAnime/AllAnime";
import { getBoxWidth } from "@/Components/AllAnime/tool/tool";
import AnimeListTitle from "@/Components/AllAnime/AnimeListTitle";
import SearchBar from "@/Components/AllAnime/SearchBar";

const Index = () => {
    const BoxWidth = getBoxWidth();

    const [open, setOpen] = useState<boolean>(false);
    const handleOpen = () => setOpen(true);
    const handleClose = () => setOpen(false);

    const [value, setValue] = useState<string>("");

    const handleChange = (e) => {
        setValue(e.target.value);
    };

    const handleRefresh = () => {
        setValue("");
    };

    const Main = () => {
        return (
            <Grid container direction="column" sx={{ marginTop: "100px" }}>
                <Grid container item>
                    <AnimeListTitle />
                </Grid>
                <Divider />
                <AllAnime />
            </Grid>
        );
    };

    return (
        <>
            <Head title="Anime" />
            <AnimeHeader />
            <Box sx={{ display: "flex", justifyContent: "center" }}>
                <Box
                    sx={{
                        width: BoxWidth,
                        display: "flex",
                        justifyContent: "center",
                        minWidth: "300px",
                    }}
                >
                    <Main />
                    <SearchBar
                        handleChange={handleChange}
                        handleRefresh={handleRefresh}
                        value={value}
                    />
                </Box>
            </Box>
        </>
    );
};

export default Index;
