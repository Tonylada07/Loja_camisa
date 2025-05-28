<?php
require_once 'config.php';

class Database {
    private $connection;
    
    public function __construct() {
        $this->connect();
    }
    
    private function connect() {
        try {
            $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            
            if ($this->connection->connect_error) {
                throw new Exception("Erro na conexão com o banco de dados: " . $this->connection->connect_error);
            }
            
            $this->connection->set_charset("utf8");
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    
    public function query($sql) {
        $result = $this->connection->query($sql);
        
        if (!$result) {
            die("Erro na consulta: " . $this->connection->error);
        }
        
        return $result;
    }
    
    public function select($sql) {
        $result = $this->query($sql);
        $rows = [];
        
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        
        return $rows;
    }
    
    public function insert($sql) {
        if ($this->query($sql)) {
            return $this->connection->insert_id;
        }
        
        return false;
    }
    
    public function update($sql) {
        return $this->query($sql) ? $this->connection->affected_rows : false;
    }
    
    public function delete($sql) {
        return $this->query($sql) ? $this->connection->affected_rows : false;
    }
    
    public function escape($value) {
        return $this->connection->real_escape_string($value);
    }
    
    public function close() {
        $this->connection->close();
    }
}

// Instância do banco de dados para uso global
$db = new Database();
?>
