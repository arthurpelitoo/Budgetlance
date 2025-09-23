
const nome = document.getElementById("nome");
const descricao = document.getElementById("descricao");

const nomeErro = document.getElementById("nomeErro");
const descricaoErro = document.getElementById("descricaoErro");

nome.addEventListener("input", () => {

    if (nome.value.length > 30) {
      nomeErro.textContent = "O nome precisa ser menor, tendo 30 caracteres ou menos.";
    } else {
      nomeErro.textContent = "";
    }
  });

descricao.addEventListener("input", () => {
    if(descricao.value.length > 240) {
        descricaoErro.textContent = "A descricao precisa ser menor, tendo 240 caracteres ou menos.";
    } else{
        descricaoErro.textContent = "";
    }
});
