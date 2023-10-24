import React from "react";
import Box from "@mui/material/Box";
import Tooltip from "@mui/material/Tooltip";
import Grid from "@mui/material/Grid";
// import SortItem from '../tool/SortItem';
import {getBoxWidth} from "@/Components/AllAnime/tool/tool";
import AddFolderAnime from "@/Components/Folder/tool/AddFolderAnime";
import SortAnime from "@/Components/Folder/tool/SortAnime";

interface Props {
    name: string;
    id: number;
    handleReload: () => void;

    isLoading: boolean;
}

interface MainProps {
    titleWidth: number;
    name: string;
    handleReload: () => void;
    isLoading: boolean;
    id: number;

}


const Main = ({titleWidth, name, handleReload, isLoading, id}: MainProps) => {
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
                <AddFolderAnime handleReload={handleReload} folderName={name} id={id}/>
            ),
            sx: {
                width: "50px",
                display: "flex",
                justifyContent: "center",
                alignItems: "flex-end",
            },
        },
        {
            "body": <SortAnime isLoading={isLoading}/>,
            "sx": {width: "50px", display: "flex", justifyContent: "center", alignItems: "flex-end"},
        }
    ];

    return (
        <Grid
            container
            sx={{height: "60px", marginBottom: "5px", marginTop: "20px"}}
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

const FolderTitle = ({name, handleReload, isLoading, id}: Props) => {
    const titleWidth: number = getBoxWidth() - 100;

    return (
        <Box>
            <Main
                titleWidth={titleWidth}
                name={name}
                id={id}
                handleReload={handleReload}
                isLoading={isLoading}
            />
        </Box>
    );
};

export default FolderTitle;
