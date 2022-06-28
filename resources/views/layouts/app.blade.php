<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', '') }} |  @yield('pate_title', 'Home')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ url('img/favicon.png') }}">

    <!-- page css -->

    <!-- Core css -->
    @yield('vendor_css')
    @include('layouts.scripts.css')
    @yield('custom_css')

</head>

<body>
    <div class="app">
        <div class="layout">
            @include('layouts.header')
            @include('layouts.sidenav')

            <!-- Page Container START -->
            <div class="page-container">

                @yield('content')

                <!-- Content Wrapper START -->
                @include('layouts.footer')
            </div>

            @include('layouts.extra.modals')
        </div>
    </div>

    @include('layouts.scripts.js')
    @yield('custom_js')


</body>

</html>