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
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 text-center fw-bold ">List Nota</h5>
                </div>
                <div class="card-body">
                    <div id="invTable" class="myGrid">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '/sales/getData/NotaAll',
                type: 'GET',
                success: function(data) {
                    let dataGrid = $("#invTable").dxDataGrid({
                        dataSource: data.data,
                        keyExpr: "IDM",
                        //  columnsAutoWidth: true,
                        scrollX: true,
                        // columnMinWidth: 90,
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
                                dataField: "TransDate",
                                dataType: "date",
                                caption: "Tanggal",
                                cssClass: "cls",
                                format: "dd/MM/yyyy",
                                width: "6%"
                            },
                            {
                                dataField: "IDM",
                                dataType: "string",
                                caption: "ID",
                                width: "4%",
                                cssClass: "cls"
                            },
                            {
                                dataField: "invoice_number",
                                dataType: "string",
                                caption: "No Nota",
                                width: "7%",
                                cssClass: "cls"
                            },
                            {
                                dataField: "Grosir",
                                dataType: "string",
                                caption: "Grosir",
                                cssClass: "cls",
                                width: "4%",
                            },
                            {
                                dataField: "Customer",
                                dataType: "string",
                                caption: "Customer",
                                cssClass: "cls",
                                width: "20%",
                            },
                            {
                                dataField: "Address",
                                dataType: "string",
                                caption: "Address",
                                cssClass: "cls",
                                width: "12%",
                            },
                            {
                                dataField: "Phone",
                                dataType: "string",
                                caption: "Phone",
                                cssClass: "cls",
                                width: "10%",
                            },
                            {
                                dataField: "productSW",
                                dataType: "string",
                                caption: "Kategori",
                                cssClass: "cls",
                                width: "4%",
                            },
                            {
                                dataField: "caratSW",
                                dataType: "string",
                                caption: "Kadar",
                                cssClass: "cls",
                                width: "4%",
                            },
                            {
                                dataField: "Weight",
                                dataType: "number",
                                caption: "Berat",
                                cssClass: "cls",
                                width: "6%",
                            },
                            {
                                dataField: "Event",
                                dataType: "string",
                                caption: "Event",
                                cssClass: "cls",
                                width: "5%",
                            },
                            {
                                dataField: "SubGrosir",
                                dataType: "string",
                                caption: "SubGrosir",
                                cssClass: "cls",
                                width: "14%",
                            },
                            {
                                dataField: "Venue",
                                dataType: "string",
                                caption: "Tempat",
                                cssClass: "cls",
                                width: "4%",
                            },
                        ],
                        summary: {
                            groupItems: [{
                                column: 'Weight',
                                summaryType: 'sum',
                                valueFormat: {
                                    type: "fixedPoint",
                                    precision: 2
                                },
                                displayFormat: "{0}"
                            }],
                            totalItems: [{
                                column: "Weight",
                                summaryType: "sum",
                                valueFormat: {
                                    type: "fixedPoint",
                                    precision: 2
                                },
                                displayFormat: "{0}",
                                cssClass: "summary-weight"
                            }, ]
                        },
                    }).dxDataGrid("instance");
                }

            })
        });
    </script>
@endsection
