<?php
require_once 'config/database.php';

class Reservacion {
    private $conn;
    private $table = "";
    
    public function __construct() {
        
    }
    
    public function crear($datos) {
        
        return true;
    }
    
    public function obtenerMesas() {
        
        return [];
    }
}
?>