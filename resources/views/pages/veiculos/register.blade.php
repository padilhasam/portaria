@extends('layouts.dashboard')

@section('page_dashboard')

@php
    $edit = isset($veiculo) ? true : false;
@endphp

@include('components.alerts')

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

<div class="card shadow-sm mb-4">
    <div class="card-header bg-light fw-bold">Dados do Veículo</div>
        <div class="card-body">

            <div class="card shadow-sm p-4">
                <form action="{{ $edit ? route('update.veiculo', ['id' => $veiculo->id, 'from' => request()->query('from')]) : route('store.veiculo', ['from' => request()->query('from')]) }}" method="POST">
                    @csrf
                    @if ($edit)
                        @method('PUT')
                    @endif

                    <div class="row mb-3">

                    <div class="col-md-2">
                        <label for="placa" class="form-label fw-semibold">Placa do Veículo<span class="text-danger">*</span></label>
                        <input type="text" id="placa" name="placa" class="form-control rounded-pill border-dark" placeholder="Placa do Veículo" value="{{ $edit ? $veiculo->placa : '' }}" required>
                    </div>

                    <div class="col-md-2">
                        @php
                            $tipoPlaca = old('tipo_placa') ?? ($edit ? $veiculo->tipo_placa : 'comum');
                        @endphp

                        <label class="form-label fw-semibold d-block">Tipo da Placa<span class="text-danger">*</span></label>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo_placa" id="tipoComum" value="comum"
                                {{ $tipoPlaca === 'comum' ? 'checked' : '' }}>
                            <label class="form-check-label" for="tipoComum">
                                Comum
                            </label>
                        </div>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="tipo_placa" id="tipoMercosul" value="mercosul"
                                {{ $tipoPlaca === 'mercosul' ? 'checked' : '' }}>
                            <label class="form-check-label" for="tipoMercosul">
                                Mercosul
                            </label>
                        </div>
                    </div>

                     <div class="col-md-2">
                        <label class="form-label fw-semibold d-block">Modelo</label>
                        <div id="placa-icon" class="mt-2">
                            <img src="{{ Vite::asset('/resources/images/comum-icon.png') }}" alt="Modelo Comum" class="d-none" id="comum-icon">
                            <img src="{{ Vite::asset('/resources/images/mercosul-icon.png') }}" alt="Modelo Mercosul" class="d-none" id="mercosul-icon">
                        </div>
                    </div>
                        <div class="col-md-6">
                            <label for="tipo" class="form-label fw-semibold">Tipo do Veículo<span class="text-danger">*</span></label>
                            <select class="form-control rounded-pill border-dark" name="tipo" id="tipo" required>
                                <option value="">Selecione...</option>
                                <option value="Carro" {{ $edit && $veiculo->tipo == "Carro" ? "selected" : "" }}>Carro</option>
                                <option value="Moto" {{ $edit && $veiculo->tipo == "Moto" ? "selected" : "" }}>Moto</option>
                                <option value="Caminhão" {{ $edit && $veiculo->tipo == "Caminhão" ? "selected" : "" }}>Caminhão</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="marca" class="form-label fw-semibold">Marca<span class="text-danger">*</span></label>
                            <input name="marca" type="text" class="form-control rounded-pill border-dark" id="marca" placeholder="Marca do veículo" value="{{ $edit ? $veiculo->marca : '' }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="modelo" class="form-label fw-semibold">Modelo<span class="text-danger">*</span></label>
                            <input name="modelo" type="text" class="form-control rounded-pill border-dark" id="modelo" placeholder="Modelo do veículo" value="{{ $edit ? $veiculo->modelo : '' }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="cor" class="form-label fw-semibold">Cor<span class="text-danger">*</span></label>
                            <input name="cor" type="text" class="form-control rounded-pill border-dark" id="cor" placeholder="Cor do veículo" value="{{ $edit ? $veiculo->cor : '' }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="observacoes" class="form-label fw-semibold">Observação</label>
                            <textarea class="form-control rounded-4 border-dark" name="observacoes" id="observacoes" rows="4" style="resize: none">{{ old('observacoes', $edit ? $veiculo->observacoes : '') }}</textarea>
                        </div>
                    </div>

                    <div class="col-12 d-flex gap-2 justify-content-end mt-3">
                        <button type="submit" class="btn btn-success rounded-pill px-4 me-2">{{ $edit ? "Alterar" : "Cadastrar" }}</button>
                        <button type="reset" class="btn btn-outline-danger rounded-pill px-4 me-2">Limpar</button>
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-4 me-2">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
