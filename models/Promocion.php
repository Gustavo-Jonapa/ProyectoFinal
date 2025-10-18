<?php
require_once 'config/database.php';

class Promocion {
    private $conn;
    private $table = "promociones";
    
    public function __construct() {
        // Descomentar cuando configures la BD
        // $database = new Database();
        // $this->conn = $database->getConnection();
    }
    
    public function obtenerTodas() {
        // Implementar cuando tengas BD
        return [];
    }
}
?>