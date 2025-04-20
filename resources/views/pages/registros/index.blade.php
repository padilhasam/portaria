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
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title mb-3">Gráfico de Acessos do Dia</h5>
            <canvas id="graficoAcessos"
                height="100"
                data-entradas="{{ $entradasHoje }}"
                data-saidas="{{ $saidasHoje }}">
            </canvas>
        </div>
    </div>

    <!-- Tabela de registros -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3">Lista de Registros</h5>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Documentação</th>
                            <th>Tipo</th>
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
                                <td>{{ ucfirst($registro->tipo_morador) }}</td>
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
                                        <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('edit.registro', $registro->id) }}">
                                                    <i class="bi bi-pencil-square me-2"></i> Editar
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $registro->id }}">
                                                    <i class="bi bi-trash me-2"></i> Remover
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

                            <!-- Modal de confirmação -->
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
                                <td colspan="8" class="text-center text-muted">Nenhum registro encontrado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Paginação -->
                <div class="mt-3 d-flex justify-content-center">
                    {{ $registros->links() }}
                </div>

            </div>
        </div>
    </div>

</div>

@endsection