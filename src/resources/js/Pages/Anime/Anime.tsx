import {Head} from "@inertiajs/react";
import React, {useState} from "react";
import {Box, Grid, TextField} from "@mui/material";
import AnimeHeader from "../../Components/Header/AnimeHeader";
import Typography from "@mui/material/Typography";
import Button from "@mui/material/Button";

interface AnimeProps {
    name: string;
}

const Anime = ({name}: AnimeProps) => {
    const [isEdit, setIsEdit] = useState(false);

    return (
        <>
            <Head title="Anime"/>
            <AnimeHeader/>
            <Grid container alignItems={"center"} justifyContent={"center"}>
                <Box
                    sx={{
                        position: "absolute",
                        top: "50%",
                        left: "50%",
                        transform: "translate(-50%, -50%)",
                    }}
                >
                    {isEdit ? (
                        <div>
                            <Box
                                component="form"
                                sx={{
                                    height: "5ch",
                                    alignItems: "center",
                                    justifyContent: "center",
                                    marginTop: 7,
                                }}
                            >
                                <Typography sx={{marginLeft: 22}}>
                                    アニメ名
                                </Typography>
                                <TextField
                                    label="name"
                                    variant="outlined"
                                    size="small"
                                    defaultValue="銀魂"
                                    sx={{
                                        alignSelf: "center",
                                        justifyContent: "center",
                                        marginTop: 1,
                                        marginLeft: 9,
                                        width: 350,
                                    }}
                                />
                            </Box>
                            <Button sx={{marginLeft: 27, marginTop: 27}}>
                                決定
                            </Button>
                            <Button
                                sx={{
                                    position: "absolute",
                                    top: 25,
                                    right: 20,
                                }}
                                onClick={() => setIsEdit(false)}
                            >
                                編集
                            </Button>
                        </div>
                    ) : (
                        <div>
                            <Box
                                component="form"
                                sx={{
                                    alignItems: "center",
                                    justifyContent: "center",
                                    marginTop: 2,
                                }}
                            >
                                <Typography sx={{alignSelf: "center"}}>
                                    アニメ名
                                </Typography>
                                <Typography
                                    sx={{
                                        marginTop: 1,
                                        alignSelf: "center",
                                        fontSize: 30,
                                    }}
                                >
                                    銀魂
                                </Typography>
                            </Box>
                            <Button
                                sx={{
                                    position: "absolute",
                                    left: 176,
                                    top: -24,
                                }}
                                onClick={() => setIsEdit(true)}
                            >
                                編集
                            </Button>
                        </div>
                    )}
                </Box>
            </Grid>
        </>
    );
}

export default Anime;
