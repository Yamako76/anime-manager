import React from "react";
import Header from "@/Components/Header/Header";
import Typography from "@mui/material/Typography";
import {Box, Button} from "@mui/material";

const Index = () => {
    return (
        <Box
            sx={{
                backgroundColor: "#212121",
                flex: 1,
                justifyContent: "center",
                alignItems: "center",
                height: "100vh",
                margin: "0px",
            }}
        >
            <Header/>
            <Box sx={{flexGrow: 1}}>
                <Typography
                    component="div"
                    sx={{
                        color: "#ffc107",
                        fontSize: "80px",
                        textAlign: "center",
                        fontWeight: "medium",
                        marginTop: "300px",
                    }}
                >
                    Anime Manager
                </Typography>
                <Box
                    sx={{
                        flexGrow: 1,
                        display: "flex",
                        flexDirection: "column",
                        justifyContent: "center",
                        alignItems: "center",
                    }}
                >
                    <Button
                        sx={{
                            width: "150px",
                            borderRadius: "25px",
                            backgroundColor: "#e53935",
                            color: "#FFFFFF",
                            fontSize: "16px",
                            boxShadow: "none",
                            alignItems: "center",
                            justifyContent: "center",
                            marginTop: "200px",
                            "&:hover": {
                                backgroundColor: "#b71c1c",
                            },
                        }}
                    >
                        新規登録
                    </Button>
                    <Button
                        sx={{
                            width: "150px",
                            borderRadius: "25px",
                            backgroundColor: "#37474f",
                            color: "#FFFFFF",
                            fontSize: "16px",
                            boxShadow: "none",
                            alignItems: "center",
                            justifyContent: "center",
                            marginTop: "20px",
                            "&:hover": {
                                backgroundColor: "#263238",
                            },
                        }}
                    >
                        ログイン
                    </Button>
                    <Button
                        sx={{
                            width: "150px",
                            borderRadius: "25px",
                            backgroundColor: "#ffc107",
                            color: "black",
                            fontSize: "16px",
                            boxShadow: "none",
                            alignItems: "center",
                            justifyContent: "center",
                            marginTop: "20px",
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
    );
}

export default Index;
