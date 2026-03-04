<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS</title>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('DevExtreme/css/dx.common-new.css') }}">
    <link rel="stylesheet" href="{{ asset('DevExtreme/css/dx.light.compact.css') }}">
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('autocomplete/autocomplete.css') }}" rel="stylesheet">
    <link href="{{ asset('select2/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet">
    {{-- <link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.6/dist/css/tom-select.css" rel="stylesheet"> --}}
    <link href="{{ asset('jquery-ui/jquery-ui.css') }}" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="{!! asset('assets/images/favicon.png') !!}">

    <style>
        #itemsTable th,
        #itemsTable td {
            padding: 3px 8px !important;
            margin: 0 !important;
            line-height: 1.8 !important;
            vertical-align: middle !important;
        }

        #itemsTable th *,
        #itemsTable td * {
            margin: 0 !important;
        }

        .form-control.required-form {
            border: 1px solid #dc3545;
        }


        .ts-control input::placeholder {
            font-size: 17px;
        }

        .ts-dropdown .option {
            font-size: 17px;
            padding: 8px;
        }

        .ts-control .item {
            font-size: 17px;
        }

        .ts-control input {
            font-size: 17px;
        }

        .btn-info-dark {
            background-color: #0bb5d8;
            border-color: #0bb5d8;
        }

        .btn-info-dark:hover {
            background-color: #0891b2;
            border-color: #0891b2;
        }

        .bg-primary-color {
            background-color: #913030 !important;
        }

        .btn-primary {
            background-color: #913030 !important;
        }

        .btn-primary {
            background-color: #913030 !important;
        }

        .text-active {
            color: #913030 !important;
        }

        input[readonly],
        textarea[readonly] {
            background-color: #e9ecef;
            /* warna abu-abu Bootstrap */
            opacity: 1;
            /* biar teks tetap jelas */
        }


        .app-brand-text.demo {
            font-size: 1.75rem;
            letter-spacing: -0.5px;
            /* text-transform: lowercase; */
        }

        body {
            font-family: 'Poppins', sans-serif;

        }

        /* .font-custom {
                font-size: 17px;
            } */
        .font-custom.form-control {
            font-size: 17px;
        }

        /* kalau ingin khusus label */
        .font-custom.form-label {
            font-size: 17px;
        }

        .select2-container--default .select2-selection--single {
            font-size: 17px;
        }

        .itemsTable td {
            font-size: 17px;
            /* ubah angka sesuai kebutuhan */
        }

        .autoComplete_wrapper>ul>li mark {
            color: #000;
        }
    </style>
</head>

<body class="bg-light">

    <div class="bg-primary-color text-white py-1 px-3 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <img src="{!! asset('assets/images/favicon.png') !!}" class="w-px-40 h-auto rounded-circle me-2"
                style="opacity:.9; width:50px; height:50px; object-fit:cover;">
            <span class="app-brand-text demo menu-text fw-bolder text-white">
                LMS - Sales
            </span>
        </div>

        <div class="d-flex align-items-center  gap-3">
            <div id="datetime" class="me-3"></div>
            @auth
                <div class="dropdown">
                    <button class="btn btn-light  d-flex align-items-center" style="height: 25px;" type="button"
                        id="historyDropdown" data-bs-toggle="dropdown" aria-expanded="false">

                        <i class="fas fa-history me-2"></i>
                        Riwayat
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow mt-3"
                        style="min-width: 300px;max-height: 300px; overflow-y: auto;" id="historyList">
                        {{-- <li>
                            <a class="dropdown-item" href="#">
                                <div class="fw-semibold">INV-0001</div>
                                <small class="text-muted">20 Feb 2026 13:05</small>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="fw-semibold">INV-0002</div>
                                <small class="text-muted">20 Feb 2026 12:40</small>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="fw-semibold">INV-0003</div>
                                <small class="text-muted">20 Feb 2026 11:10</small>
                            </a>
                        </li> --}}

                    </ul>
                </div>
                <div class="dropdown">
                    <a class="d-flex align-items-center text-white text-decoration-none dropdown-toggle px-2 py-1 rounded-2 bg-dark bg-opacity-25 hover-bg-dark"
                        href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle fs-4 me-2 text-warning"></i>
                        <div class="d-flex flex-column lh-sm">
                            <span class="fw-semibold">
                                {{ Auth::user()->UserName ?? 'User' }}
                            </span>
                            @if (session('event') != '' || session('venue') != '')
                                <small class="text-light text-opacity-75">
                                    {{ session('event') ? session('event') . ' :' : '' }}
                                    {{ session('venue') ?? '-' }}
                                </small>
                            @endif
                        </div>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow mt-2" aria-labelledby="userDropdown">
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                @endif
            </div>
        </div>
        {{-- Navbar menu --}}
        @auth
            <nav class="navbar navbar-expand-lg bg-white shadow-sm py-0">
                <div class="container-fluid">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center  {{ request()->is('/') ? 'active text-active fw-bold' : 'text-secondary fw-semibold' }}"
                                href="/">
                                <i class="bi bi-receipt me-2"></i>
                                Nota Tagihan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-secondary d-flex align-items-center {{ request()->is('sales/show') ? 'active text-active fw-bold' : 'text-secondary fw-semibold' }} "
                                href="/sales/show">
                                <i class="bi bi-receipt me-2"></i>
                                Informasi
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                    <a class="nav-link text-secondary d-flex align-items-center {{ request()->is('pack/*') ? 'active text-active fw-bold' : 'text-secondary fw-semibold' }} "
                        href="/pack/show">
                        <i class="bi bi-receipt me-2"></i>
                        Kemasan
                    </a>
                </li> --}}
                        <li class="nav-item">
                            <a class="nav-link text-secondary d-flex align-items-center {{ request()->is('grosir/*') ? 'active text-active fw-bold' : 'text-secondary fw-semibold' }} "
                                href="/grosir/show">
                                <i class="bi bi-receipt me-2"></i>
                                Grosir
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-secondary d-flex align-items-center {{ request()->is('venue/*') ? 'active text-active fw-bold' : 'text-secondary fw-semibold' }} "
                                href="/venue/show">
                                <i class="bi bi-receipt me-2"></i>
                                Venue
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-secondary d-flex align-items-center {{ request()->is('pricelist/*') ? 'active text-active fw-bold' : 'text-secondary fw-semibold' }} "
                                href="/pricelist/show">
                                <i class="bi bi-receipt me-2"></i>
                                Pricelist
                            </a>
                        </li>
                        @if (Auth::user() && Auth::user()->Role === 'administrator')
                            <li class="nav-item">
                                <a class="nav-link text-secondary d-flex align-items-center {{ request()->is('user/*') ? 'active text-active fw-bold' : 'text-secondary fw-semibold' }}"
                                    href="/user/show">
                                    <i class="bi bi-receipt me-2"></i>
                                    Manajemen User
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </nav>
            @endif

            {{-- Content --}}
            <main class="container-fluid py-1">
                @yield('content')
            </main>
            <script src="{{ mix('js/app.js') }}"></script>
            <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
            <script src="{{ asset('select2/select2.min.js') }}"></script>
            {{-- <script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.6/dist/js/tom-select.complete.min.js"></script> --}}
            <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
            <script src="{{ asset('sweetalert2/sweetalert2.all.min.js') }}"></script>
            <script src="{{ asset('DevExtreme/js/jszip-new.min.js') }}"></script>
            <script src="{{ asset('DevExtreme/js/dx-new.all.js') }}"></script>
            <script>
                async function loadRiwayat() {
                    const historyList = document.getElementById("historyList");

                    try {
                        const res = await fetch("{{ url('/sales/getData/Nota/riwayat') }}");
                        const data = await res.json();

                        historyList.innerHTML = "";

                        if (!data.length) {
                            historyList.innerHTML = `
                <li class="dropdown-item text-center text-muted">
                    Tidak ada riwayat
                </li>
            `;
                            return;
                        }

                        data.forEach((item, index) => {
                            historyList.insertAdjacentHTML("beforeend", `
                <li>
                        <a class="dropdown-item" href="/sales/detail/${item.invoice_number}">
                                      
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="fw-semibold">${item.invoice_number}</div>
                            <small class="text-muted">${item.TransDate}</small>
                        </div>

                      
                        <div>
                            <small class="text-muted">${item.Customer}</small>
                        </div>

                     
                        <div class="mt-1">
                            <span
                                style="background-color:${item.color};
                                    color:${item.textColor};
                                    padding:2px 8px;
                                    border-radius:4px;
                                    font-size:12px;">
                                ${item.carat}
                            </span>
                            <small class="text-muted ms-1">/ ${item.Weight}</small>
                        </div>
                    </a>
                </li>
                ${index !== data.length - 1 ? '<li><hr class="dropdown-divider"></li>' : ''}
            `);
                        });

                    } catch (err) {
                        console.error("Gagal load riwayat:", err);
                    }
                }

                document.getElementById("historyDropdown")
                    ?.addEventListener("click", loadRiwayat);


                $("#listVenue").select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    placeholder: "Pilih Tempat",
                    allowClear: true,
                    ajax: {
                        url: "/getData/Venue/search",
                        dataType: "json",
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.map(item => ({
                                    id: item.Description,
                                    text: item.Description
                                }))
                            };
                        },
                        cache: true
                    },
                });
                $("#listEvent").select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    placeholder: "Pilih Event",
                    allowClear: true,
                    data: [{
                            'id': 'Pameran',
                            'text': 'Pameran'
                        },
                        {
                            'id': 'In House',
                            'text': 'In House'
                        }
                    ]
                });
                $("#listEvent").val(null).trigger('change');

                function updateDateTime() {
                    const now = new Date();
                    const options = {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    };
                    const formatted = now.toLocaleDateString('id-ID', options);
                    document.getElementById('datetime').textContent = formatted;
                }

                updateDateTime();
                setInterval(updateDateTime, 1000);
            </script>
        </body>

        </html>
