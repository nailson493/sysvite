<?php
if (isset($_GET['cpf'])) {
    $cpf = $_GET['cpf'];

    // Configurações do banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sysvite";

    // Conexão ao banco de dados
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexão
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Preparar e executar a consulta
    $stmt = $conn->prepare("SELECT * FROM dados WHERE cpf = ?");
    $stmt->bind_param("s", $cpf);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // CPF encontrado, retorna os dados em formato JSON
        $data = $result->fetch_assoc();
        echo json_encode(array('success' => true, 'nome' => $data['nome'], 'cpf' => $data['cpf'], 'cep' => $data['cep'], 'rua' => $data['rua'], 'bairro' => $data['bairro'], 'cidade' => $data['cidade'], 'estado' => $data['estado'], 'telefone' => $data['telefone'], 'sexo' => $data['sexo']));
    } else {
        // CPF não encontrado
        echo json_encode(array('success' => false, 'message' => 'CPF não encontrado'));
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(array('success' => false, 'message' => 'Nenhum CPF fornecido'));
}
?>
