<?php
require_once 'config/database.php';

class Usuario {
    private $conn;
    private $table = "usuarios";
    
    public function __construct() {
        // Descomentar cuando configures la BD
        // $database = new Database();
        // $this->conn = $database->getConnection();
    }
    
    public function crear($datos) {
        // Implementar cuando tengas BD
        return true;
    }
    
    public function autenticar($email, $password) {
        // Implementar cuando tengas BD
        return false;
    }
}
?>