document.addEventListener('DOMContentLoaded', function () {
    // Função para esconder os alertas após um tempo
    function hideElement(selector, delay = 4000) {
        const elements = document.querySelectorAll(selector);
        elements.forEach(element => {
            setTimeout(() => {
                element.style.display = 'none';
            }, delay);
        });
    }

    // Exibe o alerta de sucesso caso tenha
    const metaSuccess = document.querySelector('meta[name="success-message"]');
    const successAlert = document.querySelector('.alert-success');
    const errorAlert = document.querySelector('.alert-danger');
    const validationAlert = document.querySelector('.alert-danger-validation');

    // Mostra o alerta de sucesso se houver mensagem no meta tag
    if (metaSuccess && successAlert) {
        const message = metaSuccess.getAttribute('content');
        successAlert.textContent = message;
        successAlert.style.display = 'block';

        // Esconde o alerta de sucesso após 5 segundos
        hideElement('.alert-success', 5000);
    }

    // Esconde todos os alertas após 4 segundos
    hideElement('.alert-success');
    hideElement('.alert-danger');
    hideElement('.alert-danger-validation');
});