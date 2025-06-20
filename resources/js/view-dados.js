document.addEventListener('DOMContentLoaded', function () {
    ['viewDataModalMorador', 'viewDataModalVisitante', 'viewDataModalPrestador', 'viewDataModalNotificacao'].forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                if (!button) return;

                // Função auxiliar para preencher campos do modal
                function preencherCampoModal(seletor, valor, padrao = '') {
                    const elemento = modal.querySelector(seletor);
                    if (elemento) {
                        if (elemento.id == "modal-foto") {
                            elemento.src = valor || padrao;
                        } else {
                            elemento.textContent = valor || padrao;
                        }
                    } else {
                        console.warn(`Elemento não encontrado: ${seletor}`);
                    }
                }

                // Campos comuns
                preencherCampoModal('#modal-foto', button.getAttribute('data-foto'));
                preencherCampoModal('#modal-nome', button.getAttribute('data-nome'));
                preencherCampoModal('#modal-cpf', button.getAttribute('data-cpf'));
                preencherCampoModal('#modal-empresa', button.getAttribute('data-empresa'));
                preencherCampoModal('#modal-apartamento', button.getAttribute('data-apartamento'));
                preencherCampoModal('#modal-marca', button.getAttribute('data-marca'));
                preencherCampoModal('#modal-modelo', button.getAttribute('data-modelo'));
                preencherCampoModal('#modal-cor', button.getAttribute('data-cor'));
                preencherCampoModal('#modal-placa', button.getAttribute('data-placa'));
                preencherCampoModal('#modal-celular', button.getAttribute('data-celular'));
                preencherCampoModal('#modal-email', button.getAttribute('data-email'));
                preencherCampoModal('#modal-tipo', button.getAttribute('data-tipo'));
                preencherCampoModal('#modal-cnpj', button.getAttribute('data-cnpj'));
                preencherCampoModal('#modal-telefone', button.getAttribute('data-telefone'));
                preencherCampoModal('#modal-prestador', button.getAttribute('data-prestador'));
                preencherCampoModal('#modal-acompanhante', button.getAttribute('data-acompanhante'));

                // Notificação
                preencherCampoModal('#modal-titulo', button.getAttribute('data-title'));
                preencherCampoModal('#modal-mensagem', button.getAttribute('data-message'));
                preencherCampoModal('#modal-criador', button.getAttribute('data-criador'));
                preencherCampoModal('#modal-data', button.getAttribute('data-data'));

                // Evidência / Arquivo anexo
                const arquivoUrl = button.getAttribute('data-arquivo');
                const containerArquivo = modal.querySelector('#arquivo-container');
                const linkArquivo = modal.querySelector('#modal-arquivo');

                if (arquivoUrl) {
                    containerArquivo.classList.remove('d-none');
                    linkArquivo.href = arquivoUrl;
                    linkArquivo.textContent = '📎 Visualizar Arquivo';
                } else {
                    containerArquivo.classList.add('d-none');
                    linkArquivo.href = '#';
                    linkArquivo.textContent = '';
                }

                // Status
                const badge = modal.querySelector('#modal-status');
                const status = button.getAttribute('data-status') || 'Desconhecido';
                badge.textContent = status;
                badge.className = 'badge ' + (status === 'Lida' ? 'bg-success' : 'bg-warning text-dark');

                // Botão de marcar como lida
                const formMarcarLida = modal.querySelector('#form-marcar-lida-modal');
                const botaoLer = formMarcarLida?.querySelector('button');
                const url = button.getAttribute('data-url');
                if (formMarcarLida && url) {
                    formMarcarLida.action = url;
                    if (status === 'Lida') {
                        botaoLer?.classList.add('d-none');
                    } else {
                        botaoLer?.classList.remove('d-none');
                    }
                }

                // Define a action do form de resposta para enviar ao endpoint correto
                const formResposta = modal.querySelector('#form-resposta-notificacao');
                const idNotificacao = button.getAttribute('data-id');
                if (formResposta && idNotificacao) {
                    formResposta.action = `/notificacoes/${idNotificacao}/responder`;
                }

            });
        }
    });

    // Função para preencher Placa ao selecionar o Veículo
    const veiculoSelect = document.getElementById('id_veiculo');
    const placaInput = document.getElementById('placa');
    // const vagaInput = document.getElementById('vaga');

    if (veiculoSelect) {
        veiculoSelect.addEventListener('change', function () {
            const selectedId = this.value;
            if (selectedId) {
                const token = document.querySelector('meta[name="csrf-token"]').content;

                $.ajax({
                    url: `/veiculos/${selectedId}/details`,
                    dataType: 'json',
                    data: { _token: token },
                    type: 'POST',
                    success: function (data) {
                        placaInput.value = data.placa || '';
                    },
                    error: function (error) {
                        console.log('Erro ao carregar dados:', error);
                        // Limpa os campos se der erro
                        // $.each(fieldMap, function(fieldId) {
                        //     $('#' + fieldId).val('');
                        // });
                    }
                });

            } else {
                placaInput.value = '';
                // vagaInput.value = '';
            }
        });
    }
});

    //Função para exibir respostas das mensagens
    document.querySelectorAll('.view-notificacao').forEach(button => {
        button.addEventListener('click', () => {
            const idNotificacao = button.getAttribute('data-id');

            // Define a action do form de resposta
            const formResposta = document.querySelector('#form-resposta-notificacao');
            if (formResposta) {
                formResposta.action = button.getAttribute('data-url-resposta-enviar');
            }

            // Define a action do botão "Ver Respostas"
            const btnVerRespostas = document.querySelector('#btn-ver-respostas');
            if (btnVerRespostas) {
                btnVerRespostas.href = button.getAttribute('data-respostas-url');
            }

            // Define os outros campos como título, mensagem, status etc.
            document.querySelector('#modal-titulo').textContent = button.getAttribute('data-title') || '';
            document.querySelector('#modal-mensagem').textContent = button.getAttribute('data-message') || '';
            document.querySelector('#modal-status').textContent = button.getAttribute('data-status') || '';
            document.querySelector('#modal-criador').textContent = button.getAttribute('data-criador') || '';
            document.querySelector('#modal-data').textContent = button.getAttribute('data-data') || '';

            // Arquivo (condicional)
            const arquivo = button.getAttribute('data-arquivo');
            const containerArquivo = document.querySelector('#arquivo-container');
            const linkArquivo = document.querySelector('#modal-arquivo');
            if (arquivo) {
                containerArquivo.classList.remove('d-none');
                linkArquivo.href = arquivo;
            } else {
                containerArquivo.classList.add('d-none');
                linkArquivo.href = '#';
            }

            // Define a action do form de marcar como lida
            const formMarcarLida = document.querySelector('#form-marcar-lida-modal');
            if (formMarcarLida) {
                formMarcarLida.action = button.getAttribute('data-url');
            }
        });
    });