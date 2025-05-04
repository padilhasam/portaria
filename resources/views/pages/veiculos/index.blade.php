@extends('layouts.dashboard')

@section('page_dashboard')

<header class="mb-2 px-4 py-3 bg-white border rounded shadow-sm d-flex align-items-center justify-content-between">
    <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3">
        {{ svg('hugeicons-car-01') }}
        Cadastro de Veículos
    </h3>
    <a href="{{ route('create.veiculo') }}" class="btn btn-success btn-sm text-white rounded-pill transition-shadow">
        Novo Veículo
    </a>
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
        <h5 class="card-title mb-3 fw-semibold">Lista de Veículos</h5>

        <div class="table-responsive flex-grow-1">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Placa</th>
                        <th>Tipo</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Cor</th>
                        <th>Observação</th>
                        <th>Criado em</th>
                        <th>Atualizado em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($veiculos as $veiculo)
                    <tr>
                        <td><span class="badge bg-primary text-white">{{ $veiculo->id }}</span></td>
                        <td>{{ $veiculo->placa }}</td>
                        <td>{{ $veiculo->tipo }}</td>
                        <td>{{ $veiculo->marca }}</td>
                        <td>{{ $veiculo->modelo }}</td>
                        <td>{{ $veiculo->cor }}</td>
                        <td>{{ $veiculo->observacao }}</td>
                        <td>{{ $veiculo->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $veiculo->updated_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('edit.veiculo', ['id' => $veiculo->id]) }}" class="btn btn-primary btn-sm text-white">
                                    <i class="bi bi-pencil-fill me-1"></i> Editar
                                </a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white" data-bs-toggle="modal" data-bs-target="#removeItemModal" data-id="{{ $veiculo->id }}">
                                    <i class="bi bi-trash3-fill me-1"></i> Remover
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted">Nenhum veículo cadastrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection