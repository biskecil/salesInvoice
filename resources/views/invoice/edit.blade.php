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
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <button id="btnTambah" type="button" class="btn btn-outline-success fw-bold px-5"   onclick="toggleButtons('tambah')" >Form tambah</button>
                    <button id="btnUpdate" type="button" class="btn btn-outline-warning fw-bold px-5"
                        onclick="toggleButtons('edit')" ">Form Edit</button>
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
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach

                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif


                        <!-- FORM UTAMA -->
                        <form action="/sales/create" method="post">
                            @csrf
                            <div class="row">
                                <!-- LEFT -->
                                <div class="col-md-4">
                                    <div class="mb-3 " id="idInvDiv">
                                        <label class="form-label">ID</label>
                                        <input type="text" class="form-control" name="noNota" id="idInv">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal</label>
                                        <input type="date" class="form-control" name="transDate">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Customer</label>
                                        <input type="text" class="form-control" placeholder="Nama customer"
                                            name="customer">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nama Pembeli</label>
                                        <input type="text" class="form-control" placeholder="Nama pembeli"
                                            name="pembeli"="">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Alamat</label>
                                        <textarea class="form-control" rows="2" placeholder="Alamat" name="alamat"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Phone</label>
                                        <input type="text" class="form-control" placeholder="Phone" name="phone"="">
                                    </div>

                                </div>

                                <!-- RIGHT -->
                                <div class="col-md-4">
                                    {{-- <div class="mb-3">
                                    <label class="form-label">No Nota</label>
                                    <input type="text" class="form-control" value="-" name="nota" readonly>
                                </div> --}}
                                    <div class="mb-3">
                                        <label class="form-label">Event</label>
                                        <input type="text" class="form-control" placeholder="Event" name="event">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Grosir</label>
                                        <input type="text" class="form-control" placeholder="Grosir" name="grosir">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Sub Grosir</label>
                                        <input type="text" class="form-control" placeholder="Sub Grosir"
                                            name="sub_grosir">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tempat</label>
                                        <input class="form-control" rows="2" placeholder="Tempat" name="tempat">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Total Berat</label>
                                        <input class="form-control" id="totalgwall" type="number" value="0.00"
                                            rows="2" placeholder="Total Berat" name="total_berat" readonly>
                                    </div>
                                </div>

                                <!-- RIGHT -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Kadar</label>
                                        <select class="form-control" id="carat">
                                            @foreach ($kadar as $d)
                                                <option value="{{ $d->Description }}">{{ $d->Description }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label d-block">Harga</label>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="harga[]"
                                                value="50000" id="harga1">
                                            <label class="form-check-label" for="harga1">Iya</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Catatan</label>
                                        <textarea class="form-control" rows="2" placeholder="Catatan" name="catatan"></textarea>
                                    </div>

                                </div>
                            </div>

                            <!-- CARD TAMBAH ITEM -->
                            <div class="card mt-4 shadow-sm">
                                <div
                                    class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 fw-bold">Daftar Item</h6>
                                    <div>
                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                            data-bs-target="#scanModal">
                                            Scan Item
                                        </button>
                                        {{-- <button type="button" class="btn btn-sm btn-success" id="addRow">
                                        + Item
                                    </button> --}}
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0" id="itemsTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 120px;">Kategori</th>
                                                    <th style="width: 150px;">Kadar</th>
                                                    <th style="width: 150px;">Brt Kotor</th>
                                                    <th style="width: 150px;">Harga</th>
                                                    <th style="width: 150px;">Berat Bersih</th>
                                                    <th style="width: 150px;">Harga Cust</th>
                                                    <th style="width: 150px;">Brt Bersih Cust</th>
                                                    <th style="width: 50px;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- <tr>
                                            <td colspan="8" class="text-center"> Data kosong</td>
                                        </tr> --}}
                                                {{-- <tr>
                                            <td><input type="text" name="category[]" class="form-control"></td>
                                            <td><input type="text" name="cadar[]" class="form-control"></td>
                                            <td><input type="number" name="wbruto[]" class="form-control"
                                                    min="0" step="0.01"></td>
                                            <td><input type="number" name="price[]" class="form-control" min="0"
                                                    step="0.01"></td>
                                            <td><input type="number" name="wnet[]" class="form-control" min="0"
                                                    step="0.01"></td>
                                            <td><input type="number" name="pricecust[]" class="form-control"
                                                    min="0" step="0.01"></td>
                                            <td><input type="number" name="wnetocust[]" class="form-control"
                                                    min="0" step="0.01"></td>
                                            <td class="text-center">
                                                <button type="button"
                                                    class="btn btn-sm btn-danger removeRow">&times;</button>
                                            </td>
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


    <div class="modal fade" id="scanModal" tabindex="-1" aria-labelledby="scanModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog  modal-lg modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="scanModalLabel">Tambah Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="text" class="form-control" placeholder="Scan barcode disini" id="barcodeInput" />
                    <button id="scanBtn" class="btn btn-success btn-sm mb-3">Scan Kamera</button>
                    <div id="reader" style="width:100%; max-width:400px; display:none;"></div>

                    <h6 class="mt-3">Pilih Kategori</h6>
                    <select class="form-control" id="descItem">
                        @foreach ($desc as $d)
                            <option value="{{ $d->Description }}">{{ $d->Description }}</option>
                        @endforeach
                    </select>
                    <h6 class="mt-3">Rincian</h6>
                    <div class="table-responsive">
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
                                {{-- <tr>
                                <td>CKDSFSDF</td>
                                <td>1.3 gram</td>
                                <td>1.3 gram</td>
                            <tr> --}}
                            </tbody>
                        </table>
                    </div>
                    <div class="card shadow-sm mt-3" style="max-width: 300px;">
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





                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btnTambahkan">Tambahkan</button>
                </div>

            </div>
        </div>
    </div>

    <script>
        function toggleButtons(mode) {
            let btnTambah = document.getElementById("btnTambah");
            let btnUpdate = document.getElementById("btnUpdate");
            let idInvDiv = document.getElementById("idInvDiv");

            if (mode === "tambah") {
                btnTambah.classList.remove("btn-outline-success");
                btnTambah.classList.add("btn-success");
                btnUpdate.classList.remove("btn-warning");
                btnUpdate.classList.add("btn-outline-warning");
                idInvDiv.classList.add("d-none");
            } else if (mode === "edit") {
                btnTambah.classList.remove("btn-success");
                btnTambah.classList.add("btn-outline-success");
                btnUpdate.classList.remove("btn-outline-warning");
                btnUpdate.classList.add("btn-warning");
                idInvDiv.classList.remove("d-none");
            }
        }

        document.addEventListener("DOMContentLoaded", function() {


            toggleButtons("tambah");



            const itemsTable = document.getElementById("itemsTable").getElementsByTagName("tbody")[0];
            const itemScanTable = document.getElementById("itemScantable").getElementsByTagName("tbody")[0];
            const barcodeInput = document.getElementById("barcodeInput");
            const caratInput = document.getElementById("carat");
            const totalgwallInput = document.getElementById("totalgwall");
            const descInput = document.getElementById("descItem");
            const itemScantableBody = document.querySelector("#itemScantable tbody");
            const totalItem = document.getElementById("total_item");
            const total_gw = document.getElementById("total_gw");
            const total_nw = document.getElementById("total_nw");
            let totalgw = 0;
            let totalgwall = 0;
            let totalnw = 0;
            let carat = '';
            let desc_item = '';
            let itemScan = [];

            caratInput.addEventListener("change", function() {
                carat = this.value;


                document.querySelectorAll(".cadar_item").forEach(el => {
                    el.value = carat;
                })
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
            }

            document.getElementById('scanModal').addEventListener('hidden.bs.modal', function() {
                resetTableScan();
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
            <td><input type="number"  style="min-width:100px;" name="wbruto[]" class="form-control" readonly value="${totalgw}" step="0.01"></td>
            <td><input type="number"  style="min-width:100px;" name="price[]" class="form-control" value="0" step="0.01"></td>
            <td><input type="number"  style="min-width:100px;" name="wnet[]" class="form-control" readonly value="${totalnw}" step="0.01"></td>
            <td><input type="number"  style="min-width:100px;" name="pricecust[]" class="form-control" value="0" step="0.01"></td>
            <td><input type="number"  style="min-width:100px;" name="wnetocust[]" class="form-control" value="0" step="0.01"></td>
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
