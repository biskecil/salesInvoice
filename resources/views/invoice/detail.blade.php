<form action="/sales/update/{{ $data->ID }}" method="post" id="salesForm" class="mt-4">
    @method('PUT')
    @csrf
    <div class="row">
        <!-- LEFT -->
        <div class="col-md-4">
            <div class="mb-2 row">
                <label class="form-label col-sm-4 ">No Nota*</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="noNota" readonly value="{{ $data->invoice_number }}" >
                </div>
            </div>
            <div class="mb-2 row">
                <label class="form-label col-sm-4">Tanggal*</label>
                <div class="col-sm-8">
                    <input type="date" class="form-control" name="transDate" value="{{ $data->TransDate }}" readonly>
                </div>
            </div>
            <div class="mb-2 row">
                <label class="form-label col-sm-4">Customer*</label>
                <div class="col-sm-8 d-flex gap-2 ">
                    <input type="text" class="form-control" id="customer" name="customer" style="flex:1"
                        value="{{ $data->Customer }}" readonly>
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
                    <input type="text" class="form-control" rows="2" placeholder="Alamat" name="alamat"
                        value="{{ $data->Address }}" id="alamat" readonly>
                </div>
            </div>
            <div class="mb-2 row">
                <label class="form-label col-sm-4">Phone</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" placeholder="Phone" name="phone" readonly
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
                        <option value="0" > {{ $data->Event }}</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="form-label col-sm-4">Grosir*</label>
                <div class="col-sm-8">
                    <select class="form-control select2" name="grosir" id="grosir">
                        <option value="0" > {{ $data->Grosir }}</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="form-label col-sm-4">Sub Grosir</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" placeholder="Sub Grosir" name="sub_grosir" readonly
                        value="{{ $data->SubGrosir }}" id="sub_grosir">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="form-label col-sm-4">Tempat</label>
                <div class="col-sm-8">
                    <select class="form-control select2" name="tempat">
                        <option value="0" > {{ $data->Venue }}</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="form-label col-sm-4">Total Berat</label>
                <div class="col-sm-8">
                    <input class="form-control" id="totalgwall" type="number" rows="2"
                        placeholder="Total Berat" name="total_berat" readonly value="{{ $data->Weight }}">
                </div>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="col-md-4">
            <div class="mb-3 row">
                <label class="form-label col-sm-4">Kadar*</label>
                <div class="col-sm-8">
                    <select class="form-control select2" id="carat">

                        <option value="{{ $data->Carat }}">
                            {{ $data->Carat }}</option>

                    </select>

                </div>
            </div>
            <div class="mb-3 row">
                <label class="form-label col-sm-4 d-block">Harga*</label>
                <div class="col-sm-8">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="harga" id="is_harga_cust"
                            {{ $data->isHarga ? 'checked' : '' }} readonly>
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
    <div class="card mt-4 shadow-sm">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold">Daftar Item</h6>
            <div>
                <button type="button" id="btnScan" class="btn btn-sm btn-success d-none">
                    Scan Item
                </button>
                <button type="button" class="btn btn-sm btn-success d-none" id="addRow">
                    + Item
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                <table class="table table-bordered mb-0" id="itemsTable">
                    <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                        <tr>
                            <th style="width: 120px;">Kategori</th>
                            <th style="width: 150px;">Kadar</th>
                            <th style="width: 150px;">Brt Kotor</th>
                            <th style="width: 150px;">Harga</th>
                            <th style="width: 150px;">Berat Bersih</th>
                            <th style="width: 150px;" class="isPriceCust d-none">Harga Cust</th>
                            <th style="width: 150px;" class="isPriceCust d-none">Brt Bersih Cust
                            </th>
                            <th style="width: 50px;" class="isEdit"></th>
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

    <!-- SUBMIT -->
    <div class="row mt-3">
        <div class="col text-center">
            <button type="button" class="btn btn-warning fw-bold px-5 d-none" id="btnSubmitEdit">Simpan</button>
        </div>
    </div>
</form>
