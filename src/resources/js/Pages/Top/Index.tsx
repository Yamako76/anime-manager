import React from "react";
import Header from "@/Components/Header/Header";
import Typography from "@mui/material/Typography";
import { Box, Button } from "@mui/material";
import { InertiaLink } from "@inertiajs/inertia-react";

const Index = () => {
    return (
        <Box
            sx={{
                backgroundColor: "#212121",
                flex: 1,
                justifyContent: "center",
                alignItems: "center",
                height: `calc(100vh - 65px)`,
                margin: "0px",
                minWidth: "350px",
                paddingBottom: "65px",
            }}
        >
            <Header />
            <Box
                sx={{
                    flexGrow: 1,
                    display: "flex",
                    flexDirection: "column",
                    alignItems: "center",
                    justifyContent: "center",
                    height: "100%",
                }}
            >
                <Typography
                    component="div"
                    sx={{
                        color: "#ffc107",
                        fontSize: "80px",
                        textAlign: "center",
                        fontWeight: "medium",
                    }}
                >
                    Anime Manager
                </Typography>
                <Box
                    sx={{
                        display: "flex",
                        flexDirection: "column",
                        alignItems: "center",
                        marginTop: "50px",
                    }}
                >
                    <Box
                        as={InertiaLink}
                        href="/register"
                        sx={{ marginBottom: "20px" }}
                    >
                        <Button
                            sx={{
                                width: "150px",
                                borderRadius: "25px",
                                backgroundColor: "#e53935",
                                color: "#FFFFFF",
                                fontSize: "16px",
                                boxShadow: "none",
                                "&:hover": {
                                    backgroundColor: "#b71c1c",
                                },
                            }}
                        >
                            新規登録
                        </Button>
                    </Box>
                    <Box
                        as={InertiaLink}
                        href="/login"
                        sx={{ marginBottom: "20px" }}
                    >
                        <Button
                            sx={{
                                width: "150px",
                                borderRadius: "25px",
                                backgroundColor: "#37474f",
                                color: "#FFFFFF",
                                fontSize: "16px",
                                boxShadow: "none",
                                "&:hover": {
                                    backgroundColor: "#263238",
                                },
                            }}
                        >
                            ログイン
                        </Button>
                    </Box>
                    <Box as={InertiaLink} href="/guest">
                        <Button
                            sx={{
                                width: "150px",
                                borderRadius: "25px",
                                backgroundColor: "#ffc107",
                                color: "black",
                                fontSize: "16px",
                                boxShadow: "none",
                                "&:hover": {
                                    backgroundColor: "#ffeb3b",
                                },
                            }}
                        >
                            ゲストログイン
                        </Button>
                    </Box>
                </Box>
            </Box>
        </Box>
    );
};

export default Index;
