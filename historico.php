<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LAP Informática</title>
    <link rel="stylesheet" href="style.css" />
    <script src="https://accounts.google.com/gsi/client" async defer></script>
  </head>
  <body class="dark" onload="conferir_tema()">
    <header>
      <img class="img_logo" src="img/logo.png" alt="Logo lap informática" />
      <div class="header-actions">
        <button class="sun" id="toggleTheme">☀️/🌙</button>
        <div class="user-wrapper">
          <img id="userIcon" src="img/default_user.png" alt="Usuário" />
          <div id="userMenu" class="hidden">
            <div id="authSection">
              <form id="loginForm" style="display: none">
                <input type="email" name="email" placeholder="Email" required />
                <input
                  type="password"
                  name="senha"
                  placeholder="Senha"
                  required
                />
                <button type="submit">Entrar</button>
                <p class="toggle-text">
                  Ainda não tem uma conta?
                  <a href="#" id="showRegister">Cadastre-se</a>
                </p>
              </form>

              <form id="registerForm">
                <input type="text" name="nome" placeholder="Nome" required />
                <input type="tel" name="telefone" placeholder="Tell" required />
                <input type="email" name="email" placeholder="Email" required />
                <input
                  type="password"
                  name="senha"
                  placeholder="Senha"
                  required
                />
                <input
                  type="password"
                  name="confirmar"
                  placeholder="Confirmar Senha"
                  required
                />
                <button type="submit">Cadastrar</button>
                <p class="toggle-text">
                  Já tem uma conta? <a href="#" id="showLogin">Entrar</a>
                </p>
              </form>
            </div>

            <ul class="user_logado">
              <li class="btn_ol sobre">Sobre</li>
              <li class="btn_ol logoutBtn" id="logoutBtn">Sair</li>

            </ul>
          </div>
        </div>
      </div>
    </header>

    <nav id="mainNav" class="hidden">
      <a href="index.html">Início</a>
      <a href="pedidos.html">Pedidos</a>
      <a href="./historico.php">Rastreamento</a>
    </nav>

    <!-- Main -->
    <main>
      <h2>Seus Pedidos</h2>
      <div id="listaPedidos">
        <!-- Conteúdo inserido via PHP -->
<?php
require_once("backend/conexao.php");

$stmt = $pdo->prepare("SELECT * FROM pedidos ORDER BY data_pedido DESC");
$stmt->execute();
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($pedidos)) {
  echo '
    <div class="noPedidos">
      <a href="./pedidos.html">Você ainda não tem pedidos. Clique aqui para fazer um.</a>
    </div>
  ';
} else {
  foreach ($pedidos as $pedido) {
    $status = $pedido["status"] === "entregue" ? "Entregue" : "Pendente";

    echo '<div class="pedidoBox">';
    echo "<p><strong>Pedido #{$pedido['id']}</strong></p>";
    echo "<p>Status: <span class='status {$status}'>$status</span></p>";
    echo "<p><strong>Coleta:</strong> {$pedido['endereco_coleta']}</p>";
    echo "<p><strong>Entrega:</strong> {$pedido['endereco_entrega']}</p>";
    echo "<p><strong>Valor Total:</strong> R$ {$pedido['valor']}</p>";
    echo "<p><strong>Precisa de Troco?</strong> " . ($pedido['precisa_troco'] ? "Sim (R$ {$pedido['troco']})" : "Não") . "</p>";

    if ($status === "Pendente") {
      echo '
        <div class="entrega-form">
          <input type="text" maxlength="3" placeholder="ID do piloto" class="input-piloto" data-id="' . $pedido['id'] . '" />
          <button class="btn-entregue" data-id="' . $pedido['id'] . '">Concluir Entrega</button>
        </div>
      ';
    }

    echo '</div>';
  }
}
?>


      </div>
    </main>

    <!-- Footer -->
    <footer>
      <a href="#"><img src="img/instagram.png" alt="Instagram" /></a>
      <a href="#"><img src="img/facebook.png" alt="Facebook" /></a>
      <a href="#"><img src="img/whatsapp.png" alt="WhatsApp" /></a>
      <a href="mailto:contato@lap.com.br"
        ><img src="img/gmail.png" alt="Gmail"
      /></a>
    </footer>

    <script src="script.js"></script>
  </body>
</html>
