<?php
// Assegure que a resposta seja JSON
header('Content-Type: application/json');

// Função para enviar resposta JSON
function sendResponse($success, $message = '') {
    echo json_encode(array('success' => $success, 'message' => $message));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Configurações do banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sysvite";

    // Conexão ao banco de dados
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexão
    if ($conn->connect_error) {
        sendResponse(false, 'Falha na conexão: ' . $conn->connect_error);
    }

    // Preparar e bind
    $stmt = $conn->prepare("INSERT INTO visitas (nome, cpf, destino, data, cracha, motivo) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        sendResponse(false, 'Erro na preparação da consulta: ' . $conn->error);
    }

    $stmt->bind_param("ssssss", $nome, $cpf, $destino, $data, $cracha, $motivo);

    // Definir parâmetros e executar
    $nome = $_POST['nome'];
    $cpf = $_POST['idt'];
    $destino = $_POST['destino'];
    $data = $_POST['data'];
    $cracha = $_POST['cracha'];
    $motivo = $_POST['motivo'];

    if ($stmt->execute()) {
        sendResponse(true, 'Cadastro realizado com sucesso!');
    } else {
        sendResponse(false, 'Erro ao cadastrar: ' . $stmt->error);
    }

    // Fechar a declaração e a conexão
    $stmt->close();
    $conn->close();
} else {
    sendResponse(false, 'Método de requisição inválido.');
}
?>
