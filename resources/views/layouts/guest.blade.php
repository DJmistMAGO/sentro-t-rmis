<!--
=========================================================
* Soft UI Dashboard - v1.0.3
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2021 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @stack('links')
    @livewireStyles
    <link rel="shortcut icon" href="{{ asset('images/st1.png') }}" type="image/x-icon">
    <title>
        Sentro Trading Record Inventory Management System
    </title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bs5/css/bootstrap.min.css') }}">
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body class="g-sidenav-show  bg-gray-400">
    @yield('content')

    {{-- Core JS files --}}
    <script src="{{ asset('assets/bs5/js/bootstrap.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/core/popper.min.js') }}"></script> --}}

    @stack('scripts')
    @livewireScripts
    {{-- <script src="{{ asset('assets/js/soft-ui-dashboard.min.js') }}"></script> --}}
</body>

</html>
