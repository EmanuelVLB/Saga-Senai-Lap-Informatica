const  user_logado = document.querySelector(".user_logado");
const authSection = document.querySelector("#authSection");

window.addEventListener("DOMContentLoaded", () => {
  // Endereço de Coleta
  document.querySelector("#rua_coleta").value = "Rua Maria das Mercês Lima";
  document.querySelector("#num_coleta").value = "385";
  document.querySelector("#bairro_coleta").value = "Pqe Betim Ind";
  document.querySelector("#cidade_coleta").value = "Betim";

  // Endereço de Entrega
  document.querySelector("#rua_entrega").value = "Av. Amazonas";
  document.querySelector("#num_entrega").value = "55";
  document.querySelector("#bairro_entrega").value = "Centro";
  document.querySelector("#cidade_entrega").value = "Betim";
});


// ------------------ Tema Claro/Escuro ------------------
const tema_toggle = document.querySelector("#toggleTheme");

function conferir_tema() {
  const tema = localStorage.getItem("tema") || "dark";
  document.body.classList.add(tema);
}
tema_toggle?.addEventListener("click", () => {
  document.body.classList.toggle("dark");
  document.body.classList.toggle("light");
  localStorage.setItem(
    "tema",
    document.body.classList.contains("dark") ? "dark" : "light"
  );
  conferir_tema();
});

// ------------------ Usuário e Menus ------------------
const userIcon = document.querySelector("#userIcon");
const userMenu = document.querySelector("#userMenu");
const nav = document.querySelector("#mainNav");
const logoutBtn = document.querySelector("#logoutBtn");
const loginForm = document.querySelector("#loginForm");
const registerForm = document.querySelector("#registerForm");

userIcon?.addEventListener("click", () => {
  userMenu?.classList.toggle("show");
  if (window.innerWidth < 768) {
    nav?.classList.toggle("hidden");
  }

  // Troca de formulários
  const showLogin = document.getElementById("showLogin");
  const showRegister = document.getElementById("showRegister");

  if (showLogin && showRegister) {
    showLogin.onclick = (e) => {
      e.preventDefault();
      loginForm.style.display = "block";
      registerForm.style.display = "none";
    };

    showRegister.onclick = (e) => {
      e.preventDefault();
      loginForm.style.display = "none";
      registerForm.style.display = "block";
    };
  }
});

logoutBtn?.addEventListener("click", () => {
  alert("Usuário deslogado!");
  localStorage.removeItem("logado");
  location.reload();
});

const img_logo = document.querySelector(".img_logo");
img_logo?.addEventListener("click", () => {
  window.location.replace("./index.html");
});

// ------------------ Cadastro ------------------
registerForm?.addEventListener("submit", (e) => {
  e.preventDefault();
  const formData = new FormData(registerForm);
  formData.append("cadastro", 1);

  fetch("./backend/cadastro.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "sucesso") {
        alert("Cadastro realizado com sucesso!");
        localStorage.setItem("logado", "true");
        location.reload();
      } else {
        alert("Erro: " + data.mensagem);
      }
    });
});

if (localStorage.getItem("logado") === "true") {
  user_logado.style.display = "flex";
  authSection.style.display = "none";
}

// ------------------ Login ------------------
loginForm?.addEventListener("submit", (e) => {
  e.preventDefault();
  const formData = new FormData(loginForm);
  formData.append("login", 1);

  fetch("./backend/login.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "logado") {
        alert("Login realizado com sucesso!");
        localStorage.setItem("logado", "true");
        location.reload();
        user_logado.style.display = "flex";
        authSection.style.display = "none";
      } else {
        alert("Erro: " + data.mensagem);
      }
    });
});

// ------------------ Slides index ------------------
document.querySelector(".login-cad")?.addEventListener("click", () => {
  userIcon?.click();
});
document.querySelector(".pedido-novo")?.addEventListener("click", () => {
  window.location.replace("./pedidos.html");
});
document.querySelector(".status-pedido")?.addEventListener("click", () => {
  window.location.replace("./historico.html");
});

// ------------------ Endereço e Mapa ------------------
document.querySelector(".enviar_end")?.addEventListener("click", (event) => {
  event.preventDefault();

  const coleta = [
    document.querySelector("#rua_coleta")?.value,
    document.querySelector("#num_coleta")?.value,
    document.querySelector("#bairro_coleta")?.value,
    document.querySelector("#cidade_coleta")?.value
  ].map(item => item.trim()).join(" ");

  const entrega = [
    document.querySelector("#rua_entrega")?.value,
    document.querySelector("#num_entrega")?.value,
    document.querySelector("#bairro_entrega")?.value,
    document.querySelector("#cidade_entrega")?.value
  ].map(item => item.trim()).join(" ");

  if (!coleta || !entrega || coleta.length < 5 || entrega.length < 5) {
    alert("Preencha todos os campos de endereço.");
    return;
  }

  const mapURL = `https://www.google.com/maps/embed?pb=!1m28!1m12!1m3!1d14999.951393034817!2d-44.19040368432524!3d-19.967013284934787!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m13!3e6!4m5!1s0xa6c1005f4c8d3b%3A0x692fff60b9c53071!2sUltragaz%20-%20Rua%20Maria%20das%20Merc%C3%AAs%20Lima%20-%20Pqe%20Betim%20Ind%2C%20Betim%20-%20MG!3m2!1d-19.9594502!2d-44.1673544!4m5!1s0xa6eaa73c6d609f%3A0xd61a7f12deb82d4a!2sSENAI%20-%20Avenida%20Amazonas%20-%20Centro%2C%20Betim%20-%20MG!3m2!1d-19.9649188!2d-44.1938752!5e0!3m2!1spt-BR!2sbr!4v1753746934995!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;`;
  const iframe = document.querySelector(".iframe_map");
  iframe.src = mapURL;
});

// ------------------ Pedido (envio) ------------------
const pedidoForm = document.querySelector("#pedidoForm");
const pesoInput = document.querySelector("#peso");
const tamanhoInput = document.querySelector("#tamanho");
const valorTotalSpan = document.querySelector("#valorTotal");
const checkbox = document.getElementById("meuCheckbox");
const valorTroco = document.querySelector("#valorTroco");

checkbox?.addEventListener("change", () => {
  valorTroco.classList.toggle("hidden", !checkbox.checked);
});

pedidoForm?.addEventListener("submit", () => {
  const peso = pesoInput.value;
  const tamanho = tamanhoInput.value;
  const troco = checkbox.checked ? valorTroco.value : null;

  if (!peso || !tamanho) {
    alert("Preencha todos os dados do pedido.");
    return;
  }

  // Simulação de cálculo de valor
  let valor = parseFloat(peso) * 2;
  if (tamanho === "medio") valor += 5;
  if (tamanho === "grande") valor += 10;

  valorTotalSpan.textContent = valor.toFixed(2);

  // Endereços de coleta/entrega
  const coleta = `${document.querySelector("#rua_coleta")?.value} ${document.querySelector("#num_coleta")?.value} ${document.querySelector("#bairro_coleta")?.value} ${document.querySelector("#cidade_coleta")?.value}`;
  const entrega = `${document.querySelector("#rua_entrega")?.value} ${document.querySelector("#num_entrega")?.value} ${document.querySelector("#bairro_entrega")?.value} ${document.querySelector("#cidade_entrega")?.value}`;

  const formData = new FormData();
  formData.append("peso", peso);
  formData.append("tamanho", tamanho);
  formData.append("troco", troco ?? "");
  formData.append("coleta", coleta);
  formData.append("entrega", entrega);

  fetch("./backend/pedido.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "sucesso") {
        alert("Pedido enviado com sucesso!");
        pedidoForm.reset();
      } else {
        alert("Erro ao enviar pedido: " + data.mensagem);
      }
    });
});
// ------------------ Concluir entrega ------------------

document.addEventListener("click", (e) => {
  if (e.target.classList.contains("btn-entregue")) {
    const pedidoId = e.target.getAttribute("data-id");
    const input = document.querySelector(`.input-piloto[data-id='${pedidoId}']`);
    const pilotoId = input.value.trim();

    if (pilotoId.length !== 3 || isNaN(pilotoId)) {
      alert("Insira um ID de piloto válido (3 dígitos).");
      return;
    }

    const formData = new FormData();
    formData.append("concluir", 1);
    formData.append("pedido_id", pedidoId);
    formData.append("piloto_id", pilotoId);

    fetch("backend/concluir_pedido.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        alert(data.mensagem);
        if (data.status === "sucesso") location.reload();
      });
  }
});
