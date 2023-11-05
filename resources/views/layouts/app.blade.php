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
        Sentro Trading Inventory Management System
    </title>
    <!-- Nucleo Icons -->
    <link rel="stylesheet" href="{{ asset('assets/css/nucleo-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nucleo-svg.css') }}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.css') }}">
    {{-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
    <!-- Swwet Alert -->
    <link rel="stylesheet" href="{{ asset('assets/sweetalert/dist/sweetalert2.min.css') }}">

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bs5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/soft-ui-dashboard.min.css') }}" id="pagestyle">
    <style>
        .navbar-vertical .navbar-nav>.nav-item .nav-link.active .icon {
            background-image: linear-gradient(310deg, #ff4000, #ff8400) !important;
        }

        .sidenav {
            overflow: hidden !important;
        }

        .sidenav .nav-link:hover {
            background-color: rgb(168, 167, 167);
            border-radius: 10px;
        }

        body,
        p,
        div {
            font-family: 'Poppins', sans-serif !important;
        }

        .form-control:focus {
            border-color: #e97134 !important;
            box-shadow: 0 0 0 2px #F87737 !important;
        }

        .card:hover .icon-shape {
            transform: scale(1.1);
            transition: transform 0.3s ease;
        }

        /* hide the scrollbar on the sidebar */
        body::-webkit-scrollbar {
            display: none !important;
        }
    </style>
</head>

<body class="g-sidenav-show  bg-gray-400">

    @include('layouts.navbars.sidebar')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
        @include('layouts.navbars.nav')
        <div class="container-fluid py-4">
            @yield('content')
        </div>
    </main>

    {{-- Core JS files --}}
    {{-- <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.3.7.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
    <script src="{{ asset('assets/sweetalert/dist/sweetalert2.min.js') }}"></script>

    <script>
        var URL = '{{ config('app.url') }}'
    </script>

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
    <script src="{{ asset('assets/js/soft-ui-dashboard.min.js') }}"></script>
    <script src="{{ asset('assets/bs5/js/bootstrap.min.js') }}"></script>

    <script src="{{ mix('js/app.js') }}"></script>

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

    {{-- script to auto close alert --}}
    <script>
        window.setTimeout(function() {
            $(".alert").fadeTo(1000, 0).slideUp(1000, function() {
                $(this).remove();
            });
        }, 5000);
    </script>

    <script>
        if (window.livewire) {
            window.livewire.on('hideModal', (modalId) => {
                $(modalId).modal('hide');
            });
        }

        window.addEventListener('SwalSuccess', event => {
            Swal.fire({
                position: 'top-center',
                icon: 'success',
                title: event.detail.message,
                showConfirmButton: false,
                timer: 1500
            })
        });

        window.addEventListener('SwalError', event => {
            Swal.fire({
                position: 'top-center',
                icon: 'error',
                title: event.detail.message,
                showConfirmButton: true,
            })
        });

        window.addEventListener('already-confirmed', event => {
            Swal.fire({
                position: 'top-center',
                icon: 'warning',
                title: event.detail.message,
                showConfirmButton: false,
                timer: 1500
            })
        });

        window.addEventListener('swal:confirm', event => {
            Swal.fire({
                position: 'top-center',
                icon: 'warning',
                title: event.detail.message,
                showCancelButton: true,
                confirmButtonText: `Yes`,
                denyButtonText: `Cancel`
            }).then((result) => {
                if (result.isConfirmed) {
                    window.livewire.emit('delete', event.detail.id)
                    Swal.fire({
                        position: 'top-center',
                        icon: 'success',
                        title: 'Successfully Deleted',
                        showConfirmButton: false,
                        timer: 1000
                    })
                }
            });
        });
    </script>
</body>

</html>
