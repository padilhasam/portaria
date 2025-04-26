<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Ícone Favicon--}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    {{-- Título dinâmico com fallback padrão --}}
    <title>@yield('title', 'Secure Access')</title>

    {{-- Vite CSS --}}
    @auth
        @vite('resources/css/app.css')
    @else
        @vite('resources/css/login.css')
    @endauth

    {{-- Fonte --}}
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap CSS via CDN (somente se não usar via npm) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body class="antialiased">
    <div class="app">
        {{-- Exibe dashboard ou login conforme autenticação --}}
        @auth
            @yield('dashboard')
        @else
            @yield('content_login')
        @endauth
    </div>

    {{-- Vite JS --}}
    @vite('resources/js/app.js')

    {{-- Bootstrap JS via CDN (remova se estiver usando via Vite/npm) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    {{-- Scripts adicionais --}}
    @stack('scripts')
</body>
</html>