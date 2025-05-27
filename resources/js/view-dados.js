document.addEventListener('DOMContentLoaded', function () {
  ['viewDataModalMorador', 'viewDataModalVisitante'].forEach(modalId => {
    const modal = document.getElementById(modalId);
    if (modal) {
      modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        if (!button) return;

        modal.querySelector('#modal-nome').textContent = button.getAttribute('data-nome') || '';
        modal.querySelector('#modal-cpf').textContent = button.getAttribute('data-cpf') || '';
        modal.querySelector('#modal-empresa').textContent = button.getAttribute('data-empresa') || '';
        modal.querySelector('#modal-apartamento').textContent = button.getAttribute('data-apartamento') || '';
        modal.querySelector('#modal-veiculo').textContent = button.getAttribute('data-veiculo') || '';
        modal.querySelector('#modal-celular').textContent = button.getAttribute('data-celular') || '';
        modal.querySelector('#modal-veiculo').textContent = button.getAttribute('data-veiculo') || '';
        modal.querySelector('#modal-celular').textContent = button.getAttribute('data-celular') || '';
        modal.querySelector('#modal-email').textContent = button.getAttribute('data-email') || 'N/A';
        modal.querySelector('#modal-tipo').textContent = button.getAttribute('data-tipo') || '';
      });
    }
  });

// Função para preencher Bloco e Ramal ao selecionar o Apartamento
const apartamentoSelect = document.getElementById('id_apartamento');
const blocoInput = document.getElementById('bloco');
const ramalInput = document.getElementById('ramal');

if (apartamentoSelect) {
    apartamentoSelect.addEventListener('change', function () {
        const selectedId = this.value;
        if (selectedId) {
            fetch(`/apartamentos/${selectedId}/details`)
                .then(response => response.json())
                .then(data => {
                    blocoInput.value = data.bloco || '';
                    ramalInput.value = data.ramal || '';
                })
                .catch(error => {
                    console.error('Erro ao buscar detalhes do apartamento:', error);
                    blocoInput.value = '';
                    ramalInput.value = '';
                });
        } else {
            blocoInput.value = '';
            ramalInput.value = '';
        }
    });
}

// Função para preencher Placa e Vaga ao selecionar o Veículo
const veiculoSelect = document.getElementById('id_veiculo');
const placaInput = document.getElementById('placa');
//const vagaInput = document.getElementById('vaga');

if (veiculoSelect) {
    veiculoSelect.addEventListener('change', function () {
        const selectedId = this.value;
        if (selectedId) {
            fetch(`/veiculos/${selectedId}/details`)
                .then(response => response.json())
                .then(data => {
                    placaInput.value = data.placa || '';
                    //vagaInput.value = data.vaga || '';
                })
                .catch(error => {
                    console.error('Erro ao buscar detalhes do veículo:', error);
                    placaInput.value = '';
                    //vagaInput.value = '';
                });
        } else {
            placaInput.value = '';
            //vagaInput.value = '';
        }
    });
}
});