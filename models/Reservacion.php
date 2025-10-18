<?php
require_once 'config/database.php';

class Reservacion {
    private $conn;
    private $table = "reservaciones";
    
    public function __construct() {
        // Descomentar cuando configures la BD
        // $database = new Database();
        // $this->conn = $database->getConnection();
    }
    
    public function crear($datos) {
        // Implementar cuando tengas BD
        return true;
    }
    
    public function obtenerMesas() {
        // Implementar cuando tengas BD
        return [];
    }
}
?>