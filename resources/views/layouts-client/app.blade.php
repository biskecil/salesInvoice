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
    <link href="{{ asset('jquery-ui/jquery-ui.css') }}" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="{!! asset('assets/images/favicon.png') !!}">

    <style>
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

        <div class="d-flex align-items-center">
            <div id="datetime" class="me-3"></div>
             @auth
            <div class="dropdown">
                <a class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" href="#"
                    role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle fs-4 me-1"></i>
                    <span>{{ Auth::user()->name ?? 'User' }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end mt-2" aria-labelledby="userDropdown">
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item">Logout</button>
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
                    <a class="nav-link text-secondary d-flex align-items-center {{ request()->is('pricelist/*') ? 'active text-active fw-bold' : 'text-secondary fw-semibold' }} "
                        href="/pricelist/show">
                        <i class="bi bi-receipt me-2"></i>
                        Pricelist
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    @endif

    {{-- Content --}}
    <main class="container-fluid py-4">
        @yield('content')
    </main>
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('DevExtreme/js/jszip-new.min.js') }}"></script>
    <script src="{{ asset('DevExtreme/js/dx-new.all.js') }}"></script>
    <script>
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
            const formatted = now.toLocaleDateString('en-US', options);
            document.getElementById('datetime').textContent = formatted;
        }

        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>
</body>

</html>
