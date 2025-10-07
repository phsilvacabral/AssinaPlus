<?php
include ("../Model/SessionManagerModel.php");

class SessionController {
    private $sessionManager;

    public function __construct() {
        $this->sessionManager = SessionManagerModel::getInstance();
    }

    public function logout() {
        $this->sessionManager->destroy();
        header('Location: login.php'); // Redireciona para a página de login
        exit();
    }

    public function checkAuth() {
        if (!$this->sessionManager->get('cpf')) {
            header('Location: login.php');
            exit();
        }
    }
}

?>