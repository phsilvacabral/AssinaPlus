<?php
class ConexaoBD {
    private static $instancia = null; 
    private PDO $conn; 

    private string $host = "localhost";
    private string $usuario = "root";
    private string $senha = "PUC@1234";
    private string $banco = "gestaocontratos";

    private function __construct() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->banco};charset=utf8";
            $this->conn = new PDO($dsn, $this->usuario, $this->senha);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "
                <section>
                    <p>Houve um problema de conexão com o banco de dados. 
                    Tente novamente mais tarde.</p>
                </section>
            ";
            die("Erro de conexão: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instancia === null) {
            echo "Criando nova instancia de ConexaoBD";
            self::$instancia = new ConexaoBD();
        }
        return self::$instancia;
    }

    public function getConexao(): PDO {
        return $this->conn;
    }
}
?>
