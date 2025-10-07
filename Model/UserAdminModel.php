<?php

require_once "ConexaoBD.php";

class UserAdminModel {
    private static $instance = null;

    private $name;
    private $email;
    private $senha; 
    private $nomeUsuario;
    private $setor;
    private $tipoUsuario;
    private $status;


    private function __construct($name, $email, $senha, $nomeUsuario, $setor, $tipoUsuario, $status) {
        $this->name = $name;
        $this->email = $email;
        $this->senha = $senha;
        $this->nomeUsuario = $nomeUsuario;
        $this->setor = $setor;
        $this->tipoUsuario = $tipoUsuario;
        $this->status = $status;  
    }

    public static function getInstance($name, $email, $senha, $nomeUsuario, $setor, $tipoUsuario, $status) {
        if (self::$instance === null) {
            self::$instance = new UserAdminModel($name, $email, $senha, $nomeUsuario, $setor, $tipoUsuario, $status);
        }
        return self::$instance;
    }

    public static function buscarDadosUsuario($email) {
        $conexao = ConexaoBD::getInstance()->getConexao();
        $stmt = $conexao->prepare("SELECT * FROM usuario WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } 

    public static function buscarSetor($setor) {
        $conexao = ConexaoBD::getInstance()->getConexao();
        $stmt = $conexao->prepare("SELECT * FROM setor WHERE id_setor = :setor");
        $stmt->bindParam(':setor', $setor);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
        
    }

    public static function buscarTipoUsuario($tipoUsuario) {
        $conexao = ConexaoBD::getInstance()->getConexao()  ;
        $stmt = $conexao->prepare("SELECT * FROM tipousuario WHERE id_tipo = :tipoUsuario");
        $stmt->bindParam(':tipoUsuario', $tipoUsuario);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
        
    }

}
?>