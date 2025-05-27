import jsPDF from "jspdf";

document.addEventListener("DOMContentLoaded", function () {
    const exportarBtn = document.getElementById('exportar-pdf');
    if (exportarBtn) {
        exportarBtn.addEventListener('click', function () {
            const doc = new jsPDF();

            doc.setFontSize(18);
            doc.text("Relatório de Atividades", 10, 10);

            doc.setFontSize(12);
            doc.text("Este é um relatório gerado com base nos dados selecionados pelo usuário.", 10, 20);

            doc.save("relatorio.pdf");
        });
    }
});