import React from "react";

export default function SearchBar({ handleFilter, id }) {
    return (
        <div className="input-group">
            <input
                id={id}
                onInput={evt => handleFilter(evt.target.value)}
                type="text"
                className="form-control"
                placeholder="Buscar.."
            />
                <span className="input-group-text">
                    <i className="fas fa-search"></i>
                </span>
        </div>
    );
}
