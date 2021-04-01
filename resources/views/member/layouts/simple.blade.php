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
    <link rel="stylesheet" href="https://unpkg.com/@tabler/core@latest/dist/css/tabler.min.css">

</head>
<body>
    <div id="flex-fill d-flex flex-column justify-content-center py-4">
        <main>
            @yield('content')
        </main>
    </div>
    <script src="https://unpkg.com/@tabler/core@latest/dist/js/tabler.min.js"></script>
</body>
</html>
