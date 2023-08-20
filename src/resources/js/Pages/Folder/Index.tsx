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
import FolderIcon from "@mui/icons-material/Folder";

export default function Index() {
    const [open, setOpen] = useState(false);
    const handleOpen = () => setOpen(true);
    const handleClose = () => setOpen(false);

    const [isSearch, setIsSearch] = useState(false);

    return (
        <>
            <Head title="Folder" />

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
                                    marginTop: 15,
                                }}
                            >
                                <Typography sx={{ marginLeft: 10 }}>
                                    フォルダ名
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
                        フォルダ一覧
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
                <Box sx={{ color: "gray" }}>
                    <FolderIcon
                        sx={{
                            width: 120,
                            height: 120,
                            margin: 3,
                            marginTop: -3,
                        }}
                    />
                    <Typography
                        textAlign={"center"}
                        color={"black"}
                        marginTop={-5}
                    >
                        コメディー
                    </Typography>
                </Box>
                <Box sx={{ color: "gray" }}>
                    <FolderIcon
                        sx={{
                            width: 120,
                            height: 120,
                            margin: 3,
                            marginTop: -3,
                        }}
                    />
                    <Typography
                        textAlign={"center"}
                        color={"black"}
                        marginTop={-5}
                    >
                        アクション
                    </Typography>
                </Box>
            </Grid>
        </>
    );
}
