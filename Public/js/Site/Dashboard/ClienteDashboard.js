let clienteParaExcluir = null;

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