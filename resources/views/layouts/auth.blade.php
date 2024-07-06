<!DOCTYPE html>
<html lang="en">
    <!-- BEGIN: Head-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
        <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
        <meta name="author" content="Devendra Rajput">
        <title> @yield('title') </title>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="apple-touch-icon" href="{{ asset('images/theme/ico/apple-icon-120.png') }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/images/logo.png') }}">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('fontawesome/css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('fontawesome/css/fontawesome.css') }}">
        <link rel="stylesheet" href="{{ asset('fontawesome/css/regular.css') }}">
        <link rel="stylesheet" href="{{ asset('fontawesome/css/solid.css') }}">
        <script href="{{ asset('fontawesome/js/all.min.js') }}"></script>
        <!-- <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css"> -->
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->

        <!-- BEGIN: Vendor CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/vendors.min.css') }}">
        <!-- END: Vendor CSS-->

        <!-- BEGIN: Theme CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/bootstrap.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/bootstrap-extended.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/colors.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/components.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/themes/dark-layout.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/themes/bordered-layout.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/themes/semi-dark-layout.css') }}">
        <!-- END: Theme CSS-->

        <!-- BEGIN: Page CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/core/menu/menu-types/vertical-menu.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/plugins/forms/form-validation.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/theme/pages/authentication.css') }}">
        @stack('page_style')
        <!-- END: Page CSS-->

        <!-- BEGIN: Custom CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
        <!-- END: Custom CSS-->

    </head>
    <!-- END: Head-->

    <body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

        <!-- BEGIN: Content-->
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <div class="auth-wrapper auth-cover">
                        <div class="auth-inner row m-0">

                            <!-- Brand logo-->
                            <a class="brand-logo" href="{{route('login')}}">
                                <img src="{{ asset('/images/logo.png')}}">
                                <h2 class="brand-text text-primary ms-1">{{config('app.name')}}</h2>
                            </a>
                            <!-- /Brand logo-->
                            <!-- Left Text-->
                            
                            <!-- /Left Text-->
                                @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Content-->

        <!-- BEGIN: Vendor JS-->
        <script src="{{ asset('js/theme/vendors.min.js') }}"></script>
        <!-- BEGIN Vendor JS-->

        <!-- BEGIN: Page Vendor JS-->
        <script src="{{ asset('js/theme/forms/validation/jquery.validate.min.js') }}"></script>
        <!-- END: Page Vendor JS-->

        <!-- BEGIN: Theme JS-->
        <script src="{{ asset('js/theme/core/app-menu.js') }}"></script>
        <script src="{{ asset('js/theme/core/app.js') }}"></script>
        <!-- END: Theme JS-->

        <!-- BEGIN: Page JS-->
        <script src="{{ asset('js/theme/scripts/pages/auth-login.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>
        @stack('page_script')
        <!-- END: Page JS-->

    </body>
</html>
