@extends('layouts.dashboard')

@section('page_dashboard')

<header class="mb-4 px-4 py-3 bg-white border rounded shadow-sm">

    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-3">
        <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3" style="font-size: 1.75rem;">
            <span class="icon-container d-flex align-items-center justify-content-center"
                  style="width: 36px; height: 36px; background: linear-gradient(135deg, #4e73df, #224abe); border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-person-badge-fill" viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                    <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm4.5 0a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6m5 2.755C12.146 12.825 10.623 12 8 12s-4.146.826-5 1.755V14a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1z"/>
                </svg>
            </span>
            Cadastro de Visitantes
        </h3>

        <a href="{{ route('create.visitante') }}" class="btn btn-primary btn-sm rounded-pill text-white" aria-label="Botão para criar novo visitante">
            Novo Visitante
        </a>
    </div>

    <form method="GET" action="{{ route('index.visitante') }}" class="d-flex flex-wrap gap-3 align-items-end">

        {{-- Campo de busca --}}
        <div class="d-flex flex-column flex-grow-1" style="min-width: 180px;">
            <label for="search" class="form-label mb-1 small text-secondary">Buscar</label>
            <input type="search" name="search" id="search" class="form-control form-control-sm rounded-pill border-dark" placeholder="Nome, CPF, Telefone..." value="{{ request('search') }}">
        </div>

        {{-- Filtro por Empresa Prestadora --}}
        <div class="d-flex flex-column" style="min-width: 150px;">
            <label for="id_prestador" class="form-label mb-1 small text-secondary">Empresa</label>
            <select name="id_prestador" id="id_prestador" class="form-select form-select-sm rounded">
                <option value="">Todas</option>
                @foreach($prestadores as $prestador)
                    <option value="{{ $prestador->id }}" {{ request('id_prestador') == $prestador->id ? 'selected' : '' }}>
                        {{ $prestador->empresa }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Filtro por Veículo --}}
        <div class="d-flex flex-column" style="min-width: 150px;">
            <label for="id_veiculo" class="form-label mb-1 small text-secondary">Carro</label>
            <select name="id_veiculo" id="id_veiculo" class="form-select form-select-sm rounded">
                <option value="">Todos</option>
                @foreach($veiculos as $veiculo)
                    <option value="{{ $veiculo->id }}" {{ request('id_veiculo') == $veiculo->id ? 'selected' : '' }}>
                        {{ $veiculo->modelo }} - {{ $veiculo->placa }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Botões --}}
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4">🔍 Filtrar</button>
            <a href="{{ route('index.visitante') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-4">❌ Limpar</a>
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
        <h5 class="card-title mb-3 fw-semibold">Lista de Visitantes</h5>

        <div class="table-responsive flex-grow-1">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Celular</th>
                        <th>Empresa</th>
                        <th>Veículo</th>
                        <th>Cor</th>
                        <th>Placa</th>
                        <th>Criado em</th>
                        <th>Atualizado em</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($visitantes as $visitante)
                        <tr>
                            {{-- <td><span class="badge bg-primary text-white">{{ $visitante->nome }}</span></td> --}}
                            <td><strong>{{ $visitante->nome }}</strong></td>
                            <td>{{ $visitante->documento ?? 'Não informado'}}</td>
                            <td>{{ $visitante->celular ?? 'Não informado'}}</td>
                            <td>{{$visitante->prestador->empresa ?? 'Não informado'}}</td>
                            <td>
                                {{optional($visitante->veiculo)
                                ->marca ?? 'Não informado'}}
                                @if(optional($visitante->veiculo)->modelo)
                                - {{optional($visitante->veiculo)
                                ->modelo ?? 'Não informado' }}
                            @endif
                            </td>
                            <td>
                                {{optional($visitante->veiculo)
                                ->cor ?? 'Não informado'}}
                            </td>
                            <td>
                                {{optional($visitante->veiculo)
                                ->placa ?? 'Não informado'}}
                            </td>
                            <td>{{ $visitante->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $visitante->updated_at->format('d/m/Y H:i') }}</td>
                            <td>{{ ucfirst($visitante->status) ?? 'Não informado'}}</td>
                            {{-- <td>
                                @if($registro->status == 'bloqueado')
                                    <span class="badge bg-danger">Bloqueado</span>
                                @else
                                    <span class="badge bg-success">Liberado</span>
                                @endif
                            </td> --}}
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
                                                    <path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-4 1.5a.5.5 0 0 1-.65-.65l1.5-4a.5.5 0 0 1 .11-.168l10-10zM11.207 2L13 3.793 14.293 2.5 12.5.707 11.207 2zM12 4.207 11.793 4 3 12.793 3.207 13 12 4.207zM2.5 13.5 4 13l-.5-.5-1.5.5.5 1.5z"/>
                                                </svg>
                                                Editar
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2 text-danger" href="#" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $visitante->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5a.5.5 0 0 1 .5.5V12a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5.5a.5.5 0 0 1 1 0V12a.5.5 0 0 1-1 0V6zm3-.5a.5.5 0 0 1 .5.5V12a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5z"/>
                                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1 0-2h4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h4a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3a.5.5 0 0 0 0 1H13.5a.5.5 0 0 0 0-1H2.5z"/>
                                                </svg>
                                                Remover
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)"
                                                class="dropdown-item d-flex align-items-center gap-2 view-dados"
                                                data-bs-toggle="modal"
                                                data-bs-target="#viewDataModalVisitante"
                                                data-nome="{{ $visitante->nome ?? 'Não informado'}}"
                                                data-cpf="{{ $visitante->documento ?? 'Não informado'}}"
                                                data-empresa="{{ $visitante->prestador->empresa ?? 'Não informado' }}"
                                                data-marca="{{ $visitante->veiculo->marca ?? 'Não informado' }}"
                                                data-modelo="{{ $visitante->veiculo->modelo ?? 'Não informado' }}"
                                                data-cor="{{ $visitante->veiculo->cor ?? 'Não informado' }}"
                                                data-placa="{{ $visitante->veiculo->placa ?? 'Não informado' }}"
                                                data-celular="{{ $visitante->celular ?? 'Não informado' }}"
                                                data-foto="{{ $visitante->image ? asset('storage/visitantes/'.$visitante->image) : Vite::asset('/resources/images/avatar2.png') }}">
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
                            <td colspan="10" class="text-center text-muted">Nenhum visitante encontrado</td>
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

<div class="modal fade" id="viewDataModalVisitante" tabindex="-1" aria-labelledby="viewDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 shadow-sm border-0">
            <div class="modal-header bg-primary text-white rounded-top-4 py-3 px-4">
                <h5 class="modal-title" id="viewDataModalLabel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-lines-fill me-2" viewBox="0 0 16 16">
                        <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z"/>
                    </svg>
                    Detalhes do Visitante
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body px-4 py-4">
                <div class="row g-4">
                    <!-- Coluna da Foto -->
                    <div class="col-md-4 text-center">
                        <img id="modal-foto" src="" alt="Foto do Visitante" class="img-fluid rounded-3 shadow-sm border" style="max-height: 300px; object-fit: cover;">
                    </div>

                    <!-- Coluna dos Dados -->
                    <div class="col-md-8">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong class="text-secondary">Nome:</strong> <span id="modal-nome" class="ms-2"></span>
                            </li>
                            <li class="list-group-item">
                                <strong class="text-secondary">CPF:</strong> <span id="modal-cpf" class="ms-2"></span>
                            </li>
                            <li class="list-group-item">
                                <strong class="text-secondary">Empresa:</strong> <span id="modal-empresa" class="ms-2"></span>
                            </li>
                            <li class="list-group-item">
                                <strong class="text-secondary">Marca:</strong> <span id="modal-marca" class="ms-2"></span>
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
                            <li class="list-group-item">
                                <strong class="text-secondary">Celular:</strong> <span id="modal-celular" class="ms-2"></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
