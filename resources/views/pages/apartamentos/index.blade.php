@extends('layouts.dashboard')

@section('page_dashboard')

<header class="mb-2 px-4 py-3 bg-white border rounded shadow-sm d-flex align-items-center justify-content-between">
    <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3">
        <span class="icon-container" style="width: 32px; height: 32px;">
            {{ svg('hugeicons-house-01') }}
        </span>
        Cadastro de Apartamentos
    </h3>
    <a href="{{ route('create.apartamento') }}" class="btn btn-success btn-sm text-white rounded-pill transition-shadow">
        Novo Apartamento
    </a>
</header>

<div class="card shadow-sm border-0 rounded-4" style="min-height: 600px;">
    <div class="card-body d-flex flex-column">
        <h5 class="card-title mb-3 fw-semibold">Lista de Apartamentos</h5>

        <div class="table-responsive flex-grow-1">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Apartamento</th>
                        <th>Bloco</th>
                        <th>Vaga</th>
                        <th>Ramal</th>
                        <th>Situação</th>
                        <th>Status da Vaga</th>
                        <th>Data Criação</th>
                        <th>Data Alteração</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($apartamentos as $apartamento)
                        <tr>
                            <td>{{ $apartamento->numero }}</td>
                            <td>{{ $apartamento->bloco }}</td>
                            <td>{{ $apartamento->vaga }}</td>
                            <td>{{ $apartamento->ramal }}</td>
                            <td>
                                <span class="badge bg-{{ $apartamento->situacao === 'ativo' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($apartamento->situacao) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $apartamento->status_vaga === 'ocupada' ? 'danger' : 'primary' }}">
                                    {{ ucfirst($apartamento->status_vaga) }}
                                </span>
                            </td>
                            <td>{{ $apartamento->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $apartamento->updated_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center p-0"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 32px; height: 32px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi" viewBox="0 0 16 16">
                                            <path d="M8 3.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end show-on-top">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('edit.apartamento', $apartamento->id) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#0d6efd" viewBox="0 0 16 16">
                                                    <path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-4 1.5a.5.5 0 0 1-.65-.65l1.5-4a.5.5 0 0 1 .11-.168l10-10z"/>
                                                    <path d="M11.207 2L13 3.793 14.293 2.5 12.5.707 11.207 2z"/>
                                                </svg>
                                                Editar
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2 text-danger" href="#" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $apartamento->id }}">
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
                        <div class="modal fade" id="confirmDeleteModal{{ $apartamento->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $apartamento->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content shadow">
                                    <form action="{{ route('destroy.apartamento', $apartamento->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Confirmar Exclusão</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                        </div>
                                        <div class="modal-body">
                                            Tem certeza que deseja remover o apartamento <strong>#{{ $apartamento->numero }}</strong>?
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
                            <td colspan="9" class="text-center text-muted">Nenhum apartamento cadastrado</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Paginação
<div class="mt-4 d-flex justify-content-center">
    {{ $apartamentos->links('pagination::bootstrap-5') }}
</div>--}}

@endsection