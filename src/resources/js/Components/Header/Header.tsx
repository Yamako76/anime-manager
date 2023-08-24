import AppBar from "@mui/material/AppBar";
import Box from "@mui/material/Box";
import Toolbar from "@mui/material/Toolbar";
import Typography from "@mui/material/Typography";
import Button from "@mui/material/Button";

export default function Header() {
    return (
        <Box sx={{flexGrow: 1}}>
            <AppBar
                position="static"
                sx={{
                    backgroundColor: "#ffc107",
                    width: "100%",
                    margin: "0px",
                }}
            >
                <Toolbar>
                    <Typography
                        variant="h6"
                        component="div"
                        sx={{flexGrow: 1, color: "black"}}
                    >
                        Anime Manager
                    </Typography>
                    <Button
                        sx={{
                            color: "#616161",
                            "&:hover": {
                                color: "#212121",
                            },
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
                </Toolbar>
            </AppBar>
        </Box>
    );
}
