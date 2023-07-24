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
    <!-- Nucleo Icons -->
    <link rel="stylesheet" href="{{ asset('assets/css/nucleo-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nucleo-svg.css') }}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.css') }}">
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/soft-ui-dashboard.min.css') }}" id="pagestyle">
</head>

<body class="g-sidenav-show  bg-gray-400">
    @auth
        @include('layouts.navbars.auth.sidebar')
        <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
            @include('layouts.navbars.auth.nav')
            <div class="container-fluid py-4">
                @yield('content')
            </div>
        </main>
    @endauth

    {{-- Core JS files --}}
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>

    @stack('scripts')
    @livewireScripts

    @stack('dashboard')
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    {{-- script for date on the navbar  --}}
    <script>
        function updateDateTime() {
            var currentDate = new Date(); //will get current date

            // format currentDate as Weekday, Month Day, Year - Hour:Minute:Second AM/PM
            var formattedDateTime = currentDate.toLocaleString('en-US', {
                month: 'long',
                day: 'numeric',
                year: 'numeric',
                hour: '2-digit',
                minute: 'numeric',
                second: 'numeric',
                hour12: true,
                weekday: 'long'
            });
            // replace at with space
            formattedDateTime = formattedDateTime.replace("at", " - ");

            document.getElementById("currentDateTime").innerHTML = formattedDateTime;
        }
        setInterval(updateDateTime, 1000); // updates the code every second
    </script>

    <script src="{{ asset('assets/js/soft-ui-dashboard.min.js') }}"></script>
</body>

</html>
