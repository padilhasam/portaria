@extends('layouts.dashboard')

@section('page_dashboard')

@php
    $edit = isset($usuario) ? true : false;
@endphp

@if(session('success'))
    <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
@endif

@if(session('error'))
    <div id="error-alert" class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
@endif

@if($errors->any())
    <div id="validation-alert" class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $erro)
                <li>{{ $erro }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
@endif

<header class="mb-2 px-4 py-3 bg-white border rounded shadow-sm d-flex align-items-center justify-content-between">
    <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3">
        <span class="icon-container" style="width: 32px; height: 32px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-house-add-fill" viewBox="0 0 16 16">
                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 1 1-1 0v-1h-1a.5.5 0 1 1 0-1h1v-1a.5.5 0 0 1 1 0"/>
                <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/>
                <path d="m8 3.293 4.712 4.712A4.5 4.5 0 0 0 8.758 15H3.5A1.5 1.5 0 0 1 2 13.5V9.293z"/>
              </svg>
        </span>
        {{ $edit ? "Alterar Usuários" : "Cadastrar Usuários" }}
    </h3>
    <div class="d-flex align-items-center gap-3">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm rounded-pill">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
              </svg> Voltar
        </a>
    </div>
</header>

<div class="card shadow-sm p-4">
    <form action="{{ $edit ? route('update.usuario', ['id' => $usuario->id]) : route('store.usuario') }}" method="POST">
        @csrf
        @if ($edit)
            @method('PUT')
        @endif

        <div class="card shadow-sm mb-2">
            <div class="card-header bg-light fw-bold">Dados Usuário</div>
                <div class="card-body row g-3">
                
                <div class="col-md-4">
                    <label for="nome">Nome Completo</label>
                    <input name="nome" type="text" class="form-control rounded-pill border-dark" @error('nome') is-invalid @enderror id="nome" placeholder="Nome Completo" value="{{ old('nome', $edit ? $usuario->nome : '') }}">
                </div>
                @error('nome')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <div class="col-md-4">
                    <label for="documento">CPF</label>
                    <input name="documento" type="text" class="form-control rounded-pill border-dark" @error('documento') is-invalid @enderror" id="documento" placeholder="CPF" value="{{ old('documento', $edit ? $usuario->documento : '') }}">
                </div>
                @error('documento')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <div class="col-md-4">
                    <label for="nascimento">Data de Nascimento</label>
                    <input name="nascimento" type="date" class="form-control rounded-pill border-dark" @error('nascimento') is-invalid @enderror id="nascimento" placeholder="Data de Nascimento" value="{{ old('nascimento', $edit ? $usuario->nascimento : '') }}">
                </div>
                @error('nascimento')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <div class="col-md-4">
                    <label for="celular">Celular</label>
                    <input name="celular" type="text" class="form-control rounded-pill border-dark" @error('celular') is-invalid @enderror id="celular" placeholder="WhatsApp" value="{{ old('celular', $edit ? $usuario->celular : '') }}">
                </div>
                @error('celular')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <div class="col-md-4">
                    <label for="user">Usuario</label>
                    <input name="user" type="text" class="form-control rounded-pill border-dark" @error('user') is-invalid @enderror id="user" placeholder="Digite um usuário" value="{{ old('user', $edit ? $usuario->user : '') }}">
                </div>
                @error('user')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <div class="col-md-4">
                    <label for="email">Email</label>
                    <input name="email" type="text" class="form-control rounded-pill border-dark" @error('email') is-invalid @enderror placeholder="Digite um email de usuário" value="{{ old('email', $edit ? $usuario->email : '') }}">
                </div>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <div class="col-md-4">
                    <label for="password">Senha</label>
                    <input name="password" type="password" class="form-control rounded-pill border-dark" @error('password') is-invalid @enderror id="password" placeholder="Digite uma senha">
                </div>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <div class="col-md-4">
                    <label for="password_confirmation">Repetir Senha</label>
                    <input name="password_confirmation" type="password" class="form-control rounded-pill border-dark" @error('password_confirmation') is-invalid @enderror id="password_confirmation" placeholder="Repita a sua senha">
                </div>
                @error('password_confirmation')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <div class="col-md-4">
                    <label for="acesso_tipo">Status</label>
                    <!-- TROCAR POR CHECK BOX -->
                    <select class="form-control rounded-pill border-dark" name="acesso_tipo" id="acesso_tipo">
                        <option value="" selected>Selecione</option>
                        <option value="liberado" {{ $edit && $usuario->acesso_tipo == "liberado" ? "selected" : "" }}>Liberado</option>
                        <option value="bloqueado" {{ $edit && $usuario->acesso_tipo == "bloqueado" ? "selected" : "" }}>Bloqueado</option>
                        <option value="ferias" {{ $edit && $usuario->acesso_tipo == "ferias" ? "selected" : "" }}>Férias</option>
                    </select>
                </div>
                {{-- BOTÕES --}}
                <div class="col-12 d-flex gap-2 justify-content-end mt-3">
                    <button type="submit" class="btn btn-success rounded-pill">{{ $edit ? "Alterar" : "Salvar" }}</button>
                    <button type="reset" class="btn btn-outline-danger rounded-pill" onclick="return confirm('Tem certeza que deseja limpar o formulário?')">Limpar</button>
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-4 me-2">Cancelar</a>
                </div>
    </form>
</div>

@endsection