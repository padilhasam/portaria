document.addEventListener('DOMContentLoaded', function() {

    var marca = document.getElementById('marca')
    var modelo = document.getElementById('modelo')
    var cor = document.getElementById('cor')

    // apartamento, veículo e visitante
    function getByPrefix(url, prefix) {
        const token = document.querySelector('meta[name="csrf-token"]').content;

        $.ajax({
            url: url,
            dataType: 'json',
            data: {_token: token},
            type: 'POST',
            success: function(data) {
                if (!data) throw new Error('Dados vazios');

                if(prefix === "id_veiculo"){
                    marca.value = data.marca;
                    modelo.value = data.modelo;
                    cor.value = data.cor;
                }
                if(prefix === "id_visitante_registros"){
                    document.getElementById('nome').value = data.nome;
                    document.getElementById('documento').value = data.documento;
                    document.getElementById('empresa').value = data.empresa;
                    document.getElementById('veiculo').value = data.modelo;
                    document.getElementById('placa').value = data.placa;
                    document.getElementById('image').src = `${window.location.origin}/storage/visitantes/${data.image}`;
                }

                if(prefix === "id_apartamento"){
                    document.getElementById('bloco').value = data.bloco;
                    document.getElementById('ramal').value = data.ramal;
                    document.getElementById('vaga').value = data.vaga;
                }

            },
            error: function(error) {
                console.log('Erro ao carregar dados:', error);
                // Limpa os campos se der erro
                $.each(fieldMap, function(fieldId) {
                    $('#' + fieldId).val('');
                });
            }
        });
    }

    //captura a troca dos dados no select
    function setupListener(selectId, urlPrefix) {
        const select = document.getElementById(selectId);
        if (!select) return;

        select.addEventListener('change', function() {
            const id = this.value;
            if (id) {
                getByPrefix(`${urlPrefix}/${id}/details`, selectId);
            }
        });
    }

    // Configura listeners para apartamento, veículo e visitante
    setupListener('id_apartamento', '/apartamento');
    setupListener('id_veiculo', '/veiculo');
    setupListener('id_visitante', '/visitante');
    setupListener('id_visitante_registros', '/registro-by-idvisitante');
});
