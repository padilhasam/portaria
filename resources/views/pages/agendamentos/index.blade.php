@extends('layouts.dashboard')

@section('page_dashboard')

<!-- Cabeçalho -->
<header class="mb-2 px-4 py-3 bg-white border rounded shadow-sm d-flex align-items-center justify-content-between">
    <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3">
        <span class="icon-container" style="width: 32px; height: 32px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-buildings-fill" viewBox="0 0 16 16">
                <path d="M15 .5a.5.5 0 0 0-.724-.447l-8 4A.5.5 0 0 0 6 4.5v3.14L.342 9.526A.5.5 0 0 0 0 10v5.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V14h1v1.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5zM2 11h1v1H2zm2 0h1v1H4zm-1 2v1H2v-1zm1 0h1v1H4zm9-10v1h-1V3zM8 5h1v1H8zm1 2v1H8V7zM8 9h1v1H8zm2 0h1v1h-1zm-1 2v1H8v-1zm1 0h1v1h-1zm3-2v1h-1V9zm-1 2h1v1h-1zm-2-4h1v1h-1zm3 0v1h-1V7zm-2-2v1h-1V5zm1 0h1v1h-1z"/>
            </svg>
        </span>
        Agendamentos de Áreas Comuns
    </h3>
    <a href="{{ route('create.agendamento') }}" class="btn btn-success btn-sm text-white rounded-pill shadow-sm">
        <i class="bi bi-plus-circle me-1"></i> Novo Agendamento
    </a>
</header>

<!-- Alertas -->
@include('components.alerts', [
    'success' => session('success'), 
    'message' => session('message')
])

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body flex-column">
        <h5 class="card-title mb-3 fw-semibold">Lista de Apartamentos</h5>
            <!-- Legenda de Cores das Áreas -->

            <!-- Calendário -->
            <div aria-labelledby="titulo-calendario">
                <div class="card border-0 shadow-sm rounded-4 bg-light-subtle">
                    <div class="card-body p-4">
                        <div id="calendar" aria-live="polite" aria-label="Calendário de agendamentos"></div>
                    </div>
                </div>
            </div>
    </div>
</div>

@endsection