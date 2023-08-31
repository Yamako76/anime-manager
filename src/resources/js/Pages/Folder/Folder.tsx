import { Head } from "@inertiajs/react";
import React, { useContext, useEffect, useRef, useState } from "react";
import { Box, Divider, Grid } from "@mui/material";
import AnimeHeader from "../../Components/Header/AnimeHeader";
import AnimeList from "@/Components/Folder/AnimeList";
import { getBoxWidth } from "@/Components/AllAnime/tool/tool";
import FolderTitle from "@/Components/Folder/FolderTitle";
import SearchBar from "@/Components/AllAnime/SearchBar";
import { NoticeContext } from "@/Components/common/Notification";
// import { useNavigate } from "react-router-dom";

interface FolderProps {
    name: string;
}

const Folder = ({ name }: FolderProps) => {
    const BoxWidth = getBoxWidth();
    const [value, setValue] = useState<string>("");
    const [items, setItems] = useState([]);
    const [reRender, setReRender] = useState(true);
    const [isLoading, setIsLoading] = useState(true);
    const [hasMore, setHasMore] = useState(true);
    // const [state, dispatch] = useContext(SortContext);
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
        // page.current = 1;
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
    //     (items.length) ? <ViewInfiniteScroll/> : <NotExistFolders/>
    // );

    const Main = () => {
        return (
            <Grid container direction="column" sx={{ marginTop: "100px" }}>
                <Grid container item>
                    <FolderTitle name={name} handleReload={handleReload}/>
                </Grid>
                <Divider />
                <AnimeList handleReload={handleReload} />
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
                        handleReload={handleReload}
                        handleSubmit={handleSubmit}
                        value={value}
                    />
                </Box>
            </Box>
        </>
    );
};

export default Folder;
