import React, { useContext, useEffect, useRef, useState } from "react";
import { Box, Divider, Grid, Skeleton } from "@mui/material";
import { getBoxWidth } from "@/Components/AllAnime/tool/tool";
import SearchBar from "@/Components/AllAnime/SearchBar";
import { SortContext } from "@/Components/common/SortManagement";
import ApiErrorDialog from "@/Components/common/ApiErrorDialog";
import InfiniteScroll from "react-infinite-scroller";
import NotExistAnimes from "@/Components/common/NotExistAnimes";
import FolderTitle from "@/Components/Folder/FolderTitle";
import AnimeList from "@/Components/Folder/AnimeList";
import { FolderAnime } from "@/Components/FolderAnime";

interface FolderProps {
    name: string;
    id: number;
}

// フォルダ内のアニメ一覧の管理画面
// - 新しいアニメの追加
// - 既存アニメの削除
// - フォルダ内のアニメの検索 を実装
const AnimeManagement = ({ name, id }: FolderProps) => {
    const BoxWidth: number = getBoxWidth();
    const [value, setValue] = useState<string>("");
    const [animes, setAnimes] = useState<FolderAnime[]>([]);
    const [reRender, setReRender] = useState<boolean>(true);
    const [isLoading, setIsLoading] = useState<boolean>(true);
    const [hasMore, setHasMore] = useState<boolean>(true);
    const [isDialog, setIsDialog] = useState<boolean>(false);
    const [state, dispatch] = useContext(SortContext);
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
        setAnimes([]);
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
        setAnimes([]);
        searchFolderAnimes();
    };

    const handleDialogOpen = () => {
        setIsDialog(true);
    };
    const handleDialogClose = () => {
        setIsDialog(false);
        location.reload();
    };

    const fetchAnimes = async (page) => {
        let res;
        const abortCtrl = new AbortController();
        const timeout = setTimeout(() => {
            abortCtrl.abort();
        }, 10000);
        try {
            switch (state.sortIndex) {
                case 1:
                    // 最新順にアニメを取得
                    res = await fetch(
                        `/api/folders/${id}/anime-list?page=${page}&sort=latest`,
                        { signal: abortCtrl.signal }
                    );
                    break;

                case 2:
                    // タイトル順にアニメを取得
                    res = await fetch(
                        `/api/folders/${id}/anime-list?page=${page}&sort=title`,
                        { signal: abortCtrl.signal }
                    );
                    break;

                default:
                    // 作成順にアニメを取得
                    res = await fetch(
                        `/api/folders/${id}/anime-list?page=${page}&sort=created_at`,
                        { signal: abortCtrl.signal }
                    );
                    break;
            }
            if (!res.ok) {
                throw new Error(res.statusText);
            }
        } catch (error) {
            handleDialogOpen();
        } finally {
            clearTimeout(timeout);
        }
        return res;
    };

    const searchFolderAnimes = async () => {
        const abortCtrl = new AbortController();
        const timeout = setTimeout(() => {
            abortCtrl.abort();
        }, 10000);
        try {
            const res = await fetch(
                `/api/folders/${id}/anime-list/search?q=${value.trim()}`,
                { signal: abortCtrl.signal }
            );
            if (!res.ok) {
                throw new Error(res.statusText);
            }
            const data = await res.json();
            if (!isMounted.current) {
                return;
            }
            setAnimes(data);
            setIsLoading(false);
        } catch (error) {
            handleDialogOpen();
        } finally {
            clearTimeout(timeout);
        }
    };

    // Mountされた時点でアニメ読み込みを開始し
    // reRenderがtrueになるたびに再読み込み
    useEffect(() => {
        const getAnimes = async () => {
            const res = await fetchAnimes(1);
            if (isMounted.current) {
                const data = await res.json();
                if (data.last_page === page.current) {
                    setHasMore(false);
                }
                setAnimes(data.data);
                setIsLoading(false);
            }
        };

        if (reRender) {
            getAnimes();
            setReRender(false);
        }
    }, [reRender]);

    // アニメの並び替えが発生した場合に再読み込み
    useEffect(() => {
        if (!isLoading) {
            handleReload();
        }
    }, [state.sortIndex]);

    // 無限スクロールで呼ばれるアイテムの読み込みを行う関数
    const loadMore = async () => {
        page.current++;
        const res = await fetchAnimes(page.current);
        if (isMounted.current) {
            const data = await res.json();
            if (data.last_page === page.current) {
                setHasMore(false);
            }
            setAnimes([...animes, ...data.data]);
        }
    };

    // 無限スクロールで読み込み中に表示するコンポーネント
    const loader = (
        <Skeleton
            key={0}
            variant="rectangular"
            sx={{ width: BoxWidth, height: "50px", marginTop: "10px" }}
        />
    );

    // 無限スクロール用のコンポーネント
    const ViewInfiniteScroll = () => {
        return (
            <Box sx={{ marginBottom: "100px" }}>
                <InfiniteScroll
                    pageStart={1}
                    initialLoad={false}
                    loadMore={loadMore}
                    hasMore={hasMore}
                    loader={loader}
                >
                    <AnimeList
                        handleReload={handleReload}
                        animes={animes}
                        id={id}
                    />
                </InfiniteScroll>
            </Box>
        );
    };

    // アニメが存在するときとそうでないときに表示する分岐
    const isNotExist = animes.length ? (
        <ViewInfiniteScroll />
    ) : (
        <NotExistAnimes />
    );

    // コンテンツのMain部分
    // アニメ一覧を表示
    const Main = () => {
        return (
            <Grid container direction="column" sx={{ marginTop: "100px" }}>
                <Grid container item>
                    <FolderTitle
                        name={name}
                        id={id}
                        handleReload={handleReload}
                        isLoading={isLoading}
                    />
                </Grid>
                <Divider />
                {/* アイテム一覧 */}
                <Grid container item>
                    {isLoading ? loader : isNotExist}
                </Grid>
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
                <Main />
                {/* フォルダ内のアニメ検索 */}
                <SearchBar
                    handleChange={handleChange}
                    handleRefresh={handleRefresh}
                    handleReload={handleReload}
                    handleSubmit={handleSubmit}
                    value={value}
                />
            </Box>
            {isDialog && (
                <ApiErrorDialog
                    isDialog={isDialog}
                    handleDialogClose={handleDialogClose}
                    message={"アニメの読み込みに失敗しました"}
                />
            )}
        </>
    );
};
export default AnimeManagement;
