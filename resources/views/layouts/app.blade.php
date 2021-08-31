<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>SpreadingSystem | @yield('title')</title>
    @include('layouts.css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    @include('sweetalert::alert')
    <div class="wrapper">
        <!-- Preloader -->
        <!-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{!! asset('img/AdminLTELogo.png') !!}" alt="AdminLTELogo" height="60" width="60">
        </div> -->
        @include('layouts.header')
        @include('layouts.sidebar')
        <div class="content-wrapper">
            <main class="py-12">
                @yield('content')
            </main>
        </div>
        @include('layouts.footer')
    </div>
    @include('layouts.scripts')
</body>
</html>
