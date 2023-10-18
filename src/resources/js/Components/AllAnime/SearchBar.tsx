import React from "react";
import Box from "@mui/material/Box";
import Paper from "@mui/material/Paper";
import IconButton from "@mui/material/IconButton";
import InputBase from "@mui/material/InputBase";
import Tooltip from "@mui/material/Tooltip";
import SearchIcon from "@mui/icons-material/Search";
import RefreshIcon from "@mui/icons-material/Refresh";
import ClearButton from "@/Components/Button/ClearButton";
import { getBoxWidth, getSearchBarWidth } from "./tool/tool";
import { pressEnter } from "@/Components/common/tool";

interface Props {
    handleChange: (e) => void;
    handleRefresh: () => void;

    handleReload: () => void;

    handleSubmit: () => void;

    value: string;
}

const SearchBar = ({
    handleChange,
    handleRefresh,
    handleReload,
    handleSubmit,
    value,
}: Props) => {
    const BoxWidth = getBoxWidth();
    const SearchBarWidth = getSearchBarWidth();

    const box_sx = {
        position: "fixed",
        display: "flex",
        justifyContent: "center",
        height: 100,
        width: BoxWidth,
    };

    const paper_sx = {
        margin: "20px auto",
        display: "flex",
        alignItems: "center",
        width: SearchBarWidth,
    };
    return (
        <Box sx={box_sx}>
            <Paper elevation={24} sx={paper_sx}>
                <Tooltip title="検索">
                    <IconButton onClick={handleSubmit}>
                        <SearchIcon />
                    </IconButton>
                </Tooltip>
                <InputBase
                    sx={{ ml: 1, flex: 1 }}
                    placeholder="アニメ検索"
                    value={value}
                    onChange={handleChange}
                    onKeyDown={(e) => {
                        pressEnter(e, handleSubmit);
                    }}
                />
                {value === "" ? null : (
                    <ClearButton
                        title="検索のクリア"
                        handleRefresh={handleRefresh}
                    />
                )}
                <Tooltip title="アニメの再読み込み" placement="bottom">
                    <IconButton onClick={handleReload}>
                        <RefreshIcon />
                    </IconButton>
                </Tooltip>
            </Paper>
        </Box>
    );
};

export default SearchBar;
