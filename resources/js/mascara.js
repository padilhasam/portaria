import Inputmask from 'inputmask';

document.addEventListener('DOMContentLoaded', () => {
    const cpfInput = document.getElementById('documento');
    const dataNascimentoInput = document.getElementById('nascimento');
    const telFixoInput = document.getElementById('tel_fixo');
    const celularInput = document.getElementById('celular');

    if (cpfInput) Inputmask('999.999.999-99').mask(cpfInput);
    if (dataNascimentoInput) Inputmask('99/99/9999').mask(dataNascimentoInput);
    if (telFixoInput) Inputmask('(99) 9999-9999').mask(telFixoInput);
    if (celularInput) Inputmask('(99) 99999-9999').mask(celularInput);
});
