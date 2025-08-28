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
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 text-center fw-bold ">List Invoice</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered mb-0" id="itemsTable">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 120px;">No</th>
                                <th style="width: 150px;">Nota</th>
                                <th style="width: 150px;">Grosir</th>
                                <th style="width: 150px;">Customer</th>
                                <th style="width: 150px;">Address</th>
                                <th style="width: 150px;">Phone</th>
                                <th style="width: 150px;">Kategori</th>
                                <th style="width: 150px;">Kadar</th>
                                <th style="width: 150px;">Berat</th>
                                <th style="width: 150px;">Event</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $d )
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>-</td>
                                <td>{{$d->Grosir}}</td>
                                <td>{{$d->Customer}}</td>
                                <td>{{$d->Address}}</td>
                                <td>{{$d->Phone}}</td>
                                <td>{{$d->category_name}}</td>
                                <td>{{$d->carat_name}}</td>
                                <td>{{$d->Weight}}</td>
                                <td>{{$d->Event}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>




    <script></script>
@endsection
