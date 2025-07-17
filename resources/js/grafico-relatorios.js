import Chart from 'chart.js/auto';

document.addEventListener("DOMContentLoaded", function () {
    const meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];

    let chartAcessos, chartUsuarios, chartEntradas, chartEntradaSaida;

    async function carregarGraficos(dataInicio = '', dataFim = '') {
        try {
            const url = `/api/graficos?data_inicio=${dataInicio}&data_fim=${dataFim}`;
            const response = await fetch(url);

            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

            const data = await response.json();
            console.log("Dados completos recebidos:", data);

            // ✅ Mapeamento corrigido
            const acessosData = meses.map((_, i) => Number(data.acessos?.[i + 1] ?? 0));
            const usuariosData = meses.map((_, i) => Number(data.usuarios?.[i + 1] ?? 0));
            const entradasData = Object.values(data.entradas ?? {});
            const entradasMesData = meses.map((_, i) => Number(data.entrada_saida?.entradas?.[i + 1] ?? 0));
            const saidasMesData = meses.map((_, i) => Number(data.entrada_saida?.saidas?.[i + 1] ?? 0));

            // ✅ Destroi gráficos antigos para evitar sobreposição
            [chartAcessos, chartUsuarios, chartEntradas, chartEntradaSaida].forEach(chart => chart?.destroy());

            // ✅ Gráfico de Acessos
            const ctx1 = document.getElementById('grafico-acessos')?.getContext('2d');
            if (ctx1) {
                chartAcessos = new Chart(ctx1, {
                    type: 'bar',
                    data: {
                        labels: meses,
                        datasets: [{
                            label: 'Acessos',
                            data: acessosData,
                            backgroundColor: 'rgba(59, 130, 246, 0.2)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 2
                        }]
                    },
                    options: { responsive: true, scales: { y: { beginAtZero: true } } }
                });
            }

            // ✅ Gráfico de Usuários Ativos
            const ctx2 = document.getElementById('grafico-usuarios')?.getContext('2d');
            if (ctx2) {
                chartUsuarios = new Chart(ctx2, {
                    type: 'line',
                    data: {
                        labels: meses,
                        datasets: [{
                            label: 'Usuários Ativos',
                            data: usuariosData,
                            borderColor: 'rgba(34, 197, 94, 1)',
                            backgroundColor: 'rgba(34, 197, 94, 0.1)',
                            tension: 0.3,
                            fill: true
                        }]
                    },
                    options: { responsive: true }
                });
            }

            // ✅ Gráfico de Entradas por Tipo (Pie)
            const ctx3 = document.getElementById('grafico-entradas')?.getContext('2d');
            if (ctx3) {
                chartEntradas = new Chart(ctx3, {
                    type: 'pie',
                    data: {
                        labels: Object.keys(data.entradas ?? {}),
                        datasets: [{
                            data: entradasData,
                            backgroundColor: [
                                'rgba(59,130,246,0.6)',
                                'rgba(34,197,94,0.6)',
                                'rgba(251,146,60,0.6)',
                                'rgba(239,68,68,0.6)'
                            ],
                            borderColor: [
                                'rgba(59,130,246,1)',
                                'rgba(34,197,94,1)',
                                'rgba(251,146,60,1)',
                                'rgba(239,68,68,1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: { responsive: true }
                });
            }

            // ✅ Gráfico Entrada x Saída
            const ctx4 = document.getElementById('grafico-entrada-saida')?.getContext('2d');
            if (ctx4) {
                chartEntradaSaida = new Chart(ctx4, {
                    type: 'bar',
                    data: {
                        labels: meses,
                        datasets: [
                            {
                                label: 'Entradas',
                                data: entradasMesData,
                                backgroundColor: 'rgba(34,197,94,0.6)',
                                borderColor: 'rgba(34,197,94,1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Saídas',
                                data: saidasMesData,
                                backgroundColor: 'rgba(239,68,68,0.6)',
                                borderColor: 'rgba(239,68,68,1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: { y: { beginAtZero: true } }
                    }
                });
            }

        } catch (error) {
            console.error("Erro ao carregar os gráficos:", error);
        }
    }

    // ✅ Carrega ao abrir a página
    carregarGraficos();
});
