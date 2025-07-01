document.getElementById('status').addEventListener('change', function () {
        const label = document.getElementById('statusLabel');
        if (this.checked) {
            label.textContent = 'Ativo';
            label.classList.add('text-danger');
        } else {
            label.textContent = 'Bloqueado';
            label.classList.remove('text-danger');
        }
    });