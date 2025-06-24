@extends('layouts.dashboard')

@section('page_dashboard')

<!-- Cabeçalho -->
<header class="mb-3 px-4 py-3 bg-white border rounded shadow-sm d-flex align-items-center justify-content-between">
    <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3">
        <span class="icon-container d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: linear-gradient(135deg, #0d6efd, #0a58ca); border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-graph-up-arrow" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M0 0h1v15h15v1H0zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5"/>
        </svg>
        </span>
        Relatório de Atividades
    </h3>
    <div class="d-flex align-items-center gap-2">
        <a href="#" class="btn btn-outline-primary btn-sm rounded-pill d-flex align-items-center gap-2">
            Exportar CSV
        </a>
        {{-- <a href="#" class="btn btn-success btn-sm rounded-pill d-flex align-items-center gap-2">
            Criar Novo Relatório
        </a> --}}
        <form method="GET" action="{{ route('logs.gerar') }}" class="d-flex gap-2">
            <select name="tipo" class="form-select w-auto">
                <option value="pdf">PDF</option>
                <option value="txt">TXT</option>
            </select>

            <select name="nivel" class="form-select w-auto">
                <option value="">Todos os níveis</option>
                <option value="INFO">INFO</option>
                <option value="ERRO">ERRO</option>
                <option value="WARNING">WARNING</option>
            </select>

            <input type="date" name="data" class="form-control w-auto" />

            <button type="submit" class="btn btn-primary">
                📄 Gerar Logs
            </button>
        </form>
    </div>
</header>

@include('components.alerts', [
    'success' => session()->get('success'),
    'message' => session()->get('message')
])

<!-- Filtros -->
<div class="card shadow-sm border-0 rounded-4 mb-4">
    <div class="card-body">
        <h5 class="card-title mb-3 fw-semibold">Gerar Relatório de Acessos</h5>
        <form method="GET" action="#" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="data_inicio" class="form-label">Data Início</label>
                <input type="date" name="data_inicio" id="data_inicio" class="form-control rounded-pill border-dark"
                       value="{{ old('data_inicio', request('data_inicio')) }}">
            </div>
            <div class="col-md-3">
                <label for="data_fim" class="form-label">Data Fim</label>
                <input type="date" name="data_fim" id="data_fim" class="form-control rounded-pill border-dark"
                       value="{{ old('data_fim', request('data_fim')) }}">
            </div>
            <div class="col-md-3">
                <label for="tipo" class="form-label">Tipo de Acesso</label>
                <select id="tipo" name="tipo" class="form-select rounded-pill border-dark">
                    <option value="">Todos</option>
                    <option value="entrada">Entrada</option>
                    <option value="saida">Saída</option>
                    <option value="visitante">Visitante</option>
                    <option value="prestador">Prestador</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="apartamento" class="form-label">Apartamento</label>
                <input type="text" name="apartamento" id="apartamento" class="form-control rounded-pill border-dark"
                       value="{{ request('apartamento') }}">
            </div>
            <div class="col-12 text-end">
                <button type="submit" class="btn btn-dark rounded-pill">
                    🔍 Gerar Relatório
                </button>
            </div>
        </form>
    </div>
</div>

<!-- KPIs -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="bg-white border shadow-sm rounded-4 p-3 text-center">
            <h6 class="text-muted">Total de Acessos</h6>
            <h3 class="fw-bold text-success">{{ number_format($total ?? 0) }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="bg-white border shadow-sm rounded-4 p-3 text-center">
            <h6 class="text-muted">Entradas</h6>
            <h3 class="fw-bold text-primary">{{ number_format($entradas ?? 0) }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="bg-white border shadow-sm rounded-4 p-3 text-center">
            <h6 class="text-muted">Saídas</h6>
            <h3 class="fw-bold text-warning">{{ number_format($saidas ?? 0) }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="bg-white border shadow-sm rounded-4 p-3 text-center">
            <h6 class="text-muted">Tentativas Negadas</h6>
            <h3 class="fw-bold text-danger">{{ number_format($negados ?? 0) }}</h3>
        </div>
    </div>
</div>

<!-- Gráficos -->
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

<!-- Exportar PDF -->
<div class="text-center mb-5">
    <a href="#" id="exportar-pdf" class="btn btn-outline-dark rounded-pill px-4 py-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf-fill" viewBox="0 0 16 16"><path d="M5.523 12.424q.21-.124.459-.238a8 8 0 0 1-.45.606c-.28.337-.498.516-.635.572l-.035.012a.3.3 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548m2.455-1.647q-.178.037-.356.078a21 21 0 0 0 .5-1.05 12 12 0 0 0 .51.858q-.326.048-.654.114m2.525.939a4 4 0 0 1-.435-.41q.344.007.612.054c.317.057.466.147.518.209a.1.1 0 0 1 .026.064.44.44 0 0 1-.06.2.3.3 0 0 1-.094.124.1.1 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256M8.278 6.97c-.04.244-.108.524-.2.829a5 5 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.5.5 0 0 1 .145-.04c.013.03.028.092.032.198q.008.183-.038.465z"/><path fill-rule="evenodd" d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2zM4.165 13.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.7 11.7 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.86.86 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.84.84 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.8 5.8 0 0 0-1.335-.05 11 11 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.24 1.24 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a20 20 0 0 1-1.062 2.227 7.7 7.7 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103"/></svg>
        Exportar PDF
    </a>
</div>

@endsection
