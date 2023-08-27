import {Head} from "@inertiajs/react";
import React, {useState} from "react";
import {Box, Divider, Grid} from "@mui/material";
import AnimeHeader from "../../Components/Header/AnimeHeader";
import AllAnime from "@/Components/AllAnime/AllAnime";
import {getBoxWidth} from "@/Components/AllAnime/tool";
import AnimeListTitle from "@/Components/AllAnime/AnimeListTitle";

const Index = () => {
    const BoxWidth = getBoxWidth();

    const [open, setOpen] = useState<boolean>(false);
    const handleOpen = () => setOpen(true);
    const handleClose = () => setOpen(false);

    const Main = () => {
        return (
            <Grid container direction="column" sx={{marginTop: "100px"}}>
                <Grid container item>
                    <AnimeListTitle
                        open={open}
                        handleOpen={handleOpen}
                        handleClose={handleClose}
                    />
                </Grid>
                <Divider/>
                <AllAnime/>
            </Grid>
        );
    };

    return (
        <>
            <Head title="Anime"/>
            <AnimeHeader/>
            <Box sx={{display: "flex", justifyContent: "center"}}>
                <Box
                    sx={{
                        width: BoxWidth,
                        display: "flex",
                        justifyContent: "center",
                        alignItems: "center",
                        // marginLeft: "50px",
                        // marginRight: "50px",
                    }}
                >
                    <Main/>
                    {/* フォルダ内検索 */}
                    {/*<ItemSearchBar*/}
                    {/*    handleChange={handleChange}*/}
                    {/*    handleRefresh={handleRefresh}*/}
                    {/*    handleReload={handleReload}*/}
                    {/*    handleSubmit={handleSubmit}*/}
                    {/*    value={value}*/}
                    {/*/>*/}
                </Box>
            </Box>
        </>
    );
};

export default Index;
