@extends('layouts.dashboard')

@section('page_dashboard')

{{-- Cabeçalho --}}
<header class="mb-2 px-4 py-3 bg-white border rounded shadow-sm d-flex align-items-center justify-content-between">
    <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3">
        <span class="icon-container" style="width: 32px; height: 32px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.628-14.885A1.5 1.5 0 0 1 10.5 2h.5a1.5 1.5 0 0 1 1.5 1.5v.086c0 .11.009.219.026.327C13.127 6.25 14 7.5 14 9v1l.447.894a.5.5 0 0 1-.447.75H2a.5.5 0 0 1-.447-.75L2 10V9c0-1.5.873-2.75 1.474-5.087A1.5 1.5 0 0 1 5.5 2h.5a1.5 1.5 0 0 1 1.372-.885z"/>
            </svg>
        </span>
        Ocorrências
    </h3>

    <form method="GET" action="{{ route('index.notificacao') }}" class="d-flex flex-wrap align-items-end gap-3">

        {{-- Data de Início --}}
        <div>
            <label for="data_inicio" class="form-label mb-1 small">De:</label>
            <input type="date" name="data_inicio" id="data_inicio" class="form-control form-control-sm"
                value="{{ request('data_inicio') }}">
        </div>

        {{-- Data de Fim --}}
        <div>
            <label for="data_fim" class="form-label mb-1 small">Até:</label>
            <input type="date" name="data_fim" id="data_fim" class="form-control form-control-sm"
                value="{{ request('data_fim') }}">
        </div>

        {{-- Criador --}}
        <div>
            <label for="criador" class="form-label mb-1 small">Criador:</label>
            <select name="criador" id="criador" class="form-select form-select-sm">
                <option value="">Todos</option>
                @foreach($usuariosCriadores as $usuario)
                    <option value="{{ $usuario->id }}" {{ request('criador') == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Status --}}
        <div>
            <label for="status" class="form-label mb-1 small">Status:</label>
            <select name="status" id="status" class="form-select form-select-sm">
                <option value="">Todos</option>
                <option value="lida" {{ request('status') == 'lida' ? 'selected' : '' }}>Lidas</option>
                <option value="nao_lida" {{ request('status') == 'nao_lida' ? 'selected' : '' }}>Não Lidas</option>
            </select>
        </div>

        {{-- Busca por texto --}}
        <div>
            <label for="search" class="form-label mb-1 small">Buscar:</label>
            <input type="text" name="search" id="search" class="form-control form-control-sm rounded-pill"
                placeholder="Título ou Mensagem" value="{{ request('search') }}">
        </div>

        {{-- Ações --}}
        <div class="d-flex gap-2 align-items-end">
            <button type="submit" class="btn btn-outline-dark btn-sm rounded-pill">🔍 Filtrar</button>
            <a href="{{ route('index.notificacao') }}" class="btn btn-outline-secondary btn-sm rounded-pill">❌ Limpar</a>
        </div>

        {{-- Nova Ocorrência --}}
        <div class="ms-auto">
            <a href="{{ route('create.notificacao') }}" class="btn btn-success btn-sm text-white rounded-pill">
                Nova Ocorrência
            </a>
        </div>
    </form>
</header>

{{-- Alertas --}}
@include('components.alerts', [
    'success' => session('success'),
    'message' => session('message')
])

{{-- Lista --}}
<div class="card shadow-sm border-0 rounded-4" style="min-height: 600px;">
    <div class="card-body d-flex flex-column">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title m-0 fw-semibold">Lista de Notificações</h5>
            <form action="{{ route('notificacoes.marcar_todas_como_lidas') }}" method="POST">
                @csrf
                @method('PATCH')
                <button class="btn btn-outline-primary btn-sm">Marcar todas como lidas</button>
            </form>
        </div>

        <div class="table-responsive flex-grow-1">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Título</th>
                        <th>Mensagem</th>
                        <th>Status</th>
                        <th>Enviado por</th>
                        <th>Criada em</th>
                        <th>Anexo</th> <!-- NOVA COLUNA -->
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notificacoes as $notificacao)
                        <tr @class(['table-warning' => !$notificacao->pivot->read])>
                            <td>
                                @if(!$notificacao->pivot->read)
                                    <strong>{{ $notificacao->title }}</strong>
                                @else
                                    {{ $notificacao->title }}
                                @endif
                            </td>
                            <td>{{ Str::limit($notificacao->message, 50) }}</td>
                            <td>
                                <span class="badge {{ $notificacao->pivot->read ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ $notificacao->pivot->read ? 'Lida' : 'Não lida' }}
                                </span>
                            </td>
                            <td>{{ $notificacao->criador->nome ?? 'Sistema' }}</td>
                            <td>{{ $notificacao->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center">
                                @if ($notificacao->arquivo)
                                    <a href="{{ asset('storage/notificacoes/' . $notificacao->arquivo) }}" target="_blank" download title="Baixar anexo">
                                        📎
                                    </a>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 32px; height: 32px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi" viewBox="0 0 16 16">
                                            <path d="M8 3.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end show-on-top">
                                        @if(!$notificacao->pivot->read)
                                            <li>
                                                <form id="form-marcar-lida-{{ $notificacao->id }}" action="{{ route('notificacoes.marcar_como_lida', $notificacao->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('PATCH')
                                                </form>
                                                <a href="#" class="dropdown-item text-success"
                                                   onclick="event.preventDefault(); document.getElementById('form-marcar-lida-{{ $notificacao->id }}').submit();">
                                                    ✅ Marcar como lida
                                                </a>
                                            </li>
                                        @endif
                                        <li>
                                            <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $notificacao->id }}">
                                                🗑 Remover
                                            </a>
                                        </li>
                                        <li>
                                        <a href="javascript:void(0)"
                                            class="dropdown-item view-notificacao"
                                            data-bs-toggle="modal"
                                            data-bs-target="#viewDataModalNotificacao"
                                            data-id="{{ $notificacao->id }}"
                                            data-title="{{ $notificacao->title }}"
                                            data-message="{{ $notificacao->message }}"
                                            data-status="{{ $notificacao->pivot->read ? 'Lida' : 'Não lida' }}"
                                            data-criador="{{ $notificacao->criador->nome ?? '—' }}"
                                            data-data="{{ $notificacao->created_at->format('d/m/Y H:i') }}"
                                            data-url="{{ route('notificacoes.marcar_como_lida', $notificacao->id) }}"
                                            data-arquivo="{{ $notificacao->arquivo ? asset('storage/notificacoes/' . $notificacao->arquivo) : '' }}"
                                            data-respostas-url="{{ route('notificacoes.respostas', $notificacao->id) }}"
                                            data-url-resposta-enviar="{{ route('notificacoes.enviar_resposta', $notificacao->id) }}"
                                            >
                                                🔍 Visualizar
                                        </a>
                                    </li>
                                </div>
                            </td>
                        </tr>

                        {{-- Modal de exclusão --}}
                        @push('modals')
                            <div class="modal fade" id="confirmDeleteModal{{ $notificacao->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $notificacao->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content shadow">
                                        <form action="{{ route('destroy.notificacao', $notificacao->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirmar Exclusão</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                            </div>
                                            <div class="modal-body">
                                                Tem certeza que deseja remover a notificação <strong>#{{ $notificacao->id }}</strong> ({{ $notificacao->title }})?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-danger">Remover</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endpush
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Nenhuma notificação encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginação --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $notificacoes->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

{{-- Modal Notificação --}}
<div class="modal fade" id="viewDataModalNotificacao" tabindex="-1" aria-labelledby="viewDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 shadow border-0">
            <!-- Cabeçalho -->
            <div class="modal-header bg-primary text-white rounded-top-4 px-4 py-3">
                <h5 class="modal-title d-flex align-items-center gap-2">
                    {{ svg('hugeicons-notification-01', 'me-1') }} Detalhes da Notificação
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <!-- Corpo -->
            <div class="modal-body px-4 py-4">
                <div class="row g-4">
                    <!-- Dados -->
                    <div class="col-md-12">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong class="text-secondary">Título:</strong> <span id="modal-titulo" class="ms-2"></span>
                            </li>
                            <li class="list-group-item">
                                <strong class="text-secondary d-block mb-2">Mensagem:</strong>
                                <div id="modal-mensagem" class="border rounded p-3 bg-light"
                                    style="max-height: 250px; overflow-y: auto; white-space: pre-wrap;">
                                </div>
                            </li>
                            <li class="list-group-item d-none" id="arquivo-container">
                                <strong class="text-secondary">Anexo:</strong>
                                <a id="modal-arquivo" class="ms-2" href="#" target="_blank" download>
                                    📎 Visualizar Arquivo
                                </a>
                            </li>
                            <li class="list-group-item">
                                <strong class="text-secondary">Status:</strong>
                                <span id="modal-status" class="ms-2 badge"></span>
                            </li>
                            <li class="list-group-item">
                                <strong class="text-secondary">Criador:</strong> <span id="modal-criador" class="ms-2"></span>
                            </li>
                            <li class="list-group-item">
                                <strong class="text-secondary">Data de Envio:</strong> <span id="modal-data" class="ms-2"></span>
                            </li>
                        </ul>
                    </div>
                </div>

            <!-- Campo de resposta -->
            <div class="mt-4">
                <form id="form-resposta-notificacao" method="POST" action="">
                    @csrf
                    <label for="resposta" class="form-label fw-semibold">Responder ao remetente:</label>
                    <textarea name="resposta" id="modal-resposta" rows="3" class="form-control" placeholder="Digite sua resposta..."></textarea>

                    <div class="d-flex justify-content gap-2 my-2">
                        <button type="submit" class="btn btn-primary btn-sm">
                            📩 Enviar Resposta
                        </button>
                    </div>
                </form>
                <form method="POST" action="#" id="form-ver-respostas" class="d-flex">
                    @csrf
                    <button type="submit" id="btn-ver-respostas" class="btn btn-info btn-sm">
                        📨 Ver Respostas
                    </button>
                </form>
            </div>

            <!-- Rodapé -->
            <div class="modal-footer bg-light rounded-bottom-4 px-4 py-3 d-flex justify-content-between">
                <small class="text-muted">Você pode marcar como lida caso ainda não tenha sido lida.</small>
                <form id="form-marcar-lida-modal" method="POST" action="">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-outline-success btn-sm">
                        ✅ Marcar como Lida
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Renderiza todos os modals no final --}}
@stack('modals')

@endsection
