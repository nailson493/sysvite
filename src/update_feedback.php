<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

$id = $input['id'];
$rating = $input['rating'];
$feedback = $input['feedback'];
$process = $input['process'];

// Define o fuso horário
date_default_timezone_set('America/Sao_Paulo'); // Substitua pelo seu fuso horário

// Captura a data e hora atual
$currentDateTime = date('Y-m-d H:i:s'); // Formato 'YYYY-MM-DD HH:MM:SS'

include "banco.php";

$sql = "UPDATE visitas SET feedbackNumber = ?, feedbackText = ?, processo = ?, cracha = 0, data_encerramento = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('isisi', $rating, $feedback, $process, $currentDateTime, $id);

if ($stmt->execute()) {
    echo json_encode(['message' => 'Feedback atualizado com sucesso!']);
} else {
    echo json_encode(['message' => 'Erro ao atualizar o feedback: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
