import React from "react";

export default function Paginator({ config, handlePagination }) {
    function handlePageItems(label, url, active) {
        let itemData = "page-item";
        label.includes('Previous') && url == null ? itemData = itemData  + " disabled" : null;
        label.includes('Next') && url == null ? itemData = itemData + " disabled" : null;
        itemData = active ? itemData + " active" : itemData;
        return itemData;
    }
    
    return (
        <>
            {config.links && (
                <ul className="pagination">
                    {config.links.map(link => {
                        return (
                            <li key={link.label}
                        className={
                            handlePageItems(link.label, link.url, link.active)
                        }
                        >
                            <a
                                className="page-link"
                                onClick={evt => {
                                    evt.preventDefault();
                                    handlePagination(link.url);
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
    );
}