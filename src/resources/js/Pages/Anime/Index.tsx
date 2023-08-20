import { Head } from "@inertiajs/react";
import React, { useState } from "react";
import {
    Box,
    Grid,
    IconButton,
    InputAdornment,
    Modal,
    TextField,
    Tooltip,
} from "@mui/material";
import AddIcon from "@mui/icons-material/Add";
import SortIcon from "@mui/icons-material/Sort";
import Typography from "@mui/material/Typography";
import SearchIcon from "@mui/icons-material/Search";
import AnimeHeader from "../../Components/Header/AnimeHeader";
import Button from "@mui/material/Button";

export default function Index() {
    const [open, setOpen] = useState(false);
    const handleOpen = () => setOpen(true);
    const handleClose = () => setOpen(false);

    const [isSearch, setIsSearch] = useState(false);

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
                <Box sx={{ color: "grey", marginLeft: "10%" }}>
                    <Tooltip title={"追加"}>
                        <IconButton onClick={handleOpen}>
                            <AddIcon />
                        </IconButton>
                    </Tooltip>
                    <Modal open={open} onClose={handleClose}>
                        <Box
                            sx={{
                                position: "absolute",
                                top: "50%",
                                left: "50%",
                                transform: "translate(-50%, -50%)",
                                width: 500,
                                height: 400,
                                border: 1,
                                borderRadius: 10,
                                bgcolor: "white",
                            }}
                        >
                            <Box
                                component="form"
                                sx={{
                                    height: "5ch",
                                    alignItems: "center",
                                    justifyContent: "center",
                                    marginTop: 7,
                                }}
                            >
                                <Typography sx={{ marginLeft: 22 }}>
                                    アニメ名
                                </Typography>
                                <TextField
                                    label="name"
                                    variant="outlined"
                                    size="small"
                                    sx={{
                                        alignSelf: "center",
                                        justifyContent: "center",
                                        marginTop: 1,
                                        marginLeft: 9,
                                        width: 350,
                                    }}
                                />
                                <Typography
                                    sx={{ marginTop: 1, marginLeft: 22 }}
                                >
                                    年
                                </Typography>
                                <TextField
                                    label="year"
                                    variant="outlined"
                                    size="small"
                                    sx={{
                                        alignSelf: "center",
                                        justifyContent: "center",
                                        marginTop: 1,
                                        marginLeft: 22,
                                        width: 150,
                                    }}
                                />
                                <Typography
                                    sx={{ marginTop: 1, marginLeft: 22 }}
                                >
                                    シーズン
                                </Typography>
                                <TextField
                                    label="season"
                                    variant="outlined"
                                    size="small"
                                    sx={{
                                        alignSelf: "center",
                                        justifyContent: "center",
                                        marginTop: 1,
                                        marginLeft: 22,
                                        width: 150,
                                    }}
                                />
                            </Box>
                            <Button
                                sx={{ position: "absolute", top: 25, left: 20 }}
                                onClick={handleClose}
                            >
                                戻る
                            </Button>
                            <Button sx={{ marginLeft: 27, marginTop: 27 }}>
                                追加
                            </Button>
                        </Box>
                    </Modal>
                </Box>
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
            <Grid
                container
                alignItems={"center"}
                justifyContent={"center"}
                marginTop={3}
                direction={"row"}
            >
                <Box
                    sx={{
                        backgroundColor: "gray",
                        width: 140,
                        height: 160,
                        borderRadius: 5,
                        margin: 3,
                    }}
                >
                    <Typography textAlign={"center"} paddingTop={2}>
                        銀魂
                    </Typography>
                    <Typography textAlign={"center"} marginTop={1}>
                        2006年
                    </Typography>
                    <Typography textAlign={"center"} marginTop={1}>
                        春
                    </Typography>
                </Box>
                <Box
                    sx={{
                        backgroundColor: "gray",
                        width: 140,
                        height: 160,
                        borderRadius: 5,
                        margin: 3,
                    }}
                >
                    <Typography textAlign={"center"} paddingTop={2}>
                        ドラゴンボールGT
                    </Typography>
                    <Typography textAlign={"center"} marginTop={1}>
                        1980年
                    </Typography>
                    <Typography textAlign={"center"} marginTop={1}>
                        夏
                    </Typography>
                </Box>
            </Grid>
        </>
    );
}
