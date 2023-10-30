@extends('layouts.app')

@section('dashboard') <!-- Corpo padrão -->
    @vite(['resources/css/nav.css'])
    <div class="container-fluid w-100 h-100">
        <div class="row">
            <nav class="lateral-nav col-3 col-sm-2 vh-100 p-0">
                <img src={{Vite::asset('/resources/images/logo.png')}} alt="Guardião Patrimonial" class="p-4 w-100">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 w-100">
                    <li class="mb-2">
                        <button class="btn border-0 text-white w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            Cadastros
                        </button>
                        <div class="collapse p-2" id="collapseExample">
                            @if (auth()->check())
                                <a href={{ route('create.morador') }} class="btn text-white p-0 m-0 w-100 mb-1">Cadastro morador</a>
                                <a href={{ route('create.visitante') }} class="btn text-white p-0 m-0 w-100 mb-1">Cadastro visitante</a>
                            @endif
                        </div>
                    </li>
                    <li class="mb-2">
                        @if (auth()->check())
                            {{ session()->get('success') }}
                            <a href={{ route('login.destroy') }} class="btn text-white w-100">Sair</a>
                        @endif
                    </li>
                </ul>
            </nav>
            
            <div class="col-9 col-sm-10">
                @yield('page_dashboard')
            </div>
        </div>
    </div>
   
@endsection