@extends('layouts.dashboard')

@section('page_dashboard')

@php
    $edit = isset($usuario) ? true : false;
@endphp

<header class="header-content">
    <div>
        <h3>{{ $edit ? "Alterar" : "Cadastrar" }} Usuários</h3>
    </div>
</header>
<div class="container">
    <form action="{{ $edit ? route('update.usuario', ['id' => $usuario->id]) : route('store.usuario') }}" method="POST">
        @csrf
        @if ($edit)
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="nome">Nome Completo</label>
            <input name="nome" type="text" class="form-control" id="nome" placeholder="Nome Completo" value="{{ $edit ? $usuario->nome : "" }}">
        </div>
        <div class="form-group">
            <label for="user">Usuario</label>
            <input name="user" type="text" class="form-control" id="user" placeholder="Digite um usuário" value="{{ $edit ? $usuario->user : "" }}">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input name="email" type="text" class="form-control" id="email" placeholder="Digite um email de usuário" value="{{ $edit ? $usuario->email : "" }}">
        </div>
        <div class="form-group">
            <label for="password">Senha</label>
            <input name="password" type="password" class="form-control" id="password" placeholder="Digite uma senha">
        </div>
        <div class="form-group">
            <label for="rep_pass">Repetir Senha</label>
            <input name="password_confirmation" type="password" class="form-control" id="rep_pass" placeholder="Repita a sua senha">
        </div>
        <div class="form-group">
            <label for="acesso_tipo">Tipo de Acesso</label>
            <!-- TROCAR POR CHECK BOX -->
            <select class="form-control" name="acesso_tipo" id="acesso_tipo">
                <option value="" selected>Selecione</option>
                <option value="liberado" {{ $edit && $usuario->acesso_tipo == "liberado" ? "selected" : "" }}>Liberado</option>
                <option value="bloqueado" {{ $edit && $usuario->acesso_tipo == "bloqueado" ? "selected" : "" }}>Bloqueado</option>
                <option value="ferias" {{ $edit && $usuario->acesso_tipo == "ferias" ? "selected" : "" }}>Férias</option>
            </select>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-dark">{{ $edit ? "Alterar" : "Cadastrar" }}</button>
            <button type="reset" class="btn btn-dark">Limpar</button>
        </div>
    </form>
</div>

@endsection