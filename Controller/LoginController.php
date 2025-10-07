<?php

require_once "../Model/LoginModel.php";
require_once "../Model/SessionManagerModel.php";

$acao = $_GET['action'] ?? 'index';

switch ($acao) {
    case 'validarLogin':
        $LoginModel = new LoginModel();
        $usuario = $LoginModel->validarLoginUsuario($_POST['email'], $_POST['senha']);
        if (!$usuario == false) {
            $session = SessionManagerModel::getInstance();
            $session->set('email', $usuario['email']);
            header('Location: ../View/home.php'); // adicionar a pagina inicial do sistema
            exit();
        }
        header('Location: ../View/index.php?abrirModal=login');
        break;
    default:
        header('Location: ../View/login.php?erro=2'); //Adionar a mensagem de erro na view
        break;
}


?>