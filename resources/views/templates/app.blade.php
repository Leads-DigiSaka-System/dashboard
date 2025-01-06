<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DigiSaka |@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="apple-touch-icon" href="{{ asset('images/theme/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="https://digisaka.info/images/xlogo.png.pagespeed.ic.hiiVcdbuPv.webp">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/regular.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/solid.css') }}">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/charts/apexcharts.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/extensions/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/forms/select/select2.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/themes/bordered-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/themes/semi-dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/extensions/sweetalert2.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">

    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/plugins/charts/chart-apex.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/plugins/extensions/ext-component-toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/pages/app-invoice-list.css') }}">

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css?v=1.1') }}">
    <!-- END: Custom CSS-->

    <style>
        * {
            box-sizing: border-box;
        }
        .vertical-layout.vertical-menu-modern.menu-expanded .main-menu {
            width: 300px !important;
        }
        html .layout2.content {
            margin-left: 22rem !important;
        }
        .header-navbar.navbar-static-top {
            left: 300px !important;
            width: calc(100vw - (100vw - 100%) - 300px) !important;
            background: white !important;
        }
        .main-menu .navbar-header {
            width: 300px !important;
        }
        html .content.app-content{
            padding: .1rem;
        }
        html .content.app-content{
            padding-top: 6rem;
        }
        @media (max-width: 1199.98px) {
            html .layout2.content {
                margin-left: 0 !important;
            }
            .header-navbar.navbar-static-top {
                left: 0 !important;
                width: 100% !important;
            }
        }

        .legend {
            position: absolute;
            bottom: 30px;
            left: 30px;
            background-color: white;
            padding: 10px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .legend-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .legend-entry {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .legend-entry img {
            width: 20px;
            height: 20px;
            margin-right: 5px;
        }
    </style>
    @yield('header_css')
    @yield('header_scripts')
    @stack('css')
</head>
<body class="layout2 vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">
    @include('templates.partials.navbar')
    @include('templates.partials.sidebar')
    <!-- BEGIN: Content-->
    <div class="layout2 content app-content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper p-0">
            <div class="content-header row">
            </div>
            <div class="content-body" 
            {{-- style="z-index: 99; position: relative;"   --}}
            style="position: relative;">
                @include("include.flashMessage")
                @yield('content')
            </div>
        </div>
    </div>

    <div id="pageloader" class=""></div>
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    @include('templates.partials.footer')

    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('js/theme//vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('js/theme/charts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('js/theme/extensions/toastr.min.js') }}"></script>
    <script src="{{ asset('js/theme/extensions/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/theme/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/theme/scripts/forms/form-select2.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('js/theme/core/app-menu.js') }}"></script>
    <script src="{{ asset('js/theme/core/app.js') }}"></script>
    <!-- END: Theme JS-->

    <script src="{{ asset('js/custom.js?v=1.1') }}"></script>

    <script>
        @if(session('success'))
            toastr.success("{{ session('success') }}", 'Success!', toastCofig);
        @endif
        @if(session('error'))
            toastr.error("{{ session('error') }}", 'Error!',  toastCofig);
        @endif
        @if(session('warning'))
            toastr.warning("{{ session('warning') }}", 'Warning!', toastCofig);
        @endif
        @if(session('info'))
            toastr.info("{{ session('info') }}", 'Informaton!', toastCofig);
        @endif
        @if($errors->any())
            toastr.error("Please check the form below for errors", 'Error!', toastCofig);
        @endif
    </script>

    @yield('footer_scripts')
    @stack('scripts')
</body>
</html>
