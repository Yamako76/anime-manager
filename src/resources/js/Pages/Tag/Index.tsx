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
            <Head title="Tag" />
            <AnimeHeader />
            <Grid container alignItems={"center"} justifyContent={"center"}>
                <Box
                    sx={{
                        marginLeft: "40%",
                        color: "grey",
                    }}
                >
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
                                <IconButton
                                    onClick={() => setIsSearch(!isSearch)}
                                >
                                    <SearchIcon />
                                </IconButton>
                            </Tooltip>
                        )}
                    </Box>
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
                                    marginTop: 15,
                                }}
                            >
                                <Typography sx={{ marginLeft: 10 }}>
                                    タグ名
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
                            </Box>
                            <Button
                                sx={{ marginLeft: 18, marginTop: 10 }}
                                onClick={handleClose}
                            >
                                戻る
                            </Button>
                            <Button sx={{ marginLeft: 8, marginTop: 10 }}>
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
                        タグ一覧
                    </Typography>
                </Box>
            </Grid>
            <Grid
                container
                alignItems={"center"}
                justifyContent={"center"}
                marginTop={1}
                direction={"row"}
            >
                <Box
                    sx={{
                        backgroundColor: "gray",
                        width: 140,
                        height: 30,
                        borderRadius: 5,
                        margin: 1,
                    }}
                >
                    <Typography textAlign={"center"} paddingTop={0.5}>
                        #杉田智和
                    </Typography>
                </Box>
                <Box
                    sx={{
                        backgroundColor: "gray",
                        width: 140,
                        height: 30,
                        borderRadius: 5,
                        margin: 1,
                    }}
                >
                    <Typography textAlign={"center"} paddingTop={0.5}>
                        #面白い
                    </Typography>
                </Box>
            </Grid>
        </>
    );
}
