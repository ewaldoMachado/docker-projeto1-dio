const form = document.getElementById("comment-form");
const nomeInput = document.getElementById("nome");
const emailInput = document.getElementById("email");
const mensagemInput = document.getElementById("mensagem");
const conteudoDiv = document.getElementById("conteudo");

form.addEventListener("submit", async (e) => {
  e.preventDefault();

  const nome = nomeInput.value.trim();
  const email = emailInput.value.trim();
  const mensagem = mensagemInput.value.trim();

  if (!nome && !email && !mensagem) return;

  const resposta = await fetch('api/index.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ nome, email, mensagem })
  });

  const resultado = await resposta.json();
  alert(resultado.message);

  const conteudoElemento = document.createElement("div");
  conteudoElemento.classList.add("conteudo");

  conteudoElemento.innerHTML = `
    <h3>${nome}</h3>
    <p>${email}</p>
    <p>${mensagem}</p>

  `;

  // Insere o novo conteudo acima dos anteriores
  conteudoDiv.prepend(conteudoElemento);

  // Limpa os campos
  nomeInput.value = "";
  emailInput.value = "";
  mensagemInput.value = "";
});