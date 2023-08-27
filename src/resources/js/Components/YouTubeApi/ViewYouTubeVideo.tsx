import React from "react";
import Iframe from "react-iframe";
import Box from "@mui/material/Box";

const ViewYouTubeVideo = ({videoId}) => {

    return (
        <Box sx={{
            width: "100%",
            height: "100%",
            justifyContent: "center",
            alignItems: "center",
            display: "flex",
        }}>
            <Iframe
                id="player"
                width="640"
                height="360"
                url={"https://www.youtube.com/embed/" + videoId}
                allowFullScreen
            />
        </Box>
    );
}

export default ViewYouTubeVideo;
