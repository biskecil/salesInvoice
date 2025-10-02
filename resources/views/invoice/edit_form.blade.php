@extends('layouts-client.app')

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
                @include('layouts-client.navbar')
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
                                <div class="mb-3 row">
                                    <label class="form-label col-sm-4">LinkID</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" rows="2" name="linkid" id="linkid"
                                            value="{{ $data->linkid }}">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- CARD TAMBAH ITEM -->
                        <div class="card mt-1 shadow-sm">
                            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                                <div>
                                    <button type="button" id="btnScan" class="btn btn-sm btn-success">
                                        <i class="fa-solid fa-expand"></i> Scan
                                    </button>
                                    <button type="button" class="btn btn-sm btn-success" id="addRow">
                                        + Item
                                    </button>
                                </div>
                                <h6 class="mb-0 fw-bold">Daftar Item</h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                                    <table class="table table-bordered mb-0" id="itemsTable">
                                        <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                                            <tr>
                                                <th style="width: 10px" class="text-center">No</th>
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
                                                <th style="width: 30px;"></th>
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
    @include('layouts-client.modalQR')
    @include('layouts-client.modalScan')
    <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('select2/select2.min.js') }}"></script>
    <script src="{!! asset('timbangan/timbangan.js') !!}"></script>
    <script src="{!! asset('autocomplete/autocomplete.js') !!}"></script>

    <script>
        window.addEventListener("load", () => {
            connectSerial(true);
        });

        $(document).ready(function() {
            // DateNowMax();
            hotkeys();
            loadSelect2();
            let dataNota = '';
            $('#btnTambah').prop('disabled', true);
            $('#btnBatal').prop('disabled', false);
            $('#btnCetakParent').prop('disabled', true);
            $('#btnCetakBarcode').prop('disabled', true);
            $('#btnEdit').prop('disabled', true);
            $('.buttonForm').prop('disabled', false);

            $('#cariDataNota').on('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    $('#btnCari').click();
                }
            });

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
        });

        function DateNowMax() {

            let input = document.getElementById("transDate");
            let [year, month] = input.value.split("-");
            let lastDay = new Date(year, month, 0).getDate();

            input.min = `${year}-${month}-01`;
            input.max = `${year}-${month}-${lastDay}`;


            input.addEventListener("change", function() {
                if (this.value.slice(0, 7) !== `${year}-${month}`) {
                    alert(`Hanya boleh pilih bulan ${year}-${month}`);
                    this.value = "";
                }
            });
        }


        function hotkeys() {
            const optionsDec2 = {
                digitGroupSeparator: ',',
                decimalCharacter: '.',
                decimalPlaces: 2,
                minimumValue: "0",
                roundingMethod: 'D',
                modifyValueOnUpDownArrow: false,
                modifyValueOnWheel: false,
                emptyInputBehavior: "zero"
            };
            const optionsDec3 = {
                digitGroupSeparator: ',',
                decimalCharacter: '.',
                decimalPlaces: 3,
                minimumValue: "0",
                roundingMethod: 'D',
                modifyValueOnUpDownArrow: false,
                modifyValueOnWheel: false,
                emptyInputBehavior: "zero"
            };

            const antotalgwallInput = new AutoNumeric('#totalgwall', optionsDec2);
            const antotalnwallInput = new AutoNumeric('#totalnwall', optionsDec3);

            document.addEventListener("keydown", function(e) {
                if (e.altKey && e.key === "ArrowDown") {
                    e.preventDefault();
                    document.getElementById("addRow").click();
                }
                if (e.altKey && e.key.toLowerCase() === "q") {
                    e.preventDefault();
                    document.querySelector('[data-bs-target="#scanQRModal"]').click();
                }
                if (e.altKey && e.key.toLowerCase() === "s") {
                    e.preventDefault();
                    document.getElementById("btnScan").click();
                }
                if (e.altKey && e.key === "ArrowUp") {
                    e.preventDefault();
                    const itemsTable = document.getElementById("itemsTable").getElementsByTagName("tbody")[0];
                    const rows = itemsTable.querySelectorAll("tr");
                    if (rows.length > 1) { // misal biar header ga kehapus
                        const lastRow = rows[rows.length - 1];
                        // hapus baris
                        lastRow.remove();
                        reindexRows();
                        let total = 0;
                        let totalnw = 0;
                        document.querySelectorAll(".wbruto").forEach(el => {
                            const an = AutoNumeric.getAutoNumericElement(el);
                            total += an ? an.getNumber() : 0;
                        });
                        document.querySelectorAll(".wnet").forEach(el => {
                            const an = AutoNumeric.getAutoNumericElement(el);
                            totalnw += an ? an.getNumber() : 0;
                        });

                        antotalgwallInput.set(total);
                        antotalnwallInput.set(totalnw);
                    }
                }
            });
        }

        function loadSelect2Scan() {
            $('.select2Scan').val('').trigger('change');
            $(document).on('mousedown', '.select2-selection.select2-selection--single', function(e) {
                let $select = $(this).closest('.select2-container').siblings('select:enabled');
                if (!$select.data('select2').isOpen()) {
                    $select.select2('open');
                }
                e.preventDefault();
            });

            $(document).on('select2:open', () => {
                setTimeout(() => {
                    document.querySelector('.select2-container--open .select2-search__field').focus();
                }, 0);
            });


            $('.select2Scan').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#scanModal'),
                width: '100%',
            });
        }

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


        $(document).ready(function() {
            loadSelect2();
            document.getElementById('scanQRModal').addEventListener('shown.bs.modal', function() {
                document.getElementById('qrcode').focus();
            });
            scanQRModal.addEventListener('hidden.bs.modal', function() {
                document.getElementById('qrcode').value = "";
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
                                window.location.href = '/sales/detail/' + response
                                    .data;
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

            const optionsDec2 = {
                digitGroupSeparator: ',',
                decimalCharacter: '.',
                decimalPlaces: 2,
                minimumValue: "0",
                roundingMethod: 'D',
                modifyValueOnUpDownArrow: false,
                modifyValueOnWheel: false,
                emptyInputBehavior: "zero"
            };
            const optionsDec3 = {
                digitGroupSeparator: ',',
                decimalCharacter: '.',
                decimalPlaces: 3,
                minimumValue: "0",
                roundingMethod: 'D',
                modifyValueOnUpDownArrow: false,
                modifyValueOnWheel: false,
                emptyInputBehavior: "zero"
            };

            AutoNumeric.multiple('.autonumDec2', optionsDec2);
            AutoNumeric.multiple('.autonumDec3',
                optionsDec3);
            const addRowBtn = document.getElementById("addRow");
            const itemsTable = document.getElementById("itemsTable").getElementsByTagName("tbody")[0];
            const itemScanTable = document.getElementById("itemScantable").getElementsByTagName("tbody")[0];
            const barcodeInput = document.getElementById("barcodeInput");
            const caratInput = document.getElementById("carat");
            const qrInput = document.getElementById("qrcode");
            const isHargaCheck = document.getElementById("is_harga_cust");
            const totalgwallInput = document.getElementById("totalgwall");
            const totalnwallInput = document.getElementById("totalnwall");
            const antotalgwallInput = new AutoNumeric('#totalgwall', optionsDec2);
            const antotalnwallInput = new AutoNumeric('#totalnwall', optionsDec3);
            const descInput = document.getElementById("descItem");
            const itemScantableBody = document.querySelector("#itemScantable tbody");
            const totalItem = document.getElementById("total_item");
            const total_gw = document.getElementById("total_gw");
            const total_nw = document.getElementById("total_nw");
            const transDateinput = document.getElementById("transDate");
            let today = new Date();
            let yyyy = today.getFullYear();
            let mm = String(today.getMonth() + 1).padStart(2, '0');
            let dd = String(today.getDate()).padStart(2, '0');
            let setGrosir = '';
            let totalgw = 0;
            let totalgwall = @json($data->Weight);
            let totalnwall = @json($data->NetWeight);
            let totalnw = 0;
            let carat = '';
            let carat_textcolor = '{{ $data->ItemList[0]->textColor }}';
            let carat_bgcolor = '{{ $data->ItemList[0]->color }}';
            let carat_last = '{{ $data->Carat }}';
            let desc_item = '';
            let default_cat = '{{ $desc[0]->Description }}';
            let itemScan = [];
            let itemScanBcd = [];
            let scanIndex = 0;
            let options_cat = `
            <option value="">Pilih Data</option>
@foreach ($desc as $d)
    <option value="{{ $d->Description }}">{{ $d->Description }}</option>
@endforeach
`;

            setGrosir = '{{ $data->Grosir }}';
            carat = '{{ $data->Carat }}';
            itemScan =
                @json($data->ItemList);
            addRowItemsTable(itemScan, options_cat);

            function addRowItemsTable(item, options_cat) {

                if (item[0].isHargaCheck) {
                    document.querySelectorAll(".isPriceCust").forEach(el => {
                        el.classList.remove("d-none");
                    });
                }

                itemScan.forEach((item, index) => {
                    let newRow = document.createElement("tr");
                    newRow.innerHTML = `
                    <td class="text-center">${index+1}</td>
           <td><select type="text" name="category[]" class="form-control form-control-sm select2" style="max-width:100%" > ${options_cat}</select></td>
             <td class="text-center align-middle"><span style="background-color:${item.color};color:${item.textColor};padding:2px 6px;border-radius:4px" class="cadar_text">${carat}</span>
                <input type="text" name="cadar[]" class="form-control form-control-sm cadar_item text-center d-none"  value="${item.caratSW}" readonly>
            </td>
            <td>
                     <div class="input-group input-group-sm mb-2">
   <input type="text" name="wbruto[]" class="autonumDec2 form-control form-control-sm wbruto text-end"   value="${item.gw}" >
   <button class="btn btn-primary kalibrasi-btn" type="button"><i class="fa-solid fa-scale-balanced"></i></button>
</div>
                </td>
            <td><input type="text" name="price[]" class="autonumDec3 form-control form-control-sm price text-end" readonly   value="${item.price}"></td>
            <td><input type="text" name="wnet[]" class="autonumDec3 form-control form-control-sm wnet text-end"  value="${item.nw}" readonly ></td>
            <td class="isPriceCust ${item.isHargaCheck ? '' : 'd-none'}"><input type="text" name="pricecust[]" class="autonumDec3 form-control text-end form-control-sm pricecust" value="${item.priceCust}"   ></td>
            <td class="isPriceCust  ${item.isHargaCheck ? '' : 'd-none'}"><input type="text" name="wnetocust[]" class="autonumDec3 form-control text-end form-control-sm wnetocust" value="${item.netCust}"  readonly></td>
            <td class="text-center isEdit">
                <button type="button" class="btn btn-sm btn-danger removeRow">&times;</button>
            </td>

                        `;
                    itemsTable.appendChild(newRow);

                    newRow.querySelectorAll('.autonumDec2').forEach(el => {
                        new AutoNumeric(el, optionsDec2);
                    });
                    newRow.querySelectorAll('.autonumDec3').forEach(el => {
                        new AutoNumeric(el, optionsDec3);
                    });
                    let $select = $(newRow).find('.select2').select2({
                        theme: 'bootstrap-5',
                        width: '100%'
                    });

                    $select.val(item.desc_item).trigger("change");

                });
            }

            function reindexRows() {
                [...itemsTable.rows].forEach((row, index) => {
                    row.cells[0].innerText = index + 1; // nomor otomatis
                });
            }


            $('#grosir').on('change', async function() {
                let id = this.value;
                if (id) {
                    let btn = document.getElementById("btnSubmitCreate");
                    let oldText = btn.innerHTML;
                    btn.disabled = true;
                    btn.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Loading...`;
                    let promises = [];

                    setGrosir = id;
                    document.querySelectorAll("#itemsTable tbody tr").forEach(row => {
                        let categorySelect = row.querySelector("select[name='category[]']");
                        let priceInput = row.querySelector(".price");
                        let brutoInput = row.querySelector(".wbruto");
                        let netInput = row.querySelector(".wnet");
                        let netInputCust = row.querySelector('.wnetocust');
                        let priceCustInput = row.querySelector(".pricecust");

                        let anBruto = AutoNumeric.getAutoNumericElement(brutoInput);
                        let anPrice = AutoNumeric.getAutoNumericElement(priceInput);
                        let anNet = AutoNumeric.getAutoNumericElement(netInput);
                        let anPriceCust = AutoNumeric.getAutoNumericElement(priceCustInput);
                        let anNetCust = AutoNumeric.getAutoNumericElement(netInputCust);

                        if (!categorySelect) return;

                        let selectedCat = categorySelect.value;


                        let p = fetchPrice(setGrosir, selectedCat, carat, 0).then(hasil => {
                            if (priceInput) anPrice.set(hasil.price);
                            if (priceCustInput) {
                                let newVal = hasil.priceCust || 0;
                                if (newVal !== 0) {
                                    anPriceCust.set(newVal);
                                }
                            }

                            if (brutoInput && priceCustInput) {
                                let bruto = anBruto.getNumber() || 0;
                                let priceCust = anPriceCust.getNumber() || 0;
                                let netCust = new Decimal(bruto).times(priceCust);
                                anNetCust.set(netCust);
                            }

                            if (brutoInput && priceInput && netInput) {
                                let bruto = anBruto.getNumber() || 0;
                                let price = anPrice.getNumber() || 0;
                                let net = new Decimal(bruto).times(price);
                                anNet.set(net);
                            }
                            let totalnwall = 0;
                            document.querySelectorAll(".wnet").forEach(el => {
                                const an = AutoNumeric.getAutoNumericElement(
                                    el);
                                totalnwall += an.getNumber() || 0;
                            });

                            antotalnwallInput.set(totalnwall);
                        });
                        promises.push(p);
                    });

                    await Promise.all(promises);

                    btn.disabled = false;
                    btn.innerHTML = oldText;

                } else {
                    document.getElementById("customer").value = "";
                    setGrosir = '';
                }
            });


            async function updateCarat(carat, $select) {

                carat_bgcolor = $select.find(':selected').data('color');
                carat_textcolor = getContrastYIQ(carat_bgcolor);
                document.querySelectorAll(".cadar_item").forEach(el => {
                    el.value = carat;
                    el.textContent = carat;
                })
                document.querySelectorAll(".cadar_text").forEach(el => {
                    el.style.backgroundColor = carat_bgcolor
                    el.style.color = carat_textcolor
                    el.textContent = carat;
                })

                let btn = document.getElementById("btnSubmitCreate");
                let oldText = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Loading...`;
                let promises = [];

                document.querySelectorAll("#itemsTable tbody tr").forEach(row => {
                    let categorySelect = row.querySelector("select[name='category[]']");
                    let priceInput = row.querySelector(".price");
                    let priceCustInput = row.querySelector(".pricecust");
                    let brutoInput = row.querySelector(".wbruto");
                    let netInput = row.querySelector(".wnet");
                    let netInputCust = row.querySelector('.wnetocust');

                    let anBruto = AutoNumeric.getAutoNumericElement(brutoInput);
                    let anPrice = AutoNumeric.getAutoNumericElement(priceInput);
                    let anNet = AutoNumeric.getAutoNumericElement(netInput);
                    let anPriceCust = AutoNumeric.getAutoNumericElement(priceCustInput);
                    let anNetCust = AutoNumeric.getAutoNumericElement(netInputCust);


                    if (!categorySelect) return;

                    let selectedCat = categorySelect.value;


                    let p = fetchPrice(setGrosir, selectedCat, carat, 0).then(hasil => {
                        if (priceInput) anPrice.set(hasil.price);
                        if (priceCustInput) {
                            let newVal = hasil.priceCust || 0;
                            if (newVal !== 0) {
                                anPriceCust.set(newVal);
                            }
                        }

                        if (brutoInput && priceCustInput) {
                            let bruto = anBruto.getNumber() || 0;
                            let priceCust = anPriceCust.getNumber() || 0;
                            let netCust = new Decimal(bruto).times(priceCust);
                            anNetCust.set(netCust);
                        }

                        if (brutoInput && priceInput && netInput) {
                            let bruto = anBruto.getNumber() || 0;
                            let price = anPrice.getNumber() || 0;
                            let net = new Decimal(bruto).times(price);
                            anNet.set(net);
                        }
                        let totalnwall = 0;
                        document.querySelectorAll(".wnet").forEach(el => {
                            const an = AutoNumeric.getAutoNumericElement(el);
                            totalnwall += an.getNumber() || 0;
                        });
                        antotalnwallInput.set(totalnwall);
                    });
                    promises.push(p);
                });
                await Promise.all(promises);
                btn.disabled = false;
                btn.innerHTML = oldText;
            }
            $('#carat').on('change', function() {
                let newCarat = this.value;
                if (newCarat === carat) return;
                Swal.fire({
                    title: "Konfirmasi Perubahan",
                    html: "Kadar diubah ke <b>" + newCarat +
                        "</b>,<br>Lanjutkan perubahan?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Lanjutkan",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        updateCarat(newCarat, $('#carat'));
                        carat = newCarat;
                    } else {
                        $('#carat').val(carat).trigger('change');
                    }
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

                document.getElementById("scanModal").addEventListener("shown.bs.modal", function() {
                    document.getElementById("barcodeInput").focus();
                }, {
                    once: true
                });

                //  loadSelect2Scan();
            });


            addRowBtn.addEventListener("click", function() {
                if (itemsTable.rows.length >= 10) {
                    Swal.fire({
                        title: "Batas Tercapai",
                        text: "Maksimal hanya boleh 10 item.",
                        icon: "info",
                        confirmButtonText: "OK"
                    });
                    return false;
                }
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
                 <td class="text-center"></td>
            <td><select type="text" name="category[]" class="form-control form-control-sm select2" style="max-width:100%"> ${options_cat}</select></td>
            <td class="text-center align-middle"><span style="background-color:${carat_bgcolor};color:${carat_textcolor};padding:2px 6px;border-radius:4px" class="cadar_text">${carat}</span>
                <input type="text" name="cadar[]" class="form-control form-control-sm cadar_item text-center d-none"  value="${carat}" readonly>
            </td>
            <td>
              <div class="input-group input-group-sm mb-2">
  <input type="text"  name="wbruto[]" class="autonumDec2 form-control wbruto text-end" placeholder="0.00">
   <button class="btn btn-primary kalibrasi-btn" type="button"><i class="fa-solid fa-scale-balanced"></i></button>
</div>
                </td>
            <td><input type="text" name="price[]" class="autonumDec3 form-control form-control-sm price text-end" readonly ></td>
            <td><input type="text" name="wnet[]" class="autonumDec3 form-control form-control-sm wnet text-end"  readonly ></td>
            <td class="isPriceCust ${isHargaCheck.checked ? '' : 'd-none'} "><input type="text" name="pricecust[]" class="autonumDec3 text-end form-control form-control-sm pricecust" ></td>
            <td class="isPriceCust  ${isHargaCheck.checked ? '' : 'd-none'}"><input type="text" name="wnetocust[]" class="autonumDec3 text-end form-control form-control-sm wnetocust" readonly></td>
            <td class="text-center isEdit">
                <button type="button" class="btn btn-sm btn-danger removeRow">&times;</button>
            </td>
        `;
                itemsTable.appendChild(newRow);


                // fetchPrice(setGrosir, default_cat, carat, 0).then(hasil => {
                //     document.querySelectorAll("#itemsTable tbody tr").forEach(row => {
                //         let priceInput = row.querySelector(".price");
                //         let brutoInput = row.querySelector(".wbruto");
                //         let netInput = row.querySelector(".wnet");
                //         let netInputCust = row.querySelector(".wnetocust");
                //         let priceCustInput = row.querySelector(".pricecust");

                //         if (priceInput) priceInput.value = hasil.price;
                //         if (priceCustInput) {
                //             let newVal = parseFloat(hasil.priceCust) || 0;
                //             if (newVal !== 0) {
                //                 priceCustInput.value = newVal.toFixed(2);
                //             }
                //         }

                //         if (brutoInput && priceCustInput && netInputCust) {
                //             let bruto = parseFloat(brutoInput.value) || 0;
                //             let priceCust = parseFloat(priceCustInput.value) || 0;
                //             let netCust = bruto * priceCust;
                //             netInputCust.value = netCust.toFixed(3);
                //         }

                //         if (brutoInput && priceInput && netInput) {
                //             let bruto = parseFloat(brutoInput.value) || 0;
                //             let price = parseFloat(priceInput.value) || 0;
                //             let net = bruto * price;

                //             netInput.value = net.toFixed(3);
                //         }
                //     });
                // });

                // $(newRow).find('.select2').select2({
                //     placeholder: "Pilih kategori",
                //     allowClear: true,
                //     width: '100%'
                // });
                reindexRows();
                loadSelect2();


                newRow.querySelectorAll('.autonumDec2').forEach(el => {
                    new AutoNumeric(el, optionsDec2);
                });
                newRow.querySelectorAll('.autonumDec3').forEach(el => {
                    new AutoNumeric(el, optionsDec3);
                });
                newRow.scrollIntoView({
                    behavior: "smooth",
                    block: "nearest"
                });

                newRow.querySelectorAll("td").forEach(td => {
                    td.style.backgroundColor = "#ffff99";
                });
                setTimeout(() => {
                    newRow.querySelectorAll("td").forEach(td => {
                        td.style.backgroundColor = "";
                    });
                }, 1500);

                // let selectEl = newRow.querySelector("select");
                // if (selectEl) {
                //     selectEl.focus();
                // }
                // let $select = $(newRow).find(".select2");
                // $select.select2('open');
            });



            $('#itemsTable tbody').on('click', 'button.kalibrasi-btn', async function() {
                let tr = $(this).closest('tr');
                let priceInput = tr.find('.price')[0];
                let priceCustInput = tr.find('.pricecust')[0];
                let brutoInput = tr.find('.wbruto')[0];
                let netInput = tr.find('.wnet')[0];
                let netInputCust = tr.find('.wnetocust')[0];

                let anBruto = AutoNumeric.getAutoNumericElement(brutoInput);
                let anPrice = AutoNumeric.getAutoNumericElement(priceInput);
                let anPriceCust = AutoNumeric.getAutoNumericElement(priceCustInput);
                let anNet = AutoNumeric.getAutoNumericElement(netInput);
                let anNetCust = AutoNumeric.getAutoNumericElement(netInputCust);


                let total = 0;
                let totalnw = 0;

                try {
                    const hasilTimbang = await kliktimbang();
                    anBruto.set(hasilTimbang);

                    let price = anPrice.getNumber() || 0;
                    let priceCust = anPriceCust.getNumber() || 0;

                    let net = new Decimal(hasilTimbang).times(price);
                    let netCust = new Decimal(hasilTimbang).times(priceCust);

                    anNetCust.set(netCust);
                    anNet.set(net);


                    document.querySelectorAll(".wbruto").forEach(el => {
                        const an = AutoNumeric.getAutoNumericElement(el);
                        total += an.getNumber() || 0;
                    });
                    document.querySelectorAll(".wnet").forEach(el => {
                        const an = AutoNumeric.getAutoNumericElement(el);
                        totalnw += an.getNumber() || 0;
                    });

                    antotalgwallInput.set(total);
                    antotalnwallInput.set(totalnw);


                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Periksa koneksi timbangan',
                        confirmButtonText: 'OK'
                    });
                }


            });
            $('#itemsTable tbody').on('change', 'select[name="category[]"]', function() {

                let tr = $(this).closest('tr');
                let selectedCat = $(this).val();

                let cadarInput = tr.find('.cadar_item');
                let brutoInput = tr.find('.wbruto')[0];
                let priceInput = tr.find('.price')[0];
                let priceCustInput = tr.find(".pricecust")[0];
                let netInput = tr.find('.wnet')[0];
                let netInputCust = tr.find('.wnetocust')[0];

                let anBruto = AutoNumeric.getAutoNumericElement(brutoInput);
                let anPrice = AutoNumeric.getAutoNumericElement(priceInput);
                let anNet = AutoNumeric.getAutoNumericElement(netInput);
                let anPriceCust = AutoNumeric.getAutoNumericElement(priceCustInput);
                let anNetCust = AutoNumeric.getAutoNumericElement(netInputCust);


                fetchPrice(setGrosir, selectedCat, cadarInput.val(), 0).then(hasil => {
                    if (anPrice) {
                        anPrice.set(hasil.price);
                    } else {
                        console.warn('AutoNumeric belum terpasang di', priceInput);
                    }



                    if (priceCustInput) {
                        let newVal = hasil.priceCust || 0;
                        if (newVal !== 0) {
                            anPriceCust.set(newVal);
                        }
                    }

                    if (brutoInput && priceCustInput) {
                        let bruto = anBruto.getNumber() || 0;
                        let priceCust = anPriceCust.getNumber() || 0;
                        let netCust = new Decimal(bruto).times(priceCust);
                        anNetCust.set(netCust);

                    }
                    if (brutoInput && priceInput && netInput) {
                        let bruto = anBruto.getNumber() || 0;
                        let price = anPrice.getNumber() || 0;
                        let net = new Decimal(bruto).times(price);
                        anNet.set(net);
                    }
                    let totalnwall = 0;
                    document.querySelectorAll(".wnet").forEach(el => {
                        const an = AutoNumeric.getAutoNumericElement(el);
                        totalnwall += an.getNumber() || 0;
                    });

                    antotalnwallInput.set(totalnwall);

                });
            });

            //AUTO CLEAR
            // itemsTable.addEventListener("focus", function(e) {
            //     if (e.target.classList.contains("wbruto")) {
            //         if (e.target.value === "0.00") {
            //             e.target.value = "";
            //         }


            //         setTimeout(() => {
            //             e.target.select();
            //         }, 0);
            //     }
            // }, true);


            // itemsTable.addEventListener("blur", function(e) {
            //     if (e.target.classList.contains("wbruto")) {
            //         let val = e.target.value;

            //         if (val === "" || isNaN(val)) {
            //             e.target.value = "0.00";
            //         } else {
            //             e.target.value = parseFloat(val).toFixed(2);
            //         }
            //     }
            // }, true);

            // itemsTable.addEventListener("focus", function(e) {
            //     if (e.target.classList.contains("pricecust")) {
            //         if (e.target.value === "0.00") {
            //             e.target.value = "";
            //         }


            //         setTimeout(() => {
            //             e.target.select();
            //         }, 0);
            //     }
            // }, true);


            // itemsTable.addEventListener("blur", function(e) {
            //     if (e.target.classList.contains("pricecust")) {
            //         let val = e.target.value;

            //         if (val === "" || isNaN(val)) {
            //             e.target.value = "0.00";
            //         } else {
            //             e.target.value = parseFloat(val).toFixed(2);
            //         }
            //     }
            // }, true);

            itemsTable.addEventListener("change", function(e) {
                let tr = e.target.closest("tr");
                let priceInputCust = tr.querySelector('.pricecust');
                let netInputCust = tr.querySelector('.wnetocust');

                let anPriceCust = AutoNumeric.getAutoNumericElement(priceInputCust);
                let anNetCust = AutoNumeric.getAutoNumericElement(netInputCust);

                let brutoInput = tr.querySelector('.wbruto');
                let priceInput = tr.querySelector('.price');
                let netInput = tr.querySelector('.wnet');

                let anBruto = AutoNumeric.getAutoNumericElement(brutoInput);
                let anPrice = AutoNumeric.getAutoNumericElement(priceInput);
                let anNet = AutoNumeric.getAutoNumericElement(netInput);

                let bruto = anBruto.getNumber() || 0;
                let price = anPrice.getNumber() || 0;
                let priceCust = anPriceCust.getNumber() || 0;

                let net = new Decimal(bruto).times(price);
                let netCust = new Decimal(bruto).times(priceCust);

                anNet.set(net);
                anNetCust.set(netCust);

                let total = 0;
                let totalnw = 0;

                document.querySelectorAll(".wbruto").forEach(el => {
                    const an = AutoNumeric.getAutoNumericElement(el);
                    total += an.getNumber() || 0;
                });
                document.querySelectorAll(".wnet").forEach(el => {
                    const an = AutoNumeric.getAutoNumericElement(el);
                    totalnw += an.getNumber() || 0;
                });

                antotalgwallInput.set(total);
                antotalnwallInput.set(totalnw);
            });
            itemsTable.addEventListener("click", function(e) {
                if (e.target.classList.contains("removeRow")) {
                    const row = e.target.closest("tr");

                    e.target.closest("tr").remove();

                    let total = 0;
                    let totalnw = 0;
                    document.querySelectorAll(".wbruto").forEach(el => {
                        const an = AutoNumeric.getAutoNumericElement(el);
                        total += an ? an.getNumber() : 0;
                    });
                    document.querySelectorAll(".wnet").forEach(el => {
                        const an = AutoNumeric.getAutoNumericElement(el);
                        totalnw += an ? an.getNumber() : 0;
                    });

                    antotalgwallInput.set(total);
                    antotalnwallInput.set(totalnw);
                    reindexRows();
                }
            });
            itemScantable.addEventListener("click", function(e) {
                if (e.target.classList.contains("removeRowScan")) {
                    const row = e.target.closest("tr");
                    const id = parseInt(row.getAttribute("data-id"));
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

                    const index = itemScanBcd.findIndex(item => item.id === id);
                    if (index !== -1) {
                        itemScanBcd.splice(index, 1);
                    }

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
                        const id = ++scanIndex;
                        itemScanBcd.push({
                            id: id,
                            gw: gw,
                            nw: nw
                        });

                        const row = document.createElement("tr");
                        row.setAttribute("data-id", id);
                        //Info
                        totalItem.innerText = parseInt(totalItem.innerText) + 1;
                        total_gw.innerText = totalgw.toFixed(2);
                        total_nw.innerText = totalnw.toFixed(2);



                        row.innerHTML = `
        <td class="text-center">${code}</td>
        <td class="text-end">${gw} gram</td>
        <td class="text-end">${nw} gram</td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-danger removeRowScan">&times;</button>
        </td>
      `;
                        itemScantableBody.prepend(row);
                        row.querySelectorAll("td").forEach(td => {
                            td.style.backgroundColor = "#ffff99";
                        });
                        setTimeout(() => {
                            row.querySelectorAll("td").forEach(td => {
                                td.style.backgroundColor = "";
                            });
                        }, 1500);
                        barcodeInput.value = "";
                    }
                }
            });

            function resetTableScan() {
                document.querySelector("#itemScantable tbody").innerHTML = "";
                barcodeInput.value = '';
                $('.select2Scan').val('');
                totalgw = 0;
                totalnw = 0;
                totalItem.innerText = 0;
                total_gw.innerText = "0.00 gram";
                total_nw.innerText = "0.00 gram";
                itemScanBcd = [];
            }

            document.getElementById('scanModal').addEventListener('hidden.bs.modal', function() {
                resetTableScan();
            });

            qrInput.addEventListener("keypress", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    try {
                        let data = JSON.parse(qrInput.value);
                        document.getElementById("sub_grosir").value = data.pt;
                        document.getElementById("alamat").value = data.at;
                        document.getElementById("customer").value = data.nt;
                        document.getElementById("linkid").value = data.it;
                        let modalEl = document.getElementById('scanQRModal');
                        let modal = bootstrap.Modal.getInstance(modalEl);
                        modal.hide();
                        $('#grosir').val(1246).trigger('change');
                        setGrosir = 1246;
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

                if (descInput.value == '') {
                    Swal.fire({
                        title: "Info",
                        text: "Kategori Kosong",
                        icon: "warning",
                        confirmButtonText: "OK"
                    });
                    return false;
                }
                if (itemsTable.rows.length >= 10) {
                    Swal.fire({
                        title: "Batas Tercapai",
                        text: "Maksimal hanya boleh 10 item.",
                        icon: "info",
                        confirmButtonText: "OK"
                    });
                    return false;
                }


                let subtotalgwall = antotalgwallInput.getNumber() || 0;
                let subtotalnwall = antotalnwallInput.getNumber() || 0;
                let gwBaru = parseFloat(totalgw) || 0;
                let nwBaru = parseFloat(totalnw.toFixed(2)) || 0;

                // totalgwallInput.value = (subtotalgwall + gwBaru).toFixed(2);
                // totalnwallInput.value = (subtotalnwall + nwBaru).toFixed(3);
                antotalgwallInput.set(subtotalgwall + nwBaru);
                antotalnwallInput.set(subtotalnwall + 0);

                let desc_item = descInput.value;
                let carat = caratInput.value;
                let itemScangw = 0;
                let itemScannw = 0;
                itemScanBcd.forEach(item => {
                    itemScangw += item.gw;
                    itemScannw += item.nw;
                });
                let newRow = document.createElement("tr");
                newRow.innerHTML = `
                <td class="text-center"></td>
                <td><select type="text" name="category[]" class="form-control form-control-sm select2" style="max-width:100%"  value="${desc_item}"> ${options_cat}</select></td>
               <td class="text-center align-middle"><span style="background-color:${carat_bgcolor};color:${carat_textcolor};padding:2px 6px;border-radius:4px" class="cadar_text">${carat}</span>
                <input type="text" name="cadar[]" class="form-control form-control-sm cadar_item text-center d-none"  value="${carat}" readonly>
            </td>
                <td>
                    <div class="input-group input-group-sm mb-2">
   <input type="text" name="wbruto[]" class="form-control form-control-sm wbruto text-end autonumDec2" value="${itemScannw.toFixed(2)}" >
   <button class="btn btn-primary kalibrasi-btn" type="button"><i class="fa-solid fa-scale-balanced"></i></button>
</div>
                    
                  </td>
                <td><input type="text" name="price[]" class="form-control text-end form-control-sm price autonumDec3" readonly ></td>
                <td><input type="text" name="wnet[]" class="form-control text-end form-control-sm wnet autonumDec3"  value="0" readonly ></td>
                <td class="isPriceCust ${isHargaCheck.checked ? '' : 'd-none'}"><input type="text" name="pricecust[]" class="autonumDec3 text-end form-control form-control-sm pricecust"  placeholder="0.00"  ></td>
                <td class="isPriceCust  ${isHargaCheck.checked ? '' : 'd-none'}"><input type="text" name="wnetocust[]" class="autonumDec3 text-end form-control form-control-sm wnetocust"  readonly></td>
                <td class="text-center isEdit">
                    <button type="button" class="btn btn-sm btn-danger removeRow">&times;</button>
                </td>

                            `;
                itemsTable.appendChild(newRow);

                let $select = $(newRow).find('.select2').select2({
                    // placeholder: "Pilih kategori",
                    // allowClear: true,
                    theme: 'bootstrap-5',
                    width: '100%'
                });


                newRow.querySelectorAll('.autonumDec2').forEach(el => {
                    new AutoNumeric(el, optionsDec2);
                });
                newRow.querySelectorAll('.autonumDec3').forEach(el => {
                    new AutoNumeric(el, optionsDec3);
                });

                newRow.scrollIntoView({
                    behavior: "smooth",
                    block: "nearest"
                });

                newRow.querySelectorAll("td").forEach(td => {
                    td.style.backgroundColor = "#ffff99";
                });
                setTimeout(() => {
                    newRow.querySelectorAll("td").forEach(td => {
                        td.style.backgroundColor = "";
                    });
                }, 1500);

                $select.val(desc_item).trigger("change");
                loadSelect2();



                itemScanBcd = [];
                reindexRows()
                resetTableScan()


                let modalEl = document.getElementById("scanModal");
                let modal = bootstrap.Modal.getInstance(modalEl);
                if (!modal) {
                    modal = new bootstrap.Modal(modalEl);
                }
                modal.hide();

            });






        });
    </script>
@endsection
