@extends('layouts.dashboard')

@section('page_dashboard')

<header class="mb-4 px-4 py-3 bg-white border rounded shadow-sm">

    {{-- Linha do título + botão --}}
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3" style="font-size: 1.75rem;">
            <span class="icon-container d-flex align-items-center justify-content-center"
                  style="width: 36px; height: 36px; background: linear-gradient(135deg, #0d6efd, #0a58ca); border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-buildings-fill" viewBox="0 0 16 16">
                    <path d="M15 .5a.5.5 0 0 0-.724-.447l-8 4A.5.5 0 0 0 6 4.5v3.14L.342 9.526A.5.5 0 0 0 0 10v5.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V14h1v1.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5zM2 11h1v1H2zm2 0h1v1H4zm-1 2v1H2v-1zm1 0h1v1H4zm9-10v1h-1V3zM8 5h1v1H8zm1 2v1H8V7zM8 9h1v1H8zm2 0h1v1h-1zm-1 2v1H8v-1zm1 0h1v1h-1zm3-2v1h-1V9zm-1 2h1v1h-1zm-2-4h1v1h-1zm3 0v1h-1V7zm-2-2v1h-1V5zm1 0h1v1h-1z"/>
                </svg>
            </span>
            Cadastro de Apartamentos
        </h3>

        <a href="{{ route('create.apartamento') }}" class="btn btn-primary btn-sm rounded-pill text-white" title="Adicionar novo apartamento" aria-label="Adicionar novo apartamento">
            Novo Apartamento
        </a>
    </div>

    {{-- Linha dos filtros --}}
    <form method="GET" action="{{ route('index.apartamento') }}" class="d-flex flex-wrap gap-3 align-items-end justify-content-end">

        {{-- Buscar --}}
        <div class="d-flex flex-column flex-grow-1" style="min-width: 300px; max-width: 400px;">
            <label for="search" class="form-label mb-1 small text-secondary">Buscar</label>
            <input type="text" name="search" id="search"
                   class="form-control form-control-sm rounded-pill border-dark"
                   placeholder="Bloco, Número, Proprietário..." value="{{ request('search') }}"
                   aria-label="Buscar por bloco, número ou proprietário">
        </div>

        {{-- Bloco --}}
        <div class="d-flex flex-column flex-grow-1" style="min-width: 260px;">
            <label for="bloco" class="form-label mb-1 small text-secondary">Bloco</label>
            <input type="text" name="bloco" id="bloco"
                   class="form-control form-control-sm rounded"
                   placeholder="Ex: A, B, C" value="{{ request('bloco') }}"
                   aria-label="Filtrar por bloco">
        </div>

        {{-- Número --}}
        <div class="d-flex flex-column flex-grow-1" style="min-width: 140px;">
            <label for="numero" class="form-label mb-1 small text-secondary">Número</label>
            <input type="text" name="numero" id="numero"
                   class="form-control form-control-sm rounded"
                   placeholder="Ex: 101, 202" value="{{ request('numero') }}"
                   aria-label="Filtrar por número do apartamento">
        </div>

        {{-- Tipo de Moradia --}}
        <div class="d-flex flex-column" style="min-width: 140px;">
            <label for="tipo_moradia" class="form-label mb-1 small text-secondary">Tipo</label>
            <select name="tipo_moradia" id="tipo_moradia" class="form-select form-select-sm rounded" aria-label="Filtrar por tipo de moradia">
                <option value="">Todos</option>
                <option value="propria" @selected(request('tipo_moradia') == 'propria')>Própria</option>
                <option value="aluguel" @selected(request('tipo_moradia') == 'aluguel')>Aluguel</option>
            </select>
        </div>

        {{-- Botões --}}
        <div class="d-flex gap-2" style="min-width: 160px;">
            <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 mb-2 mb-md-0" title="Aplicar filtro" aria-label="Filtrar">
                🔍 Filtrar
            </button>
            <a href="{{ route('index.apartamento') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-4" title="Limpar filtros" aria-label="Limpar filtros">
                ❌ Limpar
            </a>
        </div>

    </form>

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
                        <th>Criado em</th>
                        <th>Atualizado em</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($apartamentos as $apartamento)
                        <tr>
                            <td><span class="badge bg-primary text-white">{{ $apartamento->numero }}</span></td>
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
                                                        <path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-4 1.5a.5.5 0 0 1-.65-.65l1.5-4a.5.5 0 0 1 .11-.168l10-10zM11.207 2L13 3.793 14.293 2.5 12.5.707 11.207 2zM12 4.207 11.793 4 3 12.793 3.207 13 12 4.207zM2.5 13.5 4 13l-.5-.5-1.5.5.5 1.5z"/>
                                                    </svg>
                                                    Editar
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-2 text-danger" href="#" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $apartamento->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                        <path d="M5.5 5.5a.5.5 0 0 1 .5.5V12a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5.5a.5.5 0 0 1 1 0V12a.5.5 0 0 1-1 0V6zm3-.5a.5.5 0 0 1 .5.5V12a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5z"/>
                                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1 0-2h4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h4a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3a.5.5 0 0 0 0 1H13.5a.5.5 0 0 0 0-1H2.5z"/>
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

{{-- Paginação --}}
<div class="mt-4 d-flex justify-content-center">
    {{ $apartamentos->links('pagination::bootstrap-5') }}
</div>

@endsection
