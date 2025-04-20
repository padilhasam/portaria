$(document).ready(function () {
    // Preenche bloco automaticamente ao selecionar apartamento
    $('#id_apartamento').on('change', function () {
        let id = $(this).val();

        if (id) {
            $.get('/apartamento/' + id + '/bloco', function (data) {
                $('#bloco').val(data.bloco ?? '');
            });
        } else {
            $('#bloco').val('');
        }
    });

    // Preenche placa automaticamente ao selecionar veículo
    $('#id_veiculo').on('change', function () {
        let id = $(this).val();

        if (id) {
            $.get('/veiculo/' + id + '/placa', function (data) {
                $('#placa').val(data.placa ?? '');
            });
        } else {
            $('#placa').val('');
        }
    });
});