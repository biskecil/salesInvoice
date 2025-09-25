function DateNow() {
    let today = new Date();
    let yyyy = today.getFullYear();
    let mm = String(today.getMonth() + 1).padStart(2, "0");
    let dd = String(today.getDate()).padStart(2, "0");
    document.getElementById("transDate").value = `${yyyy}-${mm}-${dd}`;
}

const optionsDec2 = {
    digitGroupSeparator: ",",
    decimalCharacter: ".",
    decimalPlaces: 2,
    minimumValue: "0",
    roundingMethod: "D",

    emptyInputBehavior: "zero",
};
const optionsDec3 = {
    digitGroupSeparator: ",",
    decimalCharacter: ".",
    decimalPlaces: 3,
    minimumValue: "0",
    roundingMethod: "D",

    emptyInputBehavior: "zero",
};

function hotkeys() {
    document.addEventListener("keydown", function (e) {
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
            const itemsTable = document
                .getElementById("itemsTable")
                .getElementsByTagName("tbody")[0];
            const totalgwallInput = document.getElementById("totalgwall");
            const rows = itemsTable.querySelectorAll("tr");
            if (rows.length > 1) {
                const lastRow = rows[rows.length - 1];
                lastRow.remove();
                updateTotalRow();
            }
        }
    });
}

function loadSelect2Scan() {
    $(".select2Scan").val("").trigger("change");
    $(document).on(
        "mousedown",
        ".select2-selection.select2-selection--single",
        function (e) {
            let $select = $(this)
                .closest(".select2-container")
                .siblings("select:enabled");
            if (!$select.data("select2").isOpen()) {
                $select.select2("open");
            }
            e.preventDefault();
        }
    );

    $(document).on("select2:open", () => {
        setTimeout(() => {
            document
                .querySelector(
                    ".select2-container--open .select2-search__field"
                )
                .focus();
        }, 0);
    });

    $(".select2Scan").select2({
        theme: "bootstrap-5",
        dropdownParent: $("#scanModal"),
        width: "100%",
    });
}

function loadSelect2() {
    $(document).on(
        "focus",
        ".select2-selection.select2-selection--single",
        function () {
            let $select = $(this)
                .closest(".select2-container")
                .siblings("select:enabled");
            $select.select2("open");
        }
    );

    $("select.select2").on("select2:open", function () {
        setTimeout(() => {
            document.querySelector(".select2-search__field").focus();
        }, 50);
    });

    $(".select2").select2({
        theme: "bootstrap-5",
        width: "100%",
        templateResult: function (data) {
            if (!data.id) return data.text;

            var color = $(data.element).data("color");
            var $result = $("<span></span>").text(data.text);

            if (color) {
                var textColor = getContrastYIQ(color);
                $result.css({
                    "background-color": color,
                    color: textColor,
                    padding: "2px 6px",
                    "border-radius": "4px",
                });
            }
            return $result;
        },
        templateSelection: function (data) {
            if (!data.id) return data.text;

            var color = $(data.element).data("color");
            var $result = $("<span></span>").text(data.text);

            if (color) {
                var textColor = getContrastYIQ(color);
                $result.css({
                    "background-color": color,
                    color: textColor,
                    padding: "2px 6px",
                    "border-radius": "4px",
                });
            }
            return $result;
        },
    });
}

function getContrastYIQ(hexcolor) {
    hexcolor = hexcolor.replace("#", "");
    var r = parseInt(hexcolor.substr(0, 2), 16);
    var g = parseInt(hexcolor.substr(2, 2), 16);
    var b = parseInt(hexcolor.substr(4, 2), 16);
    var yiq = (r * 299 + g * 587 + b * 114) / 1000;
    return yiq >= 128 ? "#000" : "#fff";
}

