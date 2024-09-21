@php
    $option = \App\Models\Option::whereIn('name', ['favicon'])->get()->keyBy('name'); 
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="auto">
    <head>
        {{-- <script src="{{ asset('assets/js/color-modes.js') }}"></script> --}}
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>
        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset($option['favicon']->value ? 'storage/'.$option['favicon']->value : 'assets/images/laravel.png') }}">

        <!-- preloader css -->
        <link rel="stylesheet" href="{{ asset('assets/css/preloader.min.css') }}" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

        <!-- Scripts Dark Mode Bootstrap -->
        <script src="{{ asset('assets/js/color-modes.js') }}"></script>

        @stack('head')
    </head>
    <body class="d-flex align-items-center py-4 bg-body-tertiary">
        @yield('content')


        <!-- Button Mode Color / Dark Mode -->
        <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
            <button class="btn btn-sm btn-bd-primary  dropdown-toggle d-flex align-items-center gap-1" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (dark)">
                <span class="bi my-1 theme-icon-active">
                    <i class="theme-change-icon"></i>
                </span>
              <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
              <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
                    <i class="bi bi-sun-fill me-2"></i>
                    Light
                    <span class="bi ms-auto d-none" width="1em" height="1em"><a href="#check2"><i class="bi bi-check"></i></a></span>
                </button>
              </li>
              <li>
                <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="dark" aria-pressed="true">
                    <i class="bi bi-moon-stars-fill me-2"></i>
                    Dark
                    <span class="bi ms-auto d-none" width="1em" height="1em"><a href="#check2"><i class="bi bi-check"></i></a></span>
                </button>
              </li>
              <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="auto" aria-pressed="false">
                    <i class="bi bi-circle-half me-2"></i>
                    Auto
                    <span class="bi ms-auto d-none" width="1em" height="1em"><a href="#check2"><i class="bi bi-check"></i></a></span>
                </button>
              </li>
            </ul>
        </div>
         <!-- END Button Mode Color / Dark Mode -->


         <!-- JAVASCRIPT -->
         <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>

         <script src="{{ asset('assets/js/app.js') }}"></script>
    </body>
</html>
