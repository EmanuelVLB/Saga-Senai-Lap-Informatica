<?php
require_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["concluir"])) {
  $pedidoId = $_POST["pedido_id"] ?? '';
  $pilotoId = $_POST["piloto_id"] ?? '';

  if (!preg_match('/^\d{3}$/', $pilotoId)) {
    echo json_encode(["status" => "erro", "mensagem" => "ID do piloto inválido."]);
    exit;
  }

  $stmt = $pdo->prepare("UPDATE pedidos SET status = 'entregue', piloto_id = ? WHERE id = ?");
  $ok = $stmt->execute([$pilotoId, $pedidoId]);

  if ($ok) {
    echo json_encode(["status" => "sucesso", "mensagem" => "Entrega concluída com sucesso."]);
  } else {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao atualizar pedido."]);
  }
}
?>
