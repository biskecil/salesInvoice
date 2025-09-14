<form  method="post" class="mt-4">
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
                    <input type="text" class="form-control" placeholder="Sub Grosir" name="sub_grosir" readonly
                        value="{{ $data->SubGrosir }}" id="sub_grosir">
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
                <label class="form-label col-sm-4">Total Berat</label>
                <div class="col-sm-8">
                    <input class="form-control" id="totalgwall" type="number" rows="2" placeholder="Total Berat"
                        name="total_berat" readonly value="{{ $data->Weight }}">
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
                <button type="button" class="btn btn-sm btn-success d-none">
                    Scan Item
                </button>
                <button type="button" class="btn btn-sm btn-success d-none">
                    + Item
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                <table class="table table-bordered mb-0">
                    <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                        <tr>
                            <th style="width: 120px;" class="text-center">Kategori</th>
                            <th style="width: 150px;"  class="text-center">Kadar</th>
                            <th style="width: 150px;"  class="text-center">Brt Kotor</th>
                            <th style="width: 150px;"  class="text-center">Harga</th>
                            <th style="width: 150px;"  class="text-center">Brt Bersih</th>
                            @if ($data->isHarga)
                                <th style="width: 150px;"  class="text-center">Harga Cust</th>
                                <th style="width: 150px;"  class="text-center">Brt Bersih Cust
                            @endif


                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data->ItemList as $item)
                            <tr>
                                <td><input type="text" name="category[]"
                                        class="form-control form-control-sm text-center" value="{{ $item->desc_item }}" readonly>
                                </td>
                                <td><input type="text" name="cadar[]"
                                        class="form-control form-control-sm cadar_item text-center" value="{{ $item->caratSW }}"
                                        readonly></td>
                                <td><input type="number" name="wbruto[]" class="form-control form-control-sm wbruto text-end"
                                        min="0" value="{{ $item->gw }}" step="0.01"></td>
                                <td><input type="number" name="price[]" class="form-control form-control-sm price text-end"
                                        min="0" readonly step="0.01" value="{{ $item->price }}"></td>
                                <td><input type="number" name="wnet[]" class="form-control form-control-sm wnet text-end"
                                        min="0" value="{{ $item->nw }}" readonly step="0.01"></td>
                                @if ($data->isHarga)
                                    <td class="isPriceCust"><input type="number" name="pricecust[]"
                                            class="form-control form-control-sm pricecust text-end"
                                            value="{{ $item->priceCust }}" min="0" readonly step="0.01">
                                    </td>
                                    <td class="isPriceCust "><input type="number" name="wnetocust[]"
                                            class="form-control form-control-sm wnetocust text-end"
                                            value="{{ $item->netCust }}" min="0" step="0.01"></td>
                                @endif
                            </tr>
                        @endforeach
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
