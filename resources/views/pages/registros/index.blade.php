@extends('layouts.dashboard')

@section('page_dashboard')

    <header class="mb-4 px-4 py-3 bg-white border rounded shadow-sm">

        <div class="d-flex align-items-center justify-content-between mb-3">
            <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3" style="font-size: 1.75rem;">
                <span class="icon-container d-flex align-items-center justify-content-center"
                    style="width: 36px; height: 36px; background: linear-gradient(135deg, #4e73df, #224abe); border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-shield-lock-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.8 11.8 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7 7 0 0 0 1.048-.625 11.8 11.8 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.54 1.54 0 0 0-1.044-1.263 63 63 0 0 0-2.887-.87C9.843.266 8.69 0 8 0m0 5a1.5 1.5 0 0 1 .5 2.915l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99A1.5 1.5 0 0 1 8 5"/>
                    </svg>
                </span>
                Registros de Acessos
            </h3>

            <a href="{{ route('create.registro') }}" class="btn btn-primary btn-sm rounded-pill text-white">
                Novo Registro
            </a>

        </div>

       <form method="GET" action="{{ route('index.registro') }}" class="d-flex flex-wrap gap-3 align-items-end">

            {{-- Campo de Busca --}}
            <div class="d-flex flex-column flex-grow-1" style="min-width: 180px;">
                <label for="search" class="form-label mb-1 small text-secondary">Buscar</label>
                <input type="text" name="search" id="search" class="form-control form-control-sm rounded-pill border-dark"
                    placeholder="Nome, CPF, Bloco, Apartamento..." value="{{ request('search') }}">
            </div>

            {{-- Data de Início --}}
            <div class="d-flex flex-column" style="min-width: 120px;">
                <label for="entrada_inicio" class="form-label mb-1 small text-secondary">De</label>
                <input type="date" name="entrada_inicio" id="entrada_inicio" class="form-control form-control-sm rounded"
                    value="{{ request('entrada_inicio') }}">
            </div>

            {{-- Data de Fim --}}
            <div class="d-flex flex-column" style="min-width: 120px;">
                <label for="entrada_fim" class="form-label mb-1 small text-secondary">Até</label>
                <input type="date" name="entrada_fim" id="entrada_fim" class="form-control form-control-sm rounded"
                    value="{{ request('entrada_fim') }}">
            </div>

            {{-- Visitante --}}
            <div class="d-flex flex-column" style="min-width: 150px;">
                <label for="visitante_id" class="form-label mb-1 small text-secondary">Visitante</label>
                <select name="visitante_id" id="visitante_id" class="form-select form-select-sm rounded">
                    <option value="">Todos</option>
                    @foreach($visitantes as $visitante)
                        <option value="{{ $visitante->id }}" {{ request('visitante_id') == $visitante->id ? 'selected' : '' }}>
                            {{ $visitante->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tipo de Acesso --}}
            <div class="d-flex flex-column" style="min-width: 130px;">
                <label for="tipo" class="form-label mb-1 small text-secondary">Tipo de Acesso</label>
                <select name="tipo" id="tipo" class="form-select form-select-sm rounded">
                    <option value="">Todos</option>
                    <option value="entrada" {{ request('tipo') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                    <option value="saida" {{ request('tipo') == 'saida' ? 'selected' : '' }}>Saída</option>
                </select>
            </div>

            {{-- Status --}}
            <div class="d-flex flex-column" style="min-width: 130px;">
                <label for="status" class="form-label mb-1 small text-secondary">Status</label>
                <select name="status" id="status" class="form-select form-select-sm rounded">
                    <option value="">Todos</option>
                    <option value="liberado" {{ request('status') == 'liberado' ? 'selected' : '' }}>Liberado</option>
                    <option value="bloqueado" {{ request('status') == 'bloqueado' ? 'selected' : '' }}>Bloqueado</option>
                </select>
            </div>

            {{-- Botões --}}
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4">🔍 Filtrar</button>
                <a href="{{ route('index.registro') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-4">❌ Limpar</a>
            </div>
        </form>

    </header>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3 mb-3">

        <div class="col">
            <div class="card border-0 shadow-sm rounded-4 text-white" style="background-color: #375a7f;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="fs-6 fw-semibold mb-1">Total de Acessos</div>
                        <div class="fs-3 fw-bold">{{ $totalAcessos }}</div>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-people-fill" viewBox="0 0 16 16">
                        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card border-0 shadow-sm rounded-4 text-white" style="background-color: #375a7f;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="fs-6 fw-semibold mb-1">Entradas Hoje</div>
                        <div class="fs-3 fw-bold">{{ $entradasHoje }}</div>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-door-open-fill" viewBox="0 0 16 16">
                        <path d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15zM11 2h.5a.5.5 0 0 1 .5.5V15h-1zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card border-0 shadow-sm rounded-4 text-white" style="background-color: #375a7f;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="fs-6 fw-semibold mb-1">Saídas Hoje</div>
                        <div class="fs-3 fw-bold">{{ $saidasHoje }}</div>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-door-closed-fill" viewBox="0 0 16 16">
                        <path d="M12 1a1 1 0 0 1 1 1v13h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V2a1 1 0 0 1 1-1zm-2 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card border-0 shadow-sm rounded-4 text-white" style="background-color: #375a7f;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="fs-6 fw-semibold mb-1">Acessos Bloqueados</div>
                        <div class="fs-3 fw-bold">{{ $acessosBloqueados }}</div>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-shield-fill-exclamation" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.8 11.8 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7 7 0 0 0 1.048-.625 11.8 11.8 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.54 1.54 0 0 0-1.044-1.263 63 63 0 0 0-2.887-.87C9.843.266 8.69 0 8 0m-.55 8.502L7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0M8.002 12a1 1 0 1 1 0-2 1 1 0 0 1 0 2"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        @include('components.alerts', [
            'success' => session()->get('success'),
            'message' => session()->get('message')
        ])
    </div>

    <div class="card shadow-sm border-0 rounded-4" style="min-height: 600px;">
        <div class="card-body d-flex flex-column">
            <h5 class="card-title mb-3 fw-semibold">Lista de Registros</h5>

            <div class="table-responsive flex-grow-1">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nome</th>
                            <th>Documentação</th>
                            <th>Empresa</th>
                            <th>Veículo</th>
                            <th>Placa</th>
                            <th>Apartamento</th>
                            <th>Tipo Acesso</th>
                            <th>Status</th>
                            <th>Observações</th>
                            <th>Data</td>
                            <th>Entrada</th>
                            <th>Saída</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($registros as $registro)
                            <tr>
                                <td><strong>{{ $registro->nome ?? '—' }}</strong></span></td><!--<span class="badge bg-primary text-white">-->
                                <td>{{ $registro->documento ?? '—' }}</td>
                                <td>{{ $registro->empresa ?? '—' }}</td>
                                <td>{{ $registro->veiculo ?? '—' }}</td>
                                <td>{{ $registro->placa ?? '—' }}</td>
                                <td>
                                    {{ $registro->apartamento ? 'Bloco ' . $registro->apartamento->bloco . ' - Apto. ' . $registro->apartamento->numero : '—' }}
                                </td>
                                <td>
                                    <span class="badge bg-info text-white">
                                        {{ ucfirst($registro->tipo_acesso) }}
                                    </span>
                                </td>
                                <td>
                                    @if($registro->status == 'liberado')
                                        <span class="badge bg-success rounded-pill">Liberado</span>
                                    @else
                                        <span class="badge bg-danger rounded-pill">Bloqueado</span>
                                    @endif
                                </td>
                                <td>{{ $registro->observacoes }}</td>
                                <td>{{ $registro->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @if ($registro->entrada)
                                        <span class="badge bg-success-subtle text-success">{{ \Carbon\Carbon::parse($registro->entrada)->format('H:i') }}</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($registro->saida)
                                        <span class="badge bg-danger-subtle text-danger">{{ \Carbon\Carbon::parse($registro->saida)->format('H:i') }}</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning">Pendente</span>
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
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-2 text-danger" href="#" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $registro->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                        <path d="M5.5 5.5a.5.5 0 0 1 .5.5V12a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5.5a.5.5 0 0 1 1 0V12a.5.5 0 0 1-1 0V6zm3-.5a.5.5 0 0 1 .5.5V12a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5z"/>
                                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1 0-2h4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h4a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3a.5.5 0 0 0 0 1H13.5a.5.5 0 0 0 0-1H2.5z"/>
                                                    </svg>
                                                    Remover
                                                </a>
                                            </li>
                                            @if (!$registro->saida)
                                                <li>
                                                    <form action="{{ route('saida.registro', $registro->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-success">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                                <path d="M10.854 5.146a.5.5 0 0 0-.708.708L11.293 7H1.5a.5.5 0 0 0 0 1h9.793L10.146 9.146a.5.5 0 0 0 .708.708l2-2a.5.5 0 0 0 0-.708l-2-2z"/>
                                                            </svg>
                                                            Registrar Saída
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            {{-- Modal de Confirmação --}}
                            <div class="modal fade" id="confirmDeleteModal{{ $registro->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $registro->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content shadow">
                                        <form action="{{ route('destroy.registro', $registro->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirmar Exclusão</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                            </div>
                                            <div class="modal-body">
                                                Tem certeza que deseja remover o registro <strong>#{{ $registro->id }}</strong> ({{ $registro->nome }})?
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
                                <td colspan="11" class="text-center text-muted">Nenhum registro encontrado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Paginação --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $registros->links('pagination::bootstrap-5') }}
    </div>

    @endsection
