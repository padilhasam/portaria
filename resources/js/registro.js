document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.toggleButton').forEach(button => {
        button.addEventListener('click', function () {
            const icon = this.querySelector('.toggle-icon');
            const text = this.querySelector('.toggle-text');

            const isLigado = text.textContent.trim() === 'Ligar';

            // Alterna texto e estilo
            text.textContent = isLigado ? 'Desligar' : 'Ligar';
            icon.classList.toggle('text-success', !isLigado);
            icon.classList.toggle('text-danger', isLigado);

            // Alterna ícone (bi-power para bi-power-off)
            icon.classList.toggle('bi-power', !isLigado);
            icon.classList.toggle('bi-power-off', isLigado);

            // Animação rápida de clique
            icon.classList.add('pulse');
            setTimeout(() => icon.classList.remove('pulse'), 300);
        });
    });
});