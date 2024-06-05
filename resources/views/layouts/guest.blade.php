<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="auto">
    <head>
        <script src="{{ asset('assets/js/color-modes.js') }}"></script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>
        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])

        @stack('head')
    </head>
    <body>
        @yield('content')
    </body>
</html>
