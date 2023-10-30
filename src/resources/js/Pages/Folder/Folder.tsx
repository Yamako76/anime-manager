import {Head} from "@inertiajs/react";
import React from "react";
import {Box} from "@mui/material";
import AnimeHeader from "../../Components/Header/AnimeHeader";
import SortManagement from "@/Components/common/SortManagement"
import FolderAnimeManagement from "@/Components/Folder/FolderAnimeManagement";

//　/folders/folderIdの画面へ出力する要素
// folderIdによって選択されたアニメ詳細画面を表示

interface FolderProps {
    name: string;
    id: number;
}

const Folder = ({name, id}: FolderProps) => {


    return (
        <>
            <Head title="FolderAnime"/>
            <AnimeHeader/>
            <Box sx={{display: "flex", justifyContent: "center"}}>
                <SortManagement>
                    <FolderAnimeManagement name={name} id={id}/>
                </SortManagement>
            </Box>
        </>
    );
};

export default Folder;
