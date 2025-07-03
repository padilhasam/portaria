import Inputmask from 'inputmask';

document.addEventListener('DOMContentLoaded', () => {
    const cpfInput = document.getElementById('documento');
    const cnpjInput = document.getElementById('cnpj');
    const dataNascimentoInput = document.getElementById('nascimento');
    const telFixoInput = document.getElementById('tel_fixo');
    const celularInput = document.getElementById('celular');
    const placaInput = document.getElementById('placa'); // ID do campo da placa
    const mercosulCheckbox = document.getElementById('mercosulCheckbox');
    const comumIcon = document.getElementById('comum-icon');
    const mercosulIcon = document.getElementById('mercosul-icon');

    if (cpfInput) Inputmask('999.999.999-99').mask(cpfInput);
    if (cnpjInput) Inputmask('99.999.999/9999-99').mask(cnpjInput);
    if (dataNascimentoInput) Inputmask('99/99/9999').mask(dataNascimentoInput);
    if (telFixoInput) Inputmask('(99) 9999-9999').mask(telFixoInput);
    if (celularInput) Inputmask('(99) 99999-9999').mask(celularInput);

      // Inicializa o Inputmask
    const inputMaskComum = new Inputmask('AAA-9999');
    const inputMaskMercosul = new Inputmask('AAA9A99');

    // Máscara inicial (comum)
    inputMaskComum.mask(placaInput);
    
    // Exibe o ícone da placa comum por padrão
    comumIcon.classList.remove('d-none');
    mercosulIcon.classList.add('d-none');

    // Função para alternar a máscara e o ícone com base no checkbox
    mercosulCheckbox.addEventListener('change', () => {
        if (mercosulCheckbox.checked) {
            inputMaskMercosul.mask(placaInput); // Aplica a máscara Mercosul
            comumIcon.classList.add('d-none'); // Oculta o ícone comum
            mercosulIcon.classList.remove('d-none'); // Exibe o ícone Mercosul
        } else {
            inputMaskComum.mask(placaInput); // Aplica a máscara comum
            comumIcon.classList.remove('d-none'); // Exibe o ícone comum
            mercosulIcon.classList.add('d-none'); // Oculta o ícone Mercosul
        }
    });
});