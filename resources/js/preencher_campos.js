document.addEventListener('DOMContentLoaded', function() {
    function fetchAndFill(url, fieldMap) {
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (!data) throw new Error('Dados vazios');

                // Preenche os campos definidos em fieldMap
                Object.entries(fieldMap).forEach(([fieldId, dataKey]) => {
                    const el = document.getElementById(fieldId);
                    if (el) {
                        el.value = data[dataKey] ?? '';
                    }
                });
            })
            .catch(error => {
                console.log('Erro ao carregar dados:', error);
                // Limpa os campos se der erro
                Object.keys(fieldMap).forEach(fieldId => {
                    const el = document.getElementById(fieldId);
                    if (el) el.value = '';
                });
            });
    }

    function setupListener(selectId, urlPrefix, fieldMap) {
        const select = document.getElementById(selectId);
        if (!select) return;

        select.addEventListener('change', function() {
            const id = this.value;
            if (id) {
                fetchAndFill(`${urlPrefix}/${id}`, fieldMap);
            } else {
                // Limpa os campos se nada selecionado
                Object.keys(fieldMap).forEach(fieldId => {
                    const el = document.getElementById(fieldId);
                    if (el) el.value = '';
                });
            }
        });
    }

    // Configura listeners para apartamento, veículo e visitante
    setupListener('id_apartamento', '/apartamentos', {
        'bloco': 'bloco',
        'ramal': 'ramal'
    });

    setupListener('id_veiculo', '/veiculos', {
        'placa': 'placa',
        'vaga': 'vaga'
    });

    setupListener('id_visitante', '/visitantes', {
        'nome': 'nome',
        'documento': 'documento',
        'empresa': 'empresa',
        'veiculo': 'veiculo',
        'placa': 'placa'
    });
});