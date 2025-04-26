@extends('layouts.dashboard')

@section('page_dashboard')

<div class="container-fluid py-4" style="min-height: 80vh;"> {{-- Aumentando a altura mínima da div principal --}}

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Registros de Acessos</h3>
        <a href="{{ route('create.registro') }}" class="btn btn-success">Novo Registro</a>
    </div>

    <div class="row mb-4">
        <div class="col-md-4 col-sm-6 col-12 mb-3">
            <div class="card shadow-sm text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total de Acessos</h5>
                    <h3 class="card-text">{{ $totalAcessos }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12 mb-3">
            <div class="card shadow-sm text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Entradas Hoje</h5>
                    <h3 class="card-text">{{ $entradasHoje }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12 mb-3">
            <div class="card shadow-sm text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Saídas Hoje</h5>
                    <h3 class="card-text">{{ $saidasHoje }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div>
        @include('components.alerts', [
            'success' => session()->get('success'), 
            'message' =>  session()->get('message')
        ])
    </div>

    <div class="card shadow-sm" style="min-height: 600px;">
        <div class="card-body d-flex flex-column" style="height: 100%;">
            <h5 class="card-title mb-3">Lista de Registros</h5>
    
            <div class="table-responsive flex-grow-1" style="min-height: 0; overflow-y: auto;">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Documentação</th>
                            <th>Empresa</th>
                            <th>Veículo</th>
                            <th>Placa</th>
                            <th>Tipo Acesso</th>
                            <th>Observações</th>
                            <th>Entrada</th>
                            <th>Saída</th>
                            <th style="position: static;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($registros as $registro)
                            <tr>
                                <td>{{ $registro->id }}</td>
                                <td>{{ $registro->nome }}</td>
                                <td>{{ $registro->documento }}</td>
                                <td>{{ $registro->empresa }}</td>
                                <td>{{ $registro->veiculo }}</td>
                                <td>{{ $registro->placa }}</td>
                                <td>{{ ucfirst($registro->tipo_acesso) }}</td>
                                <td>{{ $registro->observacoes }}</td>
                                <td>
                                    @if ($registro->entrada)
                                        <span class="badge bg-success">{{ \Carbon\Carbon::parse($registro->entrada)->format('H:i') }}</span>
                                    @else
                                        <span class="badge bg-secondary">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($registro->saida)
                                        <span class="badge bg-danger">{{ \Carbon\Carbon::parse($registro->saida)->format('H:i') }}</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pendente</span>
                                    @endif
                                </td>
                                <td class="action-cell" style="position: relative;">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="dropdownMenuButton-{{ $registro->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                                <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                            </svg>
                                        </button>
                                        <ul class="dropdown-menu show-on-top" aria-labelledby="dropdownMenuButton-{{ $registro->id }}">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('edit.registro', $registro->id) }}">
                                                    <i class="bi bi-pencil-fill"></i> Editar
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $registro->id }}">
                                                    <i class="bi bi-trash3-fill"></i> Remover
                                                </a>
                                            </li>
                                            @if (!$registro->saida)
                                                <li>
                                                    <form action="{{ route('saida.registro', $registro->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item d-flex align-items-center gap-2">
                                                            <i class="bi bi-box-arrow-right text-danger"></i> Registrar Saída
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
    
                            <!-- Modal de confirmação de exclusão -->
                            <div class="modal fade" id="confirmDeleteModal{{ $registro->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $registro->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="{{ route('destroy.registro', $registro->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
    
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $registro->id }}">Confirmar Exclusão</h5>
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
            </div> <!-- Fim do table-responsive -->
        </div> <!-- Fim do card-body -->
    </div> <!-- Fim do card -->

    {{-- Paginação Customizada --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $registros->links('pagination::bootstrap-5') }}
    </div>

</div>

@endsection