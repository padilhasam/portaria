@extends('layouts.dashboard')

@section('page_dashboard')

{{-- ======================== Cabeçalho ======================== --}}
<header class="mb-4 px-4 py-3 bg-white border rounded shadow-sm">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

        {{-- Título com ícone --}}
        <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3">
            <span class="icon-container d-flex align-items-center justify-content-center"
                  style="width: 36px; height: 36px; background: linear-gradient(135deg, #0d6efd, #0a58ca); border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white"
                     class="bi bi-graph-up-arrow" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                          d="M0 0h1v15h15v1H0zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5"/>
                </svg>
            </span>
            Relatório de Atividades
        </h3>

        {{-- Botões de exportação --}}
        <div class="d-flex flex-wrap gap-2">
            <a id="btn-exportar-csv" class="btn btn-outline-success btn-sm rounded-pill px-4 d-flex align-items-center gap-2">
                <i class="bi bi-file-earmark-excel-fill"></i> Exportar CSV
            </a>

            <a id="btn-exportar-pdf" class="btn btn-outline-dark btn-sm rounded-pill px-4 d-flex align-items-center gap-2">
                <i class="bi bi-file-pdf-fill"></i> Exportar PDF
            </a>
        </div>

    </div>
</header>

{{-- ======================== Alertas ======================== --}}
@include('components.alerts', [
    'success' => session('success'),
    'message' => session('message')
])

{{-- ======================== KPIs ======================== --}}
<div class="row mb-4">
    @php
        $cards = [
            ['label' => 'Total de Acessos', 'value' => $total ?? 0, 'color' => 'success'],
            ['label' => 'Entradas', 'value' => $entradas ?? 0, 'color' => 'primary'],
            ['label' => 'Saídas', 'value' => $saidas ?? 0, 'color' => 'warning'],
            ['label' => 'Tentativas Negadas', 'value' => $negados ?? 0, 'color' => 'danger'],
        ];
    @endphp

    @foreach ($cards as $card)
        <div class="col-md-3">
            <div class="bg-white border shadow-sm rounded-4 p-3 text-center">
                <h6 class="text-muted">{{ $card['label'] }}</h6>
                <h3 class="fw-bold text-{{ $card['color'] }}">{{ number_format($card['value']) }}</h3>
            </div>
        </div>
    @endforeach
</div>

{{-- ======================== Filtros de Relatórios e Logs ======================== --}}
<div class="row gy-4 mb-4">

    {{-- Relatório de Acessos --}}
    <div class="col-md-6">
        <div class="border rounded p-4 bg-white shadow-sm h-100">
            <h5 class="fw-semibold mb-4">📄 Gerar Relatório de Acessos</h5>

            <form method="GET" action="{{ route('index.relatorio') }}" class="row g-3">
                <div class="col-6">
                    <label for="data_inicio" class="form-label fw-semibold">Data Início</label>
                    <input type="date" name="data_inicio" id="data_inicio" class="form-control form-control-sm rounded-pill"
                           value="{{ old('data_inicio', request('data_inicio')) }}">
                </div>

                <div class="col-6">
                    <label for="data_fim" class="form-label fw-semibold">Data Fim</label>
                    <input type="date" name="data_fim" id="data_fim" class="form-control form-control-sm rounded-pill"
                           value="{{ old('data_fim', request('data_fim')) }}">
                </div>

                <div class="col-6">
                    <label for="tipo" class="form-label fw-semibold">Tipo de Acesso</label>
                    <select name="tipo" id="tipo" class="form-select form-select-sm rounded-pill">
                        <option value="">Todos</option>
                        <option value="entrada" {{ request('tipo') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                        <option value="saida" {{ request('tipo') == 'saida' ? 'selected' : '' }}>Saída</option>
                        <option value="visitante" {{ request('tipo') == 'visitante' ? 'selected' : '' }}>Visitante</option>
                        <option value="prestador" {{ request('tipo') == 'prestador' ? 'selected' : '' }}>Prestador</option>
                    </select>
                </div>

                <div class="col-6">
                    <label for="apartamento" class="form-label fw-semibold">Apartamento</label>
                    <input type="text" name="apartamento" id="apartamento" class="form-control form-control-sm rounded-pill"
                           value="{{ request('apartamento') }}">
                </div>

                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-5 shadow-sm">
                        🔍 Gerar Relatório
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Logs do Sistema --}}
    <div class="col-md-6">
        <div class="border rounded p-4 bg-white shadow-sm h-100">
            <h5 class="fw-semibold mb-4">📝 Gerar Logs do Sistema</h5>

            <form method="GET" action="{{ route('logs.gerar') }}" class="row g-3">
                <div class="col-6 col-md-4">
                    <label for="tipo_log" class="form-label fw-semibold">Formato</label>
                    <select name="tipo" id="tipo_log" class="form-select form-select-sm rounded-pill">
                        <option value="pdf">PDF</option>
                        <option value="txt">TXT</option>
                    </select>
                </div>

                <div class="col-6 col-md-4">
                    <label for="nivel_log" class="form-label fw-semibold">Nível</label>
                    <select name="nivel" id="nivel_log" class="form-select form-select-sm rounded-pill">
                        <option value="">Todos</option>
                        <option value="INFO">INFO</option>
                        <option value="ERRO">ERRO</option>
                        <option value="WARNING">WARNING</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="data_log" class="form-label fw-semibold">Data</label>
                    <input type="date" name="data" id="data_log" class="form-control form-control-sm rounded-pill">
                </div>

                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-5 shadow-sm">
                        📄 Gerar Logs
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

{{-- ======================== Gráficos ======================== --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="bg-white p-4 shadow rounded-4 h-100">
            <h6 class="text-center text-primary fw-semibold">Acessos por Mês</h6>
            <canvas id="grafico-acessos" class="grafico mx-auto d-block"></canvas>
        </div>
    </div>
    <div class="col-md-4">
        <div class="bg-white p-4 shadow rounded-4 h-100">
            <h6 class="text-center text-success fw-semibold">Usuários Ativos</h6>
            <canvas id="grafico-usuarios" class="grafico mx-auto d-block"></canvas>
        </div>
    </div>
    <div class="col-md-4">
        <div class="bg-white p-4 shadow rounded-4 h-100">
            <h6 class="text-center text-warning fw-semibold">Entradas por Local</h6>
            <canvas id="grafico-entradas" class="grafico mx-auto d-block"></canvas>
        </div>
    </div>
</div>

@endsection
