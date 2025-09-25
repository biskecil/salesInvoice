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
            <div class="card  card-main shadow-sm">
                @include('layouts.navbar')
                <div class="card-body pt-0">
                    <!-- FORM UTAMA -->
                    <form action="/sales/store" method="post" id="salesForm" class="mt-4">
                        @csrf
                        <div class="row">
                            <!-- LEFT -->
                            <div class="col-md-4">
                                <div class="mb-2 row">
                                    <label class="form-label col-sm-4">Tanggal*</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" name="transDate" id="transDate">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="form-label col-sm-4">Customer*</label>
                                    <div class="col-sm-8 d-flex gap-2 ">
                                        <button type="button" class="text-sm btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#scanQRModal">
                                            <i class="fa-solid fa-qrcode"></i>
                                        </button>
                                        <input type="text" class="form-control" id="customer" name="customer"
                                            style="flex:1">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="form-label col-sm-4">Nama Pembeli</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" placeholder="Nama pembeli"
                                            name="pembeli">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="form-label col-sm-4">Alamat</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" rows="2" placeholder="Alamat"
                                            name="alamat" id="alamat">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="form-label col-sm-4">Phone</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" placeholder="Phone" name="phone">
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
                                            <option value="">Pilih Data</option>
                                            <option value="Pameran">Pameran</option>
                                            <option value="In House">In House</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="form-label col-sm-4">Grosir*</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="grosir" id="grosir">
                                            <option value="">Pilih Data</option>
                                            @foreach ($cust as $d)
                                                <option value="{{ $d->ID }}">{{ $d->SW }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="form-label col-sm-4">Sub Grosir</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" placeholder="Sub Grosir"
                                            name="sub_grosir" id="sub_grosir">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="form-label col-sm-4">Tempat</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="tempat">
                                            <option value="">Pilih Data</option>
                                            @foreach ($venue as $p)
                                                <option value="{{ $p->Description }}">{{ $p->Description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="form-label col-sm-4">Total</label>
                                    <div class="col-sm-8">
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <label for="totalgwall" class="small mb-1">Berat
                                                    Kotor <span class="fw-bold cadar_item"></span></label>
                                                <input class="form-control fw-bold text-end text-primary" id="totalgwall"
                                                    type="text" name="total_berat_kotor" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="totalnwall" class="small mb-1">Berat
                                                    Bersih <span class="fw-bold cadar_item"></span></label>
                                                <input class="form-control fw-bold text-end text-danger" id="totalnwall"
                                                    type="text" name="total_berat_bersih" readonly>
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
                                                <option value="{{ $d->SW }}" data-color="{{ $d->color }}">
                                                    {{ $d->SW }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="form-label col-sm-4 d-block">Harga*</label>
                                    <div class="col-sm-8">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="harga"
                                                id="is_harga_cust">
                                            <label class="form-check-label" for="is_harga_cust">Iya</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="form-label col-sm-4">Catatan</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" rows="2" placeholder="Catatan" name="catatan"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CARD TAMBAH ITEM -->
                        <div class="card mt-1 shadow-sm">
                            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold">Daftar Item</h6>
                                <div>
                                    <button type="button" id="btnScan" class="btn btn-sm btn-success">
                                        <i class="fa-solid fa-expand"></i> Scan
                                    </button>
                                    <button type="button" class="btn btn-sm btn-success" id="addRow">
                                        + Item
                                    </button>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive" style="max-height: 250px; overflow-y: auto;  ">
                                    <table class="table table-bordered mb-0" id="itemsTable">
                                        <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                                            <tr>
                                                <th style="width: 120px" class="text-center">Kategori</th>
                                                <th style="width: 150px" class="text-center">Kadar</th>
                                                <th style="width: 150px" class="text-center">Brt Kotor</th>
                                                <th style="width: 150px" class="text-center">Harga</th>
                                                <th style="width: 150px" class="text-center">Brt Bersih</th>
                                                <th style="width: 150px" class="isPriceCust d-none text-center">Harga Cust
                                                </th>
                                                <th style="width: 150px" class="isPriceCust d-none text-center">Brt Bersih
                                                    Cust
                                                </th>
                                                <th style="width: 50px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
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

    @include('layouts.modalQR')
    @include('layouts.modalScan')


    <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('select2/select2.min.js') }}"></script>
    <script src="{!! asset('timbangan/timbangan.js') !!}"></script>
    <script src="{!! asset('form/form.js') !!}"></script>
    <script src="{!! asset('autocomplete/autocomplete.js') !!}"></script>
    <script>
        const dataNota = @json($data->pluck('invoice_number'));
        createAutocomplete('cariDataNota', 'notaSuggestions', dataNota);
        window.descData = @json($desc->pluck('Description'));
    </script>
    <script>
        window.addEventListener("load", () => {
            connectSerial(true);
        });

        $(document).ready(function() {
           
            DateNow();
            hotkeys();
            loadSelect2();
            let dataNota = '';
            $('#btnTambah').prop('disabled', true);
            $('#btnBatal').prop('disabled', false);
            $('#btnCetakParent').prop('disabled', true);
            $('#btnCetakBarcode').prop('disabled', true);
            $('#btnEdit').prop('disabled', true);
            $('.buttonForm').prop('disabled', false);

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
            $('#cariDataNota').on('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    $('#btnCari').click();
                }
            });
            $('#btnBatal').on('click', function() {
                window.location.href = '/';
            });

        });
    </script>
@endsection
