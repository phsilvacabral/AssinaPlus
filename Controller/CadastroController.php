<?php
require_once "../Model/CadastroModel.php";

$acao = $_GET['action'] ?? 'index';

switch ($acao) { 
    case 'validarCadastro':
        $CadastroModel = new CadastroModel();
        
        $usuario = $CadastroModel->solicitacaoCadastro($_POST['nomeCompleto'], $_POST['email'], $_POST['nomeUsuario'], 
        $_POST['senha'],$_POST['setor'], $_POST['tipoUsuario'] );
        if ($usuario != false) {
            header('Location: ../View/Sistema%20de%20Gestão%20de%20Contratos/Sistema%20de%20Gesta╠âo%20de%20Contratos/index.php?sucesso=1'); //Adionar a mensagem de sucesso na view
            exit();
        }
        header('Location: ../View/login.php?erro=1'); //Adionar a mensagem de erro na view
        break;
    default:
        header('Location: ../View/login.php?erro=2'); //Adionar a mensagem de erro na view
        break;
}


?>