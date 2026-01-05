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
                // $.ajax({
                //     url: '/sales/getData/NotaAll',
                //     type: 'GET',
                //     success: function(data) {
                //         let dataGrid = $("#invTable").dxDataGrid({
                //             dataSource: data.data,
                //             keyExpr: "IDM",
                //             scrollX: true,
                //             height: 600,
                //             allowColumnReordering: true,
                //             allowColumnResizing: true,
                //             scrolling: {
                //                 mode: "standard",
                //                 columnRenderingMode: "virtual",
                //                 useNative: true,
                //                 scrollByContent: true,
                //                 scrollByThumb: true,
                //                 showScrollbar: "always"
                //             },
                //             showBorders: true,
                //             headerFilter: {
                //                 visible: true
                //             },
                //             rowAlternationEnabled: true,
                //             searchPanel: {
                //                 visible: true
                //             },
                //             paging: {
                //                 enabled: true,
                //                 pageSize: 90,
                //             },
                //             grouping: {
                //                 autoExpandAll: false,
                //                 allowCollapsing: true
                //             },
                //             filterRow: {
                //                 visible: true
                //             },
                //             groupPanel: {
                //                 visible: true,
                //                 emptyPanelText: "Drag kolom disini untuk grouping"
                //             },
                //             "export": {
                //                 enabled: true,
                //                 fileName: "Penerimaan Barang",
                //                 allowExportSelectedData: true
                //             },
                //             onToolbarPreparing: function(e) {
                //                 e.toolbarOptions.items.unshift({
                //                     location: "after",
                //                     widget: "dxButton",
                //                     options: {
                //                         icon: "refresh",
                //                         text: "Refresh Data",
                //                         onClick: function() {
                //                             $.ajax({
                //                                 url: '/sales/getData/NotaAll',
                //                                 method: "GET",
                //                                 success: function(data) {
                //                                     let grid = $(
                //                                             "#invTable")
                //                                         .dxDataGrid(
                //                                             "instance");
                //                                     grid.option(
                //                                         "dataSource",
                //                                         data.data);
                //                                 },
                //                                 error: function(err) {
                //                                     console.error(
                //                                         "Failed to fetch data:",
                //                                         err);
                //                                 }
                //                             });
                //                         }
                //                     }
                //                 });
                //             },
                //             columns: [{
                //                     dataField: "TransDate",
                //                     dataType: "date",
                //                     caption: "Tanggal",
                //                     cssClass: "cls",
                //                     format: "dd/MM/yyyy",
                //                     width: "6%",
                //                     groupIndex: 0,
                //                     sortOrder: "desc"
                //                 },
                //                 {
                //                     dataField: "IDM",
                //                     dataType: "string",
                //                     caption: "ID",
                //                     width: "4%",
                //                     cssClass: "cls"
                //                 },
                //                 {
                //                     dataField: "invoice_number",
                //                     dataType: "string",
                //                     caption: "No Nota",
                //                     width: "7%",
                //                     cssClass: "cls"
                //                 },
                //                 {
                //                     dataField: "Grosir",
                //                     dataType: "string",
                //                     caption: "Grosir",
                //                     cssClass: "cls",
                //                     width: "4%"
                //                 },
                //                 {
                //                     dataField: "Customer",
                //                     dataType: "string",
                //                     caption: "Customer",
                //                     cssClass: "cls",
                //                     width: "10%"
                //                 },
                //                 {
                //                     dataField: "Person",
                //                     dataType: "string",
                //                     caption: "Pembeli",
                //                     cssClass: "cls",
                //                     width: "10%"
                //                 },
                //                 {
                //                     dataField: "Address",
                //                     dataType: "string",
                //                     caption: "Address",
                //                     cssClass: "cls",
                //                     width: "12%"
                //                 },
                //                 {
                //                     dataField: "Phone",
                //                     dataType: "string",
                //                     caption: "Phone",
                //                     cssClass: "cls",
                //                     width: "10%"
                //                 },
                //                 {
                //                     dataField: "productSW",
                //                     dataType: "string",
                //                     caption: "Kategori",
                //                     cssClass: "cls",
                //                     width: "4%"
                //                 },
                //                 {
                //                     dataField: "caratSW",
                //                     dataType: "string",
                //                     caption: "Kadar",
                //                     cssClass: "cls",
                //                     width: "4%"
                //                 },
                //                 {
                //                     dataField: "Weight",
                //                     dataType: "number",
                //                     caption: "Brt Kotor",
                //                     cssClass: "cls",
                //                     width: "8%",
                //                     format: {
                //                         type: "fixedPoint",
                //                         precision: 2
                //                     },
                //                     customizeText: function(cellInfo) {
                //                         if (cellInfo.value == null) return "";
                //                         return cellInfo.value.toLocaleString('en-US', {
                //                             minimumFractionDigits: 2,
                //                             maximumFractionDigits: 2
                //                         });
                //                     }
                //                 },
                //                 {
                //                     dataField: "Price",
                //                     dataType: "number",
                //                     caption: "Harga",
                //                     cssClass: "cls",
                //                     width: "8%",
                //                     format: {
                //                         type: "fixedPoint",
                //                         precision: 3
                //                     },
                //                     customizeText: function(cellInfo) {
                //                         if (cellInfo.value == null) return "";
                //                         return cellInfo.value.toLocaleString('en-US', {
                //                             minimumFractionDigits: 3,
                //                             maximumFractionDigits: 3
                //                         });
                //                     }
                //                 },
                //                 {
                //                     dataField: "Netto",
                //                     dataType: "number",
                //                     caption: "Brt Bersih",
                //                     cssClass: "cls",
                //                     width: "8%",
                //                     format: {
                //                         type: "fixedPoint",
                //                         precision: 3
                //                     },
                //                     customizeText: function(cellInfo) {
                //                         if (cellInfo.value == null) return "";
                //                         return cellInfo.value.toLocaleString('en-US', {
                //                             minimumFractionDigits: 3,
                //                             maximumFractionDigits: 3
                //                         });
                //                     }
                //                 },
                //                 {
                //                     dataField: "PriceCust",
                //                     dataType: "number",
                //                     caption: "Harga Cust",
                //                     cssClass: "cls",
                //                     width: "8%",
                //                     format: {
                //                         type: "fixedPoint",
                //                         precision: 3
                //                     },
                //                     customizeText: function(cellInfo) {
                //                         if (cellInfo.value == null) return "";
                //                         return cellInfo.value.toLocaleString('en-US', {
                //                             minimumFractionDigits: 3,
                //                             maximumFractionDigits: 3
                //                         });
                //                     }
                //                 },
                //                 {
                //                     dataField: "NettoCust",
                //                     dataType: "number",
                //                     caption: "Brt Bersih Cust",
                //                     cssClass: "cls",
                //                     width: "8%",
                //                     format: {
                //                         type: "fixedPoint",
                //                         precision: 3
                //                     },
                //                     customizeText: function(cellInfo) {
                //                         if (cellInfo.value == null) return "";
                //                         return cellInfo.value.toLocaleString('en-US', {
                //                             minimumFractionDigits: 3,
                //                             maximumFractionDigits: 3
                //                         });
                //                     }
                //                 },
                //                 {
                //                     dataField: "Event",
                //                     dataType: "string",
                //                     caption: "Event",
                //                     cssClass: "cls",
                //                     width: "5%"
                //                 },
                //                 {
                //                     dataField: "SubGrosir",
                //                     dataType: "string",
                //                     caption: "SubGrosir",
                //                     cssClass: "cls",
                //                     width: "10%"
                //                 },
                //                 {
                //                     dataField: "Venue",
                //                     dataType: "string",
                //                     caption: "Tempat",
                //                     cssClass: "cls",
                //                     width: "4%"
                //                 }
                //             ],
                //             summary: {
                //                 groupItems: [{
                //                     column: 'Weight',
                //                     summaryType: 'sum',
                //                     valueFormat: {
                //                         type: "fixedPoint",
                //                         precision: 2
                //                     },
                //                     displayFormat: "{0}"
                //                 }],
                //                 totalItems: [{
                //                     column: "Weight",
                //                     summaryType: "sum",
                //                     valueFormat: {
                //                         type: "fixedPoint",
                //                         precision: 2
                //                     },
                //                     displayFormat: "{0}",
                //                     cssClass: "summary-weight"
                //                 }]
                //             }
                //         }).dxDataGrid("instance");
                //     }
                // });
                $.ajax({
                    url: '/sales/getData/NotaAll',
                    type: 'GET',
                    success: function(data) {
                        const now = new Date();
                        const formattedDate = now.toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit'
                        }).replace(/\//g, '-');

                        let dataGrid = $("#invTable").dxDataGrid({
                            dataSource: data.data,
                            keyExpr: "IDM",
                            height: 600,
                            allowColumnReordering: true,
                            allowColumnResizing: true,
                            columnAutoWidth: false, // Penting: set false agar bisa scroll horizontal
                            scrolling: {
                                mode: "standard",
                                columnRenderingMode: "virtual",
                                useNative: true, // Gunakan native browser scrolling
                                scrollByContent: true, // Bisa scroll dengan drag content
                                scrollByThumb: true, // Bisa scroll dengan scrollbar
                                showScrollbar: "always" // Selalu tampilkan scrollbar
                            },
                            showBorders: true,
                            headerFilter: {
                                visible: true
                            },
                            rowAlternationEnabled: true,
                            searchPanel: {
                                visible: true
                            },
                            paging: {
                                enabled: true,
                                pageSize: 90,
                            },
                            grouping: {
                                autoExpandAll: false,
                                allowCollapsing: true
                            },
                            filterRow: {
                                visible: true
                            },
                            groupPanel: {
                                visible: true,
                                emptyPanelText: "Drag kolom disini untuk grouping"
                            },
                            "export": {
                                enabled: true,
                                fileName: `Daftar Invoice ${formattedDate}`,
                                allowExportSelectedData: false
                            },
                            onToolbarPreparing: function(e) {
                                e.toolbarOptions.items.unshift({
                                    location: "after",
                                    widget: "dxButton",
                                    options: {
                                        icon: "refresh",
                                        text: "Refresh Data",
                                        onClick: function() {
                                            $.ajax({
                                                url: '/sales/getData/NotaAll',
                                                method: "GET",
                                                success: function(data) {
                                                    let grid = $(
                                                            "#invTable")
                                                        .dxDataGrid(
                                                            "instance");
                                                    grid.option(
                                                        "dataSource",
                                                        data.data);
                                                },
                                                error: function(err) {
                                                    console.error(
                                                        "Failed to fetch data:",
                                                        err);
                                                }
                                            });
                                        }
                                    }
                                });
                            },
                            columns: [{
                                    dataField: "TransDate",
                                    dataType: "date",
                                    caption: "Tanggal",
                                    cssClass: "cls",
                                    format: "dd/MM/yyyy",
                                    width: 120, // Ubah dari "6%" ke pixel
                                    groupIndex: 0,
                                    sortOrder: "desc"
                                },
                                {
                                    dataField: "IDM",
                                    dataType: "string",
                                    caption: "ID",
                                    width: 80,
                                    cssClass: "cls"
                                },
                                {
                                    dataField: "invoice_number",
                                    dataType: "string",
                                    caption: "No Nota",
                                    width: 120,
                                    cssClass: "cls"
                                },
                                {
                                    dataField: "Grosir",
                                    dataType: "string",
                                    caption: "Grosir",
                                    cssClass: "cls",
                                    width: 100
                                },
                                {
                                    dataField: "Customer",
                                    dataType: "string",
                                    caption: "Customer",
                                    cssClass: "cls",
                                    width: 150
                                },
                                {
                                    dataField: "Person",
                                    dataType: "string",
                                    caption: "Pembeli",
                                    cssClass: "cls",
                                    width: 150
                                },
                                {
                                    dataField: "Address",
                                    dataType: "string",
                                    caption: "Address",
                                    cssClass: "cls",
                                    width: 200
                                },
                                {
                                    dataField: "Phone",
                                    dataType: "string",
                                    caption: "Phone",
                                    cssClass: "cls",
                                    width: 120
                                },
                                {
                                    dataField: "productSW",
                                    dataType: "string",
                                    caption: "Kategori",
                                    cssClass: "cls",
                                    width: 100
                                },
                                {
                                    dataField: "caratSW",
                                    dataType: "string",
                                    caption: "Kadar",
                                    cssClass: "cls",
                                    width: 80,
                                    cellTemplate: function(container, options) {
                                        let bgColor = options.data.color || '#ffffff';
                                        let textColor = options.data.textColor ||
                                            '#000000';

                                        $('<div>')
                                            .css({
                                                'background-color': bgColor,
                                                'color': textColor,
                                                'padding': '5px',
                                                'border-radius': '4px',
                                                'text-align': 'center'
                                            })
                                            .text(options.value)
                                            .appendTo(container);
                                    }
                                },
                                {
                                    dataField: "Weight",
                                    dataType: "number",
                                    caption: "Brt Kotor",
                                    cssClass: "cls",
                                    width: 120,
                                    format: {
                                        type: "fixedPoint",
                                        precision: 2
                                    },
                                    customizeText: function(cellInfo) {
                                        if (cellInfo.value == null) return "";
                                        return cellInfo.value.toLocaleString('en-US', {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        });
                                    }
                                },
                                {
                                    dataField: "Price",
                                    dataType: "number",
                                    caption: "Harga",
                                    cssClass: "cls",
                                    width: 120,
                                    format: {
                                        type: "fixedPoint",
                                        precision: 3
                                    },
                                    customizeText: function(cellInfo) {
                                        if (cellInfo.value == null) return "";
                                        return cellInfo.value.toLocaleString('en-US', {
                                            minimumFractionDigits: 3,
                                            maximumFractionDigits: 3
                                        });
                                    }
                                },
                                {
                                    dataField: "Netto",
                                    dataType: "number",
                                    caption: "Brt Bersih",
                                    cssClass: "cls",
                                    width: 120,
                                    format: {
                                        type: "fixedPoint",
                                        precision: 3
                                    },
                                    customizeText: function(cellInfo) {
                                        if (cellInfo.value == null) return "";
                                        return cellInfo.value.toLocaleString('en-US', {
                                            minimumFractionDigits: 3,
                                            maximumFractionDigits: 3
                                        });
                                    }
                                },
                                {
                                    dataField: "PriceCust",
                                    dataType: "number",
                                    caption: "Harga Cust",
                                    cssClass: "cls",
                                    width: 120,
                                    format: {
                                        type: "fixedPoint",
                                        precision: 3
                                    },
                                    customizeText: function(cellInfo) {
                                        if (cellInfo.value == null) return "";
                                        return cellInfo.value.toLocaleString('en-US', {
                                            minimumFractionDigits: 3,
                                            maximumFractionDigits: 3
                                        });
                                    }
                                },
                                {
                                    dataField: "NettoCust",
                                    dataType: "number",
                                    caption: "Brt Bersih Cust",
                                    cssClass: "cls",
                                    width: 150,
                                    format: {
                                        type: "fixedPoint",
                                        precision: 3
                                    },
                                    customizeText: function(cellInfo) {
                                        if (cellInfo.value == null) return "";
                                        return cellInfo.value.toLocaleString('en-US', {
                                            minimumFractionDigits: 3,
                                            maximumFractionDigits: 3
                                        });
                                    }
                                },
                                {
                                    dataField: "Event",
                                    dataType: "string",
                                    caption: "Event",
                                    cssClass: "cls",
                                    width: 100
                                },
                                {
                                    dataField: "SubGrosir",
                                    dataType: "string",
                                    caption: "SubGrosir",
                                    cssClass: "cls",
                                    width: 150
                                },
                                {
                                    dataField: "Venue",
                                    dataType: "string",
                                    caption: "Tempat",
                                    cssClass: "cls",
                                    width: 100
                                },
                                {
                                    dataField: "UserName",
                                    dataType: "string",
                                    caption: "Created By",
                                    cssClass: "cls",
                                    width: 100
                                }
                            ],
                            summary: {
                                groupItems: [{
                                        column: 'Weight',
                                        summaryType: 'sum',
                                        showInColumn: 'Weight',
                                        alignByColumn: true,
                                        valueFormat: {
                                            type: "fixedPoint",
                                            precision: 2
                                        },
                                        displayFormat: "{0}",
                                        customizeText: function(data) {
                                            return data.value.toLocaleString('en-US', {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            });
                                        }
                                    },
                                    {
                                        column: 'Netto',
                                        summaryType: 'sum',
                                        showInColumn: 'Netto',
                                        alignByColumn: true,
                                        valueFormat: {
                                            type: "fixedPoint",
                                            precision: 2
                                        },
                                        displayFormat: "{0}",
                                        customizeText: function(data) {
                                            return data.value.toLocaleString('en-US', {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            });
                                        }
                                    }

                                ],
                                totalItems: [{
                                    column: "Weight",
                                    summaryType: "sum",
                                    showInColumn: 'Weight',
                                    valueFormat: {
                                        type: "fixedPoint",
                                        precision: 2
                                    },
                                    displayFormat: "{0}",
                                    cssClass: "summary-weight",
                                    customizeText: function(data) {
                                        return data.value.toLocaleString('en-US', {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        });
                                    }
                                }]
                            }
                        }).dxDataGrid("instance");
                    }
                });
            });
        </script>
    @endsection