$(document).ready(function () {
    loadSelect2();
    document
        .getElementById("scanQRModal")
        .addEventListener("shown.bs.modal", function () {
            document.getElementById("qrcode").focus();
        });
    scanQRModal.addEventListener("hidden.bs.modal", function () {
        document.getElementById("qrcode").value = "";
    });

    $("#sub_grosir").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "/sales/getData/subGros/",
                data: {
                    search: request.term,
                },
                dataType: "json",
                success: function (data) {
                    response(data.map((item) => item.SubGrosir)); // pakai field sesuai API
                },
            });
        },
        minLength: 2,
    });

    $("#btnSubmitCreate").on("click", function (e) {
        e.preventDefault(); // prevent normal form submit

        $.ajax({
            url: $("#salesForm").attr("action"),
            type: "POST",
            data: $("#salesForm").serialize(),
            success: function (response) {
                Swal.fire({
                    title: "Berhasil",
                    text: "Data telah berhasil disimpan.",
                    icon: "success",
                    confirmButtonText: "OK",
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "/sales/detail/" + response.data;
                    }
                });
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    Swal.fire({
                        title: "Gagal",
                        text: "Silakan periksa kembali form yang Anda isi.",
                        icon: "error",
                        confirmButtonText: "OK",
                    });
                } else {
                    Swal.fire({
                        title: "Gagal",
                        text: "Server Error",
                        icon: "error",
                        confirmButtonText: "OK",
                    });
                }
            },
        });
    });

    AutoNumeric.multiple(".autonumDec2", optionsDec2);
    AutoNumeric.multiple(".autonumDec3", optionsDec3);
    const addRowBtn = document.getElementById("addRow");
    const itemsTable = document
        .getElementById("itemsTable")
        .getElementsByTagName("tbody")[0];

    const barcodeInput = document.getElementById("barcodeInput");
    const caratInput = document.getElementById("carat");
    const qrInput = document.getElementById("qrcode");
    const isHargaCheck = document.getElementById("is_harga_cust");
    const antotalgwallInput = new AutoNumeric("#totalgwall", optionsDec2);
    const antotalnwallInput = new AutoNumeric("#totalnwall", optionsDec3);
    const descInput = document.getElementById("descItem");
    const itemScantableBody = document.querySelector("#itemScantable tbody");
    const totalItem = document.getElementById("total_item");
    const total_gw = document.getElementById("total_gw");
    const total_nw = document.getElementById("total_nw");
    let setGrosir = window.setGrosir ?? "";
    let itemScan = window.itemScan ?? [];
    let totalgw = 0;
    let totalnw = 0;
    let carat = window.carat ?? "";
    let carat_textcolor = window.carat_textcolor ?? "";
    let carat_bgcolor = window.carat_bgcolor ?? "";
    let itemScanBcd = [];
    let scanIndex = 0;
    let options_cat = `<option value="">Pilih Data</option>`;
    window.descData.forEach((d) => {
        options_cat += `<option value="${d}">${d}</option>`;
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
            console.error("Fetch gagal");
            return 0;
        }
    }

    if (itemScan.length > 0) {
        addRowItemsTable(itemScan, options_cat);
    }

    function addRowItemsTable(items, options_cat) {
        if (items[0].isHargaCheck) {
            document.querySelectorAll(".isPriceCust").forEach((el) => {
                el.classList.remove("d-none");
            });
        }

        items.forEach((item) => {
            let newRow = document.createElement("tr");
            newRow.innerHTML = `
<td><select type="text" name="category[]" class="form-control form-control-sm select2" style="max-width:100%" value="${
                item.desc_item || ""
            }"> ${options_cat}</select></td>
<td class="text-center align-middle"><span style="background-color:${
                item.color
            };color:${
                item.textColor
            };padding:2px 6px;border-radius:4px" class="cadar_text">${carat}</span>
<input type="text" name="cadar[]" class="form-control form-control-sm cadar_item text-center d-none"  value="${
                item.caratSW
            }" readonly>
</td>
<td>
<div class="input-group input-group-sm mb-2">
<input type="text" name="wbruto[]" class="autonumDec2 form-control form-control-sm wbruto text-end"   value="${
                item.gw
            }" >
<button class="btn btn-primary kalibrasi-btn" type="button"><i class="fa-solid fa-scale-balanced"></i></button>
</div>
</td>
<td><input type="text" name="price[]" class="autonumDec3 form-control form-control-sm price text-end" readonly   value="${
                item.price
            }"></td>
<td><input type="text" name="wnet[]" class="autonumDec3 form-control form-control-sm wnet text-end"  value="${
                item.nw
            }" readonly ></td>
<td class="isPriceCust ${
                item.isHargaCheck ? "" : "d-none"
            }"><input type="text" name="pricecust[]" class="autonumDec2 form-control text-end form-control-sm pricecust" value="${
                item.priceCust
            }"   ></td>
<td class="isPriceCust  ${
                item.isHargaCheck ? "" : "d-none"
            }"><input type="text" name="wnetocust[]" class="autonumDec3 form-control text-end form-control-sm wnetocust" value="${
                item.netCust
            }"  readonly></td>
<td class="text-center isEdit">
<button type="button" class="btn btn-sm btn-danger removeRow">&times;</button>
</td>

`;
            itemsTable.appendChild(newRow);

            newRow.querySelectorAll(".autonumDec2").forEach((el) => {
                new AutoNumeric(el, optionsDec2);
            });
            newRow.querySelectorAll(".autonumDec3").forEach((el) => {
                new AutoNumeric(el, optionsDec3);
            });
            let $select = $(newRow).find(".select2").select2({
                theme: "bootstrap-5",
                width: "100%",
            });

            newRow.scrollIntoView({
                behavior: "smooth",
                block: "nearest",
            });

            newRow.querySelectorAll("td").forEach((td) => {
                td.style.backgroundColor = "#ffff99";
            });
            setTimeout(() => {
                newRow.querySelectorAll("td").forEach((td) => {
                    td.style.backgroundColor = "";
                });
            }, 1500);
            $select.val(item.desc_item).trigger("change");
        });
    }

    function updateTotalRow() {
        let totalnwall = 0;
        let totalgwall = 0;

        document.querySelectorAll(".wnet").forEach((el) => {
            const an = AutoNumeric.getAutoNumericElement(el);
            totalnwall += an.getNumber() || 0;
        });
        document.querySelectorAll(".wbruto").forEach((el) => {
            const an = AutoNumeric.getAutoNumericElement(el);
            totalgwall += an.getNumber() || 0;
        });

        antotalgwallInput.set(totalgwall);
        antotalnwallInput.set(totalnwall);
        console.log("total_gwall:" + totalgwall);
        console.log("total_nwall:" + totalnwall);
    }

    function updateRowPrices(
        setGrosir = "",
        selectedCat = "",
        carat = "",
        wbruto = null,
        row = "",
        ambil_harga = ""
    ) {
        let categorySelect = row.querySelector("select[name='category[]']");
        let priceInput = row.querySelector(".price");
        let priceCustInput = row.querySelector(".pricecust");
        let brutoInput = row.querySelector(".wbruto");
        let netInput = row.querySelector(".wnet");
        let netInputCust = row.querySelector(".wnetocust");

        let anBruto = AutoNumeric.getAutoNumericElement(brutoInput);
        let anPrice = AutoNumeric.getAutoNumericElement(priceInput);
        let anNet = AutoNumeric.getAutoNumericElement(netInput);
        let anPriceCust = AutoNumeric.getAutoNumericElement(priceCustInput);
        let anNetCust = AutoNumeric.getAutoNumericElement(netInputCust);

        if (selectedCat == "") {
            selectedCat = categorySelect.value;
        }

        console.log("grosir:" + setGrosir);
        console.log("category:" + selectedCat);
        console.log("carat:" + carat);
        console.log("bruto:" + wbruto);

        if (ambil_harga != "") {
            fetchPrice(setGrosir, selectedCat, carat, 0).then((hasil) => {
               
                if (priceInput) anPrice.set(hasil.price);

              
                if (priceCustInput) {
                    let newVal = hasil.priceCust || 0;
                    if (newVal !== 0) {
                        anPriceCust.set(newVal);
                    }
                }

              
                if (brutoInput && priceCustInput && netInputCust) {
                    let bruto = anBruto.getNumber() || 0;
                    let priceCust = anPriceCust.getNumber() || 0;
                    let netCust = bruto * priceCust;
                    anNetCust.set(netCust);
                }

             
                if (brutoInput && priceInput && netInput) {
                    let bruto = anBruto.getNumber() || 0;
                    let price = anPrice.getNumber() || 0;
                    let net = bruto * price;
                    anNet.set(net);
                }
                updateTotalRow();
            });
        } else {
            let bruto = anBruto.getNumber() || 0;
            let price = anPrice.getNumber() || 0;
            let net = bruto * price;
            anNet.set(net);
            updateTotalRow();
        }
    }

    $("#grosir").on("change", function () {
        let id = this.value;
        if (id) {
            setGrosir = id;
            document.querySelectorAll("#itemsTable tbody tr").forEach((row) => {
                updateRowPrices(setGrosir, "", carat, 0, row, "ambil_harga");
            });
        } else {
            document.getElementById("customer").value = "";
            setGrosir = "";
        }
    });

    $("#carat").on("change", function () {
        carat = this.value;
        carat_bgcolor = $(this).find(":selected").data("color");
        carat_textcolor = getContrastYIQ(carat_bgcolor);
        document.querySelectorAll(".cadar_item").forEach((el) => {
            el.value = carat;
            el.textContent = carat;
        });
        document.querySelectorAll(".cadar_text").forEach((el) => {
            el.style.backgroundColor = carat_bgcolor;
            el.style.color = carat_textcolor;
            el.textContent = carat;
        });

        document.querySelectorAll("#itemsTable tbody tr").forEach((row) => {
            updateRowPrices(setGrosir, "", carat, 0, row, "ambil_harga");
        });
    });

    isHargaCheck.addEventListener("change", function () {
        if (this.checked) {
            document.querySelectorAll(".isPriceCust").forEach((el) => {
                el.classList.remove("d-none");
            });
        } else {
            document.querySelectorAll(".isPriceCust").forEach((el) => {
                el.classList.add("d-none");
            });
        }
    });

    document.getElementById("btnScan").addEventListener("click", function () {
        if (setGrosir == "" || carat == "") {
            Swal.fire({
                title: "Info",
                text: "Silakan pilih Grosir dan Kadar terlebih dahulu.",
                icon: "warning",
                confirmButtonText: "OK",
            });
            return;
        }

        let myModal = new bootstrap.Modal(document.getElementById("scanModal"));
        myModal.show();

        document.getElementById("scanModal").addEventListener(
            "shown.bs.modal",
            function () {
                document.getElementById("barcodeInput").focus();
            },
            {
                once: true,
            }
        );

        //  loadSelect2Scan();
    });

    addRowBtn.addEventListener("click", function () {
        if (setGrosir == "" || carat == "") {
            Swal.fire({
                title: "Info",
                text: "Silakan pilih Grosir dan Kadar terlebih dahulu.",
                icon: "warning",
                confirmButtonText: "OK",
            });

            return false;
        }

        let item = [
            {
                color: carat_bgcolor,
                textColor: carat_textcolor,
                caratSW: carat,
                isHargaCheck: isHargaCheck.checked ? true : false,
            },
        ];
        addRowItemsTable(item, options_cat);
    });

    $("#itemsTable tbody").on(
        "click",
        "button.kalibrasi-btn",
        async function () {
            let tr = $(this).closest("tr")[0];

            try {
                const hasilTimbang = await kliktimbang();
                anBruto.set(hasilTimbang);

                updateRowPrices(setGrosir, "", carat, hasilTimbang, tr, "");

                // let price = anPrice.getNumber() || 0;
                // let priceCust = anPriceCust.getNumber() || 0;

                // let net = hasilTimbang * price;
                // let netCust = hasilTimbang * priceCust;

                // anNetCust.set(netCust);
                // anNet.set(net);

                // document.querySelectorAll(".wbruto").forEach(el => {
                //     const an = AutoNumeric.getAutoNumericElement(el);
                //     total += an.getNumber() || 0;
                // });
                // document.querySelectorAll(".wnet").forEach(el => {
                //     const an = AutoNumeric.getAutoNumericElement(el);
                //     totalnw += an.getNumber() || 0;
                // });

                // antotalgwallInput.set(total);
                // antotalnwallInput.set(totalnw);
            } catch (error) {
                Swal.fire({
                    icon: "error",
                    title: "Gagal",
                    text: "Periksa koneksi timbangan",
                    confirmButtonText: "OK",
                });
            }
        }
    );
    $("#itemsTable tbody").on(
        "change",
        'select[name="category[]"]',
        function () {
            let tr = $(this).closest("tr")[0];
            let selectedCat = $(this).val();
            updateRowPrices(
                setGrosir,
                selectedCat,
                carat,
                0,
                tr,
                "ambil_harga"
            );
        }
    );

    itemsTable.addEventListener("change", function (e) {
        let tr = e.target.closest("tr");
        updateRowPrices(setGrosir, "", carat, 0, tr, "");
    });
    itemsTable.addEventListener("click", function (e) {
        if (e.target.classList.contains("removeRow")) {
            const row = e.target.closest("tr");

            e.target.closest("tr").remove();
            updateTotalRow();
        }
    });
    itemScantable.addEventListener("click", function (e) {
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

            const index = itemScanBcd.findIndex((item) => item.id === id);
            if (index !== -1) {
                itemScanBcd.splice(index, 1);
            }

            // hapus row
            row.remove();
        }
    });

    // ketika user tekan Enter
    barcodeInput.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            const code = barcodeInput.value.trim();
            if (code !== "") {
                barcodeInput.value = "";

                const parts = code.split("-");
                const itemCode = parts[0];
                const gw = parts.length > 2 ? parseFloat(parts[1]) : 0.0;
                const nw = parts.length > 2 ? parseFloat(parts[2]) : 0.0;
                totalgw += gw;
                totalnw += nw;
                const id = ++scanIndex;
                itemScanBcd.push({
                    id: id,
                    gw: gw,
                    nw: nw,
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
                row.querySelectorAll("td").forEach((td) => {
                    td.style.backgroundColor = "#ffff99";
                });
                setTimeout(() => {
                    row.querySelectorAll("td").forEach((td) => {
                        td.style.backgroundColor = "";
                    });
                }, 1500);
                barcodeInput.value = "";
            }
        }
    });

    function resetTableScan() {
        document.querySelector("#itemScantable tbody").innerHTML = "";
        barcodeInput.value = "";
        $(".select2Scan").val("");
        totalgw = 0;
        totalnw = 0;
        totalItem.innerText = 0;
        total_gw.innerText = "0.00 gram";
        total_nw.innerText = "0.00 gram";
    }

    document
        .getElementById("scanModal")
        .addEventListener("hidden.bs.modal", function () {
            resetTableScan();
        });

    qrInput.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            try {
                let data = JSON.parse(qrInput.value);
                document.getElementById("sub_grosir").value = data.nt;
                document.getElementById("alamat").value = data.at;
                document.getElementById("customer").value = data.pt;

                let modalEl = document.getElementById("scanQRModal");
                let modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();
                $("#grosir").val(1246).trigger("change");
                setGrosir = 1246;
            } catch (e) {
                Swal.fire({
                    title: "Info",
                    text: "Format QR Salah",
                    icon: "warning",
                    confirmButtonText: "OK",
                });
                qrInput.value = "";
            }
        }

        // let modal = new bootstrap.Modal(document.getElementById('scanQRModal'));
        // modal.hide();
    });
    document
        .getElementById("btnTambahkan")
        .addEventListener("click", function () {
            if (totalItem.innerText <= 0) {
                Swal.fire({
                    title: "Info",
                    text: "Data Scan Kosong",
                    icon: "warning",
                    confirmButtonText: "OK",
                });
                return false;
            }

            if (descInput.value == "") {
                Swal.fire({
                    title: "Info",
                    text: "Kategori Kosong",
                    icon: "warning",
                    confirmButtonText: "OK",
                });
                return false;
            }

            let subtotalgwall = antotalgwallInput.getNumber() || 0;
            let subtotalnwall = antotalnwallInput.getNumber() || 0;
            let gwBaru = parseFloat(totalgw) || 0;
            let nwBaru = parseFloat(totalnw.toFixed(2)) || 0;

            antotalgwallInput.set(subtotalgwall + nwBaru);
            antotalnwallInput.set(subtotalnwall + 0);

            let desc_item = descInput.value;
            let carat = caratInput.value;
            let itemScangw = 0;
            let itemScannw = 0;
            itemScanBcd.forEach((item) => {
                itemScangw += item.gw;
                itemScannw += item.nw;
            });

            let item = [
                {
                    color: carat_bgcolor,
                    textColor: carat_textcolor,
                    caratSW: carat,
                    isHargaCheck: isHargaCheck.checked ? true : false,
                    desc_item: desc_item,
                    gw: itemScannw.toFixed(2),
                },
            ];
            addRowItemsTable(item, options_cat);

            itemScanBcd = [];
            resetTableScan();

            let modalEl = document.getElementById("scanModal");
            let modal = bootstrap.Modal.getInstance(modalEl);
            if (!modal) {
                modal = new bootstrap.Modal(modalEl);
            }
            modal.hide();
        });
});
