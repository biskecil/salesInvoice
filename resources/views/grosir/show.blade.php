@extends('layouts.app')

@section('content')
    <style>
        table input.form-control,
        table input.form-control-sm {
            margin: 0;
            /* hilangkan margin bawaan */
            padding: 0.25rem;
            /* bikin seragam */
            height: auto;
            /* biar tidak terlalu tinggi */
        }

        .summary-weight {
            font-weight: bold;
            color: #d9534f;
            font-size: 16px;
        }

        .myGrid .dx-datagrid-rowsview .dx-row>td {
            font-size: 16px;
            /* perbesar font */
            font-weight: normal;
        }

        /* Header column */
        .myGrid .dx-datagrid-headers .dx-header-row>td {
            font-size: 12px;
            font-weight: bold;
            color: #000000;
        }
    </style>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 text-center fw-bold ">List Grosir</h5>
                </div>
                <div class="card-body">
                    <a type="button" class="btn btn-primary btn-sm" href="/grosir/create"><i class="fa-solid fa-plus"></i>
                        Baru</a>
                    <div id="grosTable" class="myGrid">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '/grosir/show_data',
                type: 'GET',
                success: function(data) {
                    let dataGrid = $("#grosTable").dxDataGrid({
                        dataSource: data.data,
                        keyExpr: "ID",
                        scrollX: true,
                        height: 600,
                        allowColumnReordering: true,
                        scrolling: {
                            mode: "standard",
                            columnRenderingMode: "virtual"
                        },
                        showBorders: true,
                        headerFilter: {
                            visible: true
                        },
                        rowAlternationEnabled: true,
                        allowColumnResizing: true,
                        searchPanel: {
                            visible: true
                        },
                        paging: {
                            enabled: true,
                            pageSize: 90,
                        },
                        grouping: {
                            autoExpandAll: false
                        },
                        filterRow: {
                            visible: true
                        },
                        groupPanel: {
                            visible: true
                        },
                        "export": {
                            enabled: true,
                            fileName: "Penerimaan Barang",
                            allowExportSelectedData: true
                        },
                        columns: [{
                                dataField: "no",
                                dataType: "string",
                                caption: "No",
                                width: "7%",
                                cssClass: "cls"
                            },
                            {
                                dataField: "ID",
                                dataType: "string",
                                caption: "ID",
                                width: "7%",
                                cssClass: "cls"
                            },
                            {
                                dataField: "SW",
                                dataType: "string",
                                caption: "No Nota",
                                width: "10%",
                                cssClass: "cls"
                            },
                            {
                                dataField: "Description",
                                dataType: "string",
                                caption: "Grosir",
                                cssClass: "cls",
                                width: "69%",
                            },
                            {
                                allowReordering: false,
                                caption: "Aksi",
                                width: "7%",
                                alignment: "center",
                                cellTemplate: function(container, options) {
                                    let id = options.data.ID;

                                    // Tombol Edit (pencil)
                                    $("<a>")
                                        .addClass("btn btn-sm btn-primary me-1")
                                        .attr("href", "/grosir/edit/" + id)
                                        .attr("title", "Edit")
                                        .html('<i class="fa-solid fa-pencil"></i>')
                                        .appendTo(container);
                                }
                            }
                        ],
                        // summary: {
                        //     groupItems: [{
                        //         column: 'Weight',
                        //         summaryType: 'sum',
                        //         valueFormat: {
                        //             type: "fixedPoint",
                        //             precision: 2
                        //         },
                        //         displayFormat: "{0}"
                        //     }],
                        //     totalItems: [{
                        //         column: "Weight",
                        //         summaryType: "sum",
                        //         valueFormat: {
                        //             type: "fixedPoint",
                        //             precision: 2
                        //         },
                        //         displayFormat: "{0}",
                        //         cssClass: "summary-weight"
                        //     }, ]
                        // },
                    }).dxDataGrid("instance");
                }

            })
        });
    </script>
@endsection
