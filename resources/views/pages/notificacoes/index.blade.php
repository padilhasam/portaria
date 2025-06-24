@extends('layouts.dashboard')

@section('page_dashboard')

{{-- Cabeçalho --}}
<header class="mb-4 px-4 py-3 bg-white border rounded shadow-sm">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3" style="font-size: 1.75rem;">
            <span class="icon-container d-flex align-items-center justify-content-center"
                style="width: 36px; height: 36px; background: linear-gradient(135deg, #0d6efd, #0a58ca); border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-wechat" viewBox="0 0 16 16">
                <path d="M11.176 14.429c-2.665 0-4.826-1.8-4.826-4.018 0-2.22 2.159-4.02 4.824-4.02S16 8.191 16 10.411c0 1.21-.65 2.301-1.666 3.036a.32.32 0 0 0-.12.366l.218.81a.6.6 0 0 1 .029.117.166.166 0 0 1-.162.162.2.2 0 0 1-.092-.03l-1.057-.61a.5.5 0 0 0-.256-.074.5.5 0 0 0-.142.021 5.7 5.7 0 0 1-1.576.22M9.064 9.542a.647.647 0 1 0 .557-1 .645.645 0 0 0-.646.647.6.6 0 0 0 .09.353Zm3.232.001a.646.646 0 1 0 .546-1 .645.645 0 0 0-.644.644.63.63 0 0 0 .098.356"/>
                <path d="M0 6.826c0 1.455.781 2.765 2.001 3.656a.385.385 0 0 1 .143.439l-.161.6-.1.373a.5.5 0 0 0-.032.14.19.19 0 0 0 .193.193q.06 0 .111-.029l1.268-.733a.6.6 0 0 1 .308-.088q.088 0 .171.025a6.8 6.8 0 0 0 1.625.26 4.5 4.5 0 0 1-.177-1.251c0-2.936 2.785-5.02 5.824-5.02l.15.002C10.587 3.429 8.392 2 5.796 2 2.596 2 0 4.16 0 6.826m4.632-1.555a.77.77 0 1 1-1.54 0 .77.77 0 0 1 1.54 0m3.875 0a.77.77 0 1 1-1.54 0 .77.77 0 0 1 1.54 0"/>
                </svg>
            </span>
            Cadastro de Ocorrências
        </h3>

        <a href="{{ route('create.notificacao') }}" class="btn btn-primary btn-sm rounded-pill text-white">
            Nova Ocorrência
        </a>
    </div>

    <form method="GET" action="{{ route('index.notificacao') }}" class="d-flex flex-wrap gap-3 align-items-end">

        {{-- Busca por texto --}}
        <div class="d-flex flex-column flex-grow-1" style="min-width: 200px;">
            <label for="search" class="form-label mb-1 small">Buscar:</label>
            <input type="text" name="search" id="search" class="form-control form-control-sm rounded-pill"
                placeholder="Título ou Mensagem" value="{{ request('search') }}">
        </div>

        {{-- Data de Início --}}
        <div class="d-flex flex-column flex-grow-1" style="min-width: 150px;">
            <label for="data_inicio" class="form-label mb-1 small">De:</label>
            <input type="date" name="data_inicio" id="data_inicio" class="form-control form-control-sm"
                value="{{ request('data_inicio') }}">
        </div>

        {{-- Data de Fim --}}
        <div class="d-flex flex-column flex-grow-1" style="min-width: 150px;">
            <label for="data_fim" class="form-label mb-1 small">Até:</label>
            <input type="date" name="data_fim" id="data_fim" class="form-control form-control-sm"
                value="{{ request('data_fim') }}">
        </div>

        {{-- Criador --}}
        <div class="d-flex flex-column flex-grow-1" style="min-width: 180px;">
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
        <div class="d-flex flex-column flex-grow-1" style="min-width: 150px;">
            <label for="status" class="form-label mb-1 small">Status:</label>
            <select name="status" id="status" class="form-select form-select-sm">
                <option value="">Todos</option>
                <option value="lida" {{ request('status') == 'lida' ? 'selected' : '' }}>Lidas</option>
                <option value="nao_lida" {{ request('status') == 'nao_lida' ? 'selected' : '' }}>Não Lidas</option>
            </select>
        </div>

        {{-- Ações --}}
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 mb-2 mb-md-0">🔍 Filtrar</button>
            <a href="{{ route('index.notificacao') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-4 mb-2 mb-md-0">❌ Limpar</a>
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
