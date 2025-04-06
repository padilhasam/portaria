@extends('layouts.app')

@section('dashboard') <!-- Corpo padrão -->
    @vite(['resources/css/nav.css'])
    
<!--Main Navigation-->
<header>
    <!-- Sidebar -->
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-5">
                <!-- Brand -->
                <a class="navbar-brand" href="#">
                    <img src={{Vite::asset('/resources/images/logo_sm_black.png')}} alt="Secure Access" class="px-3 mb-3 d-block d-sm-block d-lg-none" loading="lazy" style="width: 250px">
                </a>
                @if (auth()->check())
                    <a href={{ route('index.registro') }} class="list-group-item list-group-item-action py-2">{{ svg('hugeicons-folder-security') }} Controle de Acessos</a>
                    <a href={{ route('index.usuario') }} class="list-group-item list-group-item-action py-2">{{ svg('hugeicons-user-shield-02') }} Usuários</a>
                    <a href={{ route('index.apartamento') }} class="list-group-item list-group-item-action py-2">{{ svg('hugeicons-house-01') }} Apartamentos</a>
                    <a href={{ route('index.morador') }} class="list-group-item list-group-item-action py-2">{{ svg('hugeicons-user-multiple') }} Moradores</a> 
                    <a href={{ route('index.veiculo') }} class="list-group-item list-group-item-action py-2">{{ svg('hugeicons-car-01') }} Veículos</a>
                    <a href={{ route('index.visitante') }} class="list-group-item list-group-item-action py-2">{{ svg('hugeicons-validation-approval') }} Visitantes</a>
                    <a href="#" class="list-group-item list-group-item-action py-2">{{ svg('hugeicons-note-01') }} Histórico de Acessos</a>
                    <a href="#" class="list-group-item list-group-item-action py-2">{{ svg('hugeicons-calendar-01')}} Reservas</a>
                    <a href="#" class="list-group-item list-group-item-action py-2">{{ svg('hugeicons-chatting-01')}} Ocorrências</a>
                    <a href="#" class="list-group-item list-group-item-action py-2">{{ svg('hugeicons-repair') }} Serviços</a>
                    <a href="#" class="list-group-item list-group-item-action py-2">{{ svg('hugeicons-package-delivered')}} Correspondências</a>
                    <a href="#" class="list-group-item list-group-item-action py-2">{{ svg('hugeicons-notification-01')}} Notificações</a>
                    <a href="#" class="list-group-item list-group-item-action py-2">{{ svg('hugeicons-settings-01')}} Configurações
                    </a>
                @endif
            </div>
        </div>
    </nav>
    <!-- Sidebar -->

    <!-- Navbar -->
    <nav id="main-navbar" class="navbar navbar-expand-lg navbar-dark fixed-top">
        <!-- Container wrapper -->
        <div class="container-fluid">
            <!-- Toggle button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#sidebarMenu"
                aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                {{ svg('hugeicons-menu-01') }}
            </button>

            <!-- Brand -->
            <a class="navbar-brand" href="#">
                <img src={{Vite::asset('/resources/images/logo_sm.png')}} alt="Secure Access" class="w-75 px-3 d-none d-sm-none d-lg-block" loading="lazy">
            </a>

            <!-- Right links -->
            <ul class="navbar-nav ms-auto d-flex flex-row align-items-center">
                <!-- Notification dropdown -->
                <li class="nav-item dropdown m-3">
                <a class="nav-link dropdown-toggle hidden-arrow" href="#" id="navbarDropdownMenuLink"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ svg('hugeicons-notification-01') }}
                    <span class="badge rounded-pill badge-notification bg-danger">1</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="#">Notificações</a></li>
                </ul>
                </li>

                <!-- Avatar -->
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center" href="#"
                    id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://mdbootstrap.com/img/Photos/Avatars/img (31).jpg" class="rounded-circle" height="22"
                    alt="" loading="lazy" />
                    @if (auth()->check())
                        <p class="text-white m-3">{{ Auth::user()->nome }}</p>
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                    <li>
                    @if (auth()->check())
                        {{ session()->get('success') }}
                        <a href={{ route('login.destroy') }} class="btn w-100">{{ svg('hugeicons-logout-04') }} Deslogar</a>
                    @endif
                    </li>
                </ul>
                </li>
            </ul>
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->
</header>
<!--Main Navigation-->

<!--Main layout-->
<main style="margin-top: 90px">
    <div class="m-0 p-0">
        @yield('page_dashboard')
    </div>
</main>
<!--Main layout-->
   
@endsection

