document.addEventListener('DOMContentLoaded', function() {
    // Função para preencher os campos de Apartamento
    const apartamentoField = document.getElementById('id_apartamento');
    if (apartamentoField) {
        apartamentoField.addEventListener('change', function() {
            const apartamentoId = this.value;
            if (apartamentoId) {
                fetch(`/apartamentos/${apartamentoId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.bloco && data.ramal) {
                            document.getElementById('bloco').value = data.bloco;
                            document.getElementById('ramal').value = data.ramal;
                        } else {
                            console.log('Dados inválidos recebidos para o apartamento');
                        }
                    })
                    .catch(error => console.log('Erro ao carregar dados do apartamento:', error));
            }
        });
    }

    // Função para preencher os campos de Veículo
    const veiculoField = document.getElementById('id_veiculo');
    if (veiculoField) {
        veiculoField.addEventListener('change', function() {
            const veiculoId = this.value;
            if (veiculoId) {
                fetch(`/veiculos/${veiculoId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.placa && data.vaga) {
                            document.getElementById('placa').value = data.placa;
                            document.getElementById('vaga').value = data.vaga;
                        } else {
                            console.log('Dados inválidos recebidos para o veículo');
                        }
                    })
                    .catch(error => console.log('Erro ao carregar dados do veículo:', error));
            }
        });
    }
});