import React from "react";
import {Box, Grid} from "@mui/material";
import {getBoxWidth} from "@/Components/AllAnime/tool/tool";
import Tooltip from "@mui/material/Tooltip";
import {InertiaLink} from "@inertiajs/inertia-react";
import {grey} from "@mui/material/colors";
import DeleteFolder from "@/Components/AllFolder/tool/DeleteFolder";
import Paper from "@mui/material/Paper";
import EditFolder from "@/Components/AllFolder/tool/EditFolder";

interface Props {
    handleReload: () => void;
    folders: any[];
}

const AllFolder = ({handleReload, folders}: Props) => {
    const BoxWidth = getBoxWidth();
    const titleWidth = BoxWidth - 90;

    const PaperContent = ({folder}) => {
        const contentList = [
            {
                body: (
                    <Tooltip title={folder.name + "の詳細"} placement="bottom-end">
                        <Box
                            textOverflow="ellipsis"
                            overflow="hidden"
                            fontSize={20}
                            as={InertiaLink}
                            href={`/folders/${folder.id}`}
                            sx={{
                                margin: "0px 5px",
                                width: String(titleWidth - 10) + "px",
                                color: grey[900],
                                textDecoration: "none",
                                "&:hover": {color: grey[900]},
                            }}
                        >
                            {folder.name}
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
                body: <EditFolder folder={folder} handleReload={handleReload}/>,
                sx: {
                    width: "40px",
                    display: "flex",
                    justifyContent: "center",
                    alignItems: "flex-end",
                },
            },
            {
                body: <DeleteFolder handleReload={handleReload} folder={folder}/>,
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

    // フォルダ一覧
    const FolderList = () => {
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
                    {folders.map((folder, index) => (
                        <Grid key={index} container item>
                            <PaperContent
                                folder={folder}
                            />
                        </Grid>
                    ))}
                </Grid>
            </Box>
        );
    };

    return (
        <Box>
            <FolderList handleReload={handleReload}/>
        </Box>
    );
};

export default AllFolder;
