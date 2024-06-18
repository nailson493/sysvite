<?php
// Assegure que a resposta seja JSON
header('Content-Type: application/json');

// Função para enviar resposta JSON
function sendResponse($success, $message = '', $data = []) {
    echo json_encode(array('success' => $success, 'message' => $message, 'data' => $data));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Configurações do banco de dados
    include "banco.php";

    try {
        // Conexão ao banco de dados
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar conexão
        if ($conn->connect_error) {
            sendResponse(false, 'Falha na conexão: ' . $conn->connect_error);
        }

        // Inicia uma transação
        $conn->begin_transaction();

        // Verificar e sanitizar os dados de entrada
        $nome = htmlspecialchars(trim($_POST['nome'] ?? ''));
        $cpf = htmlspecialchars(trim($_POST['idt'] ?? ''));
        $destino = htmlspecialchars(trim($_POST['destino'] ?? ''));
        $data = htmlspecialchars(trim($_POST['data'] ?? ''));
        $cracha = htmlspecialchars(trim($_POST['cracha'] ?? ''));
        $motivo = htmlspecialchars(trim($_POST['motivo'] ?? ''));

        // Verificar se os campos obrigatórios estão presentes
        if (empty($nome) || empty($cpf) || empty($destino) || empty($data) || empty($cracha) || empty($motivo)) {
            sendResponse(false, 'Por favor, preencha todos os campos obrigatórios.');
        }

        // Preparar e bind
        $stmt = $conn->prepare("INSERT INTO visitas (nome, cpf, destino, data, cracha, motivo) VALUES (?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            sendResponse(false, 'Erro na preparação da consulta: ' . $conn->error);
        }

        $stmt->bind_param("ssssss", $nome, $cpf, $destino, $data, $cracha, $motivo);

        // Executar a inserção
        if ($stmt->execute()) {
            // Commit da transação se tudo ocorrer bem
            $conn->commit();
            sendResponse(true, 'Cadastro realizado com sucesso!');
        } else {
            // Rollback da transação em caso de erro
            $conn->rollback();
            sendResponse(false, 'Erro ao cadastrar: ' . $stmt->error);
        }

        // Fechar a declaração e a conexão
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        // Rollback da transação em caso de exceção
        $conn->rollback();
        sendResponse(false, 'Erro inesperado: ' . $e->getMessage());
    }
} else {
    sendResponse(false, 'Método de requisição inválido.');
}
?>
