<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="auto">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', $option['site-title']->value ?? config('app.name', 'Laravel'))</title>

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])

        <!-- Scripts Dark Mode Bootstrap -->
        <script src="{{ asset('assets/js/color-modes.js') }}"></script>

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset($option['favicon']->value ? 'storage/'.$option['favicon']->value:'assets/images/favicon.ico') }}">

        <!-- preloader css -->
        <link rel="stylesheet" href="{{ asset('assets/css/preloader.min.css') }}" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2-bootstrap-5-theme.min.css') }}" />

        <!-- Push Script Head-->
        @stack('head')
    </head>
    
    <body class="bg-body-tertiary">
            <!-- Begin page -->
            <div id="layout-wrapper">

                <!-- Start Header -->
                @include('layouts.header')
                <!-- End Header -->

                <!-- Left Sidebar Start -->
                @include('layouts.sidebar-left')
                <!-- Left Sidebar End -->

                <!-- Start main Content -->
                <div class="main-content">
    
                    <div class="page-content">
                        <div class="container-fluid">
                            
                            @yield('content')
                            
                        </div> <!-- container-fluid -->
                    </div>
                    <!-- End Page-content -->
    
                    
                    @include('layouts.footer')
                </div>
                <!-- end main content-->
            </div>
            <!-- END layout-wrapper -->
    
            
            <!-- Right Sidebar  Customize Theme-->
            {{-- @include('layouts.customize') --}}
            <!-- END Right-bar Customize Theme-->
    
            <!-- Right bar overlay-->
            <div class="rightbar-overlay"></div>
    
            <!-- JAVASCRIPT -->
            <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
            <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
            <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
            <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
            <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
            
            <!-- pace js -->
            <script src="{{ asset('assets/libs/pace-js/pace.min.js') }}"></script>
    
            <script src="{{ asset('assets/js/app.js') }}"></script>
            
            @stack('scripts')
        </body>
    </html>