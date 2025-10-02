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
                    <h5 class="mb-0 text-center fw-bold ">Form Harga - Tambah</h5>
                </div>
                <div class="card-body">
                    <div class="card card-main shadow-sm " id="formCard">
                        @include('pricelist.action')
                        <div class="card-body pt-0">
                            <!-- FORM UTAMA -->
                            <form action="/pricelist/store" method="post" id="salesForm" class="mt-4">
                                @csrf
                                <div class="row">
                                    <!-- LEFT -->
                                    <div class="col-md-8">
                                        <div class="mb-2 row">
                                            <label class="form-label col-sm-4">Grosir</label>
                                            <div class="col-sm-8">
                                                <select class="form-control select2" name="customer" >
                                                    <option value="">Pilih Data</option>
                                                    @foreach ($cust as $d)
                                                        <option value="{{ $d->ID }}">{{ $d->SW }} ({{ $d->Description }})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="form-label col-sm-4">Kategori</label>
                                            <div class="col-sm-8">
                                                <select class="form-control select2" name="category">
                                                    <option value="">Pilih Data</option>
                                                    @foreach ($desc as $d)
                                                        <option value="{{ $d->ID }}">{{ $d->Description }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="form-label col-sm-4">Kadar</label>
                                            <div class="col-sm-8">
                                                <select class="form-control select2" name="carat">
                                                    <option value="">Pilih Data</option>
                                                    @foreach ($kadar as $d)
                                                        <option value="{{ $d->ID }}"
                                                            data-color="{{ $d->color }}">
                                                            {{ $d->SW }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="form-label col-sm-4">Harga</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control autonumDec3" id="price"
                                                    name="price" placeholder="Description">
                                            </div>
                                        </div>
                                        <div class="mb-2 row">
                                            <label class="form-label col-sm-4">Harga Customer</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control autonumDec3" name="pricecust"
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
                <script src="{{ asset('select2/select2.min.js') }}"></script>
                <script>
                    $(document).ready(function() {
                        const optionsDec3 = {
                            digitGroupSeparator: ',',
                            decimalCharacter: '.',
                            decimalPlaces: 2,
                            minimumValue: "0",
                            roundingMethod: 'D',
                            modifyValueOnUpDownArrow: false,
                            modifyValueOnWheel: false,
                            emptyInputBehavior: "zero"
                        };
                        AutoNumeric.multiple('.autonumDec3', optionsDec3);
                        loadSelect2();
                    });


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


                    function loadSelect2() {
                        $(document).on('focus', '.select2-selection.select2-selection--single', function() {
                            let $select = $(this).closest('.select2-container').siblings('select:enabled');
                            $select.select2('open');
                        });


                        $('select.select2').on('select2:open', function() {
                            setTimeout(() => {
                                document.querySelector('.select2-search__field').focus();
                            }, 50);
                        });

                        $('.select2').select2({
                            theme: 'bootstrap-5',
                            width: '100%',
                            templateResult: function(data) {
                                if (!data.id) return data.text;

                                var color = $(data.element).data('color');
                                var $result = $('<span></span>').text(data.text);

                                if (color) {
                                    var textColor = getContrastYIQ(color);
                                    $result.css({
                                        'background-color': color,
                                        'color': textColor,
                                        'padding': '2px 6px',
                                        'border-radius': '4px'
                                    });
                                }
                                return $result;
                            },
                            templateSelection: function(data) {
                                if (!data.id) return data.text;

                                var color = $(data.element).data('color');
                                var $result = $('<span></span>').text(data.text);

                                if (color) {
                                    var textColor = getContrastYIQ(color);
                                    $result.css({
                                        'background-color': color,
                                        'color': textColor,
                                        'padding': '2px 6px',
                                        'border-radius': '4px'
                                    });
                                }
                                return $result;
                            }
                        });
                    }

                    function getContrastYIQ(hexcolor) {
                        hexcolor = hexcolor.replace('#', '');
                        var r = parseInt(hexcolor.substr(0, 2), 16);
                        var g = parseInt(hexcolor.substr(2, 2), 16);
                        var b = parseInt(hexcolor.substr(4, 2), 16);
                        var yiq = ((r * 299) + (g * 587) + (b * 114)) / 1000;
                        return (yiq >= 128) ? '#000' : '#fff';
                    }
                </script>
            @endsection
