@extends('layouts.dashboard')

@section('page_dashboard')

<header class="mb-4 px-4 py-3 bg-white border rounded shadow-sm">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3" style="font-size: 1.75rem;">
            <span class="icon-container d-flex align-items-center justify-content-center"
                style="width: 36px; height: 36px; background: linear-gradient(135deg, #0d6efd, #0a58ca); border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-people-fill" viewBox="0 0 16 16">
                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                </svg>
            </span>
            Cadastro de Moradores
        </h3>

        <a href="{{ route('create.morador') }}" class="btn btn-primary btn-sm rounded-pill text-white">
            Novo Morador
        </a>
    </div>

    <form method="GET" action="{{ route('index.morador') }}" class="d-flex flex-wrap gap-3 align-items-end">

        {{-- Campo de Busca --}}
        <div class="d-flex flex-column flex-grow-1" style="min-width: 200px;">
            <label for="search" class="form-label mb-1 small text-secondary">Buscar</label>
            <input type="text" name="search" id="search"
                   class="form-control form-control-sm rounded-pill border-dark"
                   placeholder="Nome, CPF, bloco, ap..." value="{{ request('search') }}">
        </div>

        {{-- Tipo de Morador --}}
        <div class="d-flex flex-column" style="min-width: 150px;">
            <label for="tipo_morador" class="form-label mb-1 small text-secondary">Tipo</label>
            <select name="tipo_morador" id="tipo_morador" class="form-select form-select-sm rounded">
                <option value="">Todos</option>
                <option value="propria" @selected(request('tipo_morador') == 'propria')>Própria</option>
                <option value="aluguel" @selected(request('tipo_morador') == 'aluguel')>Aluguel</option>
            </select>
        </div>

        {{-- Botões --}}
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4">🔍 Filtrar</button>
            <a href="{{ route('index.morador') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-4">❌ Limpar</a>
        </div>

    </form>
</header>

<div>
    @include('components.alerts', [
        'success' => session()->get('success'),
        'message' => session()->get('message')
    ])
</div>

<div class="card shadow-sm border-0 rounded-4" style="min-height: 600px;">
    <div class="card-body d-flex flex-column">
        <h5 class="card-title mb-3 fw-semibold">Lista de Moradores</h5>

        <div class="table-responsive flex-grow-1">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Apartamento</th>
                        <th>Bloco</th>
                        <th>Veículo</th>
                        <th>Cor</th>
                        <th>Placa</th>
                        <th>Contato</th>
                        <th>Tipo</th>
                        <th>Criado em</th>
                        <th>Atualizado em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($moradores as $morador)
                    <tr>
                        <td><span class="badge bg-primary text-white">{{ $morador->nome }}</span></td>
                        <td>{{ $morador->documento }}</td>
                        <td>
                            {{ optional($morador->apartamento)->numero }}
                        </td>
                        <td>
                            @if(optional($morador->apartamento)->bloco)
                            Bloco {{optional($morador->apartamento)
                            ->bloco }}
                            @endif
                        </td>
                        <td>
                            {{optional($morador->veiculo)
                            ->marca}}
                            @if(optional($morador->veiculo)->modelo)
                             - {{optional($morador->veiculo)
                             ->modelo }}
                            @endif
                        </td>
                        <td>
                            {{optional($morador->veiculo)
                            ->cor}}
                        </td>
                        <td>
                            {{optional($morador->veiculo)
                            ->placa}}
                        </td>
                        <td>
                            📱{{ $morador->celular }}<br>
                            @if ($morador->email)
                                📧 <small class="text-muted">{{ $morador->email }}</small>
                            @endif
                        </td>
                        <td>
                            @if ($morador->tipo_morador === 'aluguel')
                                <span class="badge bg-info text-white">Aluguel</span>
                            @elseif ($morador->tipo_morador === 'propria')
                                <span class="badge bg-success text-white">Própria</span>
                            @endif
                        </td>
                        <td>{{ $morador->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $morador->updated_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 32px; height: 32px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi" viewBox="0 0 16 16">
                                            <path d="M8 3.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                        </svg>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end show-on-top">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('edit.morador', $morador->id) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#0d6efd" viewBox="0 0 16 16">
                                                <path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-4 1.5a.5.5 0 0 1-.65-.65l1.5-4a.5.5 0 0 1 .11-.168l10-10zM11.207 2L13 3.793 14.293 2.5 12.5.707 11.207 2zM12 4.207 11.793 4 3 12.793 3.207 13 12 4.207zM2.5 13.5 4 13l-.5-.5-1.5.5.5 1.5z"/>
                                            </svg>
                                            Editar
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2 text-danger" href="#" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $morador->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5a.5.5 0 0 1 .5.5V12a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5.5a.5.5 0 0 1 1 0V12a.5.5 0 0 1-1 0V6zm3-.5a.5.5 0 0 1 .5.5V12a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5z"/>
                                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1 0-2h4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h4a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3a.5.5 0 0 0 0 1H13.5a.5.5 0 0 0 0-1H2.5z"/>
                                            </svg>
                                            Remover
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="dropdown-item d-flex align-items-center gap-2 view-morador" data-bs-toggle="modal" data-bs-target="#viewDataModalMorador"
                                            data-nome="{{ $morador->nome }}"
                                            data-cpf="{{ $morador->documento }}"
                                            data-apartamento="{{ optional($morador->apartamento)->numero }}{{ optional($morador->apartamento)->bloco ? ' - Bloco ' . optional($morador->apartamento)->bloco : '' }}"
                                            data-marca="{{ $morador->veiculo->marca ?? 'Sem veículo' }}"
                                            data-modelo="{{ $morador->veiculo->modelo ?? 'Sem veículo' }}"
                                            data-cor="{{ $morador->veiculo->cor ?? 'Sem veículo' }}"
                                            data-placa="{{ $morador->veiculo->placa ?? 'Sem veículo' }}"
                                            data-celular="{{ $morador->celular }}"
                                            data-email="{{ $morador->email }}"
                                            data-tipo="{{ $morador->tipo_morador === 'aluguel' ? 'Aluguel' : 'Própria' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#b45f06" class="bi bi-search" viewBox="0 0 16 16">
                                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                            </svg>
                                            Ver Dados
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    {{-- Modal de Confirmação --}}
                    <div class="modal fade" id="confirmDeleteModal{{ $morador->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $morador->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content shadow">
                                <form action="{{ route('destroy.morador', $morador->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Confirmar Exclusão</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                    </div>
                                    <div class="modal-body">
                                        Tem certeza que deseja remover o morador <strong>#{{ $morador->id }}</strong> ({{ $morador->nome }})?
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
                        <td colspan="10" class="text-center text-muted">Nenhum morador cadastrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-4 d-flex justify-content-center">
    {{ $moradores->links('pagination::bootstrap-5') }}
</div>

<div class="modal fade" id="viewDataModalMorador" tabindex="-1" aria-labelledby="viewDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 shadow-sm border-0">
            <div class="modal-header bg-primary text-white rounded-top-4 py-3 px-4">
                <h5 class="modal-title" id="viewDataModalLabel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16"><path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z"/>
                    </svg>
                    Detalhes do Morador
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body px-4 py-3">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item py-3">
                        <strong class="text-secondary">Nome:</strong> <span id="modal-nome" class="ms-2"></span>
                    </li>
                    <li class="list-group-item py-3">
                        <strong class="text-secondary">CPF:</strong> <span id="modal-cpf" class="ms-2"></span>
                    </li>
                    <li class="list-group-item py-3">
                        <strong class="text-secondary">Apartamento:</strong> <span id="modal-apartamento" class="ms-2"></span>
                    </li>
                    <li class="list-group-item">
                        <strong class="text-secondary">Veículo:</strong> <span id="modal-marca" class="ms-2"></span>
                    </li>
                    <li class="list-group-item">
                        <strong class="text-secondary">Modelo:</strong> <span id="modal-modelo" class="ms-2"></span>
                    </li>
                    <li class="list-group-item">
                        <strong class="text-secondary">Cor:</strong> <span id="modal-cor" class="ms-2"></span>
                    </li>
                    <li class="list-group-item">
                        <strong class="text-secondary">Placa:</strong> <span id="modal-placa" class="ms-2"></span>
                    </li>
                    <li class="list-group-item py-3">
                        <strong class="text-secondary">Celular:</strong> <span id="modal-celular" class="ms-2"></span>
                    </li>
                    <li class="list-group-item py-3">
                        <strong class="text-secondary">Email:</strong> <span id="modal-email" class="ms-2"></span>
                    </li>
                    <li class="list-group-item py-3">
                        <strong class="text-secondary">Tipo:</strong> <span id="modal-tipo" class="ms-2"></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
