document.addEventListener('DOMContentLoaded', function () {
    const tipoComum = document.getElementById('tipoComum');
    const tipoMercosul = document.getElementById('tipoMercosul');
    const comumIcon = document.getElementById('comum-icon');
    const mercosulIcon = document.getElementById('mercosul-icon');

    function updateIcon() {
        if (!tipoComum || !tipoMercosul || !comumIcon || !mercosulIcon) return;

        if (tipoComum.checked) {
            comumIcon.classList.remove('d-none');
            mercosulIcon.classList.add('d-none');
        } else if (tipoMercosul.checked) {
            mercosulIcon.classList.remove('d-none');
            comumIcon.classList.add('d-none');
        }
    }

    if (tipoComum) tipoComum.addEventListener('change', updateIcon);
    if (tipoMercosul) tipoMercosul.addEventListener('change', updateIcon);

    updateIcon(); // chama no carregamento
});
