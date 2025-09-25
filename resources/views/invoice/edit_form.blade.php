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
            <div class="card shadow-sm  card-main">
                @include('layouts.navbar')
                <div class="card-body pt-0">
                    <form action="/sales/update/{{ $data->ID }}" method="post" id="salesForm" class="mt-4">
                        @method('PUT')
                        @csrf
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
                                        <input type="date" class="form-control" name="transDate" id="transDate"
                                            value="{{ $data->TransDate }}">
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
                                            style="flex:1" value="{{ $data->Customer }}">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="form-label col-sm-4">Nama Pembeli</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" placeholder="Nama pembeli" name="pembeli"
                                            value="{{ $data->Person }}">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="form-label col-sm-4">Alamat</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" rows="2" placeholder="Alamat"
                                            name="alamat" value="{{ $data->Address }}" id="alamat">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="form-label col-sm-4">Phone</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" placeholder="Phone" name="phone"
                                            value="{{ $data->Phone }}">
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
                                            <option value="Pameran" {{ $data->Event == 'Pameran' ? 'selected' : '' }}>
                                                Pameran</option>
                                            <option value="In House" {{ $data->Event == 'In House' ? 'selected' : '' }}>In
                                                House</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="form-label col-sm-4">Grosir*</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="grosir" id="grosir">
                                            <option value="">Pilih Data</option>
                                            @foreach ($cust as $d)
                                                <option value="{{ $d->ID }}"
                                                    {{ $data->Grosir == $d->ID ? 'selected' : '' }}>
                                                    {{ $d->SW }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="form-label col-sm-4">Sub Grosir</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" placeholder="Sub Grosir"
                                            name="sub_grosir" value="{{ $data->SubGrosir }}" id="sub_grosir">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="form-label col-sm-4">Tempat</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="tempat">
                                            <option value="">Pilih Data</option>
                                            @foreach ($venue as $p)
                                                <option value="{{ $p->Description }}"
                                                    {{ $data->Venue == $p->Description ? 'selected' : '' }}>
                                                    {{ $p->Description }}</option>
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
                                        <select class="form-control select2" id="carat">
                                            <option value="">Pilih Data</option>
                                            @foreach ($kadar as $d)
                                                <option value="{{ $d->SW }}"
                                                    {{ $data->Carat == $d->SW ? 'selected' : '' }}
                                                    data-color="{{ $d->color }}">
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
                                                id="is_harga_cust" {{ $data->isHarga ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_harga_cust">Iya</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="form-label col-sm-4">Catatan</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" rows="2" placeholder="Catatan" name="catatan">{{ $data->Remarks }}</textarea>
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
                                <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                                    <table class="table table-bordered mb-0" id="itemsTable">
                                        <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                                            <tr>
                                                <th style="width: 120px;" class="text-center">Kategori</th>
                                                <th style="width: 150px;" class="text-center">Kadar</th>
                                                <th style="width: 150px;" class="text-center">Brt Kotor</th>
                                                <th style="width: 150px;" class="text-center">Harga</th>
                                                <th style="width: 150px;" class="text-center">Brt Bersih</th>
                                                <th style="width: 150px;" class="isPriceCust text-center d-none">Harga
                                                    Cust</th>
                                                <th style="width: 150px;" class="isPriceCust text-center d-none">Brt
                                                    Bersih Cust
                                                </th>
                                                <th style="width: 50px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- <tr>
                                         <td colspan="8" class="text-center"> Data kosong</td>
                                     </tr> --}}

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
        window.descData = @json($desc->pluck('Description'));
        window.itemScan = @json($data->ItemList);
        window.carat = @json($data->Carat);
        window.setGrosir = @json($data->Grosir);
        window.carat_bgcolor = @json($data->Color);
        window.carat_textcolor = @json($data->textColor);
    </script>
@endsection
