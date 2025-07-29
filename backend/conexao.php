<?php
$host = "localhost";
$db = "lap_informatica";
$user = "root";     // ajuste se seu MySQL tiver outro usuário
$pass = "";         // insira a senha correta, se houver

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["status" => "erro", "mensagem" => "Erro na conexão: " . $e->getMessage()]));
}
?>
