let clienteParaExcluir = null;

function openFullScreen(row) {
    const fullscreenContainer = document.getElementById("fullscreen-container");
    const fullscreenDetails = document.getElementById("fullscreen-details");
    const nomeColumn = document.getElementById("nome");
    const telefoneColumn = document.getElementById("telefone");
    const emailColumn = document.getElementById("email");
    const editarColumn = document.getElementById("editar");

    fullscreenContainer.style.display = "flex";
    fullscreenContainer.style.animation = "fadeIn 0.5s ease-in-out";
    fullscreenDetails.style.animation = "fadeIn 0.5s ease-in-out";
    
    const nome = row.dataset.nome;
    const telefone = row.dataset.telefone;
    const email = row.dataset.email;
    const key = row.dataset.key;

    nomeColumn.textContent = `${nome}`;
    telefoneColumn.textContent = `${telefone}`;
    emailColumn.textContent = `${email}`
    editarColumn.setAttribute("href", `/dashboard/cliente/form?id=${key}`);


}

function closeFullScreen(){
    document.getElementById("fullscreen-container").style.display = "none";
}

function confirmarExclusao(id){
    clienteParaExcluir = id;
    document.getElementById('modalConfirmacao').style.display = 'block';
    document.getElementById('modal-overlay').style.display = 'block';
}

document.getElementById('btnCancelar').addEventListener("click", () => {
    clienteParaExcluir = null;
    document.getElementById('modalConfirmacao').style.display = 'none';
    document.getElementById('modal-overlay').style.display = 'none';
});

document.getElementById('btnConfirmar').addEventListener("click", () => {
    if(clienteParaExcluir){
        fetch(`/dashboard/cliente/${clienteParaExcluir}`, {
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