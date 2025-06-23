@extends('layouts.dashboard')

@section('page_dashboard')

<header class="mb-4 px-4 py-3 bg-white border rounded shadow-sm">

    {{-- Linha do título + botão --}}
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-3">
        <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3" style="font-size: 1.75rem;">
            <span class="icon-container d-flex align-items-center justify-content-center"
                  style="width: 36px; height: 36px; background: linear-gradient(135deg, #0d6efd, #0a58ca); border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white"
                     class="bi bi-people-fill" viewBox="0 0 16 16">
                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                </svg>
            </span>
            Cadastro de Prestadores
        </h3>

        <a href="{{ route('create.prestador') }}" class="btn btn-primary btn-sm rounded-pill text-white">
            Novo Prestador
        </a>
    </div>

    {{-- Linha dos filtros --}}
    <form method="GET" action="{{ route('index.prestador') }}" class="row g-3 align-items-end">

        {{-- Buscar --}}
        <div class="col-12 col-md-4">
            <label for="search" class="form-label mb-1 small text-secondary">Buscar</label>
            <input type="text" name="search" id="search" class="form-control form-control-sm rounded-pill w-100"
                   placeholder="Nome, CNPJ..." value="{{ request('search') }}">
        </div>

        {{-- Empresa - Select --}}
        <div class="col-12 col-md-2">
            <label for="empresa" class="form-label mb-1 small text-secondary">Empresa</label>
            <select name="empresa" id="empresa" class="form-select form-select-sm rounded w-100">
                <option value="">Todas</option>
                @foreach($empresas as $empresa)
                    <option value="{{ $empresa }}" @selected(request('empresa') == $empresa)>{{ $empresa }}</option>
                @endforeach
            </select>
        </div>

        {{-- Data Início --}}
        <div class="col-6 col-md-2">
            <label for="data_inicio" class="form-label mb-1 small text-secondary">Criado de</label>
            <input type="date" name="data_inicio" id="data_inicio" class="form-control form-control-sm w-100"
                   value="{{ request('data_inicio') }}">
        </div>

        {{-- Data Fim --}}
        <div class="col-6 col-md-2">
            <label for="data_fim" class="form-label mb-1 small text-secondary">Até</label>
            <input type="date" name="data_fim" id="data_fim" class="form-control form-control-sm w-100"
                   value="{{ request('data_fim') }}">
        </div>

        {{-- Botões alinhados à direita e responsivos --}}
        <div class="col-12 col-md-2 d-flex gap-2 justify-content-md-end justify-content-start flex-wrap">
            <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 mb-2 mb-md-0">🔍 Filtrar</button>
            <a href="{{ route('index.prestador') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-4 mb-2 mb-md-0">❌ Limpar</a>
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
        <h5 class="card-title mb-3 fw-semibold">Lista de Prestadores</h5>

        <div class="table-responsive flex-grow-1">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Razão Social</th>
                        <th>CNPJ</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Prestador</th>
                        <th>CPF</th>
                        <th>Celular</th>
                        <th>Criado em</th>
                        <th>Atualizado em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($prestadores as $prestador)
                    <tr>
                        <td><span class="badge bg-primary text-white">{{ $prestador->empresa ?? '-' }}</td>
                        <td>{{ $prestador->cnpj ?? '-' }}</td>
                        <td>{{ $prestador->tel_fixo ?? '-' }}</td>
                        <td>{{ $prestador->email ?? '-' }}</td>
                        <td><span class="badge bg-primary text-white">{{ $prestador->prestador }}</td>
                        <td>{{ $prestador->documento }}</td>
                        <td>{{ $prestador->celular }}</td>
                        <td>{{ $prestador->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $prestador->updated_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 32px; height: 32px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi" viewBox="0 0 16 16">
                                        <path d="M8 3.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                    </svg>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end show-on-top">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('edit.prestador', $prestador->id) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#0d6efd" viewBox="0 0 16 16">
                                                <path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-4 1.5a.5.5 0 0 1-.65-.65l1.5-4a.5.5 0 0 1 .11-.168l10-10zM11.207 2L13 3.793 14.293 2.5 12.5.707 11.207 2zM12 4.207 11.793 4 3 12.793 3.207 13 12 4.207zM2.5 13.5 4 13l-.5-.5-1.5.5.5 1.5z"/>
                                            </svg>
                                            Editar
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2 text-danger" href="#" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $prestador->id }}">
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
                                            data-bs-target="#viewDataModalPrestador"
                                            data-empresa="{{ $prestador->empresa ?? '-' }}"
                                            data-cnpj="{{ $prestador->cnpj ?? '-' }}"
                                            data-telefone="{{ $prestador->tel_fixo ?? '-' }}"
                                            data-email="{{ $prestador->email ?? '-' }}"
                                            data-prestador="{{ $prestador->prestador }}"
                                            data-cpf="{{ $prestador->documento }}"
                                            data-celular="{{ $prestador->celular ?? '-' }}"
                                            data-acompanhante="{{ $prestador->acompanhante ?? '-' }}"
                                            data-marca="{{ optional($prestador->veiculo)->marca ?? '-' }}"
                                            data-modelo="{{ optional($prestador->veiculo)->modelo ?? '-' }}"
                                            data-cor="{{ optional($prestador->veiculo)->cor ?? '-' }}"
                                            data-placa="{{ optional($prestador->veiculo)->placa ?? '-' }}">
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
                    <div class="modal fade" id="confirmDeleteModal{{ $prestador->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $prestador->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content shadow">
                                <form action="{{ route('destroy.prestador', $prestador->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Confirmar Exclusão</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                    </div>
                                    <div class="modal-body">
                                        Tem certeza que deseja remover o prestador <strong>#{{ $prestador->id }}</strong> ({{ $prestador->empresa }})?
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
                        <td colspan="15" class="text-center text-muted">Nenhum serviço cadastrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $prestadores->links('pagination::bootstrap-5') }}
</div>

<!-- Modal de Visualização -->
<div class="modal fade" id="viewDataModalPrestador" tabindex="-1" aria-labelledby="viewDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 shadow-sm border-0">
            <div class="modal-header bg-primary text-white rounded-top-4 py-3 px-4">
                <h5 class="modal-title" id="viewDataModalLabel">
                    🛠️ Detalhes do Serviço
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body px-4 py-4">
                <div class="row g-4">
                    <div class="col-md-8">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong class="text-secondary">Empresa:</strong><span id="modal-empresa" class="ms-2"></span>
                            </li>
                            <li class="list-group-item">
                                <strong class="text-secondary">CNPJ:</strong> <span id="modal-cnpj" class="ms-2"></span>
                            </li>
                            <li class="list-group-item">
                                <strong class="text-secondary">Telefone:</strong> <span id="modal-telefone" class="ms-2"></span>
                            </li>
                            <li class="list-group-item">
                                <strong class="text-secondary">Email:</strong> <span id="modal-email" class="ms-2"></span>
                            </li>
                            <li class="list-group-item">
                                <strong class="text-secondary">Responsável:</strong> <span id="modal-prestador" class="ms-2"></span>
                            </li>
                            <li class="list-group-item">
                                <strong class="text-secondary">CPF:</strong> <span id="modal-cpf" class="ms-2"></span>
                            </li>
                            <li class="list-group-item">
                                <strong class="text-secondary">Acompanhantes:</strong> <span id="modal-acompanhante" class="ms-2"></span>
                            </li>
                            <li class="list-group-item">
                                <strong class="text-secondary">Celular:</strong> <span id="modal-celular" class="ms-2"></span>
                            </li>
                            <li class="list-group-item">
                                <strong class="text-secondary">Veículo:</strong> <span id="modal-modelo" class="ms-2"></span>
                            </li>
                            <li class="list-group-item">
                                <strong class="text-secondary">Marca:</strong> <span id="modal-marca" class="ms-2"></span>
                            </li>
                            <li class="list-group-item">
                                <strong class="text-secondary">Cor:</strong> <span id="modal-cor" class="ms-2"></span>
                            </li>
                            <li class="list-group-item">
                                <strong class="text-secondary">Placa:</strong> <span id="modal-placa" class="ms-2"></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
