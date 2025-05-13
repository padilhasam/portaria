@extends('layouts.dashboard')

@section('page_dashboard')

<header class="mb-2 px-4 py-3 bg-white border rounded shadow-sm d-flex align-items-center justify-content-between">
    <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3">
        <span class="icon-container" style="width: 32px; height: 32px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-badge-fill" viewBox="0 0 16 16">
                <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm4.5 0a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6m5 2.755C12.146 12.825 10.623 12 8 12s-4.146.826-5 1.755V14a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1z"/>
              </svg>
        </span>
        Cadastro de Visitantes
    </h3>
    <div class="d-flex align-items-center gap-3">
        <form method="GET" action="{{ route('index.visitante') }}" class="d-flex align-items-center" role="search">
            <input type="text" name="search" class="form-control form-control-sm me-2 rounded-pill border-dark" placeholder="Buscar por nome, CPF..." value="{{ request('search') }}">
            <button class="btn btn-outline-dark btn-sm rounded-pill" type="submit">
                <span class="d-none d-sm-inline">Buscar</span>
                <span class="d-inline d-sm-none">🔍</span>
            </button>
        </form>

        <a href="{{ route('create.visitante') }}" class="btn btn-success btn-sm text-white rounded-pill transition-shadow">
            Novo Visitante
        </a>
    </div>
</header>

<!-- Exibição de mensagens de sucesso ou erro -->
<div>
    @include('components.alerts', [
        'success' => session()->get('success'), 
        'message' => session()->get('message')
    ])
</div>

<div class="card shadow-sm border-0 rounded-4" style="min-height: 600px;">
    <div class="card-body d-flex flex-column">
        <h5 class="card-title mb-3 fw-semibold">Lista de Visitantes</h5>

        <div class="table-responsive flex-grow-1">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Nome</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>Empresa</th>
                        <th>Veículo</th>
                        <th>Placa</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($visitantes as $visitante)
                        <tr>
                            <td><span class="badge bg-primary text-white">{{ $visitante->nome }}</span></td>
                            <td>{{ $visitante->documento }}</td>
                            <td>{{ $visitante->telefone }}</td>
                            <td>{{ $visitante->empresa }}</td>
                            <td>{{ $visitante->veiculo->modelo ?? '-' }}</td>
                            <td>{{ $visitante->veiculo->placa ?? '-' }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 32px; height: 32px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi" viewBox="0 0 16 16">
                                            <path d="M8 3.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end show-on-top">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('edit.visitante', $visitante->id) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#0d6efd" viewBox="0 0 16 16">
                                                    <path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-4 1.5a.5.5 0 0 1-.65-.65l1.5-4a.5.5 0 0 1 .11-.168l10-10z"/>
                                                </svg>
                                                Editar
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2 text-danger" href="#" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $visitante->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5a.5.5 0 0 1 .5.5V12a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5.5a.5.5 0 0 1 1 0V12a.5.5 0 0 1-1 0V6zm3-.5a.5.5 0 0 1 .5.5V12a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5z"/>
                                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1 0-2h4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h4a1 1 0 0 1 1 1z"/>
                                                </svg>
                                                Remover
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        {{-- Modal de Confirmação --}}
                        <div class="modal fade" id="confirmDeleteModal{{ $visitante->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $visitante->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content shadow">
                                    <form action="{{ route('destroy.visitante', $visitante->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Confirmar Exclusão</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                        </div>
                                        <div class="modal-body">
                                            Tem certeza que deseja remover o visitante <strong>#{{ $visitante->id }}</strong> ({{ $visitante->nome }})?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-danger">Remover</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Nenhum visitante encontrado</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $visitantes->links('pagination::bootstrap-5') }}
</div>

@endsection