import React from "react";
import Button from "./button";
import { isUndefined } from "lodash";

export default function Table({data, columns, loading, buttons, url, fn, filter}) {
    const rows = isUndefined(data.data) ? [] : data.data;
    return (
        <div className="table-responsive table-list z-index text-nowrap">
            <table className="table table-striped">
                <caption>{rows.length > 0 && `Mostrando del ${data.from} al ${data.to} de un total de ${data.total} registros`}</caption>
                <thead className="table-light">
                    <tr>
                        {columns.map(column => {
                            return (
                                <th className={column.hClass && (column.hClass)} key={column.title}>{column.title}</th>
                            );
                        })}
                        {buttons.length > 0 && (
                            <th className="w-10">Acciones</th>
                        )}
                    </tr> 
                </thead>
                <tbody>
                    {rows.length > 0 ? (
                        data.data.map(row => {
                            return (
                                <tr
                                    key={row.id}
                                    className={row.row_class && (row.row_class)}
                                >
                                    {columns.map(column => {
                                        return (
                                            <td 
                                                key={column.name}
                                                className={column.bClass && (column.bClass)}>
                                                {column.data ? (
                                                    column.data(row[column.field], column, row)
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
                                        <td className="p-0 d-flex border-0">
                                            {buttons.map(button => {
                                                return (
                                                    <Button
                                                        key={button.icon}
                                                        id={row.id}
                                                        fn={fn}
                                                        tableUrl={url}
                                                        filter={filter}
                                                        button={button}
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
                                className="text-center"
                                colSpan={columns.length + 1}
                            >
                                {loading ? (
                                    <div className="spinner-border spinner-border-sm text-dark" role="status">
                                        <span className="visually-hidden">Cargando...</span>
                                    </div>
                                ) : (
                                    <i className="fw-light">No se encontraron registros</i>
                                )}
                            </td>
                        </tr>
                    )}
                </tbody>
            </table>
        </div>
    );
}
