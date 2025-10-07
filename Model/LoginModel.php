<?php

require_once "ConexaoBD.php";
require_once "UserAdminModel.php";

class LoginModel {
    public static function validarLoginUsuario($email, $senha) {
        $usuario = UserAdminModel::buscarDadosUsuario($email);
        if ($usuario['email'] === $email && password_verify($senha, $usuario['senha'])) {
            $userAdmin = UserAdminModel::getInstance(
                $usuario['name'],
                $usuario['email'],
                $usuario['senha'],
                $usuario['nomePerfil'],
                UserAdminModel::buscarSetor($usuario['id_setor']),
                UserAdminModel::buscarTipoUsuario($usuario['id_tipo']),
                $usuario['status']
            );
            return $usuario;
        }

        return false;
    }
}

?>