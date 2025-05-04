@extends('layouts.dashboard')

@section('page_dashboard')

<header class="mb-2 px-4 py-3 bg-white border rounded shadow-sm d-flex align-items-center justify-content-between">
    <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3">
        {{ svg('hugeicons-user-multiple') }}
        Cadastro de Moradores
    </h3>
    <div class="d-flex align-items-center gap-3">
        <!-- Formulário de busca -->
        <form method="GET" action="{{ route('index.morador') }}" class="d-flex align-items-center" role="search">
            <input type="text" name="search" class="form-control form-control-sm me-2 rounded-pill border-dark" placeholder="Buscar por nome, CPF..." value="{{ request('search') }}">
            <button class="btn btn-outline-dark btn-sm rounded-pill" type="submit">
                <span class="d-none d-sm-inline">Buscar</span>
                <span class="d-inline d-sm-none">🔍</span>
            </button>
        </form>
        <!-- Botão de cadastro -->
        <a href="{{ route('create.morador') }}" class="btn btn-success btn-sm text-white rounded-pill transition-shadow">
            Novo Morador
        </a>
    </div>
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
        <h5 class="card-title mb-3 fw-semibold">Lista de Moradores</h5>

        <!-- Tabela de moradores -->
        <div class="table-responsive flex-grow-1">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Apartamento</th>
                        <th>Veículo</th>
                        <th>Contato</th>
                        <th>Tipo</th>
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
                            @if (optional($morador->apartamento)->bloco)
                                - Bloco {{ optional($morador->apartamento)->bloco }}
                            @endif
                        </td>
                        <td>
                            {{ optional($morador->veiculo)->placa }}
                            @if (optional($morador->veiculo)->modelo)
                                - {{ optional($morador->veiculo)->modelo }}
                            @endif
                        </td>
                        <td>
                            {{ $morador->celular }}
                            @if ($morador->email)
                                <br><small class="text-muted">{{ $morador->email }}</small>
                            @endif
                        </td>
                        <td>
                            @if ($morador->tipo_morador === 'aluguel')
                                <span class="badge bg-info text-white">Aluguel</span>
                            @elseif ($morador->tipo_morador === 'propria')
                                <span class="badge bg-success text-white">Própria</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('edit.morador', ['id' => $morador->id]) }}" class="btn btn-primary btn-sm text-white">
                                    <i class="bi bi-pencil-fill me-1"></i> Editar
                                </a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white" data-bs-toggle="modal" data-bs-target="#removeItemModal" data-id="{{ $morador->id }}">
                                    <i class="bi bi-trash3-fill me-1"></i> Remover
                                </a>
                                <a href="javascript:void(0)" class="btn btn-info btn-sm text-white view-morador" data-bs-toggle="modal" data-bs-target="#viewDataModal"
                                   data-nome="{{ $morador->nome }}"
                                   data-cpf="{{ $morador->documento }}"
                                   data-apartamento="{{ optional($morador->apartamento)->numero }}{{ optional($morador->apartamento)->bloco ? ' - Bloco ' . optional($morador->apartamento)->bloco : '' }}"
                                   data-veiculo="{{ optional($morador->veiculo)->placa }}{{ optional($morador->veiculo)->modelo ? ' - ' . optional($morador->veiculo)->modelo : '' }}"
                                   data-celular="{{ $morador->celular }}"
                                   data-email="{{ $morador->email }}"
                                   data-tipo="{{ $morador->tipo_morador === 'aluguel' ? 'Aluguel' : 'Própria' }}">
                                    <i class="bi bi-eye-fill me-1"></i> Ver Dados
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Nenhum morador cadastrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para visualizar dados do morador -->
<div class="modal fade" id="viewDataModal" tabindex="-1" aria-labelledby="viewDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header bg-info text-white rounded-top-4">
                <h5 class="modal-title" id="viewDataModalLabel">Detalhes do Morador</h5>
                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <li class="list-group-item"><strong>Nome:</strong> <span id="modal-nome"></span></li>
                    <li class="list-group-item"><strong>CPF:</strong> <span id="modal-cpf"></span></li>
                    <li class="list-group-item"><strong>Apartamento:</strong> <span id="modal-apartamento"></span></li>
                    <li class="list-group-item"><strong>Veículo:</strong> <span id="modal-veiculo"></span></li>
                    <li class="list-group-item"><strong>Celular:</strong> <span id="modal-celular"></span></li>
                    <li class="list-group-item"><strong>Email:</strong> <span id="modal-email"></span></li>
                    <li class="list-group-item"><strong>Tipo:</strong> <span id="modal-tipo"></span></li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('viewDataModal');

        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            document.getElementById('modal-nome').textContent = button.getAttribute('data-nome');
            document.getElementById('modal-cpf').textContent = button.getAttribute('data-cpf');
            document.getElementById('modal-apartamento').textContent = button.getAttribute('data-apartamento');
            document.getElementById('modal-veiculo').textContent = button.getAttribute('data-veiculo');
            document.getElementById('modal-celular').textContent = button.getAttribute('data-celular');
            document.getElementById('modal-email').textContent = button.getAttribute('data-email') || 'N/A';
            document.getElementById('modal-tipo').textContent = button.getAttribute('data-tipo');
        });
    });
</script>
@endpush