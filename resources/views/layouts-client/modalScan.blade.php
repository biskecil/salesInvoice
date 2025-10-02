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
            <select class="form-control select2Scan" id="descItem">
                <option value="">Pilih Data</option>
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
                                <span class="text-primary">Total GW :</span>
                                <span id="total_gw" class="fw-bold text-primary">0</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-danger">Total NW :</span>
                                <span id="total_nw" class="fw-bold text-danger">0</span>
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