<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

$id = $input['id'];
$rating = $input['rating'];
$feedback = $input['feedback'];
$process = $input['process'];

include "banco.php";

$sql = "UPDATE visitas SET feedbackNumber = ?, feedbackText = ?, processo = ?, cracha = 0 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('isii', $rating, $feedback, $process, $id);

if ($stmt->execute()) {
    echo json_encode(['message' => 'Feedback atualizado com sucesso!']);
} else {
    echo json_encode(['message' => 'Erro ao atualizar o feedback: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
