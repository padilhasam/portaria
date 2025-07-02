@extends('layouts.dashboard')

@section('page_dashboard')

@php
    $edit = isset($agendamento);
    $inicioPermitido = config('agendamento.horario_inicio', 7);
    $fimPermitido = config('agendamento.horario_fim', 22);
@endphp

@include('components.alerts')

<header class="mb-3 px-4 py-3 bg-white border rounded shadow-sm d-flex align-items-center justify-content-between">
    <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3">
        <span class="icon-container" style="width: 32px; height: 32px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-truck-front-fill" viewBox="0 0 16 16">
                <path d="M3.5 0A2.5 2.5 0 0 0 1 2.5v9c0 .818.393 1.544 1 2v2a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5V14h6v1.5a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-2c.607-.456 1-1.182 1-2v-9A2.5 2.5 0 0 0 12.5 0zM3 3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3.9c0 .625-.562 1.092-1.17.994C10.925 7.747 9.208 7.5 8 7.5s-2.925.247-3.83.394A1.008 1.008 0 0 1 3 6.9zm1 9a1 1 0 1 1 0-2 1 1 0 0 1 0 2m8 0a1 1 0 1 1 0-2 1 1 0 0 1 0 2m-5-2h2a1 1 0 1 1 0 2H7a1 1 0 1 1 0-2"/>
            </svg>
        </span>
        {{ $edit ? "Editar Agendamento" : "Cadastrar Agendamento" }}
    </h3>
    <div>
        <a href="{{ route('index.agendamento') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
            </svg> Voltar
        </a>
    </div>
</header>

<div class="card shadow-sm mb-4">
            <div class="card-header bg-light fw-bold">Dados do Agendamento</div>
                <div class="card-body">

            <div class="card shadow-sm p-4">
                <form action="{{ $edit ? route('update.agendamento', ['id' => $agendamento->id, 'from' => request()->query('from')]) : route('store.agendamento', ['from' => request()->query('from')]) }}" method="POST" novalidate>
                    @csrf
                    @if ($edit)
                        @method('PUT')
                    @endif

                    <div class="row g-3 mb-4">

                        <div class="col-md-6">
                            <label for="id_morador" class="form-label fw-semibold">Morador <span class="text-danger">*</span></label>
                            <select name="id_morador" id="id_morador" class="form-select rounded-pill border-dark @error('id_morador') is-invalid @enderror" required>
                                <option value="" disabled {{ old('id_morador', $agendamento->id_morador ?? '') === null ? 'selected' : '' }}>Selecione o morador...</option>
                                @foreach($moradores as $morador)
                                    <option value="{{ $morador->id }}"
                                        {{ old('id_morador', $agendamento->id_morador ?? '') == $morador->id ? 'selected' : '' }}>
                                        {{ $morador->nome }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_morador')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="nome_area" class="form-label fw-semibold">Área Comum <span class="text-danger">*</span></label>
                            <select name="nome_area" id="nome_area" class="form-select rounded-pill border-dark @error('nome_area') is-invalid @enderror" required>
                                <option value="" disabled {{ old('nome_area', $agendamento->nome_area ?? '') === null ? 'selected' : '' }}>Selecione a área...</option>
                                <option value="Churrasqueira" {{ old('nome_area', $agendamento->nome_area ?? '') == 'Churrasqueira' ? 'selected' : '' }}>Churrasqueira</option>
                                <option value="Quadra" {{ old('nome_area', $agendamento->nome_area ?? '') == 'Quadra' ? 'selected' : '' }}>Quadra</option>
                                <option value="Piscina" {{ old('nome_area', $agendamento->nome_area ?? '') == 'Piscina' ? 'selected' : '' }}>Piscina</option>
                                <option value="Academia" {{ old('nome_area', $agendamento->nome_area ?? '') == 'Academia' ? 'selected' : '' }}>Academia</option>
                                <option value="Sala de Jogos" {{ old('nome_area', $agendamento->nome_area ?? '') == 'Sala de Jogos' ? 'selected' : '' }}>Sala de Jogos</option>
                                <option value="Biblioteca" {{ old('nome_area', $agendamento->nome_area ?? '') == 'Biblioteca' ? 'selected' : '' }}>Biblioteca</option>
                            </select>
                            @error('nome_area')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="data_agendamento" class="form-label fw-semibold">Data do Agendamento <span class="text-danger">*</span></label>
                            <input type="date" name="data_agendamento" id="data_agendamento" required
                                class="form-control rounded-pill border-dark @error('data_agendamento') is-invalid @enderror"
                                value="{{ old('data_agendamento', $agendamento->data_agendamento ?? '') }}">
                            @error('data_agendamento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="horario_inicio" class="form-label fw-semibold">Horário de Início <span class="text-danger">*</span></label>
                            <input type="time" name="horario_inicio" id="horario_inicio" required
                                min="{{ sprintf('%02d:00', $inicioPermitido) }}" max="{{ sprintf('%02d:00', $fimPermitido) }}"
                                class="form-control rounded-pill border-dark @error('horario_inicio') is-invalid @enderror"
                                value="{{ old('horario_inicio', $agendamento->horario_inicio ?? '') }}">
                            @error('horario_inicio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="horario_fim" class="form-label fw-semibold">Horário de Término <span class="text-danger">*</span></label>
                            <input type="time" name="horario_fim" id="horario_fim" required
                                min="{{ sprintf('%02d:00', $inicioPermitido) }}" max="{{ sprintf('%02d:00', $fimPermitido) }}"
                                class="form-control rounded-pill border-dark @error('horario_fim') is-invalid @enderror"
                                value="{{ old('horario_fim', $agendamento->horario_fim ?? '') }}">
                            @error('horario_fim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="observacoes" class="form-label fw-semibold">Observações</label>
                            <textarea name="observacoes" id="observacoes" rows="4" class="form-control rounded-4 border-dark @error('observacoes') is-invalid @enderror" style="resize: none;">{{ old('observacoes', $agendamento->observacoes ?? '') }}</textarea>
                            @error('observacoes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-success rounded-pill px-4">{{ $edit ? "Alterar" : "Cadastrar" }}</button>
                        <button type="reset" class="btn btn-outline-danger rounded-pill px-4" onclick="return confirm('Tem certeza que deseja limpar o formulário?')">Limpar</button>
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-4">Cancelar</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
