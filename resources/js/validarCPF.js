 function validarCPF(cpf) {
        cpf = cpf.replace(/[^\d]+/g, '');
        if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;

        let soma = 0;
        for (let i = 0; i < 9; i++) soma += parseInt(cpf.charAt(i)) * (10 - i);
        let resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) resto = 0;
        if (resto !== parseInt(cpf.charAt(9))) return false;

        soma = 0;
        for (let i = 0; i < 10; i++) soma += parseInt(cpf.charAt(i)) * (11 - i);
        resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) resto = 0;
        return resto === parseInt(cpf.charAt(10));
    }

    document.addEventListener('DOMContentLoaded', function () {
        const documentoInput = document.getElementById('documento');
        const cpfError = document.getElementById('cpf-error');

        if (!documentoInput || !cpfError) return;

        documentoInput.addEventListener('blur', function () {
            const cpf = documentoInput.value;
            const isValid = validarCPF(cpf);

            if (!isValid) {
                documentoInput.classList.add('is-invalid');
                cpfError.classList.remove('d-none');
                cpfError.textContent = 'CPF inválido';
            } else {
                documentoInput.classList.remove('is-invalid');
                cpfError.classList.add('d-none');
                cpfError.textContent = '';
            }
        });

    });
