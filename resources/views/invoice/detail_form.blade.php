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

        .card-main {
            overflow: hidden;
        }
    </style>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm  card-main ">
                <div class="card-header bg-white border-1 pb-2">
                    <div class="d-flex gap-2 justify-content-between">
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-warning btn-sm buttonForm" id="btnSubmitCreate"><i
                                    class="fa-solid fa-floppy-disk"></i> Simpan</button>
                            <button type="button" class="btn btn-danger btn-sm" id="btnBatal"><i
                                    class="fa-regular fa-circle-xmark"></i> Batal</button>
                            <button type="button" class="btn btn-primary btn-sm" id="btnTambah"><i
                                    class="fa-solid fa-plus"></i> Baru</button>
                            <button type="button" class="btn btn-primary btn-sm" id="btnEdit"><i
                                    class="fa-regular fa-pen-to-square"></i> Ubah</button>
                            <button type="button" class="btn btn-primary btn-sm" id="btnCari"><i
                                    class="fa-solid fa-list"></i> Lihat</button>
                            {{-- <button type="button" class="btn btn-info btn-sm" id="btnCetak"><i
                                    class="fa-solid fa-print"></i>
                                Nota
                            </button> --}}
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa-solid fa-print"></i> Nota
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <li><button class="dropdown-item" id="btnCetak">Cetak dgn harga</button></li>
                                    <li><button class="dropdown-item" id="btnCetakCust">Cetak dgn harga customer</button>
                                    </li>
                                    <li><button class="dropdown-item" id="btnCetakKosong">Cetak tanpa harga</button></li>
                                </ul>
                            </div>
                            <button type="button" class="btn btn-info btn-sm" id="btnCetakBarcode">
                                <i class="fa-solid fa-print"></i> QR Code
                            </button>
                            <button type="button" class="btn btn-primary" id="conscale" onclick="connectSerial(false)">
                                <i class="fa-solid fa-scale-balanced"></i> : Hubungkan</button>
                        </div>
                        <div>
                            <div class="d-flex gap-2 ">
                                <input type="search" class="form-control" id="cariDataNota" list="datalistNota"
                                    style="flex:1" placeholder="Cari Nota">
                                <datalist id="datalistNota">
                                    @foreach ($invoice_list as $list)
                                        <option value="{{ $list->invoice_number }}">{{ $list->invoice_number }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form method="post" class="mt-4">
                        <div class="row">
                            <!-- LEFT -->
                            <div class="col-md-4">
                                <div class="mb-2 row">
                                    <label class="form-label col-sm-4 ">No Nota*</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="noNota" readonly
                                            value="{{ $data->invoice_number }}">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="form-label col-sm-4">Tanggal*</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" name="transDate"
                                            value="{{ $data->TransDate }}" readonly>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="form-label col-sm-4">Customer*</label>
                                    <div class="col-sm-8 d-flex gap-2 ">
                                        <input type="text" class="form-control" id="customer" name="customer"
                                            style="flex:1" value="{{ $data->Customer }}" readonly>
                                        <button type="button" class="text-sm btn btn-primary d-none" data-bs-toggle="modal"
                                            data-bs-target="#scanQRModal" readonly>
                                            Scan QR
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="form-label col-sm-4">Nama Pembeli</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" placeholder="Nama pembeli" name="pembeli"
                                            value="{{ $data->Person }}" readonly>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="form-label col-sm-4">Alamat</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" rows="2" placeholder="Alamat"
                                            name="alamat" value="{{ $data->Address }}" id="alamat" readonly>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="form-label col-sm-4">Phone</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" placeholder="Phone" name="phone"
                                            readonly value="{{ $data->Phone }}">
                                    </div>
                                </div>


                            </div>

                            <!-- RIGHT -->
                            <div class="col-md-4">
                                {{-- <div class="mb-3">
                                 <label class="form-label">No Nota</label>
                                 <input type="text" class="form-control" value="-" name="nota" readonly>
                             </div> --}}
                                <div class="mb-3 row">
                                    <label class="form-label col-sm-4">Event*</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="event">
                                            <option value="0"> {{ $data->Event }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="form-label col-sm-4">Grosir*</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="grosir" id="grosir">
                                            <option value="0"> {{ $data->Grosir }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="form-label col-sm-4">Sub Grosir</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" placeholder="Sub Grosir"
                                            name="sub_grosir" readonly value="{{ $data->SubGrosir }}" id="sub_grosir">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="form-label col-sm-4">Tempat</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="tempat">
                                            <option value="0"> {{ $data->Venue }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="form-label col-sm-4">Total</label>
                                    <div class="col-sm-8">
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <label for="totalgwall" class="small mb-1">Berat
                                                    Kotor <span
                                                        class="fw-bold cadar_item">{{ $data->Carat }}</span></label>
                                                <input class="form-control fw-bold text-end text-primary" id="totalgwall"
                                                    type="text" value="{{ $data->Weight }}" name="total_berat_kotor"
                                                    readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="totalnwall" class="small mb-1">Berat
                                                    Bersih <span
                                                        class="fw-bold cadar_item">{{ $data->Carat }}</span></label>
                                                <input class="form-control fw-bold text-end text-danger" id="totalnwall"
                                                    type="text" value="{{ $data->NetWeight }}"
                                                    name="total_berat_bersih" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- RIGHT -->
                            <div class="col-md-4">
                                <div class="mb-3 row">
                                    <label class="form-label col-sm-4">Kadar*</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2 " id="carat">
                                            <option value="">Pilih Data</option>
                                            @foreach ($kadar as $d)
                                                <option value="{{ $d->SW }}"
                                                    {{ $d->SW == $data->Carat ? 'selected' : '' }}
                                                    data-color="{{ $d->color }}">{{ $d->SW }} </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="form-label col-sm-4 d-block">Harga*</label>
                                    <div class="col-sm-8">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="harga"
                                                id="is_harga_cust" {{ $data->isHarga ? 'checked' : '' }} readonly>
                                            <label class="form-check-label" for="is_harga_cust">Iya</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="form-label col-sm-4">Catatan</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" rows="2" placeholder="Catatan" name="catatan" readonly>{{ $data->Remarks }}</textarea>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- CARD TAMBAH ITEM -->
                        <div class="card mt-1 shadow-sm">
                            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold">Daftar Item</h6>

                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                                    <table class="table table-bordered mb-0">
                                        <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                                            <tr>
                                                <th style="width: 120px;" class="text-center">Kategori</th>
                                                <th style="width: 150px;" class="text-center">Kadar</th>
                                                <th style="width: 150px;" class="text-center">Brt Kotor</th>
                                                <th style="width: 150px;" class="text-center">Harga</th>
                                                <th style="width: 150px;" class="text-center">Brt Bersih</th>
                                                @if ($data->isHarga)
                                                    <th style="width: 150px;" class="text-center">Harga Cust</th>
                                                    <th style="width: 150px;" class="text-center">Brt Bersih Cust
                                                @endif


                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data->ItemList as $item)
                                                <tr>
                                                    <td><input type="text" name="category[]"
                                                            class="form-control form-control-sm text-center"
                                                            value="{{ $item->desc_item }}" readonly>
                                                    </td>
                                                    <td class="text-center align-middle"><span
                                                            style="background-color:{{ $item->color }};color:{{ $item->textColor }};padding:2px 6px;border-radius:4px"
                                                            class="cadar_text">{{ $item->caratSW }}</span>

                                                    </td>
                                                    {{-- <td>
                                                        <input type="text" name="cadar[]"
                                                            class="form-control form-control-sm cadar_item text-center"
                                                            value="{{ $item->caratSW }}" readonly>
                                                    </td> --}}
                                                    <td><input type="text" name="wbruto[]"
                                                            class="form-control form-control-sm wbruto text-end"
                                                            min="0" value="{{ $item->gw }}" step="0.01"
                                                            readonly>
                                                    </td>
                                                    <td><input type="text" name="price[]"
                                                            class="form-control form-control-sm price text-end"
                                                            min="0" readonly step="0.01"
                                                            value="{{ $item->price }}"></td>
                                                    <td><input type="text" name="wnet[]"
                                                            class="form-control form-control-sm wnet text-end"
                                                            min="0" value="{{ $item->nw }}" readonly
                                                            step="0.01"></td>
                                                    @if ($data->isHarga)
                                                        <td class="isPriceCust"><input type="text" name="pricecust[]"
                                                                class="form-control form-control-sm pricecust text-end"
                                                                value="{{ $item->priceCust }}" min="0" readonly
                                                                step="0.01">
                                                        </td>
                                                        <td class="isPriceCust "><input type="text" name="wnetocust[]"
                                                                class="form-control form-control-sm wnetocust text-end"
                                                                value="{{ $item->netCust }}" min="0" readonly
                                                                step="0.01"></td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>


                    </form>


                </div>
            </div>
        </div>
    </div>

    <!-- Modal  QR Scan -->
    <div class="modal fade" id="scanQRModal" tabindex="-1" aria-labelledby="scanQRModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="scanQRModalLabel">Scan QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="text" class="form-control" id="qrcode" placeholder="Scan Barcode di sini"
                        autofocus>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    {{-- <button type="button" class="btn btn-primary" id="btnTambahkanQR">Simpan</button> --}}
                </div>

            </div>
        </div>
    </div>

    <!-- Modal  Camera QR Scan -->
    {{-- <div class="modal fade" id="scanQRModalCamera" tabindex="-1" aria-labelledby="scanQRModalCameraLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="scanQRModalCameraLabel">Scan QR Camera</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="reader"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>

            </div>
        </div>
    </div> --}}

    <!-- Modal  Item Scan -->
    <div class="modal fade" id="scanModal" tabindex="-1" aria-labelledby="scanModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog  modal-lg modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="scanModalLabel">Tambah Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">


                    <h6 class="mt-3">Pilih Kategori</h6>
                    <select class="form-control" id="descItem">
                        @foreach ($desc as $d)
                            <option value="{{ $d->Description }}">{{ $d->Description }}</option>
                        @endforeach
                    </select>

                    <div class="row mt-3">
                        <!-- KANAN: Total -->
                        <div class="col-md-4">
                            <h6 class="mt-3">Barcode</h6>
                            <input type="text" class="form-control mt-3" autofocus placeholder="Scan barcode disini"
                                id="barcodeInput" />
                            <h6 class="mt-3">Info</h6>
                            <div class="card shadow-sm mt-3">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between">
                                        <span>Total Item :</span>
                                        <span id="total_item" class="fw-bold">0</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Total GW :</span>
                                        <span id="total_gw" class="fw-bold">0</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Total NW :</span>
                                        <span id="total_nw" class="fw-bold">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <h6 class="mt-3">Rincian</h6>
                            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                                <table class="table table-bordered" id="itemScantable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Item</th>
                                            <th class="text-center">GW</th>
                                            <th class="text-center">NW</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- data item --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btnTambahkan">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('select2/select2.min.js') }}"></script>
    <script src="{{ asset('websocket/websocket-printer.js') }}"></script>
    <script src="{!! asset('timbangan/timbangan.js') !!}"></script>
    <script>
        window.addEventListener("load", () => {
            connectSerial(true);
        });

        var printService = new WebSocketPrinter();
        $(document).ready(function() {
            let noNota = $('input[name="noNota"]').val();
            $('.select2').prop('disabled', true);
            let dataNota = "";

            $('#btnTambah').prop('disabled', false);
            $('#btnBatal').prop('disabled', false);
            $('#btnCetak').prop('disabled', false);
            $('#btnCetakBarcode').prop('disabled', false);
            $('#btnEdit').prop('disabled', false);
            $('.buttonForm').prop('disabled', true);

            $('#btnEdit').on('click', function() {


                $.ajax({
                    url: '/sales/edit/' + noNota,
                    method: 'GET',
                    success: function(response) {
                        window.location.href = '/sales/edit/' + noNota;
                    },
                    error: function(xhr) {
                        if (xhr.status === 500) {

                            Swal.fire({
                                title: "Info",
                                text: "Data tidak ditemukan",
                                icon: "warning",
                                confirmButtonText: "OK"
                            });
                        }
                    }
                });
            });
            $('#btnCetak').on('click', function() {
                //window.open('/sales/cetakNota/semua/' + noNota, '_blank');
                printDirectNota('semua', noNota);
            });
            $('#btnCetakCust').on('click', function() {
                //window.open('/sales/cetakNota/hargacust/' + noNota, '_blank');
                printDirectNota('hargacust', noNota);
            });
            $('#btnCetakKosong').on('click', function() {
                //window.open('/sales/cetakNota/kosong/' + noNota, '_blank');
                printDirectNota('kosong', noNota);
            });
            $('#btnCetakBarcode').on('click', function() {
                // window.open('/sales/cetakBarcode/' + noNota, '_blank');
                printDirectBarcode(noNota)
            });

            $('#cariDataNota').on('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    $('#btnCari').click();
                }
            });

            function printDirectBarcode(data) {
                if (!printService.isConnected()) {
                    console.error("Printer WebSocket tidak aktif");
                    return;
                }
                try {
                    fetch('/sales/cetakBarcode/' + data)
                        .then(res => res.json())
                        .then(res => {
                            printService.submit({
                                type: 'Barcode',
                                url: res.url
                            });
                        });
                    console.log("Berhasil");
                } catch (err) {
                    console.error("Gagal Cetak :", err);
                }
            }

            function printDirectNota(jenis, data) {
                if (!printService.isConnected()) {
                    console.error("Printer WebSocket tidak aktif");
                    return;
                }
                try {
                    fetch('/sales/cetakNota/' + jenis + '/' + data)
                        .then(res => res.json())
                        .then(res => {
                            printService.submit({
                                type: 'Nota',
                                url: res.url
                            });
                        });
                    console.log("Berhasil");
                } catch (err) {
                    console.error("Gagal Cetak :", err);
                }
            }

            $('#btnCari').on('click', function() {
                dataNota = $('#cariDataNota').val();


                $.ajax({
                    url: '/sales/detail/' + dataNota,
                    method: 'GET',
                    success: function(response) {
                        window.location.href = '/sales/detail/' + dataNota;
                    },
                    error: function(xhr) {
                        if (xhr.status === 500) {

                            Swal.fire({
                                title: "Info",
                                text: "Data tidak ditemukan",
                                icon: "warning",
                                confirmButtonText: "OK"
                            });
                        }
                    }
                });

            });


            $('#btnBatal').on('click', function() {
                window.location.href = '/';
            });

            $('#btnTambah').on('click', function() {
                window.location.href = '/sales/create';
            });


            loadSelect2();

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



        });
    </script>
@endsection
