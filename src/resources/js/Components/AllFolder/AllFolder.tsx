import React from "react";
import { Box, Grid } from "@mui/material";
import { getBoxWidth } from "@/Components/AllAnime/tool/tool";
import Tooltip from "@mui/material/Tooltip";
import { InertiaLink } from "@inertiajs/inertia-react";
import { grey } from "@mui/material/colors";
import DeleteFolder from "@/Components/AllFolder/tool/DeleteFolder";
import Paper from "@mui/material/Paper";
import EditFolder from "@/Components/AllFolder/tool/EditFolder";

interface Props {
    handleReload: () => void;
}

const AllFolder = ({ handleReload }: Props) => {
    const BoxWidth = getBoxWidth();
    const titleWidth = BoxWidth - 90;

    const FolderList: string[] = [
        "コメディー",
        "アクション",
        "ホラー",
        "恋愛",
        "泣ける",
        "サスペンス",
        "ミステリー",
        "ミステリー",
        "ミステリー",
        "ミステリー",
        "ミステリー",
        "ミステリー",
        "ミステリー",
        "ミステリー",
        "ミステリー",
        "ミステリー",
        "ミステリー",
        "ミステリー",
        "ミステリー",
    ];

    const PaperContent = ({ item, handleReload }) => {
        const contentList = [
            {
                body: (
                    <Tooltip title={item + "の詳細"} placement="bottom-end">
                        <Box
                            textOverflow="ellipsis"
                            overflow="hidden"
                            fontSize={20}
                            as={InertiaLink}
                            href="/folders/a"
                            sx={{
                                margin: "0px 5px",
                                width: String(titleWidth - 10) + "px",
                                color: grey[900],
                                textDecoration: "none",
                                "&:hover": { color: grey[900] },
                            }}
                        >
                            {item}
                        </Box>
                    </Tooltip>
                ),
                sx: {
                    width: String(titleWidth) + "px",
                    display: "flex",
                    justifyContent: "flex-start",
                    alignItems: "flex-end",
                },
            },
            {
                body: <EditFolder folder={item} />,
                sx: {
                    width: "40px",
                    display: "flex",
                    justifyContent: "center",
                    alignItems: "flex-end",
                },
            },
            {
                body: <DeleteFolder handleReload={handleReload} />,
                sx: {
                    width: "40px",
                    display: "flex",
                    justifyContent: "center",
                    alignItems: "flex-end",
                },
            },
        ];

        return (
            <Paper
                variant="outlined"
                sx={{
                    width: "100%",
                    height: "50px",
                    display: "flex",
                    alignItems: "center",
                    color: grey[900],
                    textDecoration: "none",
                    "&:hover": {
                        color: grey[900],
                        outline: "solid",
                        outlineColor: grey[900],
                    },
                }}
            >
                <Grid container>
                    {contentList.map((content, index) => {
                        return (
                            <Grid key={index} container item sx={content.sx}>
                                {content.body}
                            </Grid>
                        );
                    })}
                </Grid>
            </Paper>
        );
    };

    // アイテム一覧
    const ItemList = (handleReload) => {
        return (
            <Box
                sx={{
                    width: "100%",
                    display: "flex",
                    justifyContent: "center",
                    marginTop: "10px",
                }}
            >
                <Grid container direction="column" spacing={1}>
                    {FolderList.map((item, index) => (
                        <Grid key={index} container item>
                            <PaperContent
                                item={item}
                                handleReload={handleReload}
                            />
                        </Grid>
                    ))}
                </Grid>
            </Box>
        );
    };

    return (
        <Box>
            <ItemList handleReload={handleReload} />
        </Box>
    );
};

export default AllFolder;
