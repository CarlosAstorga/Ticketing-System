import React, { useState, useEffect, useCallback } from "react";
import ReactDOM from "react-dom";

import SearchBar from "./searchBar";
import Paginator from "./paginator";
import Button from "./button";

function Avatar({ avatar }) {
    return (
        <img src={/images/ + avatar} className="avatar"></img>
    );
}


const users = [
    {
        name: "avatar",
        title: "Avatar",
        hClass: "w-1",
        data: Avatar
    },
    {
        name: "name",
        title: "Nombre"
    },
    {
        name: "email",
        title: "Correo electrónico"
    },
    {
        name: "role",
        title: "Rol"
    }
]

export default function Example({ sourceColumns, buttons, url }) {
    const [records, setData] = useState([]);
    const [pagination, setPagination] = useState("");
    const [filter, setFilter] = useState("");
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        search(filter);
    }, [search]);

    /**
     * Obtiene los registros correspondientes a la pagina solicitada.
     * @param {String} url
     */
    function page(url) {
        setLoading(true);
        axios(url).then(response => {
            setPagination(response.data);
            setData(response.data.data);
            setLoading(false);
        });
    }

    /**
     * Funcion debounce para las busquedas del usuario.
     */
    const search = useCallback(
        _.debounce(function(text) {
            getData(text);
        }, 1000),
        []
    );

    /**
     * Obtiene todos los registros paginados.
     * @param {String} filter
     */
    function getData(filter = null) {
        setFilter(filter);
        setLoading(true);
        const axiosInstance = filter
            ? axios(`${url}/list`, { params: { filter: filter } })
            : axios(`${url}/list`);
        axiosInstance.then(response => {
            console.log({response});
            setPagination(response.data);
            setData(response.data.data);
            setLoading(false);
        });
    }

    return (
        <>
            <div className="row justify-content-between">
                <div className="col-lg-6">
                    <Paginator config={pagination} handlePagination={page} />
                </div>
                <div className="col-lg-6 mb-3">
                    <SearchBar
                        handleFilter={search}
                        id="search"
                    />
                </div>
            </div>
            <div
                className="table-responsive"
            >
                <table className="table table-striped">
                    <thead className="table-dark">
                        <tr>
                        {   
                            sourceColumns.map(column => {
                                return (
                                    <th className={column.hClass}
                                    key={column.title}>{column.title}</th>
                                );
                            })
                            
                        }
                        {
                            buttons.length > 0 && (
                                <th style={{ width: 5 + "%" }}>Acciones</th>
                            )}
                        </tr>
                            
                    </thead>
                    <tbody>
                    {records.length > 0 ? (
                            records.map(row => {
                                return (
                                    <tr
                                        key={row.id}
                                    >
                                        {sourceColumns.map(column => {
                                            return (
                                                <td key={column.name}>
                                                    {column.data ? (
                                                        column.data(row)
                                                    ) : (
                                                        _.get(
                                                            row,
                                                            column.name
                                                        )
                                                    )}
                                                </td>
                                            );
                                        })}
                                        {buttons.length > 0 && (
                                            <td className="p-0 d-flex">
                                                {buttons.map(button => {
                                                    return (
                                                        <Button
                                                            key={button.icon}
                                                            id={row.id}
                                                            icon={button.icon}
                                                            cb={button.cb}
                                                            url={url}
                                                        />
                                                    );
                                                })}
                                            </td>
                                        )}
                                    </tr>
                                );
                            })
                        ) : (
                            <tr>
                                <td
                                    style={{ textAlign: "center" }}
                                    colSpan={sourceColumns.length + 1}
                                >
                                    {loading ? (
                                        <i>Cargando registros...</i>
                                    ) : (
                                        <i>No se encontraron registros</i>
                                    )}
                                </td>
                            </tr>
                        )}
                    </tbody>
                </table>
            </div>
        </>
    );
}

if (document.getElementById('testing')) {
    const container = document.getElementById("testing");
    let buttons = [{ cb: handleEdit, icon: "fas fa-user-tag"}, { cb: handleDelete, icon: "far fa-trash-alt text-danger"}];
    ReactDOM.render(
        <Example sourceColumns={users} buttons={buttons}
        url={'admin/users'}/>,
        container
    );
}


function handleEdit(url, id) {
    window.location = `${url}/${id}/edit`;
}

function handleView(url, id) {
    window.location = `${url}/${id}`;
}

function handleDelete(url, id) {
    console.log('url', url);
    if (confirm("Eliminar registro?")) {
        axios({
            method: "delete",
            url: `${url}/${id}`,
            data: {
                id
            }
        })
            .then((window.location = `${url}`))
    }
}
