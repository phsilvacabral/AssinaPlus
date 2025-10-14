<?php
session_start();
include('../connection.php');
header('Content-Type: application/json');

try {
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';

    if (empty($usuario) || empty($senha)) {
        echo json_encode(['status' => 'error', 'message' => 'usuario e senha são obrigatórios']);
        exit;
    }

    if ($conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Erro de conexão: ' . $conn->connect_error]);
        exit;
    }

    $sql = "SELECT * FROM Usuario WHERE nomePerfil = ? AND senha = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao preparar query: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param("ss", $usuario, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id_usuario'];
        $_SESSION['user_nome'] = $user['nome'];
        echo json_encode(['status' => 'success', 'message' => 'Login realizado']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'usuario ou senha incorretos']);
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erro: ' . $e->getMessage()]);
}
?>