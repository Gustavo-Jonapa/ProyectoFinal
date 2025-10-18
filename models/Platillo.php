<?php
require_once 'config/database.php';

class Platillo {
    private $conn;
    private $table = "platillos";
    
    public function __construct() {
        // Descomentar cuando configures la BD
        // $database = new Database();
        // $this->conn = $database->getConnection();
    }
    
    public function obtenerTodos() {
        // Implementar cuando tengas BD
        return [];
    }
}
?>