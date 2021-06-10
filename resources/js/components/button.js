import React from "react";

export default function Button({ row, id, fn, tableUrl, filter, button }) {
    const { icon, cb, url, condition = (id) => { return id; }, column = "id", permission = true } = button;
    const hasPermission = permission ? true : permissions[permission];
    return (
        <>
            {condition(row[column]) && hasPermission ? (
                <a
                    className="flex-fill btn border-0 lh-lg border-radius-0"
                    onClick={() => cb(url, id, fn, filter, tableUrl)}
                >
                    <i className={icon}></i>
                </a>
            ) : (
                <a className="flex-fill btn border-0 lh-lg border-radius-0 disabled text-black-50">
                    <i className={icon}></i>
                </a>
            )}
        </>
    );
}
