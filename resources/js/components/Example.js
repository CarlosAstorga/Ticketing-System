import React, { useState, useEffect, useCallback } from "react";
import ReactDOM from "react-dom";

import SearchBar from "./searchBar";
import Paginator from "./paginator";
import Button from "./button";
import Table from "./Table";
import { isArray, isUndefined } from "lodash";

function Avatar(img, column, row) {
    let path = "/storage/images/avatar/profile_picture.png";
    if (img) path = "/storage/images/avatar/" + row.id + "/" + img;
    return (
        <img src={path} className="rounded-circle image-cover" width="28" height="28"></img>
    );
}

function Pills(array, column) {
    const { cClass = "bg-danger" } = column;
    return array.map(row => {
        return (
            <span key={row.id} className={`badge ${cClass} me-1`}>{row.title}</span>
        )
    });
}

const users = [
    {
        name: "avatar",
        title: "Avatar",
        hClass: "w-1",
        data: Avatar,
        field: 'profile_picture'
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
        title: "Roles",
        data: Pills,
        field: "roles",
        cClass: "bg-blue"
    }
];

const projects = [
    {
        name: "title",
        title: "Título"
    },
    {
        name: "description",
        title: "Descripción"
    }
];

const tickets = [
    {
        name: "title",
        title: "Asunto"
    },
    {
        name: "project.title",
        title: "Proyecto"
    },
    {
        name: "description",
        title: "Descripción"
    },
    {
        name: "developer.name",
        title: "Resolverá"
    },
    {
        name: "priority.title",
        title: "Prioridad"
    },
    {
        name: "status.title",
        title: "Estatus"
    },
    {
        name: "category.title",
        title: "Categoria"
    },
    {
        name: "created_at",
        title: "Creado el dia"
    },
    {
        name: "due_date",
        title: "Fecha requerido"
    }
];

const roles = [
    {
        name: "title",
        title: 'Título'
    },
    {
        name: "permissions",
        title:  "Permisos",
        data: Pills,
        field: 'permissions',
        cClass: 'bg-blue',
        bClass: 'text-wrap'
    }
];

export default function Example({ sourceColumns, buttons, url }) {
    const [tableData, setTableData] = useState({});
    const [filter, setFilter] = useState('');
    const [currentPage, setCurrentPage] = useState('1');
    const [loading, setLoading] = useState(true)

    useEffect(() => {
        search(url, filter);
    }, [filter]);

    useEffect(() => {
        if (!isUndefined(tableData.links)) getData(tableData.links[currentPage].url, filter);
    }, [currentPage]);

    /**
     * Funcion debounce para las busquedas del usuario.
     */
    const search = useCallback(
        _.debounce(function(url, filter) {
            getData(url, filter);
        }, 1000),
        []
    );

    /**
     * Obtiene todos los registros paginados.
     * @param {String} filter
     */
    function getData(pageUrl, filter) {
        setLoading(true);
        const axiosInstance = filter
            ? axios(pageUrl, { params: { filter: filter } })
            : axios(pageUrl);
        axiosInstance.then(response => {
            setTableData(response.data);
            setLoading(false);
        });
    }

    return (
        <>
            <div className="row justify-content-between">
                <div className="col mb-3 table-responsive z-index">
                    <Paginator currentPage={currentPage} handlePagination={setCurrentPage} config={tableData} />
                </div>
                <div className="col-md-6 col-lg-4 col-xl-3 align-self-end mb-3">
                    <SearchBar
                        id="search"
                        handleFilter={setFilter}
                    />
                </div>
            </div>
            <Table data={tableData} columns={sourceColumns} loading={loading} buttons={buttons} url={url} fn={getData} filter={filter} />
        </>
    );
}

if (document.getElementById('users')) {
    const container = document.getElementById("users");
    let buttons = [{ cb: handleEdit, icon: "fas fa-edit", url: "users"}, { cb: handleDelete, icon: "fas fa-trash text-danger", url: "users"}];
    ReactDOM.render(
        <Example sourceColumns={users} buttons={buttons}
        url={'/admin/users/list'}/>,
        container
    );
}

if (document.getElementById('projects')) {
    const container = document.getElementById("projects");
    let buttons = [
        {
            cb: handleView,
            icon: "fas fa-eye",
            url: "projects"
        },
        {
            cb: handleEdit,
            icon: "fas fa-edit",
            url: "projects"
        },
        {
            cb: handleDelete,
            icon: "fas fa-trash text-danger",
            url: "projects"
        }
    ];

    ReactDOM.render(
        <Example sourceColumns={projects
        } buttons={buttons}
        url={'/projects/list'}/>,
        container
    );
}

if (document.getElementById('tickets')) {
    const container = document.getElementById("tickets");
    let buttons = [
        {
            cb: handleView,
            icon: "fas fa-eye",
            url: "tickets"
        },
        {
            cb: handleEdit,
            icon: "fas fa-edit",
            url: "tickets"
        },
        {
            cb: handleDelete,
            icon: "fas fa-trash text-danger",
            url: "tickets"
        }
    ];
    ReactDOM.render(
        <Example sourceColumns={tickets} buttons={buttons}
        url={'/tickets/list'}/>,
        container
    );
}


function handleEdit(url, id) {
    window.location = `${url}/${id}/edit`;
}

function handleView(url, id) {
    window.location = `${url}/${id}`;
}

function handleDelete(url, id, fn, filter, tableUrl) {
    if (confirm("Eliminar registro?")) {
        axios({
            method: "delete",
            url: `${url}/${id}`,
            data: {
                id
            }
        }).then(fn(tableUrl, filter));
    }
}

if (document.getElementById('roles')) {
    const container = document.getElementById("roles");
    let buttons = [
        {
            cb: handleEdit,
            icon: "fas fa-edit",
            url: "roles",
            condition: (id) => {return id != 1}
        },
        {
            cb: handleDelete,
            icon: "fas fa-trash text-danger",
            url: "roles",
            condition: (id) => { return id != 1}
        }
    ];
    ReactDOM.render(
        <Example sourceColumns={roles} buttons={buttons}
        url={'/roles/list'}/>,
        container
    );
}

if (document.getElementById('project-tickets')) {
    const container = document.getElementById("project-tickets");
    let buttons = [
        {
            cb: handleView,
            icon: "fas fa-eye",
            url: "/tickets"
        }
    ];
    tickets.splice(1,1);
    ReactDOM.render(
        <Example sourceColumns={tickets} buttons={buttons}
        url={`${window.location.pathname}/tickets`}/>,
        container
    );
}