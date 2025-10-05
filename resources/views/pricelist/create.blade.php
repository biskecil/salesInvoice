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

        .summary-weight {
            font-weight: bold;
            color: #d9534f;
            font-size: 16px;
        }

        .myGrid .dx-datagrid-rowsview .dx-row>td {
            font-size: 16px;
            /* perbesar font */
            font-weight: normal;
        }

        /* Header column */
        .myGrid .dx-datagrid-headers .dx-header-row>td {
            font-size: 12px;
            font-weight: bold;
            color: #000000;
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(204, 204, 204, 0.5);
            /* abu-abu transparan */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10;
        }
    </style>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 text-center fw-bold ">Form Harga - Edit</h5>
                </div>
                <div class="card-body">
                    <div class="card card-main shadow-sm " id="formCard">
                        @include('pricelist.action')
                        <div class="card-body pt-0">
                            <!-- FORM UTAMA -->
                            <form action="/pricelist/store" method="post" id="salesForm" class="mt-4">
                                @csrf
                                <div class="row justify-content-center">
                                    <!-- LEFT -->
                                    <div class="col-md-6"> <!-- sesuaikan lebar -->
                                        <div class="mb-2 row align-items-center">
                                            <label class="form-label col-sm-4 text-end">Grosir</label>
                                            <div class="col-sm-8">
                                                <select class="form-control select2" name="grosir" id="grosir">
                                                    <option value="">Pilih Data</option>
                                                    @foreach ($cust as $d)
                                                        <option value="{{ $d->ID }}">{{ $d->SW }}
                                                            ({{ $d->Description }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="card mt-1 shadow-sm mx-4 ">
                                    <div class="loading-overlay d-none ">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;overflow-x: auto; ">
                                            <table class="table table-bordered mb-0 itemsTable" id="itemsTable"
                                                style="font-size: 11px;">
                                                <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                                                    <tr>
                                                        <th style="font-size:14px" rowspan="2" class="text-center">
                                                            Kode/Nama</th>
                                                        @foreach ($kadar as $k)
                                                            <th style="font-size:14px" class="text-center" colspan="2">

                                                                <span
                                                                    style="background-color:{{ $k->color }};color:{{ $k->textColor }};padding:2px 6px;border-radius:4px"
                                                                    class="cadar_text">{{ $k->SW }}</span>
                                                            </th>
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        @foreach ($kadar as $k)
                                                            <th style="font-size:14px" class="text-center">Harga</th>
                                                            <th style="font-size:14px" class="text-center">Harga Cust</th>
                                                        @endforeach
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($desc as $d)
                                                        <tr>
                                                            <td
                                                                @if ($d->SW == 'PRT' || $d->SW == 'PRV') style="font-size:14px;background-color: #cce5ff;"@else  style="font-size:14px;" @endif>
                                                                <b>{{ $d->SW }}</b>-{{ $d->Description }}
                                                            </td>
                                                            @foreach ($kadar as $k)
                                                                <td
                                                                    @if ($d->SW == 'PRT' || $d->SW == 'PRV') style="background-color: #cce5ff;" @endif>
                                                                    <input type="text" class="form-control autonumDec3"
                                                                        style="padding: 2px 4px; height: 26px;"
                                                                        id="input_{{ $d->SW }}_{{ $k->SW }}"
                                                                        name="input_{{ $d->ID }}_{{ $k->ID }}">
                                                                </td>
                                                                <td
                                                                    @if ($d->SW == 'PRT' || $d->SW == 'PRV') style="background-color: #cce5ff;" @endif>
                                                                    <input type="text" class="form-control autonumDec3"
                                                                        style="padding: 2px 4px; height: 26px;"
                                                                        id="inputCust_{{ $d->SW }}_{{ $k->SW }}"
                                                                        name="inputCust_{{ $d->ID }}_{{ $k->ID }}">
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>




                <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
                <script src="{{ asset('select2/select2.min.js') }}"></script>
                <script>
                    $(document).ready(function() {
                        const optionsDec3 = {
                            digitGroupSeparator: ',',
                            decimalCharacter: '.',
                            decimalPlaces: 2,
                            minimumValue: "0",
                            roundingMethod: 'D',
                            modifyValueOnUpDownArrow: false,
                            modifyValueOnWheel: false,
                            emptyInputBehavior: "zero"
                        };
                        AutoNumeric.multiple('.autonumDec3', optionsDec3);
                        loadSelect2();

                        async function fetchPrice(grosirId) {
                            try {
                                let res = await fetch(
                                    `/pricelist/getDataAll?grosir=${grosirId}`
                                );
                                let data = await res.json();

                                return data ?? 0;
                            } catch (err) {
                                console.error("Fetch gagal");
                                return 0;
                            }
                        }

                        $('#grosir').on('change', async function() {
                            let id = this.value;
                            if (id) {
                                let btn = document.getElementById("btnSubmitCreate");
                                let oldText = btn.innerHTML;
                                btn.disabled = true;
                                btn.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Loading...`;
                                $('.loading-overlay').removeClass('d-none');
                                try {
                                    $('.autonumDec3').each(function() {
                                        const an = AutoNumeric.getAutoNumericElement(this);
                                        if (an) an.set('');
                                    });

                                    const hasil = await fetchPrice(id);
                                    console.log(hasil);

                                    Object.keys(hasil).forEach(key => {
                                        if (key.endsWith('_Cust')) {
                                            const baseKey = key.replace('_Cust', '');
                                            el = $('#inputCust_' + baseKey);
                                        } else {
                                            el = $('#input_' + key);
                                        }

                                        if (!el.length) return;

                                        const anInput = AutoNumeric.getAutoNumericElement(el[0]);
                                        const value = hasil[key];

                                        if (anInput) {
                                            anInput.set(value ?? '');
                                        } else {
                                            el.val(value ?? '');
                                        }
                                    });
                                } catch (error) {
                                    console.error('Gagal update harga:', error);
                                } finally {
                                    $('.loading-overlay').addClass('d-none');
                                    btn.disabled = false;
                                    btn.innerHTML = oldText;
                                }
                            }
                        });

                        // $(document).on('input', 'table input.autonumDec3', function() {
                        //     const anElement = AutoNumeric.getAutoNumericElement(this);
                        //     const val = anElement.getNumber();
                        //     const colIndex = $(this).closest('td').index();

                        //     $('#itemsTable tbody tr').each(function() {
                        //         const input = $(this).find('td').eq(colIndex).find('input.autonumDec3');
                        //         const anInput = AutoNumeric.getAutoNumericElement(input[0]);
                        //         anInput.set(val);
                        //     });
                        // });
                        $(document).on('change blur', 'table input.autonumDec3', function() {
                            const anElement = AutoNumeric.getAutoNumericElement(this);
                            const val = anElement.getNumber();
                            const $td = $(this).closest('td');
                            const $tr = $(this).closest('tr');
                            const colIndex = $td.index();
                            const rowIndex = $tr.index();

                            // hanya kalau input di baris pertama
                            if (rowIndex === 0) {
                                $('#itemsTable tbody tr').each(function() {
                                    const input = $(this).find('td').eq(colIndex).find(
                                        'input.autonumDec3');
                                    const anInput = AutoNumeric.getAutoNumericElement(input[
                                        0]);
                                    let id = input.attr('id') || '';
                                    const match = id.match(/^(?:input|inputCust)_(\w+)_/);

                                    if (match) {
                                        const sw = match[1];

                                        // SW tertentu ditambah 0.5
                                        const swPlus = ['PRT', 'PRV'];
                                        const swMin = ['PKR'];
                                        let targetVal = val;
                                        if (swPlus.includes(sw)) {
                                            targetVal += 0.5;
                                        }

                                        anInput.set(
                                            targetVal); // set nilai dengan AutoNumeric
                                    }
                                });
                            }
                        });

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
                                        let btn = document.getElementById("btnSubmitCreate");
                                        let oldText = btn.innerHTML;
                                        btn.disabled = true;
                                        btn.innerHTML =
                                            `<span class="spinner-border spinner-border-sm"></span> Loading...`;
                                        window.location.reload();
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
                        });
                    }
                </script>
            @endsection
