import { Head } from "@inertiajs/react";
import React, { useState } from "react";
import {
    Box,
    Grid,
    IconButton,
    InputAdornment,
    TextField,
    Tooltip,
} from "@mui/material";
import SortIcon from "@mui/icons-material/Sort";
import SearchIcon from "@mui/icons-material/Search";
import AnimeHeader from "../../Components/Header/AnimeHeader";
import AddButton from "@/Components/Button/AddButton";
import AllAnime from "@/Components/AllAnime/AllAnime";
import Typography from "@mui/material/Typography";

const Index = () => {
    const [open, setOpen] = useState<boolean>(false);
    const handleOpen = () => setOpen(true);
    const handleClose = () => setOpen(false);

    const [isSearch, setIsSearch] = useState<boolean>(false);

    return (
        <>
            <Head title="Anime" />
            <AnimeHeader />
            <Grid container alignItems={"center"} justifyContent={"center"}>
                <Box
                    sx={{
                        marginLeft: "40%",
                        color: "grey",
                    }}
                >
                    {isSearch ? (
                        <TextField
                            size={"small"}
                            type="search"
                            id="search"
                            sx={{ width: 200, marginTop: 1 }}
                            InputProps={{
                                endAdornment: (
                                    <InputAdornment position="end">
                                        <IconButton
                                            onClick={() =>
                                                setIsSearch(!isSearch)
                                            }
                                        >
                                            <SearchIcon />
                                        </IconButton>
                                    </InputAdornment>
                                ),
                            }}
                        />
                    ) : (
                        <Tooltip title={"検索"}>
                            <IconButton onClick={() => setIsSearch(!isSearch)}>
                                <SearchIcon />
                            </IconButton>
                        </Tooltip>
                    )}
                </Box>
                <AddButton
                    open={open}
                    handleOpen={handleOpen}
                    handleClose={handleClose}
                />
                <Box sx={{ color: "grey" }}>
                    <Tooltip title={"並び替え"}>
                        <IconButton>
                            <SortIcon />
                        </IconButton>
                    </Tooltip>
                </Box>
            </Grid>
            <Grid container alignItems={"center"} justifyContent={"center"}>
                <Box
                    sx={{
                        marginTop: 1,
                    }}
                >
                    <Typography
                        fontSize={20}
                        fontWeight={"bold"}
                        marginRight={40}
                    >
                        アニメ一覧
                    </Typography>
                </Box>
            </Grid>
            <AllAnime />
        </>
    );
};

export default Index;
