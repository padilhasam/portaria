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

<header class="header-content">
    <div>
        <h3>{{ $edit ? "Alterar" : "Cadastrar" }} Usuários</h3>
    </div>
</header>
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    {{-- Exibir sucesso --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <form action="{{ $edit ? route('update.usuario', ['id' => $usuario->id]) : route('store.usuario') }}" method="POST">
        @csrf
        @if ($edit)
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="nome">Nome Completo</label>
            <input name="nome" type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" placeholder="Nome Completo" value="{{ old('nome', $edit ? $usuario->nome : '') }}">
        </div>
        @error('nome')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <div class="form-group">
            <label for="documento">CPF</label>
            <input name="documento" type="text" class="form-control @error('documento') is-invalid @enderror" id="documento" placeholder="CPF" value="{{ old('documento', $edit ? $usuario->documento : '') }}">
        </div>
        @error('documento')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <div class="form-group">
            <label for="nascimento">Data de Nascimento</label>
            <input name="nascimento" type="date" class="form-control @error('nascimento') is-invalid @enderror" id="nascimento" placeholder="Data de Nascimento" value="{{ old('nascimento', $edit ? $usuario->nascimento : '') }}">
        </div>
        @error('nascimento')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <div class="form-group">
            <label for="celular">Celular</label>
            <input name="celular" type="text" class="form-control @error('celular') is-invalid @enderror" id="celular" placeholder="WhatsApp" value="{{ old('celular', $edit ? $usuario->celular : '') }}">
        </div>
        @error('celular')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <div class="form-group">
            <label for="user">Usuario</label>
            <input name="user" type="text" class="form-control @error('user') is-invalid @enderror" id="user" placeholder="Digite um usuário" value="{{ old('user', $edit ? $usuario->user : '') }}">
        </div>
        @error('user')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <div class="form-group">
            <label for="email">Email</label>
            <input name="email" type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Digite um email de usuário" value="{{ old('email', $edit ? $usuario->email : '') }}">
        </div>
        @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <div class="form-group">
            <label for="password">Senha</label>
            <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Digite uma senha">
        </div>
        @error('password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <div class="form-group">
            <label for="password_confirmation">Repetir Senha</label>
            <input name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Repita a sua senha">
        </div>
        @error('password_confirmation')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <div class="form-group">
            <label for="acesso_tipo">Status</label>
            <!-- TROCAR POR CHECK BOX -->
            <select class="form-control" name="acesso_tipo" id="acesso_tipo">
                <option value="" selected>Selecione</option>
                <option value="liberado" {{ $edit && $usuario->acesso_tipo == "liberado" ? "selected" : "" }}>Liberado</option>
                <option value="bloqueado" {{ $edit && $usuario->acesso_tipo == "bloqueado" ? "selected" : "" }}>Bloqueado</option>
                <option value="ferias" {{ $edit && $usuario->acesso_tipo == "ferias" ? "selected" : "" }}>Férias</option>
            </select>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-dark">{{ $edit ? "Alterar" : "Salvar" }}</button>
            <button type="reset" class="btn btn-dark">Limpar</button>
        </div>
    </form>
</div>

@endsection