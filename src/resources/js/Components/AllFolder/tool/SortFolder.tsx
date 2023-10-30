import React, { useContext, useState } from "react";
import Box from "@mui/material/Box";
import IconButton from "@mui/material/IconButton";
import SortIcon from "@mui/icons-material/Sort";
import Tooltip from "@mui/material/Tooltip";
import MenuItem from "@mui/material/MenuItem";
import Menu from "@mui/material/Menu";
import { SortContext } from "../../common/SortManagement";

// アイテムの並べ替えをするMenu
// 0:  作成順
// 1:  最新順
// 2:  タイトル順
// でSortする

const options = ["作成順", "最新順", "タイトル順"];

interface Props {
    isLoading: boolean;
}

const SortFolder = ({ isLoading }: Props) => {
    const [anchorEl, setAnchorEl] = useState(null);
    const open = Boolean(anchorEl);
    const [state, dispatch] = useContext(SortContext);

    const handleClick = (e) => {
        setAnchorEl(e.currentTarget);
    };

    const handleClose = () => {
        setAnchorEl(null);
    };

    const handleSortIndex = (index) => {
        handleClose();
        if (isLoading) {
            return;
        }
        dispatch({ type: "setSortIndex", payload: index });
    };

    return (
        <Box>
            <Tooltip title="並び替え">
                <IconButton
                    id="sort-button"
                    aria-controls={open ? "sort-menu" : undefined}
                    aria-haspopup="true"
                    aria-expanded={open ? "true" : undefined}
                    onClick={handleClick}
                >
                    <SortIcon />
                </IconButton>
            </Tooltip>

            <Menu
                id="sort-menu"
                anchorEl={anchorEl}
                open={open}
                onClose={handleClose}
                MenuListProps={{
                    "aria-labelledby": "sort-button",
                }}
            >
                {options.map((option, index) => {
                    return (
                        <MenuItem
                            key={index}
                            selected={index === state.sortIndex}
                            onClick={() => {
                                handleSortIndex(index);
                            }}
                        >
                            {option}
                        </MenuItem>
                    );
                })}
            </Menu>
        </Box>
    );
};

export default SortFolder;
