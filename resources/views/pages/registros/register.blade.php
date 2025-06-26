@extends('layouts.dashboard')

@section('page_dashboard')

@php
    $edit = isset($registro) ? true : false;
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
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-key-fill" viewBox="0 0 16 16">
                <path d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2M2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
              </svg>
        </span>
        {{ $edit ? "Editar Registro" : "Novo Registro" }}
    </h3>
    <div>
        <a href="{{ route('index.registro') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
              </svg> Voltar
        </a>
    </div>
</header>

<div class="card shadow-sm p-2">
    <form
        action="{{ $edit ? route('update.registro', ['id' => $registro->id]) : route('store.registro') }}"
        method="POST"
        enctype="multipart/form-data"
        id="registroForm"
    >
        @csrf
        @if ($edit)
            @method('PUT')
        @endif

        <div class="card shadow-sm mb-2">
            <div class="card-header bg-light fw-bold">
                Dados Pessoais
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="row g-3">
                            <div class="col-md-6">
                                    <label for="id_visitante" class="form-label">Nome</label>
                                    <select class="form-select rounded-pill border-dark" id="id_visitante_registros" name="id_visitante">
                                        <option value="">Selecione o visitante...</option>
                                        @foreach ($visitantes as $visitante)
                                            <option value="{{ $visitante->id }}"
                                                {{ old('id_visitante', $edit ? $visitante->id_visitante : '') == $visitante->id ? 'selected' : '' }}>
                                                {{ $visitante->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="nome" id="nome"/>
                                </div>

                                <div class="col-md-6">
                                    <label for="documento" class="form-label">CPF</label>
                                    <input type="text" class="form-control rounded-pill border-dark" id="documento" name="documento" value="{{ old('documento', $edit ? $registro->documento : '') }}" placeholder="CPF" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="empresa" class="form-label">Empresa</label>
                                    <input
                                        type="text"
                                        class="form-control rounded-pill border-dark bg-light"
                                        id="empresa"
                                        name="empresa"
                                        value="{{ old('empresa', $edit && $registro->visitante && $registro->visitante->prestador ? $registro->visitante->prestador->empresa : '') }}"
                                        placeholder="Empresa Prestadora"
                                        readonly
                                    >
                                </div>

                                <div class="col-md-6">
                                    <label for="veiculo" class="form-label">Veículo</label>
                                    <input type="text" class="form-control rounded-pill border-dark" id="veiculo" name="veiculo" value="{{ old('veiculo', $edit ? $registro->veiculo : '') }}" placeholder="Modelo do veículo">
                                </div>

                                <div class="col-md-6">
                                    <label for="placa" class="form-label">Placa</label>
                                    <input type="text" class="form-control rounded-pill border-dark" id="placa" name="placa" value="{{ old('placa', $edit ? $registro->placa : '') }}" placeholder="Placa do veículo ">
                                </div>

                                <div class="col-md-6">
                                    <label for="tipo_acesso" class="form-label">Tipo de Acesso</label>
                                    <select class="form-select rounded-pill border-dark" name="tipo_acesso" id="tipo_acesso">
                                        <option value="">Selecione o tipo de acesso...</option>
                                        @foreach (['visita', 'entrega', 'mudança', 'manutenção', 'abastecimento', 'limpeza', 'dedetização'] as $tipo)
                                            <option value="{{ $tipo }}" {{ old('tipo_acesso', $registro->tipo_acesso ?? '') == $tipo ? 'selected' : '' }}>
                                                {{ ucfirst($tipo) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label for="observacoes" class="form-label">Observação</label>
                                    <textarea class="form-control rounded-4 border-dark" name="observacoes" id="observacoes" rows="4" style="resize: none">{{ old('observacoes', $edit ? $registro->observacoes : '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Foto --}}
                        <div class="col-lg-3">
                            <div class="card h-100 shadow-sm p-3 text-center d-flex flex-column justify-content-between">
                                <label class="form-label"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-camera2" viewBox="0 0 16 16">
                                    <path d="M5 8c0-1.657 2.343-3 4-3V4a4 4 0 0 0-4 4"/>
                                    <path d="M12.318 3h2.015C15.253 3 16 3.746 16 4.667v6.666c0 .92-.746 1.667-1.667 1.667h-2.015A5.97 5.97 0 0 1 9 14a5.97 5.97 0 0 1-3.318-1H1.667C.747 13 0 12.254 0 11.333V4.667C0 3.747.746 3 1.667 3H2a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1h.682A5.97 5.97 0 0 1 9 2c1.227 0 2.367.368 3.318 1M2 4.5a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0M14 8A5 5 0 1 0 4 8a5 5 0 0 0 10 0"/>
                                </svg></label>
                                <div>
                                    <img id="image" src="{{ Vite::asset('/resources/images/avatar2.png') }}" class="img-fluid rounded mb-3 border" alt="Foto">
                                </div>
                            </div>
                        </div>

                        {{-- Botões --}}
                        <div class="col-12 d-flex gap-2 justify-content-end mt-3">
                            <button type="submit" class="btn btn-success rounded-pill">{{ $edit ? "Alterar" : "Salvar" }}</button>
                            <button type="reset" class="btn btn-outline-danger rounded-pill">Limpar</button>
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-4 me-2">Cancelar</a>
                        </div>

        {{-- Modal da câmera --}}
        @include('components.modal-camera')
    </form>
</div>

@endsection
