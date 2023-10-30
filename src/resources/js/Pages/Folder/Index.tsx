import { Head } from "@inertiajs/react";
import React from "react";
import { Box } from "@mui/material";
import AnimeHeader from "../../Components/Header/AnimeHeader";
import SortManagement from "@/Components/common/SortManagement";
import FolderManagement from "@/Components/AllFolder/FolderManagement";

// /foldersの画面へ出力する要素
//  フォルダ一覧画面を表示
const Index = () => {
    return (
        <>
            <Head title="Folder" />
            <AnimeHeader />
            <Box sx={{ display: "flex", justifyContent: "center" }}>
                <SortManagement>
                    <FolderManagement />
                </SortManagement>
            </Box>
        </>
    );
};

export default Index;
