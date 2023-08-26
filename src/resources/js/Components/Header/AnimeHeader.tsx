import AppBar from "@mui/material/AppBar";
import Box from "@mui/material/Box";
import Toolbar from "@mui/material/Toolbar";
import Typography from "@mui/material/Typography";
import Button from "@mui/material/Button";
import Menu from "@mui/material/Menu";
import MenuItem from "@mui/material/MenuItem";
import { createTheme, ThemeProvider, useMediaQuery } from "@mui/material";
import { useState } from "react";

const AnimeHeader = () => {
    const theme = createTheme();
    const isSmallScreen = useMediaQuery(theme.breakpoints.down(550));

    const [menuAnchor, setMenuAnchor] = useState(null);

    const handleMenuOpen = (event) => {
        setMenuAnchor(event.currentTarget);
    };

    const handleMenuClose = () => {
        setMenuAnchor(null);
    };

    return (
        <ThemeProvider theme={theme}>
            <Box sx={{ flexGrow: 1 }}>
                <AppBar
                    position="static"
                    sx={{
                        backgroundColor: "#ffc107",
                        width: "100%",
                        margin: "0px",
                        minWidth: "300px",
                        height: "64px",
                    }}
                >
                    <Toolbar
                        sx={{
                            display: "flex",
                            justifyContent: "space-between",
                        }}
                    >
                        <Typography
                            variant="h6"
                            component="div"
                            sx={{ color: "black", lineHeight: "64px" }}
                        >
                            Anime Manager
                        </Typography>
                        {isSmallScreen ? (
                            <div>
                                <Button
                                    onClick={handleMenuOpen}
                                    sx={{
                                        color: "#616161",
                                        "&:hover": {
                                            color: "#212121",
                                        },
                                    }}
                                >
                                    メニュー
                                </Button>
                                <Menu
                                    anchorEl={menuAnchor}
                                    open={Boolean(menuAnchor)}
                                    onClose={handleMenuClose}
                                    PaperProps={{
                                        sx: {
                                            backgroundColor: "#ffc107",
                                            color: "#616161",
                                        },
                                    }}
                                >
                                    <MenuItem
                                        sx={{
                                            color: "#616161",
                                            "&:hover": {
                                                color: "#212121",
                                            },
                                        }}
                                    >
                                        アニメ一覧
                                    </MenuItem>
                                    <MenuItem
                                        sx={{
                                            color: "#616161",
                                            "&:hover": {
                                                color: "#212121",
                                            },
                                        }}
                                    >
                                        フォルダ一覧
                                    </MenuItem>
                                    <MenuItem
                                        sx={{
                                            color: "#616161",
                                            "&:hover": {
                                                color: "#212121",
                                            },
                                        }}
                                    >
                                        ログアウト
                                    </MenuItem>
                                </Menu>
                            </div>
                        ) : (
                            <div>
                                <Button
                                    sx={{
                                        color: "#616161",
                                        "&:hover": {
                                            color: "#212121",
                                        },
                                        marginRight: 1,
                                    }}
                                >
                                    アニメ一覧
                                </Button>
                                <Button
                                    sx={{
                                        color: "#616161",
                                        "&:hover": {
                                            color: "#212121",
                                        },
                                        marginRight: 1,
                                    }}
                                >
                                    フォルダ一覧
                                </Button>
                                <Button
                                    sx={{
                                        color: "#616161",
                                        "&:hover": {
                                            color: "#212121",
                                        },
                                    }}
                                >
                                    ログアウト
                                </Button>
                            </div>
                        )}
                    </Toolbar>
                </AppBar>
            </Box>
        </ThemeProvider>
    );
};

export default AnimeHeader;
