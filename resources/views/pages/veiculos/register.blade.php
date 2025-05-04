@extends('layouts.dashboard')

@section('page_dashboard')

@php
    $edit = isset($veiculo) ? true : false;
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
    <h3 class="m-0 fw-bold text-dark">
        {{ $edit ? "Alterar" : "Cadastrar" }} Veículo
    </h3>
</header>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body">
        <form action="{{ $edit ? route('update.veiculo', ['id' => $veiculo->id, 'from' => request()->query('from')]) : route('store.veiculo', ['from' => request()->query('from')]) }}" method="POST">
            @csrf
            @if ($edit)
                @method('PUT')
            @endif

            <div class="form-group mb-3">
                <label for="placa">Placa</label>
                <input name="placa" type="text" class="form-control" id="placa" placeholder="Placa do veículo" value="{{ $edit ? $veiculo->placa : '' }}">
            </div>

            <div class="form-group mb-3">
                <label for="tipo">Tipo do Veículo</label>
                <select class="form-control" name="tipo" id="tipo">
                    <option value="">Selecione...</option>
                    <option value="carro" {{ $edit && $veiculo->tipo == "carro" ? "selected" : "" }}>Carro</option>
                    <option value="moto" {{ $edit && $veiculo->tipo == "moto" ? "selected" : "" }}>Moto</option>
                    <option value="caminhão" {{ $edit && $veiculo->tipo == "caminhão" ? "selected" : "" }}>Caminhão</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="marca">Marca</label>
                <input name="marca" type="text" class="form-control" id="marca" placeholder="Marca do veículo" value="{{ $edit ? $veiculo->marca : '' }}">
            </div>

            <div class="form-group mb-3">
                <label for="modelo">Modelo</label>
                <input name="modelo" type="text" class="form-control" id="modelo" placeholder="Modelo do veículo" value="{{ $edit ? $veiculo->modelo : '' }}">
            </div>

            <div class="form-group mb-3">
                <label for="cor">Cor</label>
                <input name="cor" type="text" class="form-control" id="cor" placeholder="Cor do veículo" value="{{ $edit ? $veiculo->cor : '' }}">
            </div>

            <div class="form-group mb-3">
                <label for="observacao">Observação</label>
                <input name="observacao" type="text" class="form-control" id="observacao" placeholder="Observações adicionais" value="{{ $edit ? $veiculo->observacao : '' }}">
            </div>

            <div class="mt-4 d-flex justify-content-between">
                <button type="submit" class="btn btn-dark">{{ $edit ? "Alterar" : "Cadastrar" }}</button>
                <button type="reset" class="btn btn-outline-dark">Limpar</button>
            </div>
        </form>
    </div>
</div>

@endsection