import React from "react";
import { Box, Grid } from "@mui/material";
import Typography from "@mui/material/Typography";

interface Props {}

const AllAnime = ({}: Props) => {
    return (
        <>
            <Grid
                container
                alignItems={"center"}
                justifyContent={"center"}
                marginTop={3}
                direction={"row"}
            >
                <Box
                    sx={{
                        backgroundColor: "gray",
                        width: 140,
                        height: 160,
                        borderRadius: 5,
                        margin: 3,
                    }}
                >
                    <Typography textAlign={"center"} paddingTop={2}>
                        銀魂
                    </Typography>
                </Box>
                <Box
                    sx={{
                        backgroundColor: "gray",
                        width: 140,
                        height: 160,
                        borderRadius: 5,
                        margin: 3,
                    }}
                >
                    <Typography textAlign={"center"} paddingTop={2}>
                        ドラゴンボールGT
                    </Typography>
                </Box>
            </Grid>
        </>
    );
};

export default AllAnime;
