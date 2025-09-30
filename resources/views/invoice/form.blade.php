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
        <div class="col-md-12">
            <div class="card shadow-sm">
                @include('layouts.navbar')
                <div class="card-body pt-0">

                </div>
            </div>
        </div>
    </div>




    <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('select2/select2.min.js') }}"></script>
    <script src="{!! asset('timbangan/timbangan.js') !!}"></script>
    <script src="{!! asset('autocomplete/autocomplete.js') !!}"></script>
    <script>
        const dataNota = @json($data->pluck('invoice_number'));
        createAutocomplete('cariDataNota', 'notaSuggestions', dataNota);
    </script>
    <script>
        window.addEventListener("load", () => {
            connectSerial(true);
        });

        $(document).ready(function() {
            let dataNota = '';
            $('#btnTambah').prop('disabled', false);
            $('#btnBatal').prop('disabled', true);
            $('#btnCetak').prop('disabled', true);
            $('#btnCetakBarcode').prop('disabled', true);
            $('#btnEdit').prop('disabled', true);
            $('.buttonForm').prop('disabled', true);

            $('#cariDataNota').on('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    $('#btnCari').click();
                }
            });

            $('#btnCari').on('click', function() {
                dataNota = $('#cariDataNota').val();
                if (dataNota == '') {
                    dataNota = 0;
                }


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

            $('#btnTambah').on('click', function() {
                window.location.href = '/sales/create';
            });

        });
    </script>
@endsection
