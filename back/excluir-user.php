<?php
session_start();
header('Content-Type: application/json');
include('../connection.php');

try {
    // Verificar se o ID do usuário foi enviado
    if (!isset($_POST['id_usuario']) || empty($_POST['id_usuario'])) {
        echo json_encode(['status' => 'error', 'message' => 'ID do usuário não fornecido']);
        exit;
    }

    $id_usuario = intval($_POST['id_usuario']);

    // Verificar se o usuário existe
    $check_sql = "SELECT nome FROM Usuario WHERE id_usuario = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $id_usuario);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Usuário não encontrado']);
        exit;
    }

    $usuario = $check_result->fetch_assoc();
    $nome_usuario = $usuario['nome'];

    // Excluir o usuário
    $delete_sql = "DELETE FROM Usuario WHERE id_usuario = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $id_usuario);

    if ($delete_stmt->execute()) {
        echo json_encode([
            'status' => 'success', 
            'message' => "Usuário '{$nome_usuario}' excluído com sucesso!"
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir usuário: ' . $delete_stmt->error]);
    }

    $delete_stmt->close();
    $check_stmt->close();

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erro: ' . $e->getMessage()]);
} finally {
    if ($conn) {
        $conn->close();
    }
}
?>
