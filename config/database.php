<?php
    class Database{
        private $host = ".\SQLEXPRESS";
        private $db_name = "";
        private $username = "";
        private $password = "";
        public $conn;
        public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("sqlsrv:Server={$this->host};Database={$this->db_name}", 
                                   $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
    }    
?>