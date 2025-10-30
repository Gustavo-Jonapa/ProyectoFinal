<?php
require_once 'config/database.php';

class Proveedor {
    private $conn;
    private $table = "PROVEEDORES";
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    public function obtenerTodos() {
        try {
            $sql = "{CALL SP_SELECT_PROVEEDORES()}";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }
    
    public function obtenerPorId($id) {
        try {
            $sql = "{CALL SP_SELECT_PROVEEDORES(?)}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return null;
        }
    }
    
    public function crear($datos) {
        try {
            $sql = "{CALL SP_INSERT_PROVEEDOR(?, ?, ?, ?, ?, ?)}";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindParam(1, $datos['nombre']);
            $stmt->bindParam(2, $datos['contacto']);
            $stmt->bindParam(3, $datos['telefono']);
            $stmt->bindParam(4, $datos['email']);
            $stmt->bindParam(5, $datos['direccion']);
            $stmt->bindParam(6, $datos['tipo_producto']);
            
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result;
        } catch(PDOException $e) {
            return ['Status' => 'ERROR', 'Mensaje' => $e->getMessage()];
        }
    }
    
    public function actualizar($id, $datos) {
        try {
            $sql = "{CALL SP_UPDATE_PROVEEDOR(?, ?, ?, ?, ?, ?, ?)}";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindParam(1, $id);
            $stmt->bindParam(2, $datos['nombre']);
            $stmt->bindParam(3, $datos['contacto']);
            $stmt->bindParam(4, $datos['telefono']);
            $stmt->bindParam(5, $datos['email']);
            $stmt->bindParam(6, $datos['direccion']);
            $stmt->bindParam(7, $datos['tipo_producto']);
            
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result;
        } catch(PDOException $e) {
            return ['Status' => 'ERROR', 'Mensaje' => $e->getMessage()];
        }
    }
    
    public function eliminar($id) {
        try {
            $sql = "{CALL SP_DELETE_PROVEEDOR(?)}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch(PDOException $e) {
            return ['Status' => 'ERROR', 'Mensaje' => $e->getMessage()];
        }
    }
    
    public function obtenerActivos() {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE ACTIVO = 1 ORDER BY NOMBRE";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }
}
?>