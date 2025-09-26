const filtroSelect = document.getElementById('filtro-select');
const valorOperadorSelect = document.getElementById('valor-operador');
const pesquisaInput = document.querySelector('input[name="pesquisa"]');
const opcaoIgual = document.getElementById('operador-igual');
const opcaoMaiorQue = document.getElementById('operador-maiorque');
const opcaoMenorQue = document.getElementById('operador-menorque');

let orcamentoParaExcluir = null;

function openFullScreen(row) {
    const fullscreenContainer = document.getElementById("fullscreen-container");
    const fullscreenDetails = document.getElementById("fullscreen-details");
    const clienteColumn = document.getElementById("cliente");
    const servicoColumn = document.getElementById("servico");
    const nomeColumn = document.getElementById("nome");
    const descricaoColumn = document.getElementById("descricao");
    const valorColumn = document.getElementById("valor");
    const prazoColumn = document.getElementById("prazo");
    const statusColumn = document.getElementById("status");
    const editarColumn = document.getElementById("editar");

    fullscreenContainer.style.display = "flex";
    fullscreenContainer.style.animation = "fadeIn 0.5s ease-in-out";
    fullscreenDetails.style.animation = "fadeIn 0.5s ease-in-out";
    
    const cliente = row.dataset.cliente;
    const servico = row.dataset.servico;
    const nome = row.dataset.nome;
    const descricao = row.dataset.descricao;
    const valor = row.dataset.valor;
    const prazo = row.dataset.prazo;
    const status = row.dataset.status;
    const key = row.dataset.key;

    clienteColumn.textContent = `${cliente}`;
    servicoColumn.textContent = `${servico}`;
    nomeColumn.textContent = `${nome}`;
    descricaoColumn.textContent = `${descricao}`;
    valorColumn.textContent = `${valor}`;
    prazoColumn.textContent = `${prazo}`;
    statusColumn.textContent = `${status}`;
    editarColumn.setAttribute("href", `/dashboard/orcamento/form?id=${key}`);


}

function closeFullScreen(){
    document.getElementById("fullscreen-container").style.display = "none";
}


function confirmarExclusao(id){
    orcamentoParaExcluir = id;
    document.getElementById('modalConfirmacao').style.display = 'block';
    document.getElementById('modal-overlay').style.display = 'block';
}

document.getElementById('btnCancelar').addEventListener("click", () => {
    orcamentoParaExcluir = null;
    document.getElementById('modalConfirmacao').style.display = 'none';
    document.getElementById('modal-overlay').style.display = 'none';
});

document.getElementById('btnConfirmar').addEventListener("click", () => {
    if(orcamentoParaExcluir){
        fetch(`/dashboard/orcamento/${orcamentoParaExcluir}`, {
            method: "DELETE"
        })
        .then(res => {
            if (res.ok) {
                location.reload();
            }
        });
    }
});

window.addEventListener("DOMContentLoaded", () => {
    const url = new URL(window.location);
    url.search = "";
    window.history.pushState({}, "", url);
});

filtroSelect.addEventListener('change', (event) => {
    if (event.target.value === 'valor') {
        opcaoIgual.textContent = "Igual a";
        opcaoMaiorQue.textContent = "Maior que";
        opcaoMenorQue.textContent = "Menor que";
        valorOperadorSelect.hidden = false;
        pesquisaInput.type = 'number';
        // Adiciona o passo de 0.01 para permitir valores decimais
        pesquisaInput.setAttribute('step', '0.01');
    } else if (event.target.value === 'prazo') {
        opcaoIgual.textContent = "Em";
        opcaoMaiorQue.textContent = "Após";
        opcaoMenorQue.textContent = "Antes de";
        valorOperadorSelect.hidden = false;
        pesquisaInput.type = 'date';
        pesquisaInput.removeAttribute('step');
    } else {
        valorOperadorSelect.hidden = true;
        pesquisaInput.type = 'text';
        pesquisaInput.removeAttribute('step');
    }
    
    // Se o valor selecionado for 'prazo', muda o tipo do input para 'date'

});