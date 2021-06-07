import React from "react";

export default function Button({ id, fn, tableUrl, filter, button }) {
    const { icon, cb, url, condition=(id)=> {return id} } = button;
    return (
        <>
            {condition(id) && (
                <a
                    className="flex-fill btn btn-light border-0 lh-lg border-radius-0"
                    onClick={() => cb(url, id, fn, filter, tableUrl)}
                >
                    <i className={icon}></i>
                </a>
            )}
        </>
    );
}
