 document.addEventListener("DOMContentLoaded", function () {
        const toggle = document.getElementById('status');
        const label = document.getElementById('statusLabel');

        if (toggle && label) {
            toggle.addEventListener('change', function () {
                if (this.checked) {
                    label.textContent = 'Bloqueado';
                    label.classList.add('text-danger');
                } else {
                    label.textContent = 'Ativo';
                    label.classList.remove('text-danger');
                }
            });
        }
    });
