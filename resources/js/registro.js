document.addEventListener('DOMContentLoaded', () => {
    // =============================
    // ✅ TOGGLE GENÉRICO (LIGAR/DESLIGAR)
    // =============================
    document.querySelectorAll('.toggleButton').forEach(button => {
        button.addEventListener('click', function () {
            const icon = this.querySelector('.toggle-icon');
            const text = this.querySelector('.toggle-text');

            if (!icon || !text) return; // segurança

            const isLigado = text.textContent.trim() === 'Ligar';

            // Alterna texto e estilo
            text.textContent = isLigado ? 'Desligar' : 'Ligar';
            icon.classList.toggle('text-success', !isLigado);
            icon.classList.toggle('text-danger', isLigado);

            // Alterna ícone (bi-power ↔ bi-power-off)
            icon.classList.toggle('bi-power', !isLigado);
            icon.classList.toggle('bi-power-off', isLigado);

            // Animação rápida de clique
            icon.classList.add('pulse');
            setTimeout(() => icon.classList.remove('pulse'), 300);
        });
    });

    // =============================
    // ✅ MODAL LIBERAR/BLOQUEAR (SÓ RODA SE OS BOTÕES EXISTIREM)
    // =============================
    const btnLiberar = document.getElementById("btnLiberar");
    const btnBloquear = document.getElementById("btnBloquear");
    const btnConfirmarStatus = document.getElementById("btnConfirmarStatus");
    const statusField = document.getElementById("status");
    const motivoContainer = document.getElementById("motivoBloqueioContainer");
    const motivoField = document.getElementById("motivo_bloqueio");
    const observacoes = document.getElementById("observacoes");
    const form = document.getElementById("registroForm");

    // 🔥 Verifica se todos os elementos obrigatórios existem antes de continuar
    if (btnLiberar && btnBloquear && btnConfirmarStatus && statusField && form) {
        let statusEscolhido = "liberado";

        btnLiberar.addEventListener("click", function () {
            statusEscolhido = "liberado";
            if (motivoContainer) motivoContainer.classList.add("d-none");
            if (motivoField) motivoField.value = "";
        });

        btnBloquear.addEventListener("click", function () {
            statusEscolhido = "bloqueado";
            if (motivoContainer) motivoContainer.classList.remove("d-none");
        });

        btnConfirmarStatus.addEventListener("click", function () {
            if (statusEscolhido === "bloqueado" && motivoField?.value.trim() === "") {
                alert("Por favor, informe o motivo do bloqueio.");
                return;
            }

            statusField.value = statusEscolhido;

            if (statusEscolhido === "bloqueado" && motivoField) {
                let textoObs = observacoes?.value.trim() || "";
                observacoes.value = `[BLOQUEADO] Motivo: ${motivoField.value.trim()} ` + (textoObs ? `| ${textoObs}` : "");
            }

            form.submit();
        });
    }
});
