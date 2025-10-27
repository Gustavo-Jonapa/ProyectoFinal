<?php
require_once 'config/database.php';

class Calificacion {
    private $conn;
    private $table = "CALIFICACIONES";
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    public function crear($datos) {
        try {
            $sql = "{CALL SP_INSERT_CALIFICACION(?, ?, ?, ?, ?)}";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindParam(1, $datos['calificacion']);
            $stmt->bindParam(2, $datos['tipo']);
            $stmt->bindParam(3, $datos['comentario']);
            $stmt->bindParam(4, $datos['nombre']);
            $stmt->bindParam(5, $datos['email']);
            
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result;
        } catch(PDOException $e) {
            return ['Status' => 'ERROR', 'Mensaje' => $e->getMessage()];
        }
    }
    
    public function obtenerTodas($limite = 10) {
        try {
            $sql = "{CALL SP_SELECT_CALIFICACIONES(NULL, NULL, NULL, ?)}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $limite);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }
    
    public function obtenerPromedio() {
        try {
            $sql = "{CALL SP_GET_PROMEDIO_CALIFICACIONES()}";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [
                'PROMEDIO_CALIFICACION' => 0,
                'TOTAL_CALIFICACIONES' => 0,
                'CINCO_ESTRELLAS' => 0,
                'CUATRO_ESTRELLAS' => 0,
                'TRES_ESTRELLAS' => 0,
                'DOS_ESTRELLAS' => 0,
                'UNA_ESTRELLA' => 0
            ];
        }
    }
    
    public function obtenerPorTipo($tipo) {
        try {
            $sql = "{CALL SP_SELECT_CALIFICACIONES(NULL, ?, NULL, NULL)}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $tipo);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }
}
?>
