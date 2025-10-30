<?php
require_once 'config/database.php';

class Producto {
    private $conn;
    private $table = "PRODUCTOS";
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    public function obtenerTodos() {
        try {
            $sql = "{CALL SP_SELECT_PRODUCTOS()}";
            $stmt = $this->conn->prepare($sql); 
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }
    
    public function obtenerPorId($id) {
        try {
            $sql = "{CALL SP_SELECT_PRODUCTOS(?)}";
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
            $sql = "{CALL SP_INSERT_PRODUCTO(?, ?, ?, ?, ?, ?, ?)}";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindParam(1, $datos['nombre']);
            $stmt->bindParam(2, $datos['descripcion']);
            $stmt->bindParam(3, $datos['precio_compra']);
            $stmt->bindParam(4, $datos['precio_venta']);
            $stmt->bindParam(5, $datos['stock_actual']);
            $stmt->bindParam(6, $datos['stock_minimo']);
            $stmt->bindParam(7, $datos['id_proveedor']);
            
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result;
        } catch(PDOException $e) {
            return ['Status' => 'ERROR', 'Mensaje' => $e->getMessage()];
        }
    }
    
    public function actualizar($id, $datos) {
        try {
            $sql = "{CALL SP_UPDATE_PRODUCTO(?, ?, ?, ?, ?, ?, ?, ?)}";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindParam(1, $id);
            $stmt->bindParam(2, $datos['nombre_producto']);
            $stmt->bindParam(3, $datos['unidad_medida']);
            $stmt->bindParam(4, $datos['precio_unitario']);
            $stmt->bindParam(8, $datos['id_proveedor']);
            
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result;
        } catch(PDOException $e) {
            return ['Status' => 'ERROR', 'Mensaje' => $e->getMessage()];
        }
    }
    
    public function eliminar($id) {
        try {
            $sql = "{CALL SP_DELETE_PRODUCTO(?)}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch(PDOException $e) {
            return ['Status' => 'ERROR', 'Mensaje' => $e->getMessage()];
        }
    }
    
    public function obtenerProductosBajoStock() {
        try {
            $sql = "{CALL SP_PRODUCTOS_BAJO_STOCK()}";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }
}
?>