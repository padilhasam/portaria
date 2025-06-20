@extends('layouts.dashboard')

@section('page_dashboard')

    <header class="mb-2 px-4 py-3 bg-white border rounded shadow-sm d-flex align-items-center justify-content-between">
        <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3">
            <span class="icon-container" style="width: 32px; height: 32px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-shield-lock-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.8 11.8 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7 7 0 0 0 1.048-.625 11.8 11.8 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.54 1.54 0 0 0-1.044-1.263 63 63 0 0 0-2.887-.87C9.843.266 8.69 0 8 0m0 5a1.5 1.5 0 0 1 .5 2.915l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99A1.5 1.5 0 0 1 8 5"/>
                  </svg>
            </span>
            Registros de Acessos
        </h3>
        <div class="d-flex align-items-center gap-3">
            <!-- Formulário de busca com design melhorado -->
            <form method="GET" action="{{ route('index.morador') }}" class="d-flex align-items-center" role="search">
                <input type="text" name="search" class="form-control form-control-sm me-2 rounded-pill border-dark" placeholder="Buscar por nome, CPF..." value="{{ request('search') }}">
                <button class="btn btn-outline-dark btn-sm rounded-pill" type="submit">
                    <span class="d-none d-sm-inline">Buscar</span>
                    <span class="d-inline d-sm-none">🔍</span> <!-- Ícone para mobile -->
                </button>
            </form>

            <!-- Botão 'Novo Registro' com efeito de hover -->
            <a href="{{ route('create.registro') }}" class="btn btn-success btn-sm text-white rounded-pill transition-shadow">
                Novo Registro
            </a>
        </div>
    </header>

    <div class="row">
        <div class="col-md-4 col-sm-6 col-12 mb-3">
            <div class="card border-0 shadow-sm rounded-4 text-white" style="background: linear-gradient(135deg, #4e73df, #224abe);">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="fs-6 fw-semibold mb-1">Total de Acessos</div>
                        <div class="fs-3 fw-bold">{{ $totalAcessos }}</div>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="bi bi-people-fill fs-3 text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-md-4 col-sm-6 col-12 mb-3">
            <div class="card border-0 shadow-sm rounded-4 text-white" style="background: linear-gradient(135deg, #1cc88a, #198754);">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="fs-6 fw-semibold mb-1">Entradas Hoje</div>
                        <div class="fs-3 fw-bold">{{ $entradasHoje }}</div>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="bi bi-door-open-fill fs-3 text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-md-4 col-sm-6 col-12 mb-3">
            <div class="card border-0 shadow-sm rounded-4 text-white" style="background: linear-gradient(135deg, #e74a3b, #c0392b);">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="fs-6 fw-semibold mb-1">Saídas Hoje</div>
                        <div class="fs-3 fw-bold">{{ $saidasHoje }}</div>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="bi bi-door-closed-fill fs-3 text-white"></i>
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
                            <th>Tipo Acesso</th>
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
                                <td><span class="badge bg-primary text-white">{{ $registro->nome ?? '—' }}</span></td>
                                <td>{{ $registro->documento ?? '—' }}</td>
                                <td>{{ $registro->empresa ?? '—' }}</td>
                                <td>{{ $registro->veiculo ?? '—' }}</td>
                                <td>{{ $registro->placa ?? '—' }}</td>
                                <td>
                                    <span class="badge bg-info text-white">
                                        {{ ucfirst($registro->tipo_acesso) }}
                                    </span>
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
                                                <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('edit.registro', $registro->id) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#0d6efd" viewBox="0 0 16 16">
                                                        <path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-4 1.5a.5.5 0 0 1-.65-.65l1.5-4a.5.5 0 0 1 .11-.168l10-10zM11.207 2L13 3.793 14.293 2.5 12.5.707 11.207 2zM12 4.207 11.793 4 3 12.793 3.207 13 12 4.207zM2.5 13.5 4 13l-.5-.5-1.5.5.5 1.5z"/>
                                                    </svg>
                                                    Editar
                                                </a>
                                            </li>
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