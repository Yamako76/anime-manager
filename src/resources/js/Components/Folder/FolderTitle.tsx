import React from "react";
import Box from "@mui/material/Box";
import Tooltip from "@mui/material/Tooltip";
import Grid from "@mui/material/Grid";
// import SortItem from '../tool/SortItem';
import { getBoxWidth } from "@/Components/AllAnime/tool/tool";
import AddFolderAnime from "@/Components/Folder/tool/AddFolderAnime";

interface Props {
    name: string;
    handleReload: () => void;
}

const Main = ({ titleWidth, name, handleReload }) => {
    const contentList = [
        {
            body: (
                <Tooltip title={`${name}の一覧`} placement="bottom-end">
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
                        {`${name}の一覧`}
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
            body: (
                <AddFolderAnime handleReload={handleReload} folderName={name} />
            ),
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

const FolderTitle = ({ name, handleReload }: Props) => {
    const titleWidth = getBoxWidth() - 100;

    return (
        <Box>
            <Main
                titleWidth={titleWidth}
                name={name}
                handleReload={handleReload}
            />
        </Box>
    );
};

export default FolderTitle;
