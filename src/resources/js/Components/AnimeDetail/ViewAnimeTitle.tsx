import { Box } from "@mui/material";
import { grey } from "@mui/material/colors";
import Typography from "@mui/material/Typography";
import React from "react";
import ViewMemo from "@/Components/AnimeDetail/ViewMemo";

interface AnimeProps {
    name: string;
    memo: string;
}

const ViewAnimeTitle = ({ name, memo }: AnimeProps) => {
    return (
        <>
            <Box
                sx={{
                    width: "100%",
                    height: "100px",
                    justifyContent: "flex-start",
                    alignItems: "center",
                    display: "flex",
                    paddingLeft: "10px",
                }}
            >
                <Box
                    sx={{
                        height: "30px",
                        width: "10px",
                        bgcolor: grey[600],
                        marginRight: "5px",
                    }}
                />
                <Typography fontSize={30} fontWeight={"bold"}>
                    {name}
                </Typography>
            </Box>
            <ViewMemo memo={memo} />
        </>
    );
};

export default ViewAnimeTitle;
