import React from "react";

export default function Button({row, id, fn, tableUrl, filter, button }) {
    const { icon, cb, url, condition=(id)=> {return id}, column="id" } = button;
    return (
        <>
            {condition(row[column]) ? (
                <a
                    className="flex-fill btn btn-light border-0 lh-lg border-radius-0"
                    onClick={() => cb(url, id, fn, filter, tableUrl)}
                >
                    <i className={icon}></i>
                </a>
            ) : (
                <a className="flex-fill btn btn-light border-0 lh-lg border-radius-0 disabled text-black-50">
                    <i className={icon}></i>
                </a>
            )}
        </>
    );
}
