<?php
header('Content-Type: application/json');
include('../connection.php');

try {
    $id_usuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : '';
    $acao = isset($_POST['acao']) ? $_POST['acao'] : '';

    if (empty($id_usuario) || empty($acao)) {
        echo json_encode(['status' => 'error', 'message' => 'Dados incompletos']);
        exit;
    }

    if ($acao !== 'ativar' && $acao !== 'desativar') {
        echo json_encode(['status' => 'error', 'message' => 'Ação inválida']);
        exit;
    }

    if ($conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Erro de conexão']);
        exit;
    }

    // Define o novo status
    $novoStatus = ($acao === 'ativar') ? 'Ativo' : 'Inativo';

    // Atualiza o status do usuário
    $sql = "UPDATE Usuario SET statusUsuario = ? WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao preparar query']);
        exit;
    }

    $stmt->bind_param("si", $novoStatus, $id_usuario);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $mensagem = ($acao === 'ativar') ? 'Usuário ativado com sucesso!' : 'Usuário desativado com sucesso!';
            echo json_encode(['status' => 'success', 'message' => $mensagem]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Usuário não encontrado ou status já atualizado']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar status']);
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erro: ' . $e->getMessage()]);
}
?>