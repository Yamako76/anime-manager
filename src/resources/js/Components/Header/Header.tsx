import AppBar from "@mui/material/AppBar";
import Box from "@mui/material/Box";
import Toolbar from "@mui/material/Toolbar";
import Typography from "@mui/material/Typography";
import Button from "@mui/material/Button";
import Menu from "@mui/material/Menu";
import MenuItem from "@mui/material/MenuItem";
import {createTheme, ThemeProvider, useMediaQuery} from "@mui/material";
import {useState} from "react";

const Header = () => {
    const theme = createTheme(); // テーマの作成
    const isSmallScreen = useMediaQuery(theme.breakpoints.down("sm"));

    const [menuAnchor, setMenuAnchor] = useState(null);

    const handleMenuOpen = (event) => {
        setMenuAnchor(event.currentTarget);
    };

    const handleMenuClose = () => {
        setMenuAnchor(null);
    };

    return (
        <ThemeProvider theme={theme}>
            <Box sx={{flexGrow: 1}}>
                <AppBar
                    position="static"
                    sx={{
                        backgroundColor: "#ffc107",
                        width: "100%",
                        margin: "0px",
                        minWidth: "300px",
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
                            sx={{color: "black"}}
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
                                    <MenuItem sx={{
                                        color: "#616161",
                                        "&:hover": {
                                            color: "#212121",
                                        },
                                    }}> 新規登録 < /MenuItem>
                                    <MenuItem sx={{
                                        color: "#616161",
                                        "&:hover": {
                                            color: "#212121",
                                        },
                                    }}>ログイン</MenuItem>
                                    <MenuItem sx={{
                                        color: "#616161",
                                        "&:hover": {
                                            color: "#212121",
                                        },
                                    }}>ゲストログイン</MenuItem>
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
                                    新規登録
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
                                    ログイン
                                </Button>
                                <Button
                                    sx={{
                                        color: "#616161",
                                        "&:hover": {
                                            color: "#212121",
                                        },
                                    }}
                                >
                                    ゲストログイン
                                </Button>
                            </div>
                        )}
                    </Toolbar>
                </AppBar>
            </Box>
        </ThemeProvider>
    );
};

export default Header;
