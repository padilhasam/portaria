const saudacaoElement = document.getElementById('saudacao');
const horaAtual = new Date().getHours();

if (horaAtual >= 4 && horaAtual < 12) {
    saudacaoElement.textContent = "Olá, bom dia!";
} else if (horaAtual >= 12 && horaAtual < 18) {
    saudacaoElement.textContent = "Olá, boa tarde!";
} else if (horaAtual >= 18 && horaAtual < 24) {
    saudacaoElement.textContent = "Olá, boa noite!";
} else {
    saudacaoElement.textContent = "Olá, boa madrugada!";
}