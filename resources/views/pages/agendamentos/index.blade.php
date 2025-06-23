@extends('layouts.dashboard')

@section('page_dashboard')

<!-- Cabeçalho -->
<header class="mb-4 px-4 py-3 bg-white border rounded shadow-sm w-100">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3" style="font-size: 1.75rem;">
            <span class="icon-container d-flex align-items-center justify-content-center"
                style="width: 36px; height: 36px; background: linear-gradient(135deg, #0d6efd, #0a58ca); border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-calendar2-day" viewBox="0 0 16 16">
                <path d="M4.684 12.523v-2.3h2.261v-.61H4.684V7.801h2.464v-.61H4v5.332zm3.296 0h.676V9.98c0-.554.227-1.007.953-1.007.125 0 .258.004.329.015v-.613a2 2 0 0 0-.254-.02c-.582 0-.891.32-1.012.567h-.02v-.504H7.98zm2.805-5.093c0 .238.192.425.43.425a.428.428 0 1 0 0-.855.426.426 0 0 0-.43.43m.094 5.093h.672V8.418h-.672z"/>
                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z"/>
                <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5z"/>
                </svg>
            </span>
            Agendamento de Áreas Comuns
        </h3>

        <a href="{{ route('create.agendamento') }}" class="btn btn-primary btn-sm rounded-pill text-white">
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
