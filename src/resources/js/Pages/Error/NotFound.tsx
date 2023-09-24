import { Head } from "@inertiajs/react";
import React from "react";
import AnimeHeader from "../../Components/Header/AnimeHeader";
import { Box, Typography } from "@mui/material";

const NotFound = () => {
    return (
        <Box
            sx={{
                flex: 1,
                justifyContent: "center",
                alignItems: "center",
                height: "100vh",
                margin: "0px",
                minWidth: "350px",
                paddingBottom: "65px",
            }}
        >
            <Head title="NotFound" />
            <AnimeHeader />
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
                <Typography variant="h4" fontWeight="bold" mb={4}>
                    404 Not Found
                </Typography>
                <Typography variant="body1" color="text.secondary">
                    ページが見つかりませんでした。
                </Typography>
            </Box>
        </Box>
    );
};

export default NotFound;
