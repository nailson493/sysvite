<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Configurações do banco de dados
    include "banco.php";
    
    // Conexão ao banco de dados
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexão
    if ($conn->connect_error) {
        // Retorna um JSON com mensagem de erro
        header('Content-Type: application/json');
        echo json_encode(array('success' => false, 'message' => 'Falha na conexão: ' . $conn->connect_error));
        exit;
    }

    // Verificar se CPF já está cadastrado
    $cpf = $_POST['idt'];
    $stmt_check = $conn->prepare("SELECT id FROM dados WHERE cpf = ?");
    $stmt_check->bind_param("s", $cpf);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        // CPF já cadastrado, retornar erro
        header('Content-Type: application/json');
        echo json_encode(array('success' => false, 'message' => 'CPF já cadastrado.'));
        exit;
    }

    // Diretório de uploads
    $uploadsDir = 'uploads/'; 
    if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0777, true); // Cria o diretório se não existir
    }

    // Verifica se foi enviado um arquivo de foto
    $photoPath = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        // Verifica a extensão do arquivo e o tipo MIME para garantir que é uma imagem
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileMimeType = mime_content_type($_FILES['photo']['tmp_name']);
        if (!in_array($fileMimeType, $allowedMimeTypes)) {
            header('Content-Type: application/json');
            echo json_encode(array('success' => false, 'message' => 'Tipo de arquivo não permitido.'));
            exit;
        }

        // Caminho completo para a foto
        $photoPath = $uploadsDir . uniqid() . '.png';

        // Move o arquivo de upload para o diretório de uploads
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath)) {
            header('Content-Type: application/json');
            echo json_encode(array('success' => false, 'message' => 'Erro ao mover o arquivo para o diretório de uploads.'));
            exit;
        }
    }

    // Prepara a inserção dos dados
    $stmt_insert = $conn->prepare("INSERT INTO dados (nome, cpf, cep, rua, bairro, cidade, estado, telefone, sexo, photo_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt_insert->bind_param("ssssssssss", $fullName, $idt, $cep, $rua, $bairro, $cidade, $uf, $tel, $sexo, $photoPath);

    // Define os parâmetros e executa
    $fullName = htmlspecialchars($_POST['nome']);
    $idt = htmlspecialchars($_POST['idt']);
    $cep = htmlspecialchars($_POST['cep']);
    $rua = htmlspecialchars($_POST['rua']);
    $bairro = htmlspecialchars($_POST['bairro']);
    $cidade = htmlspecialchars($_POST['cidade']);
    $uf = htmlspecialchars($_POST['uf']);
    $tel = htmlspecialchars($_POST['tel']);
    $sexo = htmlspecialchars($_POST['sexo']);

    if ($stmt_insert->execute()) {
        // Se a inserção for bem-sucedida, retorna uma resposta em JSON indicando o sucesso
        header('Content-Type: application/json');
        echo json_encode(array('success' => true, 'message' => 'Dados cadastrados com sucesso.'));
    } else {
        // Se ocorrer um erro ao cadastrar, retorna uma resposta em JSON indicando o erro
        header('Content-Type: application/json');
        echo json_encode(array('success' => false, 'message' => 'Erro ao cadastrar: ' . $stmt_insert->error));
    }

    // Fecha as consultas e a conexão
    $stmt_insert->close();
    $stmt_check->close();
    $conn->close();
} else {
    header('Content-Type: application/json');
    echo json_encode(array('success' => false, 'message' => 'Nenhum arquivo enviado ou método não suportado.'));
}
?>
