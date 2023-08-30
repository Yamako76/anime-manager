import React, {useEffect} from "react";
import Checkbox from "@/Components/Checkbox";
import GuestLayout from "@/Layouts/GuestLayout";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import {Head, Link, useForm} from "@inertiajs/react";
import Header from "@/Components/Header/Header";
import {Box, CardHeader, Paper} from "@mui/material";
import Card from "@mui/material/Card";
import CardContent from "@mui/material/CardContent";
import {getBoxWidth} from "@/Components/AllAnime/tool/tool";

export default function Login({status, canResetPassword}: any) {
    const {data, setData, post, processing, errors, reset} = useForm({
        email: "",
        password: "",
        remember: "",
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
            <Header/>
            {/*<GuestLayout>*/}
            <Head title="Log in"/>

            {status && (
                <div className="mb-4 font-medium text-sm text-green-600">
                    {status}
                </div>
            )}
            <Box sx={{
                flex: 1,
                marginLeft: "50px",
                marginRight: "50px",
                marginTop: "50px",
                justifyContent: "center",
                alignItems: "center",
                display: "flex"
            }}>
                <Card
                    sx={{
                        justifyContent: "center",
                        alignItems: "center",
                        width: String(BoxWidth - 50) + "px",
                        height: "50%",
                        minWidth: "300px",
                        padding: "20px"
                    }}>
                    <CardHeader title="ログイン"
                                titleTypographyProps={{variant: "h6"}}
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
                                />

                                <InputError message={errors.email} className="mt-2"/>
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
                                />

                                <InputError message={errors.password} className="mt-2"/>
                            </div>

                            {/*<div className="block mt-4">*/}
                            {/*    <label className="flex items-center">*/}
                            {/*        <Checkbox*/}
                            {/*            name="remember"*/}
                            {/*            value={data.remember}*/}
                            {/*            onChange={handleOnChange}*/}
                            {/*        />*/}
                            {/*        <span className="ml-2 text-sm text-gray-600">*/}
                            {/*    Remember me*/}
                            {/*</span>*/}
                            {/*    </label>*/}
                            {/*</div>*/}

                            <div className="flex items-center justify-end mt-4">
                                {/*{canResetPassword && (*/}
                                {/*    <Link*/}
                                {/*        href={route("password.request")}*/}
                                {/*        className="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"*/}
                                {/*    >*/}
                                {/*        Forgot your password?*/}
                                {/*    </Link>*/}
                                {/*)}*/}

                                <PrimaryButton className="ml-4"
                                               disabled={processing}
                                               style={{backgroundColor: "#0066FF", color: "white"}}
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
