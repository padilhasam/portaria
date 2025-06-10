<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Token CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Ícone Favicon--}}
    <link rel="icon" href="{{ Vite::asset('resources/images/favicon.ico') }}" type="image/x-icon"> 

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

</head>
<body class="antialiased">

    <x-loader />

    <div class="app">
        {{-- Exibe dashboard ou login conforme autenticação --}}
        @auth
            @yield('dashboard')
        @else
            @yield('content_login')
        @endauth
    </div>

    <script>
        @isset($eventos)
            window.agendamentos = @json($eventos);
        @else
            window.agendamentos = [];
        @endisset
    </script>

    {{-- Vite JS --}}
    @vite('resources/js/app.js')
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> -->


    {{-- Scripts adicionais --}}
    @stack('scripts')
</body>
</html>