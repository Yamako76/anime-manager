import React from "react";

export default function InputLabel({
    value,
    className = "",
    children,
    ...props
}: any) {
    return (
        <label
            {...props}
            className={`block font-medium text-sm text-gray-700 ` + className}
            style={{ fontSize: "16px" }}
        >
            {value ? value : children}
        </label>
    );
}
