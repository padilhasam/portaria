document.addEventListener("DOMContentLoaded", function() {
    const loader = document.getElementById('page-loader');

    // Loader para links internos
    document.querySelectorAll('a[href]').forEach(function(link) {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');

            if (
                !href ||
                href.startsWith('#') ||
                this.target === '_blank' ||
                href.startsWith('mailto:') ||
                href.startsWith('tel:') ||
                (href.startsWith('http') && !href.includes(location.hostname))
            ) {
                return; // Ignora links externos, mailto, tel, etc.
            }

            loader.style.display = 'flex';
        });
    });

    // Loader para modais Bootstrap (vários)
    const modais = document.querySelectorAll('#viewDataModalMorador, #viewDataModalVisitante, #viewDataModalRegistro');
    modais.forEach(modal => {
        modal.addEventListener('show.bs.modal', function () {
            loader.style.display = 'flex';
        });

        modal.addEventListener('shown.bs.modal', function () {
            loader.style.display = 'none';
        });
    });

    // Loader para submits de formulários (cadastrar, editar, deletar)
    document.querySelectorAll('form').forEach(function(form) {
        form.addEventListener('submit', function() {
            loader.style.display = 'flex';
        });
    });

    // Loader para botões específicos (exemplo: cancelar, deletar)
    const actionButtons = document.querySelectorAll('.btn-cancelar, .btn-deletar, .btn-editar, .btn-cadastrar');
    actionButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            loader.style.display = 'flex';
        });
    });

    // Esconder loader quando a página carregar/voltar
    window.addEventListener('pageshow', function() {
        loader.style.display = 'none';
    });
});