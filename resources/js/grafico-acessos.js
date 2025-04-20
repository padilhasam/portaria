// resources/js/grafico-acessos.js

document.addEventListener('DOMContentLoaded', function () {
    const grafico = document.getElementById('graficoAcessos');

    if (!grafico) return;

    const entradas = parseInt(grafico.dataset.entradas);
    const saidas = parseInt(grafico.dataset.saidas);

    new Chart(grafico.getContext('2d'), {
        type: 'bar',
        data: {
            labels: ['Entradas', 'Saídas'],
            datasets: [{
                label: 'Acessos Hoje',
                data: [entradas, saidas],
                backgroundColor: [
                    'rgba(25, 135, 84, 0.7)',
                    'rgba(220, 53, 69, 0.7)'
                ],
                borderColor: [
                    'rgba(25, 135, 84, 1)',
                    'rgba(220, 53, 69, 1)'
                ],
                borderWidth: 1,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});