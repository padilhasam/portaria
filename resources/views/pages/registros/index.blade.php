@extends('layouts.dashboard')

@section('page_dashboard')

<div class="container-fluid py-4">

    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Registros de Acessos</h3>
        <a href="{{ route('create.registro') }}" class="btn btn-success">Novo Registro</a>
    </div>

    <!-- Estatísticas -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total de Acessos</h5>
                    <h3 class="card-text">{{ $totalAcessos }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Entradas Hoje</h5>
                    <h3 class="card-text">{{ $entradasHoje }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Saídas Hoje</h5>
                    <h3 class="card-text">{{ $saidasHoje }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico de acessos -->
    <!--<div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title mb-3">Gráfico de Acessos do Dia</h5>
            <canvas id="graficoAcessos"
                height="100"
                data-entradas="{{ $entradasHoje }}"
                data-saidas="{{ $saidasHoje }}">
            </canvas>
        </div>
    </div>-->

    <!-- Tabela de registros -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3">Lista de Registros</h5>
            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                <table class="table align-middle">
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
                            <th>Ações</th>
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
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                                <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                            </svg>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('edit.registro', $registro->id) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                                    </svg>
                                                    Editar
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $registro->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                                    </svg>
                                                    Remover
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
    
                <div class="mt-3 d-flex justify-content-center">
                    {{ $registros->links() }}
                </div>
    
            </div>
        </div>
    </div>

</div>

@endsection