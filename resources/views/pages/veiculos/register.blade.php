@extends('layouts.dashboard')

@section('page_dashboard')

@php
    $edit = isset($veiculo) ? true : false;
@endphp

<header class="header-content">
    <div>
        <h3>{{ $edit ? "Alterar" : "Cadastrar" }} veiculo</h3>
    </div>
</header>
<div class="container">
    <form action="{{ $edit ? route('update.veiculo', ['id' => $veiculo->id]) : route('store.veiculo') }}" method="POST">
        @csrf
        @if ($edit)
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="placa">Placa</label>
            <input name="placa" type="text" class="form-control" id="placa" placeholder="" value="{{ $edit ? $veiculo->placa : "" }}">
        </div>
        <div class="form-group">
            <label for="tipo">Tipo veículo</label>
            <select class="form-control" name="tipo" id="tipo">
                <option value="">Selecione...</option>
                <option value="carro" {{ $edit && $veiculo->tipo == "carro" ? "selected" : "" }}>Carro</option>
                <option value="moto" {{ $edit && $veiculo->tipo == "moto" ? "selected" : "" }}>Moto</option>
                <option value="caminhão" {{ $edit && $veiculo->tipo == "caminhão" ? "selected" : "" }}>Caminhão</option>
            </select>
        </div>
        <div class="form-group">
            <label for="marca">Marca</label>
            <input name="marca" type="text" class="form-control" id="marca" placeholder="" value="{{ $edit ? $veiculo->marca : "" }}">
        </div>
        <div class="form-group">
            <label for="modelo">Modelo</label>
            <input name="modelo" type="text" class="form-control" id="modelo" placeholder="" value="{{ $edit ? $veiculo->modelo : "" }}">
        </div>
        <div class="form-group">
            <label for="cor">Cor</label>
            <input name="cor" type="text" class="form-control" id="cor" placeholder="" value="{{ $edit ? $veiculo->cor : "" }}">
        </div>
        <div class="form-group">
            <label for="observacao">Observação</label>
            <input name="observacao" type="text" class="form-control" id="observacao" placeholder="" value="{{ $edit ? $veiculo->observacao : "" }}">
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">{{ $edit ? "Alterar" : "Cadastrar" }}</button>
            <button type="reset" class="btn btn-primary">Limpar</button>
        </div>
    </form>
</div>

@endsection