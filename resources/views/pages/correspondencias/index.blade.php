@extends('layouts.dashboard')

@section('page_dashboard')

<header class="mb-2 px-4 py-3 bg-white border rounded shadow-sm d-flex align-items-center justify-content-between">
    <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3">
        <span class="icon-container d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: linear-gradient(135deg, #4e73df, #224abe); border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-box-seam-fill" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.01-.003.268-.108a.75.75 0 0 1 .558 0l.269.108.01.003zM10.404 2 4.25 4.461 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339L8 5.961 5.596 5l6.154-2.461z"/>
        </svg>
        </span>
        Lista de Correspondências
    </h3>
    <div>
        <a href="{{ route('create.correspondencia') }}" class="btn btn-primary btn-sm rounded-pill text-white">
            Nova Correspondência
        </a>
    </div>
</header>

@include('components.alerts', [
    'success' => session('success'),
    'message' => session('message')
])

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body d-flex flex-column">
        <div class="table-responsive flex-grow-1">
            <form method="GET" class="mb-3 d-flex flex-wrap gap-2 align-items-end">
                <div>
                    <label class="form-label">Morador</label>
                    <select name="id_morador" class="form-select form-select-sm">
                        <option value="">Todos</option>
                        @foreach ($moradores as $morador)
                            <option value="{{ $morador->id }}" @selected(request('id_morador') == $morador->id)>
                                {{ $morador->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Todos</option>
                        <option value="Recebida" @selected(request('status') == 'Recebida')>Recebida</option>
                        <option value="Entregue" @selected(request('status') == 'Entregue')>Entregue</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Data Inicial</label>
                    <input type="date" name="inicio" class="form-control form-control-sm" value="{{ request('inicio') }}">
                </div>

                <div>
                    <label class="form-label">Data Final</label>
                    <input type="date" name="fim" class="form-control form-control-sm" value="{{ request('fim') }}">
                </div>

                <button class="btn btn-sm btn-outline-primary rounded-pill">Filtrar</button>
                <a href="{{ route('index.correspondencia') }}" class="btn btn-sm btn-outline-secondary rounded-pill">Limpar</a>
            </form>
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Morador</th>
                        <th>Tipo</th>
                        <th>Remetente</th>
                        <th>Status</th>
                        <th>Recebida em</th>
                        <th>Entregue em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($correspondencias as $item)
                        <tr>
                            <td>
                                <strong>
                                    @if($item->morador)
                                        {{ $item->morador->nome }}
                                    @else
                                        Morador não encontrado (id_morador = {{ $item->id_morador }})
                                    @endif
                                </strong>
                            </td>
                            <td>{{ $item->tipo }}</td>
                            <td>{{ $item->remetente ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $item->status === 'Entregue' ? 'success' : 'warning' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->recebida_em)->format('d/m/Y H:i') }}</td>
                            <td>{{ $item->entregue_em ? \Carbon\Carbon::parse($item->entregue_em)->format('d/m/Y H:i') : '-' }}</td>
                            <td>
                                @if($item->status === 'Recebida')
                                    <form method="POST" action="{{ route('entregar.correspondencia', $item->id) }}">
                                        @csrf
                                        <button class="btn btn-success btn-sm rounded-pill">Marcar como Entregue</button>
                                    </form>
                                @else
                                    <span class="text-muted">Entregue</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Nenhuma correspondência registrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4 d-flex justify-content-center">
            {{ $correspondencias->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@endsection
