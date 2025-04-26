document.addEventListener('DOMContentLoaded', function () {
    // Função para buscar e preencher o bloco
    const apartamentoSelect = document.getElementById('id_apartamento');
    if (apartamentoSelect) {
        apartamentoSelect.addEventListener('change', function () {
            const id = this.value;

            if (id) {
                fetch(`/apartamento/${id}/bloco`)
                    .then(response => response.json())
                    .then(data => {
                        const blocoInput = document.getElementById('bloco');
                        if (blocoInput) {
                            blocoInput.value = data.bloco ?? '';
                        }
                    })
                    .catch(error => console.error('Erro ao buscar bloco:', error));
            } else {
                const blocoInput = document.getElementById('bloco');
                if (blocoInput) {
                    blocoInput.value = '';
                }
            }
        });
    }

    // Função para buscar e preencher a placa
    const veiculoSelect = document.getElementById('id_veiculo');
    if (veiculoSelect) {
        veiculoSelect.addEventListener('change', function () {
            const id = this.value;

            if (id) {
                fetch(`/veiculo/${id}/placa`)
                    .then(response => response.json())
                    .then(data => {
                        const placaInput = document.getElementById('placa');
                        if (placaInput) {
                            placaInput.value = data.placa ?? '';
                        }
                    })
                    .catch(error => console.error('Erro ao buscar placa:', error));
            } else {
                const placaInput = document.getElementById('placa');
                if (placaInput) {
                    placaInput.value = '';
                }
            }
        });
    }
});