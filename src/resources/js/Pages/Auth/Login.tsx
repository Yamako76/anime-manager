import React, { useEffect } from "react";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import { Head, useForm } from "@inertiajs/react";
import Header from "@/Components/Header/Header";
import { Box, CardHeader } from "@mui/material";
import Card from "@mui/material/Card";
import CardContent from "@mui/material/CardContent";
import { getBoxWidth } from "@/Components/AllAnime/tool/tool";

export default function Login({ status }: any) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: "",
        password: "",
    });

    const BoxWidth = getBoxWidth();

    useEffect(() => {
        return () => {
            reset("password");
        };
    }, []);

    const handleOnChange = (event: any) => {
        setData(
            event.target.name,
            event.target.type === "checkbox"
                ? event.target.checked
                : event.target.value
        );
    };

    const submit = (e: any) => {
        e.preventDefault();

        post(route("login"));
    };

    return (
        <>
            <Header />
            <Head title="Log in" />

            {status && (
                <div className="mb-4 font-medium text-sm text-green-600">
                    {status}
                </div>
            )}
            <Box
                sx={{
                    flex: 1,
                    marginLeft: "20px",
                    marginRight: "20px",
                    marginTop: "30px",
                    justifyContent: "center",
                    alignItems: "center",
                    display: "flex",
                }}
            >
                <Card
                    sx={{
                        justifyContent: "center",
                        alignItems: "center",
                        width: String(BoxWidth - 50) + "px",
                        height: "50%",
                        minWidth: "350px",
                        padding: "10px",
                    }}
                >
                    <CardHeader
                        title="ログイン"
                        titleTypographyProps={{ variant: "h6" }}
                    />
                    <CardContent>
                        <form onSubmit={submit}>
                            <div>
                                <InputLabel
                                    htmlFor="email"
                                    value="メールアドレス"
                                    children={undefined}
                                />

                                <TextInput
                                    id="email"
                                    type="email"
                                    name="email"
                                    value={data.email}
                                    className="mt-1 block w-full"
                                    autoComplete="username"
                                    isFocused={true}
                                    onChange={handleOnChange}
                                    required
                                    style={{
                                        height: "35px",
                                    }}
                                />

                                <InputError
                                    message={errors.email}
                                    className="mt-2"
                                />
                            </div>

                            <div className="mt-4">
                                <InputLabel
                                    htmlFor="password"
                                    value="パスワード"
                                    children={undefined}
                                />

                                <TextInput
                                    id="password"
                                    type="password"
                                    name="password"
                                    value={data.password}
                                    className="mt-1 block w-full"
                                    autoComplete="current-password"
                                    onChange={handleOnChange}
                                    required
                                    style={{
                                        height: "35px",
                                    }}
                                />

                                <InputError
                                    message={errors.password}
                                    className="mt-2"
                                />
                            </div>

                            <div className="flex items-center justify-end mt-4">
                                <PrimaryButton
                                    className="ml-4"
                                    disabled={processing}
                                    style={{
                                        backgroundColor: "#0066FF",
                                        color: "white",
                                        cursor: "pointer",
                                    }}
                                    onMouseEnter={(e) => {
                                        e.target.style.backgroundColor =
                                            "#0044CC";
                                    }}
                                    onMouseLeave={(e) => {
                                        e.target.style.backgroundColor =
                                            "#0066FF";
                                    }}
                                >
                                    送信
                                </PrimaryButton>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </Box>
        </>
    );
}
