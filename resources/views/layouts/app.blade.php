<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - ERP</title>
  
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('jquery-ui/jquery-ui.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"> --}}
    <style>
        .bg-primary-color {
            background-color: #913030 !important;
        }

        input[readonly],
        textarea[readonly] {
            background-color: #e9ecef;
            /* warna abu-abu Bootstrap */
            opacity: 1;
            /* biar teks tetap jelas */
        }
    </style>
</head>

<body class="bg-light">

    {{-- Header merah --}}
    <div class="bg-primary-color text-white py-1 px-3 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <img src="{!! asset('assets/images/favicon.png') !!}" class="w-px-40 h-auto rounded-circle me-2"
                style="opacity:.9; width:50px; height:50px; object-fit:cover;">
            <span class="app-brand-text demo menu-text fw-bolder text-white">
                LMS - SALES
            </span>
        </div>

    </div>

    {{-- Navbar menu --}}
    {{-- <nav class="navbar navbar-expand-lg bg-white shadow-sm py-1">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-secondary fw-semibold d-flex align-items-center" href="/">
                        <i class="bi bi-receipt me-2"></i>
                        Nota Tagihan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-secondary fw-semibold d-flex align-items-center" href="/sales/show">
                        <i class="bi bi-receipt me-2"></i>
                        List Tagihan
                    </a>
                </li>
            </ul>
        </div>
    </nav> --}}

    {{-- Content --}}
    <main class="container-fluid py-4">
        @yield('content')
    </main>
   
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('sweetalert2/sweetalert2.all.min.js') }}"></script>
   
</body>

</html>
