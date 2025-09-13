
const nome = document.getElementById("nome");
const email = document.getElementById("email");
const telefone = document.getElementById("telefone");

const nomeErro = document.getElementById("nomeErro");
const emailErro = document.getElementById("emailErro");
const telefoneErro = document.getElementById("telefoneErro");

const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const telefoneRegex = /^[0-9\-\(\)\s]+$/;

nome.addEventListener("input", () => {

    if (nome.value.length > 30) {
      nomeErro.textContent = "O nome precisa ser menor, tendo 30 caracteres ou menos.";
    } else {
      nomeErro.textContent = "";
    }
  });

telefone.addEventListener("input", () => {
if(!telefoneRegex.test(telefone.value)){
    telefoneErro.textContent = "O telefone precisa ter a formatação correta."
}else if (telefone.value.length <= 9) {
    telefoneErro.textContent = "O telefone deve ter mais de 9 caracteres.";
} else if(telefone.value.length > 15){
    telefoneErro.textContent = "O telefone deve ter 15 caracteres ou menos."
} else {
    telefoneErro.textContent = "";
}
});


email.addEventListener("input", () => {
    /**
     * o método test() é usado com emailRegex e retorna um booleano (true ou false)
     *  dependendo se a string corresponde à expressão regular.
     *  Para cair na condição, o test tem que entregar false.
     */

    if (!emailRegex.test(email.value)) {
        emailErro.textContent = "O email precisa ter a formatação correta. ex: 'seunome@seuemail.com' ";
    } else if(email.value.length > 64){
        emailErro.textContent = "O email precisa ter no maximo 64 caracteres ou menos. ";
    } else {
        emailErro.textContent = "";
    }
});
