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


function fecharModal(){
    const modalContainer = document.getElementById('modal-container');
    const modalOverlay = document.getElementById('modal-overlay');
    modalContainer.style.display = "none";
    modalContainer.style.opacity = "0";
    modalOverlay.style.display = "none";
    modalOverlay.style.opacity = "0";

}

window.onload = () =>{
    const modalContainer = document.getElementById('modal-container');
    const modalOverlay = document.getElementById('modal-overlay');
    if(modalContainer){
        modalContainer.style.display = "flex";
        modalOverlay.style.display = "flex";
        modalContainer.style.opacity = "1";
        modalOverlay.style.opacity = "1";
    }
}

window.addEventListener("DOMContentLoaded", () => {
    const url = new URL(window.location);
    url.search = ""; // remove ?query=...&filtro=...
    window.history.pushState({}, "", url);
});