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
    <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3">
        <span class="icon-container" style="width: 32px; height: 32px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-truck-front-fill" viewBox="0 0 16 16">
                <path d="M3.5 0A2.5 2.5 0 0 0 1 2.5v9c0 .818.393 1.544 1 2v2a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5V14h6v1.5a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-2c.607-.456 1-1.182 1-2v-9A2.5 2.5 0 0 0 12.5 0zM3 3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3.9c0 .625-.562 1.092-1.17.994C10.925 7.747 9.208 7.5 8 7.5s-2.925.247-3.83.394A1.008 1.008 0 0 1 3 6.9zm1 9a1 1 0 1 1 0-2 1 1 0 0 1 0 2m8 0a1 1 0 1 1 0-2 1 1 0 0 1 0 2m-5-2h2a1 1 0 1 1 0 2H7a1 1 0 1 1 0-2"/>
            </svg>
        </span>
        {{ $edit ? "Editar Veículo" : "Cadastrar Veículo" }}
    </h3>
    <div>
        <a href="{{ route('index.veiculo') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
            </svg> Voltar
        </a>
    </div>
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
                    <option value="Carro" {{ $edit && $veiculo->tipo == "Carro" ? "selected" : "" }}>Carro</option>
                    <option value="Moto" {{ $edit && $veiculo->tipo == "Moto" ? "selected" : "" }}>Moto</option>
                    <option value="Caminhão" {{ $edit && $veiculo->tipo == "Caminhão" ? "selected" : "" }}>Caminhão</option>
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