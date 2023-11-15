@extends('layouts.dashboard')

@section('page_dashboard')

@php
    $edit = isset($apartamento) ? true : false;
@endphp

<header class="header-content">
    <div>
        <h3>{{ $edit ? "Alterar" : "Cadastrar" }} morador</h3>
    </div>
</header>
<div class="container">
    <form action="{{route('store.morador')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nome_completo">Nome Completo: </label>
            <input name="name" type="text" class="form-control" id="nome_morador" placeholder="Digite o Nome Completo do Morador...">
        </div>
        <div class="form-group">
            <label for="cpf">CPF: </label>
            <input name="cpf" type="text" class="form-control" id="cpf" placeholder="000.000.000-00">
        </div>
        <div class="form-group">
            <label for="data_nascimento_morador">Data de Nascimento: </label>
            <input name="birthdate" type="date" class="form-control" id="data_nasc_morador" placeholder="Data de Nascimento">
        </div>
        <div class="form-group">
            <label for="telefone">Celular: </label>
            <input name="telefone" type="tel" class="form-control" id="telefone_morador" placeholder="(00)0000-0000">
        </div>
        <div class="form-group">
            <label for="email">Email: </label>
            <input name="email" type="paemail" class="form-control" id="email" placeholder="email@email.com.br">
        </div>
        {{-- <div class="form-group">
            <label for="exampleInputPassword1">Foto: </label>
            <input type="file" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div> --}}
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Cadastrar</button>
            <button type="reset" class="btn btn-primary">Limpar</button>
        </div>
    </form>
</div>

@endsection