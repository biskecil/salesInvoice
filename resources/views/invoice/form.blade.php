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
    </style>
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">

                    <h5 class="mb-0 text-center fw-bold ">Form Invoice</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach

                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif


                    <!-- FORM UTAMA -->
                    <form action="/sales/create" method="post">
                        @csrf
                        <div class="row">
                            <!-- LEFT -->
                            <div class="col-md-4">
                                <div class="mb-2 row">
                                    <label class="form-label col-sm-4 ">No Nota</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="noNota">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="form-label col-sm-4">Tanggal</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" name="transDate">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="form-label col-sm-4">Customer</label>
                                    <div class="col-sm-8 d-flex gap-2 ">
                                        <input type="text" class="form-control" id="customer" name="customer"
                                            style="flex:1">
                                        <button type="button" class="text-sm btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#scanQRModal">
                                            Scan QR
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="form-label col-sm-4">Nama Pembeli</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" placeholder="Nama pembeli"
                                            name="pembeli"="">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="form-label col-sm-4">Alamat</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" rows="2" placeholder="Alamat" name="alamat" id="alamat">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="form-label col-sm-4">Phone</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" placeholder="Phone" name="phone"="">
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
                                    <label class="form-label col-sm-4">Event</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="event">
                                            <option value="">PIlih Data</option>
                                            <option value="Pameran">Pameran</option>
                                            <option value="Event">Event</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="form-label col-sm-4">Grosir</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="grosir" id="grosir">
                                            <option value="">PIlih Data</option>
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
                                            <option value="">PIlih Data</option>
                                            <option value="JCC">JCC</option>
                                            <option value="Sultan">Sultan</option>
                                            <option value="Shangri-La">Shangri-La</option>
                                            <option value="Westin">Westin</option>
                                            <option value="Bandung">Bandung</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="form-label col-sm-4">Total Berat</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" id="totalgwall" type="number" value="0.00"
                                            rows="2" placeholder="Total Berat" name="total_berat" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- RIGHT -->
                            <div class="col-md-4">
                                <div class="mb-3 row">
                                    <label class="form-label col-sm-4">Kadar</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" id="carat">
                                            <option value="">Pilih Data</option>
                                            @foreach ($kadar as $d)
                                                <option value="{{ $d->SW }}">{{ $d->SW }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="form-label col-sm-4 d-block">Harga</label>
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
                        <div class="card mt-4 shadow-sm">
                            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold">Daftar Item</h6>
                                <div>
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                        data-bs-target="#scanModal">
                                        Scan Item
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
                                                <th style="width: 120px;">Kategori</th>
                                                <th style="width: 150px;">Kadar</th>
                                                <th style="width: 150px;">Brt Kotor</th>
                                                <th style="width: 150px;">Harga</th>
                                                <th style="width: 150px;">Berat Bersih</th>
                                                <th style="width: 150px;" class="isPriceCust d-none">Harga Cust</th>
                                                <th style="width: 150px;" class="isPriceCust d-none">Brt Bersih Cust</th>
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

                        <!-- SUBMIT -->
                        <div class="row mt-3">
                            <div class="col text-center">
                                <button type="submit" class="btn btn-danger fw-bold px-5">Simpan</button>
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
                    <input type="text" class="form-control" id="qrcode">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnTambahkanQR">Simpan</button>
                </div>

            </div>
        </div>
    </div>

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


                    <button id="scanBtn" class="btn btn-success btn-sm mb-3 d-none">Scan Kamera</button>
                    <div id="reader" style="width:100%; max-width:400px; display:none;"></div>

                    <div class="row mt-3">
                        <!-- KIRI: Table -->


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
                                    <div class="d-flex flex-column">
                                        <span>Item terakhir :</span>
                                        </br>
                                        <span id="last_item_scan" class="fw-bold">-</span>
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
                                            <th>Item</th>
                                            <th>GW</th>
                                            <th>NW</th>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Pilih Data",
                allowClear: true
            });
            $("#sub_grosir").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "/sales/getData/subGros/",
                        data: {
                            search: request.term
                        },
                        dataType: "json",
                        success: function(data) {
                            response(data.map(item => item
                                .SubGrosir)); // pakai field sesuai API
                        }
                    });
                },
                minLength: 2
            });

        });

        document.addEventListener("DOMContentLoaded", function() {
            const addRowBtn = document.getElementById("addRow");
            const itemsTable = document.getElementById("itemsTable").getElementsByTagName("tbody")[0];
            const itemScanTable = document.getElementById("itemScantable").getElementsByTagName("tbody")[0];
            const barcodeInput = document.getElementById("barcodeInput");
            const caratInput = document.getElementById("carat");
            const qrInput = document.getElementById("qrcode");
            const isHargaCheck = document.getElementById("is_harga_cust");
            const totalgwallInput = document.getElementById("totalgwall");
            const lastItemlInput = document.getElementById("last_item_scan");
            const descInput = document.getElementById("descItem");
            const itemScantableBody = document.querySelector("#itemScantable tbody");
            const totalItem = document.getElementById("total_item");
            const total_gw = document.getElementById("total_gw");
            const total_nw = document.getElementById("total_nw");
            let setGrosir = '';
            let totalgw = 0;
            let totalgwall = 0;
            let totalnw = 0;
            let carat = '';
            let desc_item = '';
            let itemScan = [];
            let options_cat = `
@foreach ($desc as $d)
    <option value="{{ $d->Description }}">{{ $d->Description }}</option>
@endforeach
`;

            $('#grosir').on('change', function() {
                let id = this.value;
                if (id) {
                    setGrosir = id;
                } else {
                    document.getElementById("customer").value = "";
                    setGrosir = '';
                }
            });


            $('#carat').on('change', function() {
                carat = this.value;
                document.querySelectorAll(".cadar_item").forEach(el => {
                    el.value = carat;
                })
            });


            isHargaCheck.addEventListener("change", function() {
                console.log(this.checked);
                if (this.checked) {

                    document.querySelectorAll(".isPriceCust").forEach(el => {
                        el.classList.remove("d-none");
                    });

                } else {
                    document.querySelectorAll(".isPriceCust").forEach(el => {
                        el.classList.add("d-none");
                    });
                }

            });

            addRowBtn.addEventListener("click", function() {
                if (setGrosir == '' || carat == '') {
                    alert('Grosir dan Kadar harus di pilih');
                    return false;
                }
                let newRow = document.createElement("tr");
                newRow.innerHTML = `
            <td><select type="text" name="category[]" class="form-control form-control-sm select2" style="max-width:100%"> ${options_cat}</select></td>
            <td><input type="text" name="cadar[]" class="form-control form-control-sm cadar_item"  value="${carat}" readonly></td>
            <td><input type="number" name="wbruto[]" class="form-control form-control-sm" min="0" step="0.01"></td>
            <td><input type="number" name="price[]" class="form-control form-control-sm" min="0" readonly step="0.01"></td>
            <td><input type="number" name="wnet[]" class="form-control form-control-sm" min="0" step="0.01"></td>
            <td class="isPriceCust ${isHargaCheck.checked ? '' : 'd-none'}"><input type="number" name="pricecust[]" class="form-control form-control-sm " min="0"  readonly step="0.01"></td>
            <td class="isPriceCust  ${isHargaCheck.checked ? '' : 'd-none'}"><input type="number" name="wnetocust[]" class="form-control form-control-sm " min="0" step="0.01"></td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-danger removeRow">&times;</button>
            </td>
        `;
                itemsTable.appendChild(newRow);

                $(newRow).find('.select2').select2({
                    placeholder: "Pilih kategori",
                    allowClear: true,
                    width: '100%'
                });
            });


            // remove row
            itemsTable.addEventListener("click", function(e) {
                if (e.target.classList.contains("removeRow")) {
                    const row = e.target.closest("tr");

                    const gwall = row.cells[2].querySelector("input").value;
                    totalgwall -= gwall;
                    totalgwallInput.value = totalgwall;
                    e.target.closest("tr").remove();
                }
            });
            itemScantable.addEventListener("click", function(e) {
                if (e.target.classList.contains("removeRowScan")) {
                    const row = e.target.closest("tr");

                    const gwText = row.cells[1].innerText.replace(" gram", "").trim();
                    const nwText = row.cells[2].innerText.replace(" gram", "").trim();

                    const gw = parseFloat(gwText) || 0;
                    const nw = parseFloat(nwText) || 0;

                    // kurangi total
                    totalgw -= gw;
                    totalnw -= nw;


                    // update info
                    totalItem.innerText = parseInt(totalItem.innerText) - 1;
                    total_gw.innerText = totalgw.toFixed(2);
                    total_nw.innerText = totalnw.toFixed(2);

                    // hapus row
                    row.remove();
                }
            });



            // ketika user tekan Enter
            barcodeInput.addEventListener("keypress", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    const code = barcodeInput.value.trim();
                    if (code !== "") {
                        barcodeInput.value = "";

                        const parts = code.split("-");
                        const itemCode = parts[0];
                        const gw = parts.length > 2 ? parseFloat(parts[1]) : 0.00;
                        const nw = parts.length > 2 ? parseFloat(parts[2]) : 0.00;
                        totalgw += gw;
                        totalnw += nw;

                        const row = document.createElement("tr");
                        lastItemlInput.innerText = code;
                        //Info
                        totalItem.innerText = parseInt(totalItem.innerText) + 1;
                        total_gw.innerText = totalgw.toFixed(2);
                        total_nw.innerText = totalnw.toFixed(2);


                        row.innerHTML = `
        <td>${code}</td>
        <td>${gw} gram</td>
        <td>${nw} gram</td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-danger removeRowScan">&times;</button>
        </td>
      `;
                        itemScantableBody.appendChild(row);
                        barcodeInput.value = "";
                    }
                }
            });

            function resetTableScan() {
                document.querySelector("#itemScantable tbody").innerHTML = "";
                barcodeInput.value = '';
                totalgw = 0;
                totalnw = 0;
                totalItem.innerText = 0;
                total_gw.innerText = "0.00 gram";
                total_nw.innerText = "0.00 gram";
                lastItemlInput.innerText = '-';
            }

            document.getElementById('scanModal').addEventListener('hidden.bs.modal', function() {
                resetTableScan();
            });


            document.getElementById("btnTambahkanQR").addEventListener("click", function() {
                let qrValue = qrInput.value; 

                try {
                    let data = JSON.parse(qrValue);
                    document.getElementById("customer").value = data.nt;
                    document.getElementById("alamat").value = data.at;
                    document.getElementById("sub_grosir").value = data.pt;
                    
                } catch (e) {
                    console.error("QR Code tidak valid:", e);
                    alert("Format QR salah!");
                }

            });
            document.getElementById("btnTambahkan").addEventListener("click", function() {
                if (totalItem.innerText <= 0) {
                    alert('Item kosong')
                    return false;
                }
                totalgwall += totalgw;
                totalgwallInput.value = totalgwall;
                desc_item = descInput.value;
                carat = caratInput.value;
                let newRow = document.createElement("tr");
                newRow.innerHTML = `
            <td><input type="text"   style="min-width:100px;" name="category[]" class="form-control" readonly value="${desc_item}"></td>
            <td><input type="text"  style="min-width:100px;" name="cadar[]" class="form-control cadar_item" readonly value="${carat}"></td>
            <td><input type="number"  style="min-width:100px;" name="wbruto[]" class="form-control"  value="${totalgw}" step="0.01"></td>
            <td><input type="number"  style="min-width:100px;" name="price[]" class="form-control" value="0" step="0.01"></td>
            <td><input type="number"  style="min-width:100px;" name="wnet[]" class="form-control"  value="${totalnw}" step="0.01"></td>
            <td class="isPriceCust ${isHargaCheck.checked ? '' : 'd-none'}"><input type="number"  style="min-width:100px;" name="pricecust[]" class="form-control"  readonly value="0" step="0.01"></td>
            <td class="isPriceCust ${isHargaCheck.checked ? '' : 'd-none'}"><input type="number"  style="min-width:100px;" name="wnetocust[]" class="form-control" value="0" step="0.01"></td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-danger removeRow">&times;</button>
            </td>
        `;
                itemsTable.appendChild(newRow);
                resetTableScan()
            });

            let html5QrcodeScanner;
            let cameraId;

            document.getElementById('scanBtn').addEventListener('click', async () => {
                const reader = document.getElementById('reader');
                reader.style.display = 'block';

                let html5QrcodeScanner = new Html5Qrcode("reader");


                try {
                    // await hanya boleh di async function
                    const devices = await Html5Qrcode.getCameras();
                    if (devices && devices.length) {
                        const cameraId = devices.find(d => d.label.toLowerCase().includes('back'))
                            ?.id || devices[0].id;
                        html5QrcodeScanner.start(
                            cameraId, {
                                fps: 10,
                                qrbox: 250
                            },
                            decodedText => {
                                document.getElementById('barcodeInput').value = decodedText;
                                html5QrcodeScanner.stop().then(() => reader.style.display = 'none');
                            }
                        ).catch(err => console.error(err));
                    }
                } catch (err) {
                    console.error("Gagal dapat kamera:", err);
                }
            });
        });
    </script>
    <script src="{{ asset('scanner/html5-qrcode.min.js') }}"></script>
@endsection
