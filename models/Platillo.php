<?php
require_once 'config/database.php';

class Platillo {
    private $conn;
    private $table = "";
    
    public function __construct() {
        
    }
    
    public function obtenerTodos() {
        
        return [];
    }
}
?>