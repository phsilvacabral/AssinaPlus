<?php
header('Content-Type: application/json');
include('../connection.php');

try {
    $id_usuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : '';
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $id_setor = isset($_POST['setor']) && !empty($_POST['setor']) ? $_POST['setor'] : null;
    $id_tipo = isset($_POST['perfil']) && !empty($_POST['perfil']) ? $_POST['perfil'] : null;

    if (empty($id_usuario) || empty($nome) || empty($email)) {
        echo json_encode(['status' => 'error', 'message' => 'Dados obrigatórios não informados']);
        exit;
    }

    if ($conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Erro de conexão']);
        exit;
    }

    // Verifica se o email já existe em outro usuário
    $check_sql = "SELECT id_usuario FROM Usuario WHERE email = ? AND id_usuario != ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("si", $email, $id_usuario);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Este email já está sendo usado por outro usuário']);
        exit;
    }

    // Atualiza os dados do usuário
    $sql = "UPDATE Usuario SET nome = ?, email = ?, id_setor = ?, id_tipo = ? WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao preparar query']);
        exit;
    }

    $stmt->bind_param("ssiii", $nome, $email, $id_setor, $id_tipo, $id_usuario);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Usuário atualizado com sucesso!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar usuário']);
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erro: ' . $e->getMessage()]);
}
?>