import {Head} from "@inertiajs/react";
import React, {useEffect, useRef, useState} from "react";
import {Box, Grid} from "@mui/material";
import AnimeHeader from "../../Components/Header/AnimeHeader";
import Typography from "@mui/material/Typography";
import Button from "@mui/material/Button";
import axios from 'axios';
import ViewYouTubeVideo from "@/Components/YouTubeApi/ViewYouTubeVideo";
import Divider from "@mui/material/Divider";
import ArrowBackIcon from '@mui/icons-material/ArrowBack';
import {grey} from "@mui/material/colors";
import Paper from "@mui/material/Paper";
import EditIcon from "@mui/icons-material/Edit";
interface AnimeProps {
    name: string;
}

const Anime = ({name}: AnimeProps) => {
    const [videoId, setVideoId] = useState();
    const isMounted = useRef(false);

    useEffect(() => {
        isMounted.current = true;
        return () => {
            isMounted.current = false;
        }
    }, [])

    useEffect(() => {
        const getAnime = async () => {
            const youTubeVideoId = await fetchYouTubeVideoId(name);
            setVideoId(youTubeVideoId);
        }
        if (isMounted.current) {
            getAnime();
        }
    }, [])
    const fetchYouTubeVideoId = async (keyWord) => {
        const abortCtrl = new AbortController();
        const timeout = setTimeout(() => abortCtrl.abort(), 10000);
        let res;

        try {
            res = await axios.get(`https://www.googleapis.com/youtube/v3/search`,
                {
                    signal: abortCtrl.signal,
                    headers: {
                        "Content-Type": "application/json; charset=utf-8",
                    },
                    params: {
                        part: "snippet",
                        q: keyWord + " pv",
                        maxResults: 1,
                        type: "video",
                        key: "AIzaSyCp814viDX87DANnIYs8o2SsWwtwPxOMvY"
                    }
                });
        } catch {
            // failedToLoad();
        } finally {
            clearTimeout(timeout);
        }
        if (res.data.items == null) {
            return null;
        }
        return res.data.items[0].id.videoId;
    }

    const ViewItem = () => {
        return (
            <Box
                sx={{
                    width: "100%",
                    justifyContent: "center",
                    alignItems: "center",
                    display: "flex",
                    flexDirection: "column",
                    marginTop: "50px",
                    paddingRight: "50px",
                    paddingLeft: "50px",
                }}>
                <Box sx={{
                    justifyContent: "flex-start",
                    alignItems: "flex-end",
                    display: "flex",
                    width: "100%",
                    height: "50px",
                }}>
                    <Button
                        size={"small"}
                        // component={Link}
                        // to={"/app/home/folders/" + folderId + "/items/"}
                        variant="text"
                        startIcon={<ArrowBackIcon/>}
                        sx={{marginRight: "10px", "&:hover": {color: grey[900]}}}
                        color="inherit"
                    >
                        戻る
                    </Button>
                    {/*<EditItem item={Item} folderId={folderId}/>*/}
                    <Button
                        // onClick={handleClickOpen}
                        // aria-label={ariaLabel}
                        disableFocusRipple={true}
                        size={"small"}
                        sx={{"&:hover": {color: grey[900]}}}
                        startIcon={<EditIcon/>}
                        color="inherit"
                    >
                        編集
                    </Button>
                </Box>
                <Divider sx={{width: "100%", marginTop: "5px", marginBottom: "5px"}}/>
                <Box sx={{
                    width: "100%",
                    height: "100px",
                    justifyContent: "flex-start",
                    alignItems: "center",
                    display: "flex",
                    paddingLeft: "10px"
                }}>
                    <Box sx={{
                        height: "30px",
                        width: "10px",
                        bgcolor: grey[600],
                        marginRight: "5px"
                    }}/>
                    <Typography
                        fontSize={30}
                        fontWeight={'bold'}
                    >
                        {name}
                    </Typography>
                </Box>
                <Box sx={{
                    width: "100%",
                    height: "250px",
                    justifyContent: "center",
                    alignItems: "center",
                    display: "flex",
                    paddingLeft: "10px",
                }}>
                    <Grid
                        container
                        direction="column"
                        sx={{
                            width: "100%",
                            height: "100%",
                            justifyContent: "flex-start",
                            alignItems: "center",
                            display: "flex",
                        }}>
                        <Grid
                            sx={{
                                width: "100%",
                                justifyContent: "flex-start",
                                alignItems: "center",
                                display: "flex",
                                marginBottom: "10px"
                            }}
                        >
                            <Box sx={{
                                height: "18px",
                                width: "5px",
                                bgcolor: grey[300],
                                marginRight: "5px"
                            }}/>
                            <Typography sx={{fontSize: 18, fontWeight: "bold"}}>メモ</Typography>
                        </Grid>
                        <Grid
                            sx={{
                                width: "100%",
                                justifyContent: "flex-start",
                                alignItems: "center",
                                display: "flex",
                                paddingLeft: "5px",
                                paddingRight: "5px",
                            }}
                        >
                            <Paper
                                variant="outlined"
                                sx={{
                                    width: "100%",
                                    height: "200px",
                                    justifyContent: "flex-start",
                                    alignItems: "flex-start",
                                    display: "flex",
                                    overflow: "auto",
                                    padding: "5px",
                                }}>
                                <Typography>
                                    memo
                                </Typography>
                            </Paper>
                        </Grid>
                    </Grid>
                </Box>
                <Box
                    sx={{
                        width: "100%",
                        height: "50px",
                        justifyContent: "flex-start",
                        alignItems: "center",
                        display: "flex",
                        paddingLeft: "10px",
                        marginBottom: "1px",
                    }}>
                    <Box sx={{
                        height: "18px",
                        width: "5px",
                        bgcolor: grey[300],
                        marginRight: "5px"
                    }}/>
                    <Typography sx={{fontSize: 18, fontWeight: "bold"}}>関連のビデオ</Typography>
                </Box>
                <Box sx={{
                    width: "100%",
                    height: "400px",
                    justifyContent: "center",
                    alignItems: "center",
                    display: "flex",
                    minWidth: "320px",
                    maxWidth: "1200px",
                }}>
                    <ViewYouTubeVideo videoId={videoId}/>
                </Box>
            </Box>
        );
    }

    return (
        <>
            <Head title="Anime"/>
            <AnimeHeader/>
            <Box sx={{
                width: "100%",
                minWidth: "300px",
                maxWidth: "2000px",
                justifyContent: "center",
                alignItems: "center",
                display: "flex",
            }}>
                <ViewItem/>
            </Box>
        </>
    );
};

export default Anime;
