<?php
namespace app\db;
use app\classes\logger;

class ConfigDB{

    protected $pdo;
    
    protected function getConnection() {
        try {
            $this->pdo = new \PDO("mysql:host=localhost;port=3306;dbname=app;charset=utf8mb4","root");
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            return $this->pdo;
        } catch(\PDOException $e) {
            throw new \ErrorException("Erro ao conectar com ao banco de dados");
            Logger::error($e->getMessage());
        }
    }
}

?>
