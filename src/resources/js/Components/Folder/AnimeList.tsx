import React from "react";
import { Box, Grid } from "@mui/material";
import Typography from "@mui/material/Typography";
import Button from "@mui/material/Button";

interface Props {
    setIsEdit: (b: boolean) => void;
}

export default function AnimeList({ setIsEdit }: Props) {
    return (
        <>
            <Grid container alignItems={"center"} justifyContent={"center"}>
                <Box
                    sx={{
                        marginTop: 1,
                        display: "inline",
                    }}
                >
                    <Typography
                        fontSize={20}
                        fontWeight={"bold"}
                        marginLeft={-40}
                        display={"inline"}
                    >
                        コメディー
                    </Typography>
                    <Box sx={{ display: "inline" }}>
                        <Button
                            sx={{ marginTop: -1 }}
                            onClick={() => {
                                setIsEdit(true);
                            }}
                        >
                            編集
                        </Button>
                    </Box>
                </Box>
            </Grid>
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
                    <Typography textAlign={"center"} marginTop={1}>
                        2006年
                    </Typography>
                    <Typography textAlign={"center"} marginTop={1}>
                        春
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
                    <Typography textAlign={"center"} marginTop={1}>
                        1980年
                    </Typography>
                    <Typography textAlign={"center"} marginTop={1}>
                        夏
                    </Typography>
                </Box>
            </Grid>
        </>
    );
}
