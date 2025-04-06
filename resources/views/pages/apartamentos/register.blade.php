@extends('layouts.dashboard')

@section('page_dashboard')

@php
    $edit = isset($apartamento) ? true : false;
@endphp

<header class="header-content">
    <div>
        <h3>{{ $edit ? "Alterar" : "Cadastrar" }} apartamento</h3>
    </div>
</header>
<div class="container">
    <form action="{{ $edit ? route('update.apartamento', ['id' => $apartamento->id]) : route('store.apartamento') }}" method="POST">
        @csrf
        @if ($edit)
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="numero">Número Apartamento</label>
            <input name="numero" type="text" class="form-control" id="numero" placeholder="Número do apartamento" value="{{ $edit ? $apartamento->numero : "" }}">
        </div>
        <div class="form-group">
            <label for="bloco">Bloco</label>
            <input name="bloco" type="text" class="form-control" id="bloco" placeholder="Digite o bloco do apartamento" value="{{ $edit ? $apartamento->bloco : "" }}">
        </div>
        <div class="form-group">
            <label for="vaga">Número de Vagas</label>
            <input name="vaga" type="text" class="form-control" id="vaga" placeholder="Vagas" value="{{ $edit ? $apartamento->vaga : "" }}">
        </div>
        <div class="form-group">
            <label for="ramal">Ramal</label>
            <input name="ramal" type="text" class="form-control" id="ramal" placeholder="Ramal" value="{{ $edit ? $apartamento->ramal : "" }}">
        </div>
        <div class="form-group">
            <label for="status_vaga">Status da vaga</label>
            <select class="form-control" name="status_vaga" id="status_vaga">
                <option value="livre" {{ $edit && $apartamento->status_vaga == "livre" ? "selected" : "" }}>Livre</option>
                <option value="ocupada" {{ $edit && $apartamento->status_vaga == "ocupada" ? "selected" : "" }}>Ocupada</option>
                <option value="emprestada" {{ $edit && $apartamento->status_vaga == "emprestada" ? "selected" : "" }}>Emprestada</option>
                <option value="alugada" {{ $edit && $apartamento->status_vaga == "alugada" ? "selected" : "" }}>Alugada</option>
            </select>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-dark">{{ $edit ? "Alterar" : "Cadastrar" }}</button>
            <button type="reset" class="btn btn-dark">Limpar</button>
        </div>
    </form>
</div>

@endsection