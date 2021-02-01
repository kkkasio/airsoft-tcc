<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name')}} @yield('title')</title>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ URL::asset('css/tabler.css') }}">
</head>

<body class="antialiased" cz-shortcut-listen="true">
    <div id="page">

        @include('league.layouts.sidebar')
        @include('league.layouts.header')
        @yield('content')

    </div>
    <script src="{{URL::asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{URL::asset('js/tabler.min.js')}}"></script>
    @include('layouts.footer')
</body>

</html>
