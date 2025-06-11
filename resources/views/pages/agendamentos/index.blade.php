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

@include('components.alerts', [
    'success' => session('success'), 
    'message' => session('message')
])

<div class="container my-4">
    <div class="row justify-content-center">
        <!-- Legenda à esquerda -->
        <div class="col-12 col-md-3 col-lg-3 mb-4 mb-md-0">
            <div class="bg-light rounded p-3 border shadow-sm h-100">
                <h6 class="text-muted mb-3">Legenda</h6>
                <ul class="list-unstyled d-flex flex-column gap-2 small">
                    <li class="d-flex align-items-center gap-2">
                        <span class="rounded" style="width: 14px; height: 14px; background-color: #0d6efd;"></span>
                        Sala de Jogos
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <span class="rounded" style="width: 14px; height: 14px; background-color: #198754;"></span>
                        Churrasqueira
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <span class="rounded" style="width: 14px; height: 14px; background-color: #ffc107;"></span>
                        Academia
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <span class="rounded" style="width: 14px; height: 14px; background-color: #0dcaf0;"></span>
                        Piscina
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <span class="rounded" style="width: 14px; height: 14px; background-color: #3c0386;"></span>
                        Quadra
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <span class="rounded" style="width: 14px; height: 14px; background-color: #dd4e0c;"></span>
                        Biblioteca  
                    </li>
                </ul>
            </div>
        </div>

        <!-- Calendário -->
        <div class="col-12 col-md-9 col-lg-9">
            <div id="calendar" aria-live="polite" aria-label="Calendário de agendamentos" style="min-height: 600px;"></div>
        </div>
    </div>
</div>

<!-- Modal de Detalhes do Evento -->
<div class="modal fade" id="eventoModal" tabindex="-1" aria-labelledby="eventoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-3 shadow">
      <div class="modal-header">
        <h5 class="modal-title" id="eventoModalLabel">Detalhes do Agendamento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <p><strong>Morador:</strong> <span id="modalMorador"></span></p>
        <p><strong>Área:</strong> <span id="modalArea"></span></p>
        <p><strong>Início:</strong> <span id="modalInicio"></span></p>
        <p><strong>Fim:</strong> <span id="modalFim"></span></p>
        <p><strong>Observações:</strong> <span id="modalObs"></span></p>
      </div>
      <div class="modal-footer">
        <a href="#" id="modalLinkEditar" class="btn btn-primary">Editar</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

@endsection