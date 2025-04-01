@extends('layouts.app')

@section('dashboard') <!-- Corpo padrão -->
    @vite(['resources/css/nav.css'])
    <div class="container-fluid w-100 h-100">
        <div class="row">
            <nav class="lateral-nav col-3 col-sm-2 vh-100 p-0">
                <img src={{Vite::asset('/resources/images/logo.png')}} alt="Secure Access" class="p-4 w-100">
                <ul class="welcome">
                    @if (auth()->check())
                        <p class="text-white">Bem-vindo, {{ Auth::user()->name }}!</p>
                    @endif
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 w-200">
                    <li class="mb-2 menu-item">
                        @if (auth()->check())
                            <a href={{ route('index.registro') }} class="btn p-0 m-0 w-100 mb-1">{{ svg('hugeicons-folder-security') }} Controle de Acessos</a>
                            <a href={{ route('index.usuario') }} class="btn p-0 m-0 w-100 mb-1">{{ svg('hugeicons-user-shield-02') }} Usuários</a>
                            <a href={{ route('index.apartamento') }} class="btn p-0 m-0 w-100 mb-1">{{ svg('hugeicons-house-01') }} Apartamentos</a>
                            <a href={{ route('index.morador') }} class="btn p-0 m-0 w-100 mb-1">{{ svg('hugeicons-user-multiple') }} Moradores</a> 
                            <a href={{ route('index.veiculo') }} class="btn p-0 m-0 w-100 mb-1">{{ svg('hugeicons-car-01') }} Veículos</a>
                            <a href={{ route('index.visitante') }} class="btn p-0 m-0 w-100 mb-1">{{ svg('hugeicons-validation-approval') }} Visitantes</a>
                            <a href="#" class="btn p-0 m-0 w-100 mb-1">{{ svg('hugeicons-note-01') }} Histórico de Acessos</a>
                            <a href="#" class="btn p-0 m-0 w-100 mb-1">{{ svg('hugeicons-calendar-01')}} Reservas</a>
                            <a href="#" class="btn p-0 m-0 w-100 mb-1">{{ svg('hugeicons-chatting-01')}} Ocorrências</a>
                            <a href="#" class="btn p-0 m-0 w-100 mb-1">{{ svg('hugeicons-repair') }} Serviços</a>
                            <a href="#" class="btn p-0 m-0 w-100 mb-1">{{ svg('hugeicons-package-delivered')}} Correspondências</a>
                            <a href="#" class="btn p-0 m-0 w-100 mb-1">{{ svg('hugeicons-notification-01')}} Notificações</a>
                            <a href="#" class="btn p-0 m-0 w-100 mb-1">{{ svg('hugeicons-settings-01')}} Configurações</a>
                            
                        @endif
                    </li>
                </ul>
                <ul class = "navbar-nav ms-auto mb-2 mb-lg-0 w-100 logout-item">
                    <li class="mb-2">
                        @if (auth()->check())
                            {{ session()->get('success') }}
                            <a href={{ route('login.destroy') }} class="btn w-100">{{ svg('hugeicons-logout-04') }} Deslogar</a>
                        @endif
                    </li>
                </ul>
            </nav>
            
            <div class="col-9 col-sm-10 m-0 p-0">
                @yield('page_dashboard')
            </div>
        </div>
    </div>
   
@endsection