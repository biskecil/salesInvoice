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
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 text-center fw-bold ">Form Grosir - Tambah</h5>
                </div>
                <div class="card-body">
                    <div class="card card-main shadow-sm " id="formCard">
                        @include('grosir.action')
                        <div class="card-body pt-0">
                            <!-- FORM UTAMA -->
                            <form action="/grosir/store" method="post" id="salesForm" class="mt-4">
                                @csrf
                                <div class="row">
                                    <!-- LEFT -->
                                    <div class="col-md-8">
                                        <div class="mb-2 row">
                                            <label class="form-label col-sm-4">SW</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="sw" placeholder="SW">
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="form-label col-sm-4">Description</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="description"
                                                    placeholder="Description">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>




                <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
                <script>
                    $("#btnSubmitCreate").on("click", function(e) {
                        e.preventDefault(); // prevent normal form submit

                        $.ajax({
                            url: $("#salesForm").attr("action"),
                            type: "POST",
                            data: $("#salesForm").serialize(),
                            success: function(response) {
                                Swal.fire({
                                    title: "Berhasil",
                                    text: "Data telah berhasil disimpan.",
                                    icon: "success",
                                    confirmButtonText: "OK"
                                }).then((result) => {
                                    if (result.isConfirmed || result.isDismissed) {
                                        // window.location.href = '/sales/detail/' + response.data;
                                        window.location.reload();
                                    }
                                });
                            },
                            error: function(xhr) {
                                if (xhr.status === 422) {
                                    Swal.fire({
                                        title: "Gagal",
                                        text: xhr.responseJSON.message,
                                        icon: "error",
                                        confirmButtonText: "OK"
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Gagal",
                                        text: "Server Error",
                                        icon: "error",
                                        confirmButtonText: "OK"
                                    });
                                }

                            }
                        });
                    });
                </script>
            @endsection
