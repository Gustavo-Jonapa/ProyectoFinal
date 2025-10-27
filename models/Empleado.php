<?php
require_once 'config/database.php';

class Empleado {
    private $conn;
    private $table = "EMPLEADOS";
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    public function obtenerTodos() {
        try {
            $sql = "{CALL SP_SELECT_EMPLEADOS()}";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }
    
    public function obtenerPorId($id) {
        try {
            $sql = "{CALL SP_SELECT_EMPLEADOS(?)}";
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
            $sql = "{CALL SP_INSERT_EMPLEADO(?, ?, ?, ?, ?, ?, ?, ?)}";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindParam(1, $datos['nombre']);
            $stmt->bindParam(2, $datos['apellido']);
            $stmt->bindParam(3, $datos['puesto']);
            $stmt->bindParam(4, $datos['telefono']);
            $stmt->bindParam(5, $datos['email']);
            $stmt->bindParam(6, $datos['salario']);
            $stmt->bindParam(7, $datos['fecha_contratacion']);
            $stmt->bindParam(8, $datos['id_colonia']);
            
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result;
        } catch(PDOException $e) {
            return ['Status' => 'ERROR', 'Mensaje' => $e->getMessage()];
        }
    }
    
    public function actualizar($id, $datos) {
        try {
            $sql = "{CALL SP_UPDATE_EMPLEADO(?, ?, ?, ?, ?, ?, ?, ?, ?)}";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindParam(1, $id);
            $stmt->bindParam(2, $datos['nombre']);
            $stmt->bindParam(3, $datos['apellido']);
            $stmt->bindParam(4, $datos['puesto']);
            $stmt->bindParam(5, $datos['telefono']);
            $stmt->bindParam(6, $datos['email']);
            $stmt->bindParam(7, $datos['salario']);
            $stmt->bindParam(8, $datos['fecha_contratacion']);
            $stmt->bindParam(9, $datos['id_colonia']);
            
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result;
        } catch(PDOException $e) {
            return ['Status' => 'ERROR', 'Mensaje' => $e->getMessage()];
        }
    }
    
    public function eliminar($id) {
        try {
            $sql = "{CALL SP_DELETE_EMPLEADO(?)}";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch(PDOException $e) {
            return ['Status' => 'ERROR', 'Mensaje' => $e->getMessage()];
        }
    }
}
?>
