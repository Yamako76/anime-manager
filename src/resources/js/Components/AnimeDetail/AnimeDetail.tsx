import React, {useEffect, useRef, useState} from "react";
import {Box} from "@mui/material";
import Button from "@mui/material/Button";
import axios from "axios";
import Divider from "@mui/material/Divider";
import ArrowBackIcon from "@mui/icons-material/ArrowBack";
import {grey} from "@mui/material/colors";
import Typography from "@mui/material/Typography";
import ViewYouTubeVideo from "@/Components/YouTubeApi/ViewYouTubeVideo";
import ViewAnimeTitle from "@/Components/AnimeDetail/ViewAnimeTitle";
import EditAnime from "@/Components/AllAnime/tool/EditAnime";
// import {useNavigate} from "react-router-dom";
import ApiCommunicationFailed from "@/Components/common/ApiCommunicationFailed";

interface AnimeProps {
    name: string;
    memo: string;
    id: number;
}

const AnimeDetail = ({name, memo, id}: AnimeProps) => {
    const [videoId, setVideoId] = useState();
    const [isLoading, setIsLoading] = useState(true);
    const [isFailedSnackbar, setIsFailedSnackbar] = useState(false);
    // const navigate = useNavigate();
    const isMounted = useRef(false);

    const handleSnackbarClose = () => {
        setIsFailedSnackbar(false);
        location.reload();
    };

    const handleSnackbarFailed = () => {
        setIsFailedSnackbar(true);
    }

    useEffect(() => {
        isMounted.current = true;
        return () => {
            isMounted.current = false;
        };
    }, []);

    useEffect(() => {
        const getAnime = async () => {
            const youTubeVideoId = await fetchYouTubeVideoId(name);
            setVideoId(youTubeVideoId);
        };
        if (isMounted.current) {
            getAnime();
        }
    }, []);

    // const loader = (
    //     <Grid
    //         container
    //         direction="column"
    //         sx={{
    //             width: "100%",
    //             height: "100vh",
    //             justifyContent: "center",
    //             alignItems: "center",
    //             display: "flex",
    //         }}
    //     >
    //         <Grid
    //             sx={{
    //                 width: "100%",
    //                 justifyContent: "center",
    //                 alignItems: "center",
    //                 display: "flex",
    //             }}
    //         >
    //             <CircularProgress color="inherit" />
    //         </Grid>
    //         <Grid
    //             sx={{
    //                 width: "100%",
    //                 justifyContent: "center",
    //                 alignItems: "center",
    //                 display: "flex",
    //             }}
    //         >
    //             <Typography color="inherit">ロード中</Typography>
    //         </Grid>
    //     </Grid>
    // );

    const fetchYouTubeVideoId = async (keyWord) => {
        const abortCtrl = new AbortController();
        const timeout = setTimeout(() => abortCtrl.abort(), 10000);
        let res;

        try {
            res = await axios.get(
                `https://www.googleapis.com/youtube/v3/search`,
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
                        key: "AIzaSyCp814viDX87DANnIYs8o2SsWwtwPxOMvY",
                    },
                }
            );
        } catch {
            handleSnackbarFailed();
        } finally {
            clearTimeout(timeout);
        }
        if (res.data.items == null) {
            return null;
        }
        return res.data.items[0].id.videoId;
    };

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
                }}
            >
                <Box
                    sx={{
                        justifyContent: "flex-start",
                        alignItems: "flex-end",
                        display: "flex",
                        width: "100%",
                        height: "50px",
                    }}
                >
                    <Button
                        size={"small"}
                        // component={Link}
                        // to={"/app/home/folders/" + folderId + "/items/"}
                        variant="text"
                        startIcon={<ArrowBackIcon/>}
                        sx={{
                            marginRight: "10px",
                            "&:hover": {color: grey[900]},
                        }}
                        color="inherit"
                    >
                        戻る
                    </Button>
                    <EditAnime name={name} memo={memo} id={id}/>
                </Box>
                <Divider
                    sx={{
                        width: "100%",
                        marginTop: "5px",
                        marginBottom: "5px",
                    }}
                />
                <ViewAnimeTitle name={name} memo={memo}/>
                <Box
                    sx={{
                        width: "100%",
                        height: "50px",
                        justifyContent: "flex-start",
                        alignItems: "center",
                        display: "flex",
                        paddingLeft: "10px",
                        marginBottom: "1px",
                    }}
                >
                    <Box
                        sx={{
                            height: "18px",
                            width: "5px",
                            bgcolor: grey[300],
                            marginRight: "5px",
                        }}
                    />
                    <Typography sx={{fontSize: 18, fontWeight: "bold"}}>
                        関連のビデオ
                    </Typography>
                </Box>
                <Box
                    sx={{
                        width: "100%",
                        height: "400px",
                        justifyContent: "center",
                        alignItems: "center",
                        display: "flex",
                        minWidth: "320px",
                        maxWidth: "1200px",
                    }}
                >
                    {/*{videoId == null || !isMounted.current ? null : (*/}
                    {/*    <ViewYouTubeVideo videoId={videoId} />*/}
                    {/*)}*/}
                    <ViewYouTubeVideo videoId={videoId}/>
                </Box>
            </Box>
        );
    };
    return (
        <>
            <Box
                sx={{
                    width: "100%",
                    minWidth: "300px",
                    maxWidth: "2000px",
                    justifyContent: "center",
                    alignItems: "center",
                    display: "flex",
                }}
            >
                {/*{isLoading ? loader : <ViewItem />}*/}
                <ViewItem/>
            </Box>
            {isFailedSnackbar && <ApiCommunicationFailed message={`動画の取得に失敗しました`}
                                                         handleSnackbarClose={handleSnackbarClose}
                                                         isSnackbar={isFailedSnackbar}/>}
        </>
    );
};

export default AnimeDetail;
