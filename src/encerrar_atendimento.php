<?php

// encerrar_atendimento.php

include "banco.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    
    // Atualiza a data de encerramento para o horário atual
    $sql = "UPDATE visitas SET data_encerramento = NOW(), processo = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "Atendimento encerrado com sucesso!";
    } else {
        echo "Erro ao encerrar o atendimento: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
