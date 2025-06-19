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

    <div class="d-flex align-items-center gap-3">
        <form method="GET" action="{{ route('index.notificacao') }}" class="d-flex align-items-center" role="search">
            <input type="text" name="search" class="form-control form-control-sm me-2 rounded-pill border-dark" placeholder="Buscar..." value="{{ request('search') }}">
            <button class="btn btn-outline-dark btn-sm rounded-pill" type="submit">
                <span class="d-none d-sm-inline">Buscar</span>
                <span class="d-inline d-sm-none">🔍</span>
            </button>
        </form>

        <a href="{{ route('create.notificacao') }}" class="btn btn-success btn-sm text-white rounded-pill transition-shadow">
            Nova Ocorrência
        </a>
    </div>
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
                                    </ul>
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

{{-- Renderiza todos os modals no final --}}
@stack('modals')

@endsection