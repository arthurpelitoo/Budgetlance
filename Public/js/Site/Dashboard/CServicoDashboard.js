let servicoParaExcluir = null;

function openFullScreen(row) {
    const fullscreenContainer = document.getElementById("fullscreen-container");
    const fullscreenDetails = document.getElementById("fullscreen-details");
    const nomeColumn = document.getElementById("nome");
    const descricaoColumn = document.getElementById("descricao");
    const editarColumn = document.getElementById("editar");

    fullscreenContainer.style.display = "flex";
    fullscreenContainer.style.animation = "fadeIn 0.5s ease-in-out";
    fullscreenDetails.style.animation = "fadeIn 0.5s ease-in-out";
    
    const nome = row.dataset.nome;
    const descricao = row.dataset.descricao;
    const key = row.dataset.key;

    nomeColumn.textContent = `${nome}`;
    descricaoColumn.textContent = `${descricao}`;
    editarColumn.setAttribute("href", `/dashboard/servico/form?id=${key}`);


}

function closeFullScreen(){
    document.getElementById("fullscreen-container").style.display = "none";
}

function confirmarExclusao(id){
    servicoParaExcluir = id;
    document.getElementById('modalConfirmacao').style.display = 'block';
    document.getElementById('modal-overlay').style.display = 'block';
}

document.getElementById('btnCancelar').addEventListener("click", () => {
    servicoParaExcluir = null;
    document.getElementById('modalConfirmacao').style.display = 'none';
    document.getElementById('modal-overlay').style.display = 'none';
});

document.getElementById('btnConfirmar').addEventListener("click", () => {
    if(servicoParaExcluir){
        fetch(`/dashboard/servico/${servicoParaExcluir}`, {
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
    url.search = ""; // remove ?query=...&filtro=...
    window.history.pushState({}, "", url);
});