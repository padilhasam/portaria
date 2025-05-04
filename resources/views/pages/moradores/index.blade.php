@extends('layouts.dashboard')

@section('page_dashboard')

<header class="mb-4 px-4 py-3 bg-white border rounded shadow-sm d-flex align-items-center justify-content-between">
    <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-2">
        {{ svg('hugeicons-user-multiple') }}
        Cadastro de Moradores
    </h3>
    <div class="d-flex gap-2">
        <form method="GET" action="{{ route('index.morador') }}" class="d-flex align-items-center" role="search">
            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Buscar por nome, CPF..." value="{{ request('search') }}">
            <button class="btn btn-outline-dark btn-sm" type="submit">Buscar</button>
        </form>
        <a href="{{ route('create.morador') }}" class="btn btn-success btn-sm text-white">
            Cadastrar Morador
        </a>
    </div>
</header>

<div class="table-responsive">
    <table class="table table-bordered align-middle">
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
                <td>
                    <span class="text-dark fw-semibold">{{ $morador->nome }}</span>
                </td>
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
                        <a href="javascript:void(0)" class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#viewDataModal" data-id="{{ $morador->id }}">
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

{{-- Modal de Visualização de Dados do Morador --}}
<div class="modal fade" id="viewDataModal" tabindex="-1" aria-labelledby="viewDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold" id="viewDataModalLabel">Dados Completos do Morador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <dl class="row">
                    <dt class="col-sm-3">Nome:</dt>
                    <dd class="col-sm-9"><span id="view-nome"></span></dd>

                    <dt class="col-sm-3">CPF:</dt>
                    <dd class="col-sm-9"><span id="view-documento"></span></dd>

                    <dt class="col-sm-3">Nascimento:</dt>
                    <dd class="col-sm-9"><span id="view-nascimento"></span></dd>

                    <dt class="col-sm-3">Telefone Fixo:</dt>
                    <dd class="col-sm-9"><span id="view-tel_fixo"></span></dd>

                    <dt class="col-sm-3">Celular:</dt>
                    <dd class="col-sm-9"><span id="view-celular"></span></dd>

                    <dt class="col-sm-3">E-mail:</dt>
                    <dd class="col-sm-9"><span id="view-email"></span></dd>

                    <dt class="col-sm-3">Tipo Morador:</dt>
                    <dd class="col-sm-9"><span id="view-tipo_morador"></span></dd>

                    <dt class="col-sm-3">Apartamento:</dt>
                    <dd class="col-sm-9">
                        Apto <span id="view-apartamento_numero"></span>
                        @if (optional($morador ?? null)->apartamento)
                            - Bloco <span id="view-apartamento_bloco"></span>
                            @if (optional($morador ?? null)->apartamento->ramal)
                                - Ramal <span id="view-apartamento_ramal"></span>
                            @endif
                        @endif
                    </dd>

                    <dt class="col-sm-3">Veículo:</dt>
                    <dd class="col-sm-9">
                        Placa <span id="view-veiculo_placa"></span>
                        @if (optional($morador ?? null)->veiculo)
                            - Modelo <span id="view-veiculo_modelo"></span>
                            @if (optional($morador ?? null)->veiculo->vaga)
                                - Vaga <span id="view-veiculo_vaga"></span>
                            @endif
                        @endif
                    </dd>

                    <dt class="col-sm-3">Criado em:</dt>
                    <dd class="col-sm-9"><span id="view-created_at"></span></dd>

                    <dt class="col-sm-3">Atualizado em:</dt>
                    <dd class="col-sm-9"><span id="view-updated_at"></span></dd>
                </dl>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal de Exclusão --}}
<div class="modal fade" id="removeItemModal" tabindex="-1" aria-labelledby="removeItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold" id="removeItemModalLabel">Confirmar Exclusão</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza de que deseja excluir este morador?</p>
                <span class="fw-bold" id="remove-nome"></span>
            </div>
            <div class="modal-footer">
                <form method="POST" action="{{ route('destroy.morador', ['id' => ':id']) }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" id="removeMoradorId">
                    <button type="submit" class="btn btn-danger">Excluir</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const viewDataModal = document.getElementById('viewDataModal');
    viewDataModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');

        fetch(`/moradores/${id}`)
            .then(response => response.json())
            .then(morador => {
                document.getElementById('view-nome').textContent = morador.nome;
                document.getElementById('view-documento').textContent = morador.documento;
                document.getElementById('view-nascimento').textContent = morador.nascimento ? new Date(morador.nascimento).toLocaleDateString() : '-';
                document.getElementById('view-tel_fixo').textContent = morador.tel_fixo || '-';
                document.getElementById('view-celular').textContent = morador.celular || '-';
                document.getElementById('view-email').textContent = morador.email || '-';
                document.getElementById('view-tipo_morador').textContent = morador.tipo_morador === 'aluguel' ? 'Aluguel' : (morador.tipo_morador === 'propria' ? 'Própria' : '-');
                document.getElementById('view-apartamento_numero').textContent = morador.apartamento?.numero || '-';
                document.getElementById('view-apartamento_bloco').textContent = morador.apartamento?.bloco || '-';
                document.getElementById('view-apartamento_ramal').textContent = morador.apartamento?.ramal || '-';
                document.getElementById('view-veiculo_placa').textContent = morador.veiculo?.placa || '-';
                document.getElementById('view-veiculo_modelo').textContent = morador.veiculo?.modelo || '-';
                document.getElementById('view-veiculo_vaga').textContent = morador.veiculo?.vaga || '-';
                document.getElementById('view-created_at').textContent = new Date(morador.created_at).toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' });
                document.getElementById('view-updated_at').textContent = new Date(morador.updated_at).toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' });
            })
            .catch(error => {
                console.error("Erro ao buscar dados do morador:", error);
                alert("Erro ao carregar os dados do morador.");
            });
    });

    const removeItemModal = document.getElementById('removeItemModal');
    removeItemModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const nome = button.closest('tr').querySelector('td:first-child').textContent;
        document.getElementById('removeMoradorId').value = id;
        document.getElementById('remove-nome').textContent = nome;
    });
</script>
@endpush

@endsection