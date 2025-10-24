<?php
require_once 'config/database.php';

class Cliente {
    private $conn;
    private $table = "clientes";
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    public function crear($datos) {
        // Aquí iría la inserción a la BD
        // $query = "INSERT INTO " . $this->table . " (nombre, telefono, email, fecha_nacimiento, notas, fecha_registro) 
        //           VALUES (:nombre, :telefono, :email, :fecha_nacimiento, :notas, GETDATE())";
        return true;
    }
    
    public function obtenerTodos() {
        // Aquí iría la consulta a la BD
        return [];
    }
    
    public function buscar($termino) {
        // Aquí iría la búsqueda en la BD
        // $query = "SELECT * FROM " . $this->table . " 
        //           WHERE nombre LIKE :termino OR telefono LIKE :termino OR email LIKE :termino";
        return [];
    }
    
    public function obtenerPorId($id) {
        // Aquí iría la consulta específica
        return null;
    }
    
    public function actualizar($id, $datos) {
        // Aquí iría la actualización en la BD
        return true;
    }
}
?>
