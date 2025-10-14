<?php
session_start();
header('Content-Type: application/json');
include('../connection.php');

try {
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';
    $nomePerfil = isset($_POST['usuario']) ? $_POST['usuario'] : '';
    $id_setor = isset($_POST['setor']) && !empty($_POST['setor']) ? $_POST['setor'] : null;
    $id_tipo = isset($_POST['tipoUsuario']) && !empty($_POST['tipoUsuario']) ? $_POST['tipoUsuario'] : null;
    $statusUsuario = 'Pendente';

    if (empty($nome) || empty($email) || empty($senha) || empty($nomePerfil)) {
        echo json_encode(['status' => 'error', 'message' => 'Nome, email, nome de usuário e senha são obrigatórios']);
        exit;
    }

    // Validação dos campos obrigatórios setor e tipo de usuário
    if (empty($id_setor) || empty($id_tipo)) {
        echo json_encode(['status' => 'error', 'message' => 'Setor e tipo de usuário são obrigatórios']);
        exit;
    }

    if ($conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Erro de conexão: ' . $conn->connect_error]);
        exit;
    }

    // Verifica se o email já existe
    $check_sql = "SELECT id_usuario FROM Usuario WHERE email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Este email já está cadastrado']);
        exit;
    }

    // Insere o novo usuário
    $sql = "INSERT INTO Usuario (nome, email, senha, nomePerfil, id_setor, id_tipo, statusUsuario) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao preparar query: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param("ssssiis", $nome, $email, $senha, $nomePerfil, $id_setor, $id_tipo, $statusUsuario);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Solicitação de cadastro enviado!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao cadastrar: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erro: ' . $e->getMessage()]);
}
?>