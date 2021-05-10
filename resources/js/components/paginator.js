import { isUndefined, last } from "lodash";
import React, { useEffect, useState } from "react";

export default function Paginator({ currentPage, handlePagination, config }) {
    const isPaginated = isUndefined(config.last_page) ? false : true;
    const lastPage = isPaginated ? config.last_page : 1;
    
    function handlePageItems(label, url, active) {
        let itemData = "page-item";
        label.includes('Previous') && url == null ? itemData = itemData  + " disabled" : null;
        label.includes('Next') && url == null ? itemData = itemData + " disabled" : null;
        itemData = active ? itemData + " active" : itemData;
        return itemData;
    }
    
    return (
        <>
            {isPaginated && (
                <>
                {config.last_page > 1 && (
                    <ul className="pagination mb-0">
                        {config.links.map((link, index) => {
                            return (
                                <li key={Math.random()}
                                    className={
                                        handlePageItems(link.label, link.url, link.active)
                                    }
                                >
                                <a
                                    className="page-link"
                                    onClick={evt => {
                                        evt.preventDefault();
                                        handlePagination(index);
                                    }}
                                    href={link.url}
                                >
                                    {link.label.includes('Previous') ? "<" : link.label.includes('Next') ? ">" : link.label}
                                </a>
                            </li>
                            );
                        })}
                    </ul>
                )}
                </>
            )}
        </>
    );
}