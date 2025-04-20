<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Vite CSS -->
        @vite('resources/css/app.css')

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- CSS Bootstrap via CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    </head>
    <body class="antialiased">
        <div class="app">
            @if (auth()->check())
                @yield('dashboard')
            @else
                @yield('content_login')
            @endif
        </div>

        <!-- Vite JS -->
        @vite('resources/js/app.js')

        <!-- Bootstrap JS via CDN -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

        <!-- Scripts adicionais -->
        @stack('scripts')
    </body>
</html>