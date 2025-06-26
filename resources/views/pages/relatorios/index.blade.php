@extends('layouts.dashboard')

@section('page_dashboard')

{{-- ======================== Cabeçalho ======================== --}}
<header class="mb-4 px-4 py-3 bg-white border rounded shadow-sm">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-3">
        {{-- Título --}}
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

        {{-- Ações principais --}}
        <div class="d-flex flex-wrap align-items-center gap-2">
            <a href="#" id="exportar-excel" class="btn btn-outline-success btn-sm rounded-pill px-4 d-flex align-items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-excel-fill" viewBox="0 0 16 16">
                <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M5.884 6.68 8 9.219l2.116-2.54a.5.5 0 1 1 .768.641L8.651 10l2.233 2.68a.5.5 0 0 1-.768.64L8 10.781l-2.116 2.54a.5.5 0 0 1-.768-.641L7.349 10 5.116 7.32a.5.5 0 1 1 .768-.64"/>
                </svg>
                Exportar CSV
            </a>

            <a href="#" id="exportar-pdf" class="btn btn-outline-dark btn-sm rounded-pill px-4 d-flex align-items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-pdf-fill" viewBox="0 0 16 16">
                <path d="M5.523 10.424q.21-.124.459-.238a8 8 0 0 1-.45.606c-.28.337-.498.516-.635.572l-.035.012a.3.3 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548m2.455-1.647q-.178.037-.356.078a21 21 0 0 0 .5-1.05 12 12 0 0 0 .51.858q-.326.048-.654.114m2.525.939a4 4 0 0 1-.435-.41q.344.007.612.054c.317.057.466.147.518.209a.1.1 0 0 1 .026.064.44.44 0 0 1-.06.2.3.3 0 0 1-.094.124.1.1 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256M8.278 4.97c-.04.244-.108.524-.2.829a5 5 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.5.5 0 0 1 .145-.04c.013.03.028.092.032.198q.008.183-.038.465z"/>
                <path fill-rule="evenodd" d="M4 0h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m.165 11.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.6 11.6 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.86.86 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.84.84 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.8 5.8 0 0 0-1.335-.05 11 11 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.24 1.24 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a20 20 0 0 1-1.062 2.227 7.7 7.7 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103"/>
                </svg>
                Exportar PDF
            </a>
        </div>
    </div>

</header>

{{-- ======================== Alertas ======================== --}}
@include('components.alerts', [
    'success' => session()->get('success'),
    'message' => session()->get('message')
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

{{-- ======================== Gráficos ======================== --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="bg-white p-4 shadow rounded-4">
            <h6 class="text-center text-primary fw-semibold">Acessos por Mês</h6>
            <canvas id="grafico-acessos"></canvas>
        </div>
    </div>
    <div class="col-md-4">
        <div class="bg-white p-4 shadow rounded-4">
            <h6 class="text-center text-success fw-semibold">Usuários Ativos</h6>
            <canvas id="grafico-usuarios"></canvas>
        </div>
    </div>
    <div class="col-md-4">
        <div class="bg-white p-4 shadow rounded-4">
            <h6 class="text-center text-warning fw-semibold">Entradas por Local</h6>
            <canvas id="grafico-entradas"></canvas>
        </div>
    </div>
</div>

{{-- ======================== Filtros e Exportações ======================== --}}
<div class="row mb-4">
    <div class="card-body">
        <div class="row gy-4">

            {{-- Relatório de Acessos --}}
            <div class="col-md-6 col-12 border-md-start ps-md-4 mt-4 mt-md-0">
                <h5 class="card-title mb-4 fw-semibold">📄 Gerar Relatório de Acessos</h5>
                <form method="GET" action="{{ route('index.relatorio') }}" class="row g-3 align-items-end">
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
                        <select id="tipo" name="tipo" class="form-select form-select-sm rounded-pill">
                            <option value="">Todos</option>
                            <option value="entrada" {{ request('tipo') === 'entrada' ? 'selected' : '' }}>Entrada</option>
                            <option value="saida" {{ request('tipo') === 'saida' ? 'selected' : '' }}>Saída</option>
                            <option value="visitante" {{ request('tipo') === 'visitante' ? 'selected' : '' }}>Visitante</option>
                            <option value="prestador" {{ request('tipo') === 'prestador' ? 'selected' : '' }}>Prestador</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="apartamento" class="form-label fw-semibold">Apartamento</label>
                        <input type="text" name="apartamento" id="apartamento" class="form-control form-control-sm rounded-pill"
                               value="{{ request('apartamento') }}">
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-sm rounded-pill px-5 shadow-sm"
                                style="transition: box-shadow 0.3s ease;">
                            🔍 Gerar Relatório
                        </button>
                    </div>
                </form>
            </div>

            {{-- Logs do Sistema --}}
            <div class="col-md-6 col-12 border-md-start ps-md-4 mt-4 mt-md-0">
                <h5 class="card-title mb-4 fw-semibold">📝 Gerar Logs do Sistema</h5>
                <form method="GET" action="{{ route('logs.gerar') }}" class="row g-3 align-items-end">
                    <div class="col-md-4 col-6">
                        <label for="tipo_log" class="form-label fw-semibold">Formato</label>
                        <select name="tipo" id="tipo_log" class="form-select form-select-sm rounded-pill">
                            <option value="pdf">PDF</option>
                            <option value="txt">TXT</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-6">
                        <label for="nivel_log" class="form-label fw-semibold">Nível</label>
                        <select name="nivel" id="nivel_log" class="form-select form-select-sm rounded-pill">
                            <option value="">Todos</option>
                            <option value="INFO">INFO</option>
                            <option value="ERRO">ERRO</option>
                            <option value="WARNING">WARNING</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-12">
                        <label for="data_log" class="form-label fw-semibold">Data</label>
                        <input type="date" name="data" id="data_log" class="form-control form-control-sm rounded-pill">
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-sm rounded-pill px-5 shadow-sm"
                                style="transition: box-shadow 0.3s ease;">
                            📄 Gerar Logs
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection
