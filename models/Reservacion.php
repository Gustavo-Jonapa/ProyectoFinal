<?php
require_once 'config/database.php';

class Reservacion {
    private $conn;
    private $table = "RESERVACIONES";
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    public function crear($datos) {
        try {
            $sql = "{CALL SP_INSERT_RESERVACION(?, ?, ?, ?, ?, ?)}";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindParam(1, $datos['id_cliente']);
            $stmt->bindParam(2, $datos['id_mesa']);
            $stmt->bindParam(3, $datos['fecha']);
            $stmt->bindParam(4, $datos['hora']);
            $stmt->bindParam(5, $datos['personas']);
            $stmt->bindParam(6, $datos['estado']);
            
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result;
        } catch(PDOException $e) {
            return ['Status' => 'ERROR', 'Mensaje' => $e->getMessage()];
        }
    }
    
    public function obtenerMesas($fecha = null, $hora = null, $personas = null) {
        try {
            $sql = "{CALL SP_GET_MESAS_DISPONIBLES(?, ?, ?)}";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindParam(1, $fecha);
            $stmt->bindParam(2, $hora);
            $stmt->bindParam(3, $personas);
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }
    
    public function obtenerPorCliente($id_cliente) {
        try {
            $sql = "{CALL SP_SELECT_RESERVACIONES_CLIENTE(?)}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id_cliente);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }
    
    public function actualizar($id, $datos) {
        try {
            $sql = "{CALL SP_UPDATE_RESERVACION(?, ?, ?, ?, ?)}";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindParam(1, $id);
            $stmt->bindParam(2, $datos['fecha']);
            $stmt->bindParam(3, $datos['hora']);
            $stmt->bindParam(4, $datos['personas']);
            $stmt->bindParam(5, $datos['id_mesa']);
            
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result;
        } catch(PDOException $e) {
            return ['Status' => 'ERROR', 'Mensaje' => $e->getMessage()];
        }
    }
    
    public function cancelar($id) {
        try {
            $sql = "{CALL SP_CANCELAR_RESERVACION(?)}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch(PDOException $e) {
            return ['Status' => 'ERROR', 'Mensaje' => $e->getMessage()];
        }
    }
    
    public function obtenerTodasReservaciones($fecha = null, $estado = null) {
        try {
            $sql = "{CALL SP_SELECT_RESERVACIONES(NULL, ?, ?)}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $fecha);
            $stmt->bindParam(2, $estado);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }
}
?>
