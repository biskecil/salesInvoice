        var printService = new WebSocketPrinter();

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

        function printDirectNota(data) {
            if (!printService.isConnected()) {
                console.error("Printer WebSocket tidak aktif");
                return;
            }
            try {
                fetch('/sales/cetakNota/' + data)
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
        $(document).ready(function() {
            let dataNota = '';
            $('#btnTambah').prop('disabled', false);
            $('#btnBatal').prop('disabled', true);
            $('#btnCetak').prop('disabled', true);
            $('#btnCetakBarcode').prop('disabled', true);
            $('#btnEdit').prop('disabled', true);
            $('.buttonForm').prop('disabled', true);

            $('#btnCetak').on('click', function() {
                // window.open('/sales/cetakNota/' + dataNota, '_blank');
                printDirectNota(dataNota);
            });
            $('#btnCetakBarcode').on('click', function() {
                // window.open('/sales/cetakBarcode/' + dataNota, '_blank');
                printDirectBarcode(dataNota)
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
                        hotkeys();
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
                    hotkeys();
                    DateNow();
                });
            });
            $('#btnBatal').on('click', function() {
                dataNota = '';
                $('#cariDataNota').val('')
                $('#formData').addClass('d-none');
                $('#btnCari').prop('disabled', false);
                $('#btnTambah').prop('disabled', false);
                $('#btnBatal').prop('disabled', true);
                $('#btnCetak').prop('disabled', true);
                $('#btnCetakBarcode').prop('disabled', true);
                $('#btnEdit').prop('disabled', true);
                $('.buttonForm').prop('disabled', true);
                location.reload();
            });
        });

        function DateNow() {
            let today = new Date();
            let yyyy = today.getFullYear();
            let mm = String(today.getMonth() + 1).padStart(2, '0');
            let dd = String(today.getDate()).padStart(2, '0');
            document.getElementById("transDate").value = `${yyyy}-${mm}-${dd}`;
        }

        function hotkeys() {
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
                    const totalgwallInput = document.getElementById("totalgwall");
                    const rows = itemsTable.querySelectorAll("tr");
                    if (rows.length > 1) { // misal biar header ga kehapus
                        const lastRow = rows[rows.length - 1];

                        // ambil nilai gwall (kolom ke-3)
                        const gwall = lastRow.cells[2].querySelector("input").value;
                        totalgwall -= gwall;
                        totalgwallInput.value = totalgwall;

                        // hapus baris
                        lastRow.remove();

                        // hitung ulang total
                        let total = 0;
                        document.querySelectorAll(".wbruto").forEach(el => {
                            total += parseFloat(el.value) || 0;
                        });

                        totalgwallInput.value = total.toFixed(2);
                    }
                }
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
                // placeholder: "Pilih kategori",
                // allowClear: true,
                theme: 'bootstrap-5',
                width: '100%'
            });
        }

        function js_form(typeForm = 'default', dataInv = '') {
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
            const transDateinput = document.getElementById("transDate");
            let today = new Date();
            let yyyy = today.getFullYear();
            let mm = String(today.getMonth() + 1).padStart(2, '0');
            let dd = String(today.getDate()).padStart(2, '0');
            let setGrosir = '';
            let totalgw = 0;
            let totalgwall = 0;
            let totalnw = 0;
            let carat = '';
            let desc_item = '';
            let default_cat = '{{ $desc[0]->Description }}';
            let itemScan = [];
            let itemScanBcd = [];
            let options_cat = `
@foreach ($desc as $d)
    <option value="{{ $d->Description }}">{{ $d->Description }}</option>
@endforeach
`;



            // transDateinput.value = `${yyyy}-${mm}-${dd}`;

            $('#grosir').on('change', function() {
                let id = this.value;
                if (id) {
                    setGrosir = id;
                    document.querySelectorAll("#itemsTable tbody tr").forEach(row => {
                        let categorySelect = row.querySelector("select[name='category[]']");
                        let priceInput = row.querySelector(".price");
                        let brutoInput = row.querySelector(".wbruto");
                        let netInput = row.querySelector(".wnet");
                        let netInputCust = row.querySelector('.wnetocust');
                        let priceCustInput = row.querySelector(".pricecust");

                        if (!categorySelect) return;

                        let selectedCat = categorySelect.value;


                        fetchPrice(setGrosir, selectedCat, carat, 0).then(hasil => {
                            if (priceInput) priceInput.value = hasil.price;
                            if (priceCustInput) priceCustInput.value = hasil.priceCust;

                            if (brutoInput && priceCustInput) {
                                let bruto = parseFloat(brutoInput.value) || 0;
                                let priceCust = parseFloat(priceCustInput.value) || 0;
                                let netCust = bruto * priceCust;
                                netInputCust.value = netCust.toFixed(3);
                            }

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
                    let netInputCust = row.querySelector('.wnetocust');


                    if (!categorySelect) return;

                    let selectedCat = categorySelect.value;


                    fetchPrice(setGrosir, selectedCat, carat, 0).then(hasil => {
                        if (priceInput) priceInput.value = hasil.price;
                        if (priceCustInput) priceCustInput.value = hasil.priceCust;

                        if (brutoInput && priceCustInput) {
                            let bruto = parseFloat(brutoInput.value) || 0;
                            let priceCust = parseFloat(priceCustInput.value) || 0;
                            let netCust = bruto * priceCust;
                            netInputCust.value = netCust.toFixed(3);
                        }

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
            <td><input type="text" name="cadar[]" class="form-control form-control-sm cadar_item text-center"  value="${item.caratSW}" readonly></td>
            <td>
                     <div class="input-group input-group-sm mb-2">
   <input type="number" name="wbruto[]" class="form-control form-control-sm wbruto text-end" min="0"   value="${item.gw}" step="0.01">
   <button class="btn btn-primary kalibrasi-btn" type="button"><i class="fa-solid fa-scale-balanced"></i></button>
</div>
                </td>
            <td><input type="number" name="price[]" class="form-control form-control-sm price text-end" min="0" readonly step="0.01"  value="${item.price}"></td>
            <td><input type="number" name="wnet[]" class="form-control form-control-sm wnet text-end" min="0"  value="${item.nw}" readonly step="0.01"></td>
            <td class="isPriceCust ${item.isHargaCheck ? '' : 'd-none'}"><input type="number" name="pricecust[]" class="form-control text-end form-control-sm pricecust" value="${item.priceCust}" min="0"  readonly step="0.01"></td>
            <td class="isPriceCust  ${item.isHargaCheck ? '' : 'd-none'}"><input type="number" name="wnetocust[]" class="form-control text-end form-control-sm wnetocust" value="${item.netCust}" min="0" step="0.01"></td>
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
                // if (setGrosir == '' || carat == '') {

                //     Swal.fire({
                //         title: "Info",
                //         text: "Silakan pilih Grosir dan Kadar terlebih dahulu.",
                //         icon: "warning",
                //         confirmButtonText: "OK"
                //     });

                //     return false;
                // }

                let newRow = document.createElement("tr");
                newRow.innerHTML = `
            <td><select type="text" name="category[]" class="form-control form-control-sm select2" style="max-width:100%"> ${options_cat}</select></td>
            <td><input type="text" name="cadar[]" class="form-control form-control-sm cadar_item text-center"  value="${carat}" readonly></td>
            <td>
              <div class="input-group input-group-sm mb-2">
  <input type="number" name="wbruto[]" class="form-control wbruto text-end" min="0" step="0.01" placeholder="0.00">
   <button class="btn btn-primary kalibrasi-btn" type="button"><i class="fa-solid fa-scale-balanced"></i></button>
</div>
                </td>
            <td><input type="number" name="price[]" class="form-control form-control-sm price text-end" min="0" readonly step="0.01"></td>
            <td><input type="number" name="wnet[]" class="form-control form-control-sm wnet text-end" min="0" readonly step="0.01"></td>
            <td class="isPriceCust ${isHargaCheck.checked ? '' : 'd-none'} "><input type="number" name="pricecust[]" class="text-end form-control form-control-sm pricecust" min="0"   step="0.01"></td>
            <td class="isPriceCust  ${isHargaCheck.checked ? '' : 'd-none'}"><input type="number" name="wnetocust[]" class="text-end form-control form-control-sm wnetocust" min="0" step="0.01" readonly></td>
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
                        let netInputCust = row.querySelector(".wnetocust");
                        let priceCustInput = row.querySelector(".pricecust");

                        if (priceInput) priceInput.value = hasil.price;
                        if (priceCustInput) priceCustInput.value = hasil.priceCust;

                        if (brutoInput && priceCustInput && netInputCust) {
                            let bruto = parseFloat(brutoInput.value) || 0;
                            let priceCust = parseFloat(priceCustInput.value) || 0;
                            let netCust = bruto * priceCust;
                            netInputCust.value = netCust.toFixed(3);
                        }

                        if (brutoInput && priceInput && netInput) {
                            let bruto = parseFloat(brutoInput.value) || 0;
                            let price = parseFloat(priceInput.value) || 0;
                            let net = bruto * price;

                            netInput.value = net.toFixed(3);
                        }
                    });
                });

                // $(newRow).find('.select2').select2({
                //     placeholder: "Pilih kategori",
                //     allowClear: true,
                //     width: '100%'
                // });
                loadSelect2();
                // let $select = $(newRow).find(".select2");
                // $select.select2('open');
            });



            $('#itemsTable tbody').on('click', 'button.kalibrasi-btn', async function() {
                let tr = $(this).closest('tr');
                let priceInput = tr.find('.price');
                let priceInputCust = tr.find('.pricecust');
                let price = parseFloat(priceInput.val()) || 0;
                let priceCust = parseFloat(priceInputCust.val()) || 0;
                let brutoInput = tr.find('.wbruto');
                let netInput = tr.find('.wnet');
                let netInputCust = tr.find('.wnetocust');
                let total = 0;

                try {
                    const hasilTimbang = await kliktimbang();
                    brutoInput.val(hasilTimbang);
                    let net = hasilTimbang * price;
                    let netCust = hasilTimbang * priceCust;
                    netInput.val(net.toFixed(3));
                    netInputCust.val(netCust.toFixed(3));

                    document.querySelectorAll(".wbruto").forEach(el => {
                        total += parseFloat(el.value) || 0;
                    });

                    totalgwallInput.value = total.toFixed(2);


                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: error,
                        confirmButtonText: 'OK'
                    });
                }


            });
            $('#itemsTable tbody').on('change', 'select[name="category[]"]', function() {

                let tr = $(this).closest('tr');
                let selectedCat = $(this).val();

                let cadarInput = tr.find('.cadar_item');
                let brutoInput = tr.find('.wbruto');
                let priceInput = tr.find('.price');
                let priceCustInput = tr.find(".pricecust");
                let netInput = tr.find('.wnet');
                let netInputCust = tr.find('.wnetocust');


                fetchPrice(setGrosir, selectedCat, cadarInput.val(), 0).then(hasil => {
                    if (priceInput.length) priceInput.val(hasil.price);
                    if (priceCustInput.length) priceCustInput.val(hasil.priceCust);

                    if (brutoInput.length && priceCustInput.length) {
                        let bruto = parseFloat(brutoInput.val()) || 0;
                        let priceCust = parseFloat(priceCustInput.val()) || 0;
                        let netCust = bruto * priceCust;
                        netInputCust.val(netCust.toFixed(3));
                    }
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
                let priceInputCust = tr.querySelector('.pricecust');
                let priceInput = tr.querySelector('.price');
                let brutoInput = tr.querySelector('.wbruto');
                let netInput = tr.querySelector('.wnet');
                let netInputCust = tr.querySelector('.wnetocust');
                let bruto = parseFloat(brutoInput.value) || 0;
                let price = parseFloat(priceInput.value) || 0;
                let priceCust = parseFloat(priceInputCust.value) || 0;
                let net = bruto * price;
                netInput.value = net.toFixed(3);
                let netCust = bruto * priceCust;
                netInputCust.value = netCust.toFixed(3);

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

                        itemScanBcd.push({
                            gw: gw,
                            nw: nw
                        });

                        const row = document.createElement("tr");
                        //Info
                        totalItem.innerText = parseInt(totalItem.innerText) + 1;
                        total_gw.innerText = totalgw.toFixed(2);
                        total_nw.innerText = totalnw.toFixed(3);


                        row.innerHTML = `
        <td class="text-center">${code}</td>
        <td class="text-end">${gw} gram</td>
        <td class="text-end">${nw} gram</td>
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
                let = desc_item = descInput.value;
                let carat = caratInput.value;
                itemScanBcd.forEach(item => {
                    let newRow = document.createElement("tr");
                    newRow.innerHTML = `
               <td><select type="text" name="category[]" class="form-control form-control-sm select2" style="max-width:100%"  value="${desc_item}"> ${options_cat}</select></td>
                <td><input type="text" name="cadar[]" class="form-control form-control-sm cadar_item text-center"  value="${carat}" readonly></td>
                <td>
                    <div class="input-group input-group-sm mb-2">
   <input type="number" name="wbruto[]" class="form-control form-control-sm wbruto text-end" min="0"   value="${item.gw}" step="0.01">
   <button class="btn btn-primary kalibrasi-btn" type="button"><i class="fa-solid fa-scale-balanced"></i></button>
</div>
                    
                  </td>
                <td><input type="number" name="price[]" class="form-control text-end form-control-sm price" min="0" readonly step="0.01"></td>
                <td><input type="number" name="wnet[]" class="form-control text-end form-control-sm wnet" min="0"  value="${item.nw}" readonly step="0.01"></td>
                <td class="isPriceCust ${isHargaCheck.checked ? '' : 'd-none'}"><input type="number" name="pricecust[]" class="text-end form-control form-control-sm pricecust" min="0"  readonly step="0.01"></td>
                <td class="isPriceCust  ${isHargaCheck.checked ? '' : 'd-none'}"><input type="number" name="wnetocust[]" class="text-end form-control form-control-sm wnetocust" min="0" step="0.01"></td>
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

                    $select.val(desc_item).trigger("change");
                    loadSelect2();
                });
                itemScanBcd = [];
                resetTableScan()
            });



        };