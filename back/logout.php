<?php
session_start();

// Destrói todas as variáveis de sessão
$_SESSION = array();

// Se você quiser destruir a sessão completamente, também delete o cookie de sessão
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destrói a sessão
session_destroy();

// Redireciona para a página de login
header("Location: ../");
exit();
?>
