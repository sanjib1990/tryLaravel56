<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{!! elixir('css/app.css') !!}">
    @yield('styles')
</head>
<body>
@yield('body')
</body>
@yield('scripts')
</html>
