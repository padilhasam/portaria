@extends('layouts.app')

@php
    use App\Helpers\NotificacaoHelper;
    $dadosNotificacao = NotificacaoHelper::carregarNotificacoes();
@endphp

@if(session('tem_notificacoes_nao_lidas') || $dadosNotificacao['naoLidas'] > 0)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            toastr.info("Você tem {{ $dadosNotificacao['naoLidas'] }} notificações não lidas.", 'Notificações', {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-bottom-right',
                timeOut: 7000
            });
        });
    </script>
@endif

@section('dashboard')
    @vite(['resources/css/nav.css'])

    <!-- Main Navigation -->
    <header>
        <!-- Sidebar -->
        <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white shadow-sm">
            <div class="position-sticky">
                <div class="list-group list-group-flush mx-3 mt-5">
                    <!-- Brand -->
                    <a class="navbar-brand" href={{ route('index.registro') }}>
                        <img src={{ Vite::asset('/resources/images/logo_sm_black.png') }} alt="Secure Access" class="px-0 mb-3 d-block d-sm-block d-lg-none" loading="lazy" style="width: 250px">
                    </a>
                    @if (auth()->check())
                        <a href="{{ route('index.registro') }}" class="list-group-item list-group-item-action py-2 rounded {{ request()->is('registro*') ? 'active' : '' }}">
                            {{ svg('hugeicons-folder-security') }} Controle de Acessos
                        </a>
                        <a href="{{ route('index.visitante') }}" class="list-group-item list-group-item-action py-2 rounded {{ request()->is('visitante*') ? 'active' : '' }}">
                            {{ svg('hugeicons-validation-approval') }} Visitantes
                        </a>
                        <a href="{{ route('index.morador') }}" class="list-group-item list-group-item-action py-2 rounded {{ request()->is('morador*') ? 'active' : '' }}">
                            {{ svg('hugeicons-user-multiple') }} Moradores
                        </a>
                        <a href="{{ route('index.apartamento') }}" class="list-group-item list-group-item-action py-2 rounded {{ request()->is('apartamento*') ? 'active' : '' }}">
                            {{ svg('hugeicons-house-01') }} Apartamentos
                        </a>
                        <a href="{{ route('index.veiculo') }}" class="list-group-item list-group-item-action py-2 rounded {{ request()->is('veiculo*') ? 'active' : '' }}">
                            {{ svg('hugeicons-car-01') }} Veículos
                        </a>
                        <a href="{{ route('index.correspondencia') }}" class="list-group-item list-group-item-action py-2 rounded {{ request()->is('correspondencia*') ? 'active' : '' }}">
                            {{ svg('hugeicons-package-delivered') }} Correspondências
                        </a>
                        <a href="{{ route('index.prestador') }}" class="list-group-item list-group-item-action py-2 rounded {{ request()->is('servicos*') ? 'active' : '' }}">
                            {{ svg('hugeicons-repair') }} Prestadores
                        </a>
                        <a href="{{ route('index.agendamento') }}" class="list-group-item list-group-item-action py-2 rounded {{ request()->is('agendamento*') ? 'active' : '' }}">
                            {{ svg('hugeicons-calendar-01') }} Agendamentos
                        </a>
                        <a href="{{ route('index.notificacao') }}" class="list-group-item list-group-item-action py-2 rounded {{ request()->is('notificacao*') ? 'active' : '' }}">
                            {{ svg('hugeicons-chatting-01') }} Ocorrências
                        </a>
                        <a href="{{ route('index.relatorio') }}" class="list-group-item list-group-item-action py-2 rounded {{ request()->is('relatorio*') ? 'active' : '' }}">
                            {{ svg('hugeicons-note-01') }} Relatórios de Acessos
                        </a>
                        <a href="{{ route('index.usuario') }}" class="list-group-item list-group-item-action py-2 rounded {{ request()->is('usuario*') ? 'active' : '' }}">
                            {{ svg('hugeicons-user-shield-02') }} Usuários
                        </a>
                        <a href="#" class="list-group-item list-group-item-action py-2 rounded {{ request()->is('configuracao*') ? 'active' : '' }}">
                            {{ svg('hugeicons-settings-01') }} Configurações
                        </a>
                    @endif
                </div>
            </div>
        </nav>

        <!-- Navbar -->
        <nav id="main-navbar" class="navbar navbar-expand-lg navbar-dark fixed-top bg-gradient shadow-sm">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu"
                        aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <a class="navbar-brand fw-bold fs-3" href="{{ route('index.registro') }}">
                    <img src={{ Vite::asset('/resources/images/logo_sm.png') }} alt="Secure Access" class="w-75 px-0 d-none d-sm-none d-lg-block" loading="lazy">
                </a>

                <!-- Dropdown de Notificações -->
                <ul class="navbar-nav ms-auto d-flex flex-row align-items-center">
                    <li class="nav-item dropdown mx-3">
                        <a class="nav-link dropdown-toggle {{ $dadosNotificacao['naoLidas'] > 0 ? 'bell-alert' : '' }}" href="#" id="navbarDropdownMenuLink"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Notificações">
                            {{ svg('hugeicons-notification-01', 'w-5 h-5') }}
                            @if($dadosNotificacao['naoLidas'] > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $dadosNotificacao['naoLidas'] }}
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item fw-bold" href="{{ route('index.notificacao') }}">Notificações</a></li>
                            <li><hr class="dropdown-divider"></li>
                            @if($dadosNotificacao['notificacoes']->isEmpty())
                                <li class="dropdown-item text-muted small">Nenhuma nova notificação</li>
                            @else
                                @foreach($dadosNotificacao['notificacoes'] as $notificacao)
                                    <li>
                                        <a href="{{ route('show.notificacao', $notificacao->id) }}" class="dropdown-item">
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold text-dark">{{ $notificacao->title }}</span>
                                                <small class="text-muted">{{ Str::limit($notificacao->message, 50) }}</small>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-center small text-primary" href="{{ route('index.notificacao') }}">
                                        Ver todas as notificações
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>

                    <!-- Perfil do usuário -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                           id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Perfil">
                            <img src="{{ Auth::user()->avatar ?? 'https://mdbootstrap.com/img/Photos/Avatars/img (31).jpg' }}" class="rounded-circle me-2" height="30" alt="Avatar" loading="lazy" />
                            @if(auth()->check())
                                <span class="text-white d-none d-md-inline">{{ Auth::user()->user }}</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                                    </svg> Perfil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                @if(auth()->check())
                                    <a href="{{ route('login.destroy') }}" class="dropdown-item d-flex align-items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-power" viewBox="0 0 16 16">
                                            <path d="M7.5 1v7h1V1z"/>
                                            <path d="M3 8.812a5 5 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812"/>
                                        </svg> Deslogar
                                    </a>
                                @endif
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- Navbar -->
    </header>
    <!-- Main Navigation -->

    <!-- Main layout -->
    <main style="margin-top: 90px">
        <div class="m-0 p-0">
            @yield('page_dashboard')
        </div>
    </main>

    <!-- Scripts compilados pelo Vite -->
    @vite(['resources/js/app.js'])
@endsection
