<?php
require_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["login"])) {
    $email = trim($_POST["email"] ?? '');
    $senha = $_POST["senha"] ?? '';

    if (!$email || !$senha) {
        echo json_encode(["status" => "erro", "mensagem" => "Informe email e senha."]);
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($senha, $usuario["senha"])) {
            echo json_encode([
                "status" => "logado",
                "avatar" => $usuario["avatar"] ?? null
            ]);
        } else {
            echo json_encode(["status" => "erro", "mensagem" => "Senha incorreta."]);
        }
    } else {
        echo json_encode(["status" => "erro", "mensagem" => "Email não encontrado."]);
    }
}
?>
