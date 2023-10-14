import React, {useContext, useEffect, useRef, useState} from "react";
import {Box, Divider, Grid} from "@mui/material";
import AllAnime from "@/Components/AllAnime/AllAnime";
import {getBoxWidth} from "@/Components/AllAnime/tool/tool";
import AnimeListTitle from "@/Components/AllAnime/AnimeListTitle";
import SearchBar from "@/Components/AllAnime/SearchBar";
// import { useNavigate } from "react-router-dom";
import {NoticeContext} from "@/Components/common/Notification";
import {SortContext} from "@/Components/common/SortManagement";

const AnimeManagement = () => {
        const BoxWidth = getBoxWidth();
        const [value, setValue] = useState<string>("");
        const [items, setItems] = useState([]);
        const [reRender, setReRender] = useState(true);
        const [isLoading, setIsLoading] = useState(true);
        const [hasMore, setHasMore] = useState(true);
        const [state, dispatch] = useContext(SortContext);
        const [notice_state, notice_dispatch] = useContext(NoticeContext);
        // const navigate = useNavigate();
        const isMounted = useRef(false);
        const page = useRef(1);

        useEffect(() => {
            isMounted.current = true;
            return () => {
                isMounted.current = false;
            };
        }, []);

        const handleChange = (e) => {
            setValue(e.target.value);
        };

        const handleReRender = () => {
            setReRender(true);
        };

        const handleRefresh = () => {
            setValue("");
        };

        const handleReload = () => {
            if (isLoading || !isMounted.current) {
                return;
            }
            handleRefresh();
            setIsLoading(true);
            setItems([]);
            page.current = 1;
            handleReRender();
            setHasMore(true);
        };

        const handleSubmit = () => {
            if (isLoading || !isMounted.current) {
                return;
            }
            if (value.trim() === "") {
                return;
            }
            setHasMore(false);
            setIsLoading(true);
            setItems([]);
            // searchItems();
        };

        // const failedToLoad = () => {
        //     notice_dispatch({
        //         type: "update_message",
        //         payload: "アニメの読み込みに失敗しました",
        //     });
        //     notice_dispatch({ type: "handleNoticeOpen" });
        //     navigate("/app/home", { replace: true });
        // };

        // const isNotExist = (
        //     (items.length) ? <ViewInfiniteScroll/> : <NotExistAnime/>
        // );

        const fetchAnimes = async (page) => {
            let res;
            const abortCtrl = new AbortController();
            const timeout = setTimeout(() => {
                abortCtrl.abort()
            }, 10000);
            try {
                switch (state.sortIndex) {
                    case 1:
                        res = await fetch(`/api/anime-list?page=${page}&sort=latest`, {signal: abortCtrl.signal});
                        break;

                    case 2:
                        res = await fetch(`/api/anime-list?page=${page}&sort=title`, {signal: abortCtrl.signal});
                        break

                    default:
                        res = await fetch(`/api/anime-list?page=${page}&sort=created_at`, {signal: abortCtrl.signal});
                        break
                }
                if (!res.ok) {
                    throw new Error(res.statusText);
                }
            } catch (error) {
                // failedToLoad();
            } finally {
                clearTimeout(timeout);
            }
            return res;
        }

        useEffect(() => {
            const getAnimes = async () => {
                const res = await fetchAnimes(1);
                if (isMounted.current) {
                    const data = await res.json();
                    if (data.last_page === page.current) {
                        setHasMore(false);
                    }
                    setItems(data.data);
                    setIsLoading(false);
                }
            }

            if (reRender) {
                getAnimes();
                setReRender(false);
            }
        }, [reRender])

        // アイテムの並び替えが発生した場合に再読み込み
        useEffect(() => {
            if (!isLoading) {
                handleReload();
            }
        }, [state.sortIndex])


        const Main = () => {
            return (
                <Grid container direction="column" sx={{marginTop: "100px"}}>
                    <Grid container item>
                        <AnimeListTitle
                            handleReload={handleReload}
                            isLoading={isLoading}
                        />
                    </Grid>
                    <Divider/>
                    <AllAnime handleReload={handleReload} items={items}/>
                </Grid>
            );
        };

        return (
            <>
                <Box
                    sx={{
                        width: BoxWidth,
                        display: "flex",
                        justifyContent: "center",
                        minWidth: "300px",
                    }}
                >
                    <Main/>
                    <SearchBar
                        handleChange={handleChange}
                        handleRefresh={handleRefresh}
                        handleReload={handleReload}
                        handleSubmit={handleSubmit}
                        value={value}
                    />
                </Box>
            </>
        );
    }
;

export default AnimeManagement;
