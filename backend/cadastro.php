<?php
require_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cadastro"])) {
    $nome = trim($_POST["nome"] ?? '');
    $telefone = trim($_POST["telefone"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $senha = password_hash($_POST["senha"] ?? '', PASSWORD_DEFAULT);
    $avatar = trim($_POST["avatar"] ?? null);

    if (!$nome || !$telefone || !$email || !$senha) {
        echo json_encode(["status" => "erro", "mensagem" => "Preencha todos os campos."]);
        exit;
    }

    // Verificar se email já existe
    $verifica = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $verifica->execute([$email]);
    if ($verifica->rowCount() > 0) {
        echo json_encode(["status" => "erro", "mensagem" => "Email já cadastrado."]);
        exit;
    }

    // Inserir usuário
    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, telefone, email, senha, avatar) VALUES (?, ?, ?, ?, ?)");
    $executou = $stmt->execute([$nome, $telefone, $email, $senha, $avatar]);

    if ($executou) {
        echo json_encode(["status" => "sucesso"]);
    } else {
        echo json_encode(["status" => "erro", "mensagem" => "Erro ao cadastrar usuário."]);
    }
}
?>
