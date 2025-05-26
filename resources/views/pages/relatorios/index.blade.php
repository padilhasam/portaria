@extends('layouts.dashboard')

@section('page_dashboard')

<!-- Cabeçalho -->
<header class="mb-3 px-4 py-3 bg-white border rounded shadow-sm d-flex align-items-center justify-content-between">
    <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-graph-up" viewBox="0 0 16 16">
            <path d="M0 0h1v15h15v1H0V0zm14.293 4.707-3.5 3.5-2-2-4 4L3.5 9.207l4.5-4.5 2 2 3-3L14.293 4.707z"/>
        </svg>
        Relatório de Atividades
    </h3>
    <div class="d-flex align-items-center gap-2">
        <a href="#" class="btn btn-outline-primary btn-sm rounded-pill d-flex align-items-center gap-2">
            <i class="bi bi-download"></i> Exportar CSV
        </a>
        <a href="#" class="btn btn-outline-secondary btn-sm rounded-pill d-flex align-items-center gap-2">
            <i class="bi bi-file-earmark-plus"></i> Criar Novo Relatório
        </a>
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
            <h3 class="fw-bold text-success">1.234</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="bg-white border shadow-sm rounded-4 p-3 text-center">
            <h6 class="text-muted">Entradas</h6>
            <h3 class="fw-bold text-primary">987</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="bg-white border shadow-sm rounded-4 p-3 text-center">
            <h6 class="text-muted">Saídas</h6>
            <h3 class="fw-bold text-warning">862</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="bg-white border shadow-sm rounded-4 p-3 text-center">
            <h6 class="text-muted">Tentativas Negadas</h6>
            <h3 class="fw-bold text-danger">12</h3>
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
        📄 Exportar PDF
    </a>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    const ctx1 = document.getElementById('grafico-acessos').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
            datasets: [{
                label: 'Acessos',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 2
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });

    const ctx2 = document.getElementById('grafico-usuarios').getContext('2d');
    new Chart(ctx2, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
            datasets: [{
                label: 'Usuários Ativos',
                data: [50, 75, 60, 90, 45, 80],
                borderColor: 'rgba(34, 197, 94, 1)',
                tension: 0.3,
                fill: false
            }]
        },
        options: { responsive: true }
    });

    const ctx3 = document.getElementById('grafico-entradas').getContext('2d');
    new Chart(ctx3, {
        type: 'pie',
        data: {
            labels: ['Entrada A', 'Entrada B', 'Entrada C'],
            datasets: [{
                data: [30, 50, 20],
                backgroundColor: ['rgba(59,130,246,0.6)', 'rgba(34,197,94,0.6)', 'rgba(251,146,60,0.6)'],
                borderColor: ['rgba(59,130,246,1)', 'rgba(34,197,94,1)', 'rgba(251,146,60,1)'],
                borderWidth: 1
            }]
        },
        options: { responsive: true }
    });

    document.getElementById('exportar-pdf').addEventListener('click', function () {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        doc.setFontSize(18);
        doc.text("Relatório de Atividades", 10, 10);

        doc.setFontSize(12);
        doc.text("Este é um relatório gerado com base nos dados selecionados pelo usuário.", 10, 20);

        doc.save("relatorio.pdf");
    });
</script>

@endsection
