import React, { useEffect } from "react";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import { Head, useForm } from "@inertiajs/react";
import Header from "@/Components/Header/Header";
import { getBoxWidth } from "@/Components/AllAnime/tool/tool";
import { Box, CardHeader } from "@mui/material";
import Card from "@mui/material/Card";
import CardContent from "@mui/material/CardContent";

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
    });
    const BoxWidth = getBoxWidth();
    useEffect(() => {
        return () => {
            reset("password", "password_confirmation");
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

        post(route("register"));
    };

    return (
        <>
            <Header />
            {/*<GuestLayout>*/}
            <Head title="Register" />
            <Box
                sx={{
                    flex: 1,
                    marginLeft: "10px",
                    marginRight: "10px",
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
                        title="会員登録"
                        titleTypographyProps={{ variant: "h6" }}
                    />
                    <CardContent>
                        <form onSubmit={submit}>
                            <div>
                                <InputLabel
                                    htmlFor="name"
                                    value="ユーザー名"
                                    children={undefined}
                                />

                                <TextInput
                                    id="name"
                                    name="name"
                                    value={data.name}
                                    className="mt-1 block w-full"
                                    autoComplete="name"
                                    isFocused={true}
                                    onChange={handleOnChange}
                                    required
                                />

                                <InputError
                                    message={errors.name}
                                    className="mt-2"
                                />
                            </div>

                            <div className="mt-4">
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
                                    onChange={handleOnChange}
                                    required
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
                                    autoComplete="new-password"
                                    onChange={handleOnChange}
                                    required
                                />

                                <InputError
                                    message={errors.password}
                                    className="mt-2"
                                />
                            </div>

                            <div className="mt-4">
                                <InputLabel
                                    htmlFor="password_confirmation"
                                    value="パスワード(確認)"
                                    children={undefined}
                                />

                                <TextInput
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    value={data.password_confirmation}
                                    className="mt-1 block w-full"
                                    autoComplete="new-password"
                                    onChange={handleOnChange}
                                    required
                                />

                                <InputError
                                    message={errors.password_confirmation}
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
                                    }}
                                >
                                    送信
                                </PrimaryButton>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </Box>
            {/*</GuestLayout>*/}
        </>
    );
}
