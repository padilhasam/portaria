import Inputmask from 'inputmask';

document.addEventListener('DOMContentLoaded', () => {
    const cpfInput = document.getElementById('documento');
    const cnpjInput = document.getElementById('cnpj');
    const dataNascimentoInput = document.getElementById('nascimento');
    const telFixoInput = document.getElementById('tel_fixo');
    const celularInput = document.getElementById('celular');
    const placaInput = document.getElementById('placa');
    const tipoPlacaRadios = document.querySelectorAll('input[name="tipo_placa"]');
    const comumIcon = document.getElementById('comum-icon');
    const mercosulIcon = document.getElementById('mercosul-icon');

    // Aplica máscaras de outros campos
    if (cpfInput) Inputmask('999.999.999-99').mask(cpfInput);
    if (cnpjInput) Inputmask('99.999.999/9999-99').mask(cnpjInput);
    if (dataNascimentoInput) Inputmask('99/99/9999').mask(dataNascimentoInput);
    if (telFixoInput) Inputmask('(99) 9999-9999').mask(telFixoInput);
    if (celularInput) Inputmask('(99) 99999-9999').mask(celularInput);

    // Função para aplicar a máscara e exibir o ícone correto
    const aplicarMascaraEIcone = (tipo) => {
        if (!placaInput) return;

        Inputmask.remove(placaInput); // Remove máscara atual

        if (tipo === 'mercosul') {
            Inputmask({ mask: 'AAA9A99', placeholder: '_' }).mask(placaInput);
            mercosulIcon?.classList.remove('d-none');
            comumIcon?.classList.add('d-none');
        } else {
            Inputmask({ mask: 'AAA-9999', placeholder: '_' }).mask(placaInput);
            comumIcon?.classList.remove('d-none');
            mercosulIcon?.classList.add('d-none');
        }
    };

    // Aplica a máscara correta ao carregar a página (em caso de edição ou erro de validação)
    tipoPlacaRadios.forEach((radio) => {
        if (radio.checked) {
            aplicarMascaraEIcone(radio.value);
        }

        // Aplica a máscara e ícone quando o usuário altera o radio
        radio.addEventListener('change', () => {
            aplicarMascaraEIcone(radio.value);
        });
    });
});