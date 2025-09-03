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
    </style>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 text-center fw-bold ">List Nota</h5>
                </div>
                <div class="card-body">
                    <div class="table table-bordered mb-0" id="invTable">
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
                    console.log(data)
                    let dataGrid = $("#invTable").dxDataGrid({
                        dataSource: data.data,
                        keyExpr: "IDM",
                        columnsAutoWidth: true,
                        scrollX: true,
                        columnMinWidth: 90,
                        height: 600,
                        allowColumnReordering: true,
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
                                dataType: "string",
                                caption: "Tanggal",
                                cssClass: "cls"
                            },
                            {
                                dataField: "IDM",
                                dataType: "string",
                                caption: "ID",
                                width: '5%',
                                cssClass: "cls"
                            },
                            {
                                dataField: "SW",
                                dataType: "string",
                                caption: "No Nota",
                                cssClass: "cls"
                            },
                            {
                                dataField: "Grosir",
                                dataType: "string",
                                caption: "Grosir",
                                cssClass: "cls"
                            },
                            {
                                dataField: "Customer",
                                dataType: "string",
                                caption: "Customer",
                                cssClass: "cls"
                            },
                            {
                                dataField: "Address",
                                dataType: "string",
                                caption: "Address",
                                cssClass: "cls"
                            },
                            {
                                dataField: "Phone",
                                dataType: "string",
                                caption: "Phone",
                                cssClass: "cls"
                            },
                            {
                                dataField: "productSW",
                                dataType: "string",
                                caption: "Kategori",
                                cssClass: "cls"
                            },
                            {
                                dataField: "caratSW",
                                dataType: "string",
                                caption: "Kadar",
                                cssClass: "cls"
                            },
                            {
                                dataField: "Weight",
                                dataType: "number",
                                caption: "Berat",
                                cssClass: "cls"
                            },
                            {
                                dataField: "Event",
                                dataType: "string",
                                caption: "Event",
                                cssClass: "cls"
                            },
                            {
                                dataField: "SubGrosir",
                                dataType: "string",
                                caption: "SubGrosir",
                                cssClass: "cls"
                            },
                            {
                                dataField: "Venue",
                                dataType: "string",
                                caption: "Tempat",
                                cssClass: "cls"
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
                                displayFormat: "Berat: {0}"
                            }],
                            totalItems: [{
                                column: "Weight",
                                summaryType: "sum",
                                valueFormat: {
                                    type: "fixedPoint",
                                    precision: 2
                                },
                                displayFormat: "Berat: {0}"
                            }, ]
                        },
                    }).dxDataGrid("instance");
                }

            })
        });
    </script>
@endsection
