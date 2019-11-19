<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset('public/css/style.css') }}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="{{ asset('public/js/my.js') }}" defer></script>
</head>
<body>
    <div id="app">
        <main style="display: flex; justify-content: center">
            <div style="width: 70%; min-width: 320px">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
