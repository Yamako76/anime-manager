import { Head } from "@inertiajs/react";
import React from "react";
import Header from "@/Components/Header/Header";
import Typography from "@mui/material/Typography";
import { Button, Grid } from "@mui/material";

export default function Index() {
    return (
        <>
            <Head title="Top" />
            <Header />
            <Grid container alignItems={"center"} justifyContent={"center"}>
                <Grid item xs={"auto"}>
                    <Typography variant="h2" paddingTop={40}>
                        Anime Manager
                    </Typography>
                </Grid>
            </Grid>
            <Grid
                container
                justify={"space-between"}
                alignItems={"center"}
                justifyContent={"center"}
                justifyItems={"space-between"}
                direction={"column"}
            >
                <Button
                    sx={{
                        borderRadius: 50,
                        backgroundColor: "gray",
                        fontSize: 25,
                        color: "black",
                        marginTop: 12,
                    }}
                    size={"medium"}
                >
                    新規登録
                </Button>
                <Button
                    sx={{
                        borderRadius: 50,
                        backgroundColor: "gray",
                        fontSize: 25,
                        color: "black",
                        marginTop: 5,
                    }}
                    size={"medium"}
                >
                    ログイン
                </Button>
            </Grid>
        </>
    );
}
