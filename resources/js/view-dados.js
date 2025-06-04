document.addEventListener('DOMContentLoaded', function () {
    ['viewDataModalMorador', 'viewDataModalVisitante', 'viewDataModalPrestador'].forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                if (!button) return;

                // Função auxiliar para verificar e preencher os campos
                function preencherCampoModal(seletor, valor, padrao = '') {
                    const elemento = modal.querySelector(seletor);
                    
                    if (elemento) {
                        if(elemento.id == "modal-foto"){
                            elemento.src = valor || padrao;
                        }else{
                            elemento.textContent = valor || padrao;
                        }
                    } else {
                        console.warn(`Elemento não encontrado: ${seletor}`);
                    }
                }

                // Preenchendo os campos com verificação
                preencherCampoModal('#modal-foto', button.getAttribute('data-foto'));
                preencherCampoModal('#modal-nome', button.getAttribute('data-nome'));
                preencherCampoModal('#modal-cpf', button.getAttribute('data-cpf'));
                preencherCampoModal('#modal-empresa', button.getAttribute('data-empresa'), 'N/A');
                preencherCampoModal('#modal-apartamento', button.getAttribute('data-apartamento'));
                preencherCampoModal('#modal-marca', button.getAttribute('data-marca'));
                preencherCampoModal('#modal-modelo', button.getAttribute('data-modelo'));
                preencherCampoModal('#modal-cor', button.getAttribute('data-cor'));
                preencherCampoModal('#modal-placa', button.getAttribute('data-placa'));
                preencherCampoModal('#modal-celular', button.getAttribute('data-celular'));
                preencherCampoModal('#modal-email', button.getAttribute('data-email'), 'N/A');
                preencherCampoModal('#modal-tipo', button.getAttribute('data-tipo'));
                // Preenchendo os campos com verificação
                preencherCampoModal('#modal-cnpj', button.getAttribute('data-cnpj'));
                preencherCampoModal('#modal-telefone', button.getAttribute('data-telefone'));
                preencherCampoModal('#modal-prestador', button.getAttribute('data-prestador'));
                preencherCampoModal('#modal-acompanhante', button.getAttribute('data-acompanhante'));

            });
        }
    });

    // Função para preencher Placa e Vaga ao selecionar o Veículo
    const veiculoSelect = document.getElementById('id_veiculo');
    const placaInput = document.getElementById('placa');
    //const vagaInput = document.getElementById('vaga');

    if (veiculoSelect) {
        veiculoSelect.addEventListener('change', function () {
            const selectedId = this.value;
            if (selectedId) {
                const token = document.querySelector('meta[name="csrf-token"]').content;

                $.ajax({
                    url: `/veiculos/${selectedId}/details`,
                    dataType: 'json',
                    data: {_token: token},
                    type: 'POST',
                    success: function(data) {
                        placaInput.value = data.placa || ''
                    },
                    error: function(error) {
                        console.log('Erro ao carregar dados:', error);
                        // Limpa os campos se der erro
                        $.each(fieldMap, function(fieldId) {
                            $('#' + fieldId).val('');
                        });
                    }
                });

            } else {
                placaInput.value = '';
                //vagaInput.value = '';
            }
        });
    }
});