<?php
require_once 'config/database.php';

class Usuario {
    private $conn;
    private $table = "";
    
    public function __construct() {
        
    }
    
    public function crear($datos) {
        
        return true;
    }
    
    public function autenticar($email, $password) {
        
        return false;
    }
}
?>