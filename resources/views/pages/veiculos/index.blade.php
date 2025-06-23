@extends('layouts.dashboard')

@section('page_dashboard')

<header class="mb-4 px-4 py-3 bg-white border rounded shadow-sm">

    {{-- Linha do título + botão --}}
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-3">
        <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3" style="font-size: 1.75rem;">
            <span class="icon-container d-flex align-items-center justify-content-center"
                  style="width: 36px; height: 36px; background: linear-gradient(135deg, #4e73df, #224abe); border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
                <!-- SVG do ícone -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-car-front-fill" viewBox="0 0 16 16">
                    <path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.319.38.404.5.25.855.715.965 1.262l.335 1.679q.05.242.049.49v.413c0 .814-.39 1.543-1 1.997V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.338c-1.292.048-2.745.088-4 .088s-2.708-.04-4-.088V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.892c-.61-.454-1-1.183-1-1.997v-.413a2.5 2.5 0 0 1 .049-.49l.335-1.68c.11-.546.465-1.012.964-1.261a.8.8 0 0 0 .381-.404l.792-1.848ZM3 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2m10 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2M6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2zM2.906 5.189a.51.51 0 0 0 .497.731c.91-.073 3.35-.17 4.597-.17s3.688.097 4.597.17a.51.51 0 0 0 .497-.731l-.956-1.913A.5.5 0 0 0 11.691 3H4.309a.5.5 0 0 0-.447.276L2.906 5.19Z"/>
                </svg>
            </span>
            Cadastro de Veículos
        </h3>
        <a href="{{ route('create.veiculo') }}"
           class="btn btn-primary btn-sm rounded-pill text-white"
           title="Adicionar novo veículo" aria-label="Adicionar novo veículo">
            Novo Veículo
        </a>
    </div>

    <form method="GET" action="{{ route('index.veiculo') }}"
        class="d-flex flex-wrap align-items-end gap-3 justify-content-end">

        {{-- Buscar --}}
        <div class="d-flex flex-column flex-grow-1" style="min-width: 200px;">
            <label for="search" class="form-label mb-1 small text-secondary">Buscar</label>
            <input type="text" name="search" id="search"
                class="form-control form-control-sm rounded-pill"
                placeholder="Placa, Modelo, Marca..."
                value="{{ request('search') }}"
                aria-label="Buscar por placa, modelo ou marca">
        </div>

        {{-- Cor --}}
        <div class="d-flex flex-column flex-grow-1" style="min-width: 200px;">
            <label for="cor" class="form-label mb-1 small text-secondary">Cor</label>
            <input type="text" name="cor" id="cor"
                class="form-control form-control-sm rounded"
                placeholder="Ex: Vermelho"
                value="{{ request('cor') }}"
                aria-label="Filtrar por cor">
        </div>

        {{-- Tipo --}}
        <div class="d-flex flex-column flex-grow-1" style="min-width: 200px;">
            <label for="tipo" class="form-label mb-1 small text-secondary">Tipo</label>
            <select name="tipo" id="tipo"
                    class="form-select form-select-sm rounded"
                    aria-label="Filtrar por tipo de veículo">
                <option value="">Todos</option>
                <option value="Carro" @selected(request('tipo') == 'Carro')>Carro</option>
                <option value="Moto" @selected(request('tipo') == 'Moto')>Moto</option>
                <option value="Outro" @selected(request('tipo') == 'Outro')>Outro</option>
            </select>
        </div>

        {{-- Ações --}}
        <div class="d-flex gap-2" style="min-width: 160px;">
            <button type="submit"
                    class="btn btn-primary btn-sm rounded-pill px-4"
                    title="Aplicar filtro" aria-label="Filtrar">
                🔍 Filtrar
            </button>
            <a href="{{ route('index.veiculo') }}"
            class="btn btn-outline-secondary btn-sm rounded-pill px-4"
            title="Limpar filtros" aria-label="Limpar filtros">
                ❌ Limpar
            </a>
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
        <h5 class="card-title mb-3 fw-semibold">Lista de Veículos</h5>

        <div class="table-responsive flex-grow-1">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tipo</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Cor</th>
                        <th>Placa</th>
                        <th>Observação</th>
                        <th>Criado em</th>
                        <th>Atualizado em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($veiculos as $veiculo)
                    <tr>
                        <td>
                            @if ($veiculo->tipo === 'Carro')
                                <span class="badge bg-primary text-white">Carro</span>
                            @elseif ($veiculo->tipo === 'Moto')
                                <span class="badge bg-primary text-white">Moto</span>
                            @elseif($veiculo->tipo === 'Caminhão')
                                <span class="badge bg-primary text-white">Caminhão</span>
                            @endif
                        </td>
                        <td>{{ $veiculo->marca }}</td>
                        <td>{{ $veiculo->modelo }}</td>
                        <td>{{ $veiculo->cor }}</td>
                        <td>{{ $veiculo->placa }}</td>
                        <td>{{ $veiculo->observacoes }}</td>
                        <td>{{ $veiculo->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $veiculo->updated_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 32px; height: 32px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi" viewBox="0 0 16 16">
                                            <path d="M8 3.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                        </svg>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end show-on-top">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('edit.veiculo', $veiculo->id) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#0d6efd" viewBox="0 0 16 16">
                                                <path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-4 1.5a.5.5 0 0 1-.65-.65l1.5-4a.5.5 0 0 1 .11-.168l10-10zM11.207 2L13 3.793 14.293 2.5 12.5.707 11.207 2zM12 4.207 11.793 4 3 12.793 3.207 13 12 4.207zM2.5 13.5 4 13l-.5-.5-1.5.5.5 1.5z"/>
                                            </svg>
                                            Editar
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2 text-danger" href="#" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $veiculo->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5a.5.5 0 0 1 .5.5V12a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5.5a.5.5 0 0 1 1 0V12a.5.5 0 0 1-1 0V6zm3-.5a.5.5 0 0 1 .5.5V12a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5z"/>
                                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1 0-2h4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h4a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3a.5.5 0 0 0 0 1H13.5a.5.5 0 0 0 0-1H2.5z"/>
                                            </svg>
                                            Remover
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                     {{-- Modal de Confirmação --}}
                    <div class="modal fade" id="confirmDeleteModal{{ $veiculo->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $veiculo->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content shadow">
                                <form action="{{ route('destroy.veiculo', $veiculo->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Confirmar Exclusão</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                    </div>
                                    <div class="modal-body">
                                        Tem certeza que deseja remover o veiculo <strong>#{{ $veiculo->id }}</strong> ({{ $veiculo->modelo }} - {{ $veiculo->placa}})?
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
                        <td colspan="13" class="text-center text-muted">Nenhum veículo cadastrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
