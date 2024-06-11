<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['photo'])) {
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

    // Diretório de uploads
    $uploadsDir = 'uploads/'; // Defina o diretório de uploads
    if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0777, true); // Cria o diretório se não existir
    }

    // Caminho completo para a foto
    $photoPath = $uploadsDir . uniqid() . '.png';

    // Move o arquivo de upload para o diretório de uploads
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath)) {
        // Preparar e bind
        $stmt = $conn->prepare("INSERT INTO dados (nome, cpf, cep, rua, bairro, cidade, estado, telefone, sexo, photo_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $fullName, $idt, $cep, $rua, $bairro, $cidade, $uf, $tel, $sexo, $photoPath);

        // Definir parâmetros e executar
        $fullName = $_POST['nome'];
        $idt = $_POST['idt'];
        $cep = $_POST['cep'];
        $rua = $_POST['rua'];
        $bairro = $_POST['bairro'];
        $cidade = $_POST['cidade'];
        $uf = $_POST['uf'];
        $tel = $_POST['tel'];
        $sexo = $_POST['sexo'];

        if ($stmt->execute()) {
            // Se a inserção for bem-sucedida, retorna uma resposta em JSON indicando o sucesso
            echo json_encode(array('success' => true));
        } else {
            // Se ocorrer um erro ao cadastrar, retorna uma resposta em JSON indicando o erro
            echo json_encode(array('success' => false, 'message' => 'Erro ao cadastrar: ' . $stmt->error));
        }
        

        $conn->close();
    } else {
        echo "Erro ao enviar o arquivo.";
    }
} else {
    echo "Nenhum arquivo enviado.";
}
?>
