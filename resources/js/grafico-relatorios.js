import Chart from 'chart.js/auto';

document.addEventListener("DOMContentLoaded", function () {
    const ctx1 = document.getElementById('grafico-acessos')?.getContext('2d');
    if (ctx1) {
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
    }

    const ctx2 = document.getElementById('grafico-usuarios')?.getContext('2d');
    if (ctx2) {
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
    }

    const ctx3 = document.getElementById('grafico-entradas')?.getContext('2d');
    if (ctx3) {
        new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: ['Entrada A', 'Entrada B', 'Entrada C'],
                datasets: [{
                    data: [30, 50, 20],
                    backgroundColor: [
                        'rgba(59,130,246,0.6)',
                        'rgba(34,197,94,0.6)',
                        'rgba(251,146,60,0.6)'
                    ],
                    borderColor: [
                        'rgba(59,130,246,1)',
                        'rgba(34,197,94,1)',
                        'rgba(251,146,60,1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: { responsive: true }
        });
    }
});
