<?php
header('Content-Type: application/json');
include('../connection.php');

try {
    if ($conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Erro de conexão']);
        exit;
    }

    $sql = "SELECT u.id_usuario, u.nome, u.email, u.nomePerfil, u.statusUsuario,
                   s.nome as nome_setor, t.Nome as tipo_usuario
            FROM Usuario u
            LEFT JOIN Setor s ON u.id_setor = s.id_setor
            LEFT JOIN TipoUsuario t ON u.id_tipo = t.id_tipo
            WHERE u.statusUsuario = 'Pendente'
            ORDER BY u.id_usuario DESC";

    $result = $conn->query($sql);

    $solicitacoes = array();
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $solicitacoes[] = $row;
        }
    }

    echo json_encode([
        'status' => 'success',
        'data' => $solicitacoes
    ]);

    $conn->close();

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erro: ' . $e->getMessage()]);
}
?>