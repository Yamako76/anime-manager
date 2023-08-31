import React, { useContext, useEffect, useState } from "react";
import Box from "@mui/material/Box";
import Tooltip from "@mui/material/Tooltip";
import Grid from "@mui/material/Grid";
// import SortItem from '../tool/SortItem';
import { getBoxWidth } from "@/Components/AllAnime/tool/tool";
import AddAnime from "@/Components/AllAnime/tool/AddAnime";
import { NoticeContext } from "@/Components/common/Notification";
import { useNavigate } from "react-router-dom";

interface Props {}

// コンテンツMain部分
const Main = ({ titleWidth, handleReload }) => {
    const contentList = [
        {
            body: (
                <Tooltip title={`アニメ一覧`} placement="bottom-end">
                    <Box
                        component="div"
                        textOverflow="ellipsis"
                        overflow="hidden"
                        fontSize={15}
                        fontWeight="bold"
                        sx={{
                            width: "100%",
                            height: "20px",
                            marginBottom: "10px",
                        }}
                    >
                        {`アニメ一覧`}
                    </Box>
                </Tooltip>
            ),
            sx: {
                width: titleWidth,
                display: "flex",
                justifyContent: "flex-start",
                alignItems: "flex-end",
            },
        },
        {
            body: <AddAnime handleReload={handleReload} />,
            sx: {
                width: "50px",
                display: "flex",
                justifyContent: "center",
                alignItems: "flex-end",
            },
        },
        // {
        //     "body": <SortItem/>,
        //     "sx": {width: "50px", display: "flex", justifyContent: "center", alignItems: "flex-end"},
        // }
    ];

    return (
        <Grid
            container
            sx={{ height: "60px", marginBottom: "5px", marginTop: "20px" }}
        >
            {contentList.map((content, index) => {
                return (
                    <Grid key={index} container item sx={content.sx}>
                        {content.body}
                    </Grid>
                );
            })}
        </Grid>
    );
};

const AnimeListTitle = ({ handleReload, isLoading }) => {
    const titleWidth = getBoxWidth() - 100;
    // const [state, dispatch] = useContext(FolderStatusManagementContext);
    // const [notice_state, notice_dispatch] = useContext(NoticeContext);
    // const [folder, setFolder] = useState(null);
    // const navigate = useNavigate();

    // const NotFound = () => {
    //     notice_dispatch({type: "update_message", payload: "フォルダの読み込みに失敗したか存在しないページにアクセスした可能性があります"});
    //     notice_dispatch({type: "handleNoticeOpen"});
    //     navigate('/anime-list', {replace: true});
    // }

    // useEffect(() => {
    //     if (!state.isLoading) {
    //         if (state.all_folders != null) {
    //             const current_folder = state.all_folders.find((item) => String(item.id) === folderId);
    //             setFolder(current_folder);
    //             if (current_folder == null) {
    //                 NotFound();
    //             }
    //         }
    //     }
    // }, [state.isLoading])

    return (
        <Box>
            <Main titleWidth={titleWidth} handleReload={handleReload} />
        </Box>
    );
};

export default AnimeListTitle;
