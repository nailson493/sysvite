<?php

include "banco.php";

// Consulta SQL para contar visitas por mês
$sql = "
    SELECT 
        MONTH(STR_TO_DATE(data, '%d/%m/%Y %H:%i:%s')) as mes, 
        COUNT(*) as contagem 
    FROM 
        visitas 
    GROUP BY 
        MONTH(STR_TO_DATE(data, '%d/%m/%Y %H:%i:%s'))
";

$result = $conn->query($sql);

$visitasPorMes = [];

if ($result->num_rows > 0) {
    // Processa os resultados
    while($row = $result->fetch_assoc()) {
        $visitasPorMes[] = $row;
    }
} else {
    echo json_encode([]);
}

$conn->close();

echo json_encode($visitasPorMes);
?>