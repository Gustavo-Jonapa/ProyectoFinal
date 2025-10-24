<?php
require_once 'config/database.php';

class Calificacion {
    private $conn;
    private $table = "calificaciones";
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    public function crear($datos) {
        // Aquí iría la inserción a la BD
        // $query = "INSERT INTO " . $this->table . " (calificacion, tipo, comentario, nombre, email, fecha_creacion) 
        //           VALUES (:calificacion, :tipo, :comentario, :nombre, :email, GETDATE())";
        return true;
    }
    
    public function obtenerTodas() {
        // Aquí iría la consulta a la BD
        return [];
    }
    
    public function obtenerPromedio() {
        // Aquí iría el cálculo del promedio
        return 0;
    }
}
?>
