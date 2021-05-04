import React from "react";

export default function Button({ id, icon, cb, url }) {
    return (
        <a
            className="flex-fill btn btn-light border-0 lh-lg"
            onClick={() => cb(url, id)}
        >
            <i className={icon}></i>
        </a>
    );
}
