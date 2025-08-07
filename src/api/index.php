<?php

header('Content-Type: application/json; charset=UTF-8');

$host = 'db';
$db = 'meu_banco';
$user = 'root';
$pass = 'Senha123';

try{
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['nome']) || !isset($data['email']) || !isset($data['mensagem'])) {
        echo json_encode(["success" => false, "message" => "Dados ausentes"]);
        exit;
    }

    $nome = trim($data['nome']);
    $email = trim($data['email']);
    $mensagem = trim($data['mensagem']);
    
    if(!$nome || !$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Nome ou email inválidos.']);
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, mensagem) VALUES (:nome, :email, :mensagem)");
    $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':mensagem', $mensagem, PDO::PARAM_STR);
    $stmt->execute(['nome' => $nome, 'email' => $email, 'mensagem' => $mensagem]);
    
    echo json_encode(['success' => true, 'message' => 'Comentário enviado com sucesso!']);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erro na conexão: " . $e->getMessage()]); 
}
 
?>