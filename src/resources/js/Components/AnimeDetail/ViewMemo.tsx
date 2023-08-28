import { Box, Grid } from "@mui/material";
import { grey } from "@mui/material/colors";
import Typography from "@mui/material/Typography";
import Paper from "@mui/material/Paper";
import React from "react";

const ViewMemo = () => {
    return (
        <Box
            sx={{
                width: "100%",
                height: "250px",
                justifyContent: "center",
                alignItems: "center",
                display: "flex",
                paddingLeft: "10px",
            }}
        >
            <Grid
                container
                direction="column"
                sx={{
                    width: "100%",
                    height: "100%",
                    justifyContent: "flex-start",
                    alignItems: "center",
                    display: "flex",
                }}
            >
                <Grid
                    sx={{
                        width: "100%",
                        justifyContent: "flex-start",
                        alignItems: "center",
                        display: "flex",
                        marginBottom: "10px",
                    }}
                >
                    <Box
                        sx={{
                            height: "18px",
                            width: "5px",
                            bgcolor: grey[300],
                            marginRight: "5px",
                        }}
                    />
                    <Typography sx={{ fontSize: 18, fontWeight: "bold" }}>
                        メモ
                    </Typography>
                </Grid>
                <Grid
                    sx={{
                        width: "100%",
                        justifyContent: "flex-start",
                        alignItems: "center",
                        display: "flex",
                        paddingLeft: "5px",
                        paddingRight: "5px",
                    }}
                >
                    <Paper
                        variant="outlined"
                        sx={{
                            width: "100%",
                            height: "200px",
                            justifyContent: "flex-start",
                            alignItems: "flex-start",
                            display: "flex",
                            overflow: "auto",
                            padding: "5px",
                        }}
                    >
                        <Typography>memo</Typography>
                    </Paper>
                </Grid>
            </Grid>
        </Box>
    );
};

export default ViewMemo;
