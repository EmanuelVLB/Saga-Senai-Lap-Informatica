<?php
require_once "conexao.php";
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $peso = $_POST["peso"] ?? '';
  $tamanho = $_POST["tamanho"] ?? '';
  $troco = $_POST["troco"] ?? null;
  $coleta = $_POST["coleta"] ?? '';
  $entrega = $_POST["entrega"] ?? '';
  $valor = $_POST["valor"] ?? 0;

  $precisaTroco = !empty($troco) ? 1 : 0;

  $stmt = $pdo->prepare("INSERT INTO pedidos 
    (peso, tamanho, endereco_coleta, endereco_entrega, precisa_troco, troco, valor, status, data_pedido)
    VALUES (?, ?, ?, ?, ?, ?, ?, 'pendente', NOW())");

  $ok = $stmt->execute([$peso, $tamanho, $coleta, $entrega, $precisaTroco, $troco, $valor]);

  if ($ok) {
    echo json_encode(["status" => "sucesso"]);
  } else {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao registrar pedido."]);
  }
}
