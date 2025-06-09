@extends('layouts.dashboard')

@section('page_dashboard')

@php
    $edit = isset($agendamento) ? true : false;
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
        {{ $edit ? "Editar Agendamentos" : "Cadastrar agendamentos" }}
        </h3>
        <div>
        <a href="{{ route('index.agendamento') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
            </svg> Voltar
        </a>
    </div>
</header>

<div class="card shadow-sm p-4">
    <form action="{{ $edit ? route('update.agendamento', ['id' => $agendamento->id, 'from' => request()->query('from')]) : route('store.agendamento', ['from' => request()->query('from')]) }}" method="POST">
        @csrf
        @if ($edit)
            @method('PUT')
        @endif

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="id_morador" class="form-label">Morador</label>
                <select name="id_morador" id="id_morador" class="form-control rounded-pill border-dark">
                    <option value="">Selecione o morador...</option>
                    @foreach($moradores as $morador)
                        <option value="{{ $morador->id }}"
                            {{ old('id_morador', $agendamento->id_morador ?? '') == $morador->id ? 'selected' : '' }}>
                            {{ $morador->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="nome_area" class="form-label">Área Comum</label>
                <select class="form-control rounded-pill border-dark" name="nome_area" id="nome_area" required>{{ old('nome_area') }}
                    <option value="selecione">Selecione a área...</option>
                    <option value="Churrasqueira">Churrasqueira</option>
                    <option value="Quadra">Quadra</option>
                    <option value="Piscina">Piscina</option>
                    <option value="Academia">Academia</option>
                    <option value="Sala de Jogos">Sala de Jogos</option>
                    <option value="Biblioteca">Biblioteca</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="data_agendamento" class="form-label">Data do Agendamento</label>
                <input type="date" class="form-control rounded-pill border-dark" name="data_agendamento" id="data_agendamento" value="{{ old('data_agendamento') }}" required>
            </div>

            <div class="col-md-4">
                <div>
                    <label for="horario_inicio" class="form-label">Horário de Início</label>
                    <input type="time" class="form-control rounded-pill border-dark" name="horario_inicio" id="hora_inicio" min="08:00" max="22:00" value="{{ old('hora_inicio') }}" required>
                </div>
            </div>
            <div class="col-md-4">
                <div>
                    <label for="horario_fim" class="form-label">Horário de Término</label>
                    <input type="time" class="form-control rounded-pill border-dark" name="horario_fim" id="hora_fim" min="08:00" max="22:00" value="{{ old('hora_fim') }}" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label for="observacoes">Observações</label>
                    <textarea class="form-control rounded-4 border-dark" name="observacoes" id="observacoes" rows="4" cols="50" style="resize: none">{{ old('observacoes') }}</textarea>
                </div>
            </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success rounded-pill px-4 me-2">{{ $edit ? "Alterar" : "Cadastrar" }}</button>
            <button type="reset" class="btn btn-outline-danger rounded-pill px-4 me-2">Limpar</button>
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-4 me-2">Cancelar</a>
        </div>
    </form>
</div>

@endsection