import Inputmask from 'inputmask';

document.addEventListener('DOMContentLoaded', () => {
    const cpfInput = document.getElementById('documento');
    const dataNascimentoInput = document.getElementById('nascimento');
    const telFixoInput = document.getElementById('tel_fixo');
    const celularInput = document.getElementById('celular');
    const placaInput = document.getElementById('placa'); // ID do campo da placa

    if (cpfInput) Inputmask('999.999.999-99').mask(cpfInput);
    if (dataNascimentoInput) Inputmask('99/99/9999').mask(dataNascimentoInput);
    if (telFixoInput) Inputmask('(99) 9999-9999').mask(telFixoInput);
    if (celularInput) Inputmask('(99) 99999-9999').mask(celularInput);

    // Máscara de placa de veículo (modelo antigo ou Mercosul)
    if (placaInput) {
        Inputmask({
            mask: [
                'AAA-9999',   // Modelo antigo
                'AAA9A99'     // Modelo Mercosul
            ],
            definitions: {
                'A': {
                    validator: "[A-Za-z]",
                    casing: "upper"
                }
            },
            autoUnmask: false,
            keepStatic: true // Permite alternar entre os dois formatos
        }).mask(placaInput);
    }
});