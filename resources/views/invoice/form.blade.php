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
                    <div class="d-flex gap-2 justify-content-between">
                        <div>
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
                            <button type="button" class="btn btn-info btn-sm" id="btnCetak"><i
                                    class="fa-solid fa-print"></i>
                                Cetak
                            </button>
                            <button type="button" class="btn btn-info btn-sm" id="btnCetakBarcode">
                                Cetak Barcode
                            </button>

                        </div>
                        <div>
                            <div class="d-flex gap-2 ">
                                <input type="text" class="form-control" id="cariDataNota" style="flex:1"
                                    placeholder="Cari Nota">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <hr class="my-2">
                    <!-- FORM UTAMA -->

                    <div id="formData" class="d-none">

                    </div>
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
                    <input type="text" class="form-control" id="qrcode" placeholder="Scan Barcode di sini" autofocus>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    {{-- <button type="button" class="btn btn-primary" id="btnTambahkanQR">Simpan</button> --}}
                </div>

            </div>
        </div>
    </div>

    <!-- Modal  Camera QR Scan -->
    <div class="modal fade" id="scanQRModalCamera" tabindex="-1" aria-labelledby="scanQRModalCameraLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="scanQRModalCameraLabel">Scan QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="reader"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    {{-- <button type="button" class="btn btn-primary" id="btnTambahkanQR">Simpan</button> --}}
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
    <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('select2/select2.min.js') }}"></script>
   

    <script>
        $(document).ready(function() {
            let dataNota = '';
            $('#btnTambah').prop('disabled', false);
            $('#btnBatal').prop('disabled', true);
            $('#btnCetak').prop('disabled', true);
            $('#btnCetakBarcode').prop('disabled', true);
            $('#btnEdit').prop('disabled', true);
            $('.buttonForm').prop('disabled', true);

            $('#btnCetak').on('click', function() {
                window.open('/sales/cetakNota/' + dataNota, '_blank');
            });
            $('#btnCetakBarcode').on('click', function() {
                window.open('/sales/cetakBarcode/' + dataNota, '_blank');
            });

            $('#btnCari').on('click', function() {
                dataNota = $('#cariDataNota').val();
                $.get('/sales/detail/' + dataNota).done(function(response) {
                        $('#formData').html(response.html).removeClass('d-none');
                        $('#btnTambah').prop('disabled', true);
                        $('#btnBatal').prop('disabled', false);
                        $('#btnCetak').prop('disabled', false);
                        $('#btnCetakBarcode').prop('disabled', false);
                        $('#btnEdit').prop('disabled', false);
                        $('.buttonForm').prop('disabled', true);
                        js_form('edit', response.data);
                        document.querySelectorAll(".isEdit").forEach(el => {
                            el.classList.add("d-none");
                        })
                        document.querySelectorAll(".wbruto").forEach(el => {
                            el.readOnly = true;
                        })
                        document.querySelectorAll(".price").forEach(el => {
                            el.readOnly = true;
                        })
                        document.querySelectorAll(".wnet").forEach(el => {
                            el.readOnly = true;
                        })
                        document.querySelectorAll(".pricecust").forEach(el => {
                            el.readOnly = true;
                        })
                        document.querySelectorAll(".wnetocust").forEach(el => {
                            el.readOnly = true;
                        })

                        $('.select2').prop("disabled", true);
                        $('#cariDataNota').val('')
                    })
                    .fail(function(xhr) {
                        Swal.fire({
                            title: "Info",
                            text: "Data tidak ditemukan",
                            icon: "warning",
                            confirmButtonText: "OK"
                        });

                    });
            });
            $('#btnEdit').on('click', function() {
                $.get('/sales/edit/' + dataNota).done(function(response) {
                        $('#formData').html(response.html).removeClass('d-none');
                        $('#btnTambah').prop('disabled', true);
                        $('#btnBatal').prop('disabled', false);
                        $('#btnCetak').prop('disabled', true);
                        $('#btnCetakBarcode').prop('disabled', true);
                        $('#btnCari').prop('disabled', true);
                        $('#btnEdit').prop('disabled', false);
                        $('.buttonForm').attr("id", "btnSubmitEdit");
                        $('.buttonForm').prop('disabled', false);
                        js_form('edit', response.data);
                    })
                    .fail(function(xhr) {
                        Swal.fire({
                            title: "Info",
                            text: "Data tidak ditemukan",
                            icon: "warning",
                            confirmButtonText: "OK"
                        });

                    });
            });
            $('#btnTambah').on('click', function() {
                dataNota = '';
                $.get('/sales/create', function(html) {
                    $('#formData').html(html).removeClass('d-none');
                    $('#btnTambah').prop('disabled', true);
                    $('#btnCari').prop('disabled', true);
                    $('#btnBatal').prop('disabled', false);
                    $('#btnCetak').prop('disabled', true);
                    $('#btnCetakBarcode').prop('disabled', true);
                    $('#btnEdit').prop('disabled', true);
                    $('.buttonForm').attr("id", "btnSubmitCreate");
                    $('.buttonForm').prop('disabled', false);
                    js_form('create');
                });
            });
            $('#btnBatal').on('click', function() {
                dataNota = '';
                $('#formData').addClass('d-none');
                $('#btnCari').prop('disabled', false);
                $('#btnTambah').prop('disabled', false);
                $('#btnBatal').prop('disabled', true);
                $('#btnCetak').prop('disabled', true);
                $('#btnCetakBarcode').prop('disabled', true);
                $('#btnEdit').prop('disabled', true);
                $('.buttonForm').prop('disabled', true);
            });
        });

        function js_form(typeForm = 'default', dataInv = '') {
            document.getElementById('scanQRModal').addEventListener('shown.bs.modal', function() {
                document.getElementById('qrcode').focus();
            });
            scanQRModal.addEventListener('hidden.bs.modal', function() {
                document.getElementById('qrcode').value = "";
            });
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

            $("#btnSubmitCreate").off("click").on("click", function(e) {
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
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            Swal.fire({
                                title: "Gagal",
                                text: "Silakan periksa kembali form yang Anda isi.",
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

            $("#btnSubmitEdit").off("click").on("click", function(e) {
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
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            Swal.fire({
                                title: "Gagal",
                                text: "Silakan periksa kembali form yang Anda isi.",
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


            const addRowBtn = document.getElementById("addRow");
            const itemsTable = document.getElementById("itemsTable").getElementsByTagName("tbody")[0];
            const itemScanTable = document.getElementById("itemScantable").getElementsByTagName("tbody")[0];
            const barcodeInput = document.getElementById("barcodeInput");
            const caratInput = document.getElementById("carat");
            const qrInput = document.getElementById("qrcode");
            const isHargaCheck = document.getElementById("is_harga_cust");
            const totalgwallInput = document.getElementById("totalgwall");
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
            let default_cat = '{{ $desc[0]->Description }}';
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
                    document.querySelectorAll("#itemsTable tbody tr").forEach(row => {
                        let categorySelect = row.querySelector("select[name='category[]']");
                        let priceInput = row.querySelector(".price");
                        let brutoInput = row.querySelector(".wbruto");
                        let netInput = row.querySelector(".wnet");
                        let priceCustInput = row.querySelector(".pricecust");

                        if (!categorySelect) return;

                        let selectedCat = categorySelect.value;


                        fetchPrice(setGrosir, selectedCat, carat, 0).then(hasil => {
                            if (priceInput) priceInput.value = hasil.price;
                            if (priceCustInput) priceCustInput.value = hasil.priceCust;

                            if (brutoInput && priceInput && netInput) {
                                let bruto = parseFloat(brutoInput.value) || 0;
                                let price = parseFloat(priceInput.value) || 0;
                                let net = bruto * price;
                                netInput.value = net.toFixed(3);
                            }
                        });
                    });

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

                document.querySelectorAll("#itemsTable tbody tr").forEach(row => {
                    let categorySelect = row.querySelector("select[name='category[]']");
                    let priceInput = row.querySelector(".price");
                    let priceCustInput = row.querySelector(".pricecust");
                    let brutoInput = row.querySelector(".wbruto");
                    let netInput = row.querySelector(".wnet");

                    if (!categorySelect) return;

                    let selectedCat = categorySelect.value;


                    fetchPrice(setGrosir, selectedCat, carat, 0).then(hasil => {
                        if (priceInput) priceInput.value = hasil.price;
                        if (priceCustInput) priceCustInput.value = hasil.priceCust;

                        if (brutoInput && priceInput && netInput) {
                            let bruto = parseFloat(brutoInput.value) || 0;
                            let price = parseFloat(priceInput.value) || 0;
                            let net = bruto * price;
                            netInput.value = net.toFixed(3);
                        }
                    });
                });
            });


            isHargaCheck.addEventListener("change", function() {
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

            if (typeForm == 'edit') {
                setGrosir = dataInv.Grosir;
                carat = dataInv.Carat;
                itemScan = dataInv.ItemList;
                addRowItemsTable(itemScan, options_cat);
            }

            function addRowItemsTable(item, options_cat) {

                if (item[0].isHargaCheck) {
                    document.querySelectorAll(".isPriceCust").forEach(el => {
                        el.classList.remove("d-none");
                    });
                }

                itemScan.forEach(item => {
                    let newRow = document.createElement("tr");
                    newRow.innerHTML = `
           <td><select type="text" name="category[]" class="form-control form-control-sm select2" style="max-width:100%" > ${options_cat}</select></td>
            <td><input type="text" name="cadar[]" class="form-control form-control-sm cadar_item"  value="${item.caratSW}" readonly></td>
            <td><input type="number" name="wbruto[]" class="form-control form-control-sm wbruto" min="0"   value="${item.gw}" step="0.01"></td>
            <td><input type="number" name="price[]" class="form-control form-control-sm price" min="0" readonly step="0.01"  value="${item.price}"></td>
            <td><input type="number" name="wnet[]" class="form-control form-control-sm wnet" min="0"  value="${item.nw}" readonly step="0.01"></td>
            <td class="isPriceCust ${item.isHargaCheck ? '' : 'd-none'}"><input type="number" name="pricecust[]" class="form-control form-control-sm pricecust" value="${item.priceCust}" min="0"  readonly step="0.01"></td>
            <td class="isPriceCust  ${item.isHargaCheck ? '' : 'd-none'}"><input type="number" name="wnetocust[]" class="form-control form-control-sm wnetocust" value="${item.netCust}" min="0" step="0.01"></td>
            <td class="text-center isEdit">
                <button type="button" class="btn btn-sm btn-danger removeRow">&times;</button>
            </td>

                        `;
                    itemsTable.appendChild(newRow);

                    let $select = $(newRow).find('.select2').select2({
                        placeholder: "Pilih kategori",
                        allowClear: true,
                        width: '100%'
                    });

                    $select.val(item.desc_item).trigger("change");

                });
            }




            async function fetchPrice(grosirId, categoryId, caratId, wbruto = 0) {
                if (!grosirId || !caratId) return 0;

                try {
                    let res = await fetch(
                        `/sales/getData/Price?customer=${grosirId}&carat=${caratId}&category=${categoryId}`
                    );
                    let data = await res.json();

                    return data ?? 0;
                } catch (err) {
                    console.error("Fetch gagal:", err);
                    return 0;
                }
            }

            document.getElementById("btnScan").addEventListener("click", function() {
                if (setGrosir == '' || carat == '') {
                    Swal.fire({
                        title: "Info",
                        text: "Silakan pilih Grosir dan Kadar terlebih dahulu.",
                        icon: "warning",
                        confirmButtonText: "OK"
                    });
                    return;
                }

                let myModal = new bootstrap.Modal(document.getElementById("scanModal"));
                myModal.show();
            });


            addRowBtn.addEventListener("click", function() {
                if (setGrosir == '' || carat == '') {

                    Swal.fire({
                        title: "Info",
                        text: "Silakan pilih Grosir dan Kadar terlebih dahulu.",
                        icon: "warning",
                        confirmButtonText: "OK"
                    });

                    return false;
                }

                let newRow = document.createElement("tr");
                newRow.innerHTML = `
            <td><select type="text" name="category[]" class="form-control form-control-sm select2" style="max-width:100%"> ${options_cat}</select></td>
            <td><input type="text" name="cadar[]" class="form-control form-control-sm cadar_item"  value="${carat}" readonly></td>
            <td><input type="number" name="wbruto[]" class="form-control form-control-sm wbruto" min="0" step="0.01"></td>
            <td><input type="number" name="price[]" class="form-control form-control-sm price" min="0" readonly step="0.01"></td>
            <td><input type="number" name="wnet[]" class="form-control form-control-sm wnet" min="0" readonly step="0.01"></td>
            <td class="isPriceCust ${isHargaCheck.checked ? '' : 'd-none'}"><input type="number" name="pricecust[]" class="form-control form-control-sm pricecust" min="0"  readonly step="0.01"></td>
            <td class="isPriceCust  ${isHargaCheck.checked ? '' : 'd-none'}"><input type="number" name="wnetocust[]" class="form-control form-control-sm wnetocust" min="0" step="0.01"></td>
            <td class="text-center isEdit">
                <button type="button" class="btn btn-sm btn-danger removeRow">&times;</button>
            </td>
        `;
                itemsTable.appendChild(newRow);


                fetchPrice(setGrosir, default_cat, carat, 0).then(hasil => {
                    document.querySelectorAll("#itemsTable tbody tr").forEach(row => {
                        let priceInput = row.querySelector(".price");
                        let brutoInput = row.querySelector(".wbruto");
                        let netInput = row.querySelector(".wnet");
                        let priceCustInput = row.querySelector(".pricecust");

                        if (priceInput) priceInput.value = hasil.price;
                        if (priceCustInput) priceCustInput.value = hasil.priceCust;

                        if (brutoInput && priceInput && netInput) {
                            let bruto = parseFloat(brutoInput.value) || 0;
                            let price = parseFloat(priceInput.value) || 0;
                            let net = bruto * price;

                            netInput.value = net.toFixed(3);
                        }
                    });
                });

                $(newRow).find('.select2').select2({
                    placeholder: "Pilih kategori",
                    allowClear: true,
                    width: '100%'
                });
            });



            $('#itemsTable tbody').on('change', 'select[name="category[]"]', function() {

                let tr = $(this).closest('tr');
                let selectedCat = $(this).val();

                let cadarInput = tr.find('.cadar_item');
                let brutoInput = tr.find('.wbruto');
                let priceInput = tr.find('.price');
                let priceCustInput = tr.find(".pricecust");
                let netInput = tr.find('.wnet');


                fetchPrice(setGrosir, selectedCat, cadarInput.val(), 0).then(hasil => {
                    if (priceInput.length) priceInput.val(hasil.price);
                    if (priceCustInput.length) priceCustInput.val(hasil.priceCust);

                    if (brutoInput.length && priceInput.length && netInput.length) {
                        let bruto = parseFloat(brutoInput.val()) || 0;
                        let price = parseFloat(priceInput.val()) || 0;
                        let net = bruto * price;
                        netInput.val(net.toFixed(3));
                    }
                });
            });

            itemsTable.addEventListener("change", function(e) {
                let tr = e.target.closest("tr");
                let priceInput = tr.querySelector('.price');
                let brutoInput = tr.querySelector('.wbruto');
                let netInput = tr.querySelector('.wnet');
                let bruto = parseFloat(brutoInput.value) || 0;
                let price = parseFloat(priceInput.value) || 0;
                let net = bruto * price;
                netInput.value = net.toFixed(3);
                let total = 0;

                document.querySelectorAll(".wbruto").forEach(el => {
                    total += parseFloat(el.value) || 0;
                });

                totalgwallInput.value = total.toFixed(2);
            });
            itemsTable.addEventListener("click", function(e) {
                if (e.target.classList.contains("removeRow")) {
                    const row = e.target.closest("tr");

                    const gwall = row.cells[2].querySelector("input").value;
                    totalgwall -= gwall;
                    totalgwallInput.value = totalgwall;


                    e.target.closest("tr").remove();

                    let total = 0;
                    document.querySelectorAll(".wbruto").forEach(el => {
                        total += parseFloat(el.value) || 0;
                    });

                    totalgwallInput.value = total.toFixed(2);
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
                    total_nw.innerText = totalnw.toFixed(3);

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

                        itemScan.push({
                            gw: gw,
                            nw: nw
                        });

                        const row = document.createElement("tr");
                        //Info
                        totalItem.innerText = parseInt(totalItem.innerText) + 1;
                        total_gw.innerText = totalgw.toFixed(2);
                        total_nw.innerText = totalnw.toFixed(3);


                        row.innerHTML = `
        <td>${code}</td>
        <td>${gw} gram</td>
        <td>${nw} gram</td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-danger removeRowScan">&times;</button>
        </td>
      `;
                        itemScantableBody.prepend(row);
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

            qrInput.addEventListener("keypress", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    try {
                        let data = JSON.parse(qrInput.value);
                        document.getElementById("sub_grosir").value = data.nt;
                        document.getElementById("alamat").value = data.at;
                        document.getElementById("customer").value = data.pt;
                        let modalEl = document.getElementById('scanQRModal');
                        let modal = bootstrap.Modal.getInstance(modalEl);
                        modal.hide();
                    } catch (e) {
                        Swal.fire({
                            title: "Info",
                            text: "Format QR Salah",
                            icon: "warning",
                            confirmButtonText: "OK"
                        })
                        qrInput.value = '';

                    }

                }

                // let modal = new bootstrap.Modal(document.getElementById('scanQRModal'));
                // modal.hide();

            });
            document.getElementById("btnTambahkan").addEventListener("click", function() {
                if (totalItem.innerText <= 0) {
                    Swal.fire({
                        title: "Info",
                        text: "Data Scan Kosong",
                        icon: "warning",
                        confirmButtonText: "OK"
                    });
                    return false;
                }

                totalgwall += totalgw;
                totalgwallInput.value = totalgwall;
                desc_item = descInput.value;
                carat = caratInput.value;
                itemScan.forEach(item => {
                    let newRow = document.createElement("tr");
                    newRow.innerHTML = `
           <td><select type="text" name="category[]" class="form-control form-control-sm select2" style="max-width:100%"  value="${desc_item}"> ${options_cat}</select></td>
            <td><input type="text" name="cadar[]" class="form-control form-control-sm cadar_item"  value="${carat}" readonly></td>
            <td><input type="number" name="wbruto[]" class="form-control form-control-sm wbruto" min="0"   value="${item.gw}" step="0.01"></td>
            <td><input type="number" name="price[]" class="form-control form-control-sm price" min="0" readonly step="0.01"></td>
            <td><input type="number" name="wnet[]" class="form-control form-control-sm wnet" min="0"  value="${item.nw}" readonly step="0.01"></td>
            <td class="isPriceCust ${isHargaCheck.checked ? '' : 'd-none'}"><input type="number" name="pricecust[]" class="form-control form-control-sm pricecust" min="0"  readonly step="0.01"></td>
            <td class="isPriceCust  ${isHargaCheck.checked ? '' : 'd-none'}"><input type="number" name="wnetocust[]" class="form-control form-control-sm wnetocust" min="0" step="0.01"></td>
            <td class="text-center isEdit">
                <button type="button" class="btn btn-sm btn-danger removeRow">&times;</button>
            </td>

                        `;
                    itemsTable.appendChild(newRow);

                    let $select = $(newRow).find('.select2').select2({
                        placeholder: "Pilih kategori",
                        allowClear: true,
                        width: '100%'
                    });

                    $select.val(desc_item).trigger("change");
                });
                itemScan = [];
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
        };
    </script>
    <script src="{{ asset('scanner/html5-qrcode.min.js') }}"></script>
@endsection
