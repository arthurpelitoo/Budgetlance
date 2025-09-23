const form = document.getElementById("orcamento_form");
const steps = document.querySelectorAll(".step");
const progressBar = document.querySelector(".progress-bar");
const nextBtns = document.querySelectorAll(".btn-next");
const prevBtns = document.querySelectorAll(".btn-prev");

let currentStep = 0;

// Atualiza step + progress bar
function updateStep() {
  steps.forEach((step, i) => {
    step.classList.toggle("active", i === currentStep);
  });
  const percent = ((currentStep + 1) / steps.length) * 100;
  progressBar.style.width = percent + "%";
  clearErrors(currentStep); // limpa erros ao entrar no step
}

// Mostra erro no <small>
function showError(id, message) {
  document.getElementById(id).textContent = message;
}

// Limpa todos os erros do step atual
function clearErrors(stepIndex) {
  const step = steps[stepIndex];
  const errors = step.querySelectorAll(".error-message");
  errors.forEach(e => e.textContent = "");
}

//validações
function validateOrcamentoData(data) {
  const errors = {};

  // Validação de cliente
  if (!data.cliente || !data.cliente.trim()) {
    errors.cliente = "O cliente deve ser preenchido.";
  }

  // Validação de categoriaservico
  if (!data.categoriaservico || !data.categoriaservico.trim()) {
    errors.categoriaservico = "A categoria de servico deve ser preenchida.";
  }

  // Validação de nome
  if (!data.nome || !data.nome.trim()) {
    errors.nome = "O nome deve ser preenchido.";
  } else if (data.nome.length > 50) {
    errors.nome = "O nome precisa ter 50 caracteres ou menos.";
  }

  // Validação de descrição
  if (!data.descricao || !data.descricao.trim()) {
    errors.descricao = "A descrição deve ser preenchida.";
  } else if (data.descricao.length > 240) {
    errors.descricao = "A descrição precisa ter 240 caracteres ou menos.";
  }

  // Validação de valor
  const valor = parseFloat(data.valor);
  if (isNaN(valor)) {
    errors.valor = "O valor deve ser um número válido.";
  } else if (valor < 0.01 || valor > 9999999.99) {
    errors.valor = `O valor deve estar entre R$ 0,01 e R$ 9999999,99`;
  }

  // Validação de prazo
  if (!data.prazo || isNaN(new Date(data.prazo).getTime())) {
    errors.prazo = "Informe um prazo válido.";
  }

  // Validação de status
  const validStatuses = ['pendente','enviado','aprovado','recusado','concluido','cancelado','expirado'];
  if (!data.status || !validStatuses.includes(data.status)) {
    errors.status = "Informe um status válido.";
  }

  return errors;
}

// Validação por step
function validateStep(stepIndex) {
  const step = steps[stepIndex];
  const inputs = step.querySelectorAll("input, textarea, select");
  const data = {};

  inputs.forEach(input => {
    data[input.id] = input.value.trim();
  });

  const errors = validateOrcamentoData(data);

  // Limpa erros antigos
  clearErrors(stepIndex);

  let valid = true;
  for (let key in errors) {
    const errorEl = step.querySelector(`#${key}Erro`);
    if (errorEl) {
      errorEl.textContent = errors[key];
      valid = false;
    }
  }

  return valid;
}

// Botões "próximo"
nextBtns.forEach(btn => {
  btn.addEventListener("click", () => {
    if (validateStep(currentStep)) {
      currentStep++;
      updateStep();
    }
  });
});

// Botões "anterior"
prevBtns.forEach(btn => {
  btn.addEventListener("click", () => {
    if (currentStep > 0) {
      currentStep--;
      updateStep();
    }
  });
});

// Submit
form.addEventListener("submit", e => {
  if (!validateStep(currentStep)) {
    e.preventDefault();
  }
});


updateStep();