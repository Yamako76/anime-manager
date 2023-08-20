import AppBar from "@mui/material/AppBar";
import Box from "@mui/material/Box";
import Toolbar from "@mui/material/Toolbar";
import Typography from "@mui/material/Typography";
import Button from "@mui/material/Button";

export default function Header() {
    return (
        <Box sx={{ flexGrow: 1 }}>
            <AppBar position="static" style={{ backgroundColor: "black" }}>
                <Toolbar>
                    <Typography
                        variant="h6"
                        component="div"
                        sx={{ flexGrow: 1 }}
                    >
                        Anime Manager
                    </Typography>
                    <Button color="inherit">アニメ一覧</Button>
                    <Button color="inherit">フォルダ一覧</Button>
                    <Button color="inherit">タグ一覧</Button>
                    <Button color="inherit">ログアウト</Button>
                </Toolbar>
            </AppBar>
        </Box>
    );
}
