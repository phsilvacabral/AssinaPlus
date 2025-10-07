<?php

require_once "ConexaoBD.php";
require_once "UserAdminModel.php";

class CadastroModel {

   
    public static function solicitacaoCadastro($nomeCompleto, $email, $nomeUsuario, $senha, $setor, $tipoUsuario) {
        $usuario = UserAdminModel::buscarDadosUsuario($email);
        if ($usuario['email'] === $email) {
            return false; 
        }

        $hashedSenha = password_hash($senha, PASSWORD_BCRYPT);

        $conexao = ConexaoBD::getConnection();
        $stmt = $conexao->prepare("INSERT INTO usuarios (name, email, nomePerfil, senha, id_setor, id_tipo, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssis", $nomeCompleto, $email, $nomeUsuario, $hashedSenha, $setor, $tipoUsuario, "pendente");
        
        if ($stmt->execute()) {
            return true; 
        } else {
            return false;
        }
    }
}

?>