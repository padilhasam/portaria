document.addEventListener('DOMContentLoaded', function() {
    const exportarPdfBtn = document.getElementById('btn-exportar-pdf');
    const loader = document.getElementById('page-loader');

    if (!exportarPdfBtn) return;

    exportarPdfBtn.addEventListener('click', function() {
        if (loader) loader.style.display = 'flex';

        // Construir a URL do PDF com os filtros atuais da página
        const params = new URLSearchParams(window.location.search);
        const url = `/relatorios/exportar-pdf?${params.toString()}`;

        fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/pdf',
            },
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) throw new Error('Erro ao gerar PDF');
            return response.blob();
        })
        .then(blob => {
            // Criar link temporário para download
            const downloadUrl = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = downloadUrl;
            a.download = 'relatorio-acessos.pdf';
            document.body.appendChild(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(downloadUrl);
        })
        .catch(error => {
            alert('Erro ao gerar o PDF: ' + error.message);
        })
        .finally(() => {
            if (loader) loader.style.display = 'none';
        });
    });
});
