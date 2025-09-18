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
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-1 pb-2">
                    <div class="d-flex gap-2 justify-content-between">
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-primary" id="conscale" onclick="connectSerial(false)">
                                <i class="fa-solid fa-scale-balanced"></i> : Hubungkan</button>
                        </div>

                    </div>
                </div>
                <div class="card-body pt-10">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-2 row">
                                <label class="form-label col-sm-4 ">Nota</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" name="nota" id="nota">
                                        <option value="">Pilih Data</option>
                                        @foreach ($data as $list)
                                            <option value="{{ $list->ID }}">{{ $list->invoice_number }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2 row">
                                <label class="form-label col-sm-4 ">Grosir</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="grosir" readonly value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2 row">
                                <label class="form-label col-sm-4 ">Kadar</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="kadar" readonly value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2 row">
                                <label class="form-label col-sm-4 ">Customer</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="customer" readonly value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2 row">
                                <label class="form-label col-sm-4 ">Alamat</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="alamat" readonly value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4 row">
                                <label class="form-label col-sm-4 ">Berat</label>

                                <div class="col-sm-8">
                                    <div class="input-group input-group-sm mb-2">
                                        <input type="text" name="wbruto" id="wbruto"
                                            class="autonumDec2 form-control wbruto text-end" placeholder="0.00">
                                        <button class="btn btn-primary" type="button"><i class="fa-solid fa-scale-balanced"
                                                id="kalibrasi-btn"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-4 d-flex items-center ">
                            <button class="btn btn-warning preview-btn flex-fill me-1" type="button" id="btnPreview"
                                disabled><i class="fa-regular fa-eye"></i> Preview</button>
                            <button class="btn btn-info cetak-btn flex-fill ms-1" type="button" id="btnCetak"
                                disabled><i
                                class="fa-solid fa-print"></i> Label</button>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>




    <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('select2/select2.min.js') }}"></script>
    <script src="{!! asset('timbangan/timbangan.js') !!}"></script>
    <script src="{{ asset('websocket/websocket-printer.js') }}"></script>
    <script>
        window.addEventListener("load", () => {
            connectSerial(true);
        });
        var printService = new WebSocketPrinter();

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
        const optionsDec2 = {
            digitGroupSeparator: ',',
            decimalCharacter: '.',
            decimalPlaces: 2,
            minimumValue: "0",
            roundingMethod: 'D',

            emptyInputBehavior: "zero"
        };

        $(document).ready(function() {
            let dataNota = '';
            const wbrutoInput = new AutoNumeric('#wbruto', optionsDec2);
            loadSelect2();
        });

        async function fetchNota(id) {
            if (!id) return 0;
            try {
                let res = await fetch(
                    `/pack/getData/Nota?id=${id}`
                );
                let data = await res.json();

                return data ?? 0;
            } catch (err) {
                console.error("Fetch gagal");
                return 0;
            }
        }

        $('#kalibrasi-btn').on('click', async function() {
            let anBruto = AutoNumeric.getAutoNumericElement(wbrutoInput);
            try {
                const hasilTimbang = await kliktimbang();
                anBruto.set(hasilTimbang);
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Periksa koneksi timbangan',
                    confirmButtonText: 'OK'
                });
            }


        });


        $('#nota').on('change', function() {
            dataNota = this.value;

            let anBruto = AutoNumeric.getAutoNumericElement(document.getElementById("wbruto"));

            fetchNota(dataNota).then(hasil => {
                $('#grosir').val(hasil.data.Grosir);
                $('#customer').val(hasil.data.Customer);
                $('#alamat').val(hasil.data.Address);
                $('#kadar').val(hasil.data.carat);
                anBruto.set(hasil.data.wbruto);

                $('#btnPreview').prop('disabled', false);
                $('#btnCetak').prop('disabled', false);
            })


        });

        $('#btnCetak').on('click', function() {
            //window.open('/sales/cetakNota/semua/' + noNota, '_blank');
            let anBruto = AutoNumeric.getAutoNumericElement(document.getElementById("wbruto"));
            printDirectPack(dataNota, anBruto.getNumber());
        });
        $('#btnPreview').on('click', function() {
            let anBruto = AutoNumeric.getAutoNumericElement(document.getElementById("wbruto"));
            window.open('/pack/prevNota/?id=' + dataNota + '&wbruto=' + anBruto.getNumber(), '_blank');
        });

        function printDirectPack(id, bruto) {
            if (!printService.isConnected()) {
                console.error("Printer WebSocket tidak aktif");
                return;
            }
            try {
                fetch('/pack/cetakNota/?id=' + dataNota + '&wbruto=' + bruto)
                    .then(res => res.json())
                    .then(res => {
                        printService.submit({
                            type: 'Pack',
                            url: res.url
                        });
                    });
                console.log("Berhasil");
            } catch (err) {
                console.error("Gagal Cetak :", err);
            }
        }
    </script>
@endsection
