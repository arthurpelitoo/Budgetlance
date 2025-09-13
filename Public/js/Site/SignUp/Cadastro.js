const nome = document.getElementById("nome");
const email = document.getElementById("email");
const senha = document.getElementById("senha");

const nomeErro = document.getElementById("nomeErro");
const emailErro = document.getElementById("emailErro");
const senhaErro = document.getElementById("senhaErro");

const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

nome.addEventListener("input", () => {

    if (nome.value.length > 20) {
      nomeErro.textContent = "O nome precisa ser menor, tendo 20 caracteres ou menos.";
    } else {
      nomeErro.textContent = "";
    }
  });

email.addEventListener("input", () => {
    /**
     * o método test() é usado com regex e retorna um booleano (true ou false)
     *  dependendo se a string corresponde à expressão regular.
     *  Para cair na condição, o test tem que entregar false.
     */

    if (!regex.test(email.value)) {
        emailErro.textContent = "O email precisa ter a formatação correta. ex: 'seunome@seuemail.com' ";
    } else if(email.value.length > 64){
        emailErro.textContent = "O email precisa ter no maximo 64 caracteres ou menos. ";
    } else {
        emailErro.textContent = "";
    }
});

senha.addEventListener("input", () => {
if (senha.value.length < 6) {
    senhaErro.textContent = "A senha deve ter mais de 5 caracteres.";
} else if(senha.value.length > 20){
    senhaErro.textContent = "A senha deve ter 20 caracteres ou menos."
} else {
    senhaErro.textContent = "";
}
});

