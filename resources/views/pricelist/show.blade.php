@extends('layouts-client.app')

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
                    <h5 class="mb-0 text-center fw-bold ">List Harga</h5>
                </div>
                <div class="card-body">
                    <a type="button" class="btn btn-primary btn-sm" href="/pricelist/create"><i class="fa-solid fa-refresh"></i>
                        Update Semua Harga</a>
                    <div id="priceTable" class="myGrid">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '/pricelist/show_data',
                type: 'GET',
                success: function(data) {
                    let dataGrid = $("#priceTable").dxDataGrid({
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
                                dataField: "ID",
                                dataType: "string",
                                caption: "No",
                                width: "5%",
                                cssClass: "cls"
                            },
                            {
                                dataField: "nama_customer",
                                dataType: "string",
                                caption: "Grosir",
                                width: "35%",
                                cssClass: "cls"
                            },
                            {
                                dataField: "nama_produk",
                                dataType: "string",
                                caption: "Kategori",
                                cssClass: "cls",
                                width: "15%",
                            },
                            {
                                dataField: "nama_kadar",
                                dataType: "string",
                                caption: "Kadar",
                                cssClass: "cls",
                                width: "20%",
                            },
                            {
                                dataField: "price_format",
                                dataType: "string",
                                caption: "Harga",
                                cssClass: "cls",
                                width: "10%",
                            },
                            {
                                dataField: "priceCust_format",
                                dataType: "string",
                                caption: "Harga Customer",
                                cssClass: "cls",
                                width: "10%",
                            },
                            {
                                allowReordering: false,
                                caption: "Aksi",
                                width: "5%",
                                alignment: "center",
                                cellTemplate: function(container, options) {
                                    let cus = options.data.Customer;
                                    let cat = options.data.Category;
                                    let car = options.data.Carat;

                                    $("<a>")
                                        .addClass("btn btn-sm btn-primary me-1")
                                        .attr("href", "/pricelist/edit/" + cus + "/" +
                                            cat + "/" + car)
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
