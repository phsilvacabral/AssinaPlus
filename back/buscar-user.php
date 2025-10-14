<?php
header('Content-Type: application/json');
include('../connection.php');

try {
    $id_usuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : '';

    if (empty($id_usuario)) {
        echo json_encode(['status' => 'error', 'message' => 'ID do usuário não informado']);
        exit;
    }

    if ($conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Erro de conexão']);
        exit;
    }

    $sql = "SELECT id_usuario, nome, email, nomePerfil, id_setor, id_tipo, statusUsuario 
            FROM Usuario WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        echo json_encode(['status' => 'success', 'data' => $usuario]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Usuário não encontrado']);
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erro: ' . $e->getMessage()]);
}
?>