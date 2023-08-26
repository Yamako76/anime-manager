import React from "react";
import { Box, IconButton, Modal, TextField, Tooltip } from "@mui/material";
import AddIcon from "@mui/icons-material/Add";
import Typography from "@mui/material/Typography";
import Button from "@mui/material/Button";

interface Props {
    open: boolean;
    handleOpen: () => void;
    handleClose: () => void;
}

const AddButton = ({ open, handleOpen, handleClose }: Props) => {
    return (
        <Box sx={{ color: "grey", marginLeft: "10%" }}>
            <Tooltip title={"追加"}>
                <IconButton onClick={handleOpen}>
                    <AddIcon />
                </IconButton>
            </Tooltip>
            <Modal open={open} onClose={handleClose}>
                <Box
                    sx={{
                        position: "absolute",
                        top: "50%",
                        left: "50%",
                        transform: "translate(-50%, -50%)",
                        width: 500,
                        height: 400,
                        border: 1,
                        borderRadius: 10,
                        bgcolor: "white",
                    }}
                >
                    <Box
                        component="form"
                        sx={{
                            height: "5ch",
                            alignItems: "center",
                            justifyContent: "center",
                            marginTop: 7,
                        }}
                    >
                        <Typography sx={{ marginLeft: 22 }}>
                            アニメ名
                        </Typography>
                        <TextField
                            label="name"
                            variant="outlined"
                            size="small"
                            sx={{
                                alignSelf: "center",
                                justifyContent: "center",
                                marginTop: 1,
                                marginLeft: 9,
                                width: 350,
                            }}
                        />
                    </Box>
                    <Button
                        sx={{ position: "absolute", top: 25, left: 20 }}
                        onClick={handleClose}
                    >
                        戻る
                    </Button>
                    <Button sx={{ marginLeft: 27, marginTop: 27 }}>追加</Button>
                </Box>
            </Modal>
        </Box>
    );
};

export default AddButton;
