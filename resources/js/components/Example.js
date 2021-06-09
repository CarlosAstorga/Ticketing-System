import React, { useState, useEffect, useCallback } from "react";
import ReactDOM from "react-dom";

import axios from "axios";
import Table from "./Table";
import SearchBar from "./searchBar";
import Paginator from "./paginator";
import { isUndefined } from "lodash";

function Avatar(img, column, row) {
    let path = "/storage/images/avatar/profile_picture.png";
    if (img) path = "/storage/images/avatar/" + row.id + "/" + img;
    return (
        <img
            src={path}
            className="rounded-circle image-cover"
            width="28"
            height="28"
        ></img>
    );
}

function Pills(array, column) {
    const { cClass = "bg-danger" } = column;
    return array.map((row) => {
        return (
            <span key={row.id} className={`badge rounded-pill ${cClass} me-1`}>
                {row.title}
            </span>
        );
    });
}

export default function Example({ sourceColumns, buttons, url }) {
    const [tableData, setTableData] = useState({});
    const [filter, setFilter] = useState("");
    const [currentPage, setCurrentPage] = useState("1");
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        search(url, filter);
    }, [filter]);

    useEffect(() => {
        if (!isUndefined(tableData.links))
            getData(tableData.links[currentPage].url, filter);
    }, [currentPage]);

    /**
     * Funcion debounce para las busquedas del usuario.
     */
    const search = useCallback(
        _.debounce(function (url, filter) {
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
        axiosInstance.then((response) => {
            setTableData(response.data);
            setLoading(false);
        });
    }

    return (
        <>
            <div className="row justify-content-between">
                <div className="col mb-3 table-responsive z-index">
                    <Paginator
                        currentPage={currentPage}
                        handlePagination={setCurrentPage}
                        config={tableData}
                    />
                </div>
                <div className="col-md-6 col-lg-4 col-xl-3 align-self-end mb-3">
                    <SearchBar id="search" handleFilter={setFilter} />
                </div>
            </div>
            <Table
                data={tableData}
                columns={sourceColumns}
                loading={loading}
                buttons={buttons}
                url={url}
                fn={getData}
                filter={filter}
            />
        </>
    );
}

/**
....###.....######..########.####..#######..##....##..######.
...##.##...##....##....##.....##..##.....##.###...##.##....##
..##...##..##..........##.....##..##.....##.####..##.##......
.##.....##.##..........##.....##..##.....##.##.##.##..######.
.#########.##..........##.....##..##.....##.##..####.......##
.##.....##.##....##....##.....##..##.....##.##...###.##....##
.##.....##..######.....##....####..#######..##....##..######.
 */
function handleView(url, id) {
    window.location = `${url}/${id}`;
}

function handleEdit(url, id) {
    window.location = `${url}/${id}/edit`;
}

function handleDelete(url, id, fn, filter, tableUrl) {
    if (confirm("Eliminar registro?")) {
        axios({
            method: "delete",
            url: `${url}/${id}`,
            data: {
                id,
            },
        }).then(fn(tableUrl, filter));
    }
}

function handleStatus(url = "", id, fn, filter, tableUrl) {
    axios({
        method: "post",
        url: `/tickets/${id}/updateStatus`,
        data: { status_id: 5 },
    }).then(fn(tableUrl, filter));
}

/**
 * Ticket columns
 */
const ticketColumns = [
    {
        name: "title",
        title: "Título",
    },
    {
        name: "project.title",
        title: "Proyecto",
    },
    {
        name: "description",
        title: "Descripción",
    },
    {
        name: "developer.name",
        title: "Resolverá",
    },
    {
        name: "priority.title",
        title: "Prioridad",
    },
    {
        name: "status.title",
        title: "Estatus",
    },
    {
        name: "category.title",
        title: "Categoria",
    },
    {
        name: "created_at",
        title: "Creado el dia",
    },
    {
        name: "due_date",
        title: "Fecha requerido",
    },
];

/**
.##.....##..######..########.########...######.
.##.....##.##....##.##.......##.....##.##....##
.##.....##.##.......##.......##.....##.##......
.##.....##..######..######...########...######.
.##.....##.......##.##.......##...##.........##
.##.....##.##....##.##.......##....##..##....##
..#######...######..########.##.....##..######.
 */
if (document.getElementById("users")) {
    const container = document.getElementById("users");

    // Columns
    const users = [
        {
            name: "avatar",
            title: "Avatar",
            hClass: "w-1",
            data: Avatar,
            field: "profile_picture",
        },
        {
            name: "name",
            title: "Nombre",
        },
        {
            name: "email",
            title: "Correo electrónico",
        },
        {
            name: "role",
            title: "Roles",
            data: Pills,
            field: "roles",
            cClass: "bg-blue",
        },
    ];

    // Actions
    let buttons = [
        {
            cb: handleEdit,
            icon: "fas fa-edit",
            url: "users",
            condition: (id) => id != 1,
            permission: "user_edit",
        },
        {
            cb: handleDelete,
            icon: "fas fa-trash text-danger",
            url: "users",
            condition: (id) => id != 1,
            permission: "user_delete",
        },
    ];

    ReactDOM.render(
        <Example
            sourceColumns={users}
            buttons={buttons}
            url={"/admin/users/list"}
        />,
        container
    );
}

/**
.########...#######..##.......########..######.
.##.....##.##.....##.##.......##.......##....##
.##.....##.##.....##.##.......##.......##......
.########..##.....##.##.......######....######.
.##...##...##.....##.##.......##.............##
.##....##..##.....##.##.......##.......##....##
.##.....##..#######..########.########..######.
 */
if (document.getElementById("roles")) {
    const container = document.getElementById("roles");

    // Columns
    const roles = [
        {
            name: "title",
            title: "Título",
        },
        {
            name: "permissions",
            title: "Permisos",
            data: Pills,
            field: "permissions",
            cClass: "bg-blue",
            bClass: "text-wrap",
        },
    ];

    // Actions
    let buttons = [
        {
            cb: handleEdit,
            icon: "fas fa-edit",
            url: "roles",
            condition: (id) => id != 1,
            permission: "role_edit",
        },
        {
            cb: handleDelete,
            icon: "fas fa-trash text-danger",
            url: "roles",
            condition: (id) => id != 1,
            permission: "role_delete",
        },
    ];

    ReactDOM.render(
        <Example sourceColumns={roles} buttons={buttons} url={"/roles/list"} />,
        container
    );
}

/**
.########..########...#######........##.########..######..########..######.
.##.....##.##.....##.##.....##.......##.##.......##....##....##....##....##
.##.....##.##.....##.##.....##.......##.##.......##..........##....##......
.########..########..##.....##.......##.######...##..........##.....######.
.##........##...##...##.....##.##....##.##.......##..........##..........##
.##........##....##..##.....##.##....##.##.......##....##....##....##....##
.##........##.....##..#######...######..########..######.....##.....######.
 */
if (document.getElementById("projects")) {
    const container = document.getElementById("projects");

    // Columns
    const projects = [
        {
            name: "title",
            title: "Título",
        },
        {
            name: "description",
            title: "Descripción",
        },
    ];

    // Actions
    let buttons = [
        {
            cb: handleView,
            icon: "fas fa-eye",
            url: "projects",
            permission: "project_show",
        },
        {
            cb: handleEdit,
            icon: "fas fa-edit",
            url: "projects",
            permission: "project_edit",
        },
        {
            cb: handleDelete,
            icon: "fas fa-trash text-danger",
            url: "projects",
            permission: "project_delete",
        },
    ];

    ReactDOM.render(
        <Example
            sourceColumns={projects}
            buttons={buttons}
            url={"/projects/list"}
        />,
        container
    );
}

/**
.########.####..######..##....##.########.########..######.
....##.....##..##....##.##...##..##..........##....##....##
....##.....##..##.......##..##...##..........##....##......
....##.....##..##.......#####....######......##.....######.
....##.....##..##.......##..##...##..........##..........##
....##.....##..##....##.##...##..##..........##....##....##
....##....####..######..##....##.########....##.....######.
 */
if (document.getElementById("tickets")) {
    const container = document.getElementById("tickets");

    // Actions
    let buttons = [
        {
            cb: handleStatus,
            icon: "far fa-check-circle",
            condition: (id) => id != 5,
            column: "status_id",
            permission: "ticket_close",
        },
        {
            cb: handleView,
            icon: "fas fa-eye",
            url: "tickets",
            condition: (id) => id != 5,
            column: "status_id",
            permission: "ticket_show",
        },
        {
            cb: handleEdit,
            icon: "fas fa-edit",
            url: "tickets",
            condition: (id) => id != 5,
            column: "status_id",
            permission: "ticket_edit",
        },
        {
            cb: handleDelete,
            icon: "fas fa-trash text-danger",
            url: "tickets",
            condition: (id) => id != 5,
            column: "status_id",
            permission: "ticket_delete",
        },
    ];

    ReactDOM.render(
        <Example
            sourceColumns={ticketColumns}
            buttons={buttons}
            url={"/tickets/list"}
        />,
        container
    );
}

/**
.########.........########.####..######..##....##.########.########..######.
.##.....##...........##.....##..##....##.##...##..##..........##....##....##
.##.....##...........##.....##..##.......##..##...##..........##....##......
.########............##.....##..##.......#####....######......##.....######.
.##..................##.....##..##.......##..##...##..........##..........##
.##........###.......##.....##..##....##.##...##..##..........##....##....##
.##........###.......##....####..######..##....##.########....##.....######.
 */
if (document.getElementById("project-tickets")) {
    const container = document.getElementById("project-tickets");

    // Actions
    let buttons = [
        {
            cb: handleView,
            icon: "fas fa-eye",
            url: "/tickets",
            condition: (id) => id != 5,
            column: 'status_id',
            permission: 'ticket_show' 
        },
    ];

    ticketColumns.splice(1, 1);

    ReactDOM.render(
        <Example
            sourceColumns={ticketColumns}
            buttons={buttons}
            url={`${window.location.pathname}/tickets`}
        />,
        container
    );
}
