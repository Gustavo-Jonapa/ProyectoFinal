<?php
require_once 'config/database.php';

class Usuario {
    private $conn;
    private $table = "LOGIN_USUARIOS";
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    public function crear($datos) {
        try {
            $sql = "{CALL SP_REGISTRAR_USUARIO_CLIENTE(?, ?, ?, ?, ?, ?)}";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindParam(1, $datos['nombre']);
            $stmt->bindParam(2, $datos['apellido']);
            $stmt->bindParam(3, $datos['telefono']);
            $stmt->bindParam(4, $datos['email']);
            $stmt->bindParam(5, $datos['usuario']);
            $stmt->bindParam(6, $datos['password']);
            
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result;
        } catch(PDOException $e) {
            return ['Status' => 'ERROR', 'Mensaje' => $e->getMessage()];
        }
    }
    
    public function autenticar($usuario, $password) {
        try {
            $sql = "{CALL SP_AUTENTICAR_USUARIO(?, ?)}";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindParam(1, $usuario);
            $stmt->bindParam(2, $password);
            
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result;
        } catch(PDOException $e) {
            return ['Status' => 'ERROR', 'Mensaje' => $e->getMessage()];
        }
    }
    
    public function verificarUsuarioExiste($usuario) {
        try {
            $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE USUARIO = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $usuario);
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total'] > 0;
        } catch(PDOException $e) {
            return false;
        }
    }
    
    public function verificarEmailExiste($email) {
        try {
            $query = "SELECT COUNT(*) as total FROM CLIENTES WHERE EMAIL = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $email);
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total'] > 0;
        } catch(PDOException $e) {
            return false;
        }
    }

    public function autenticarRecepcion($usuario, $password) {
        try {
            // Buscar en LOGIN_USUARIOS con tipo RECEPCION
            $sql = "{CALL SP_AUTENTICAR_RECEPCION(?, ?)}";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindParam(1, $usuario);
            $stmt->bindParam(2, $password);
            
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result;
        } catch(PDOException $e) {
            return ['Status' => 'ERROR', 'Mensaje' => $e->getMessage()];
        }
    }

    public function autenticarAdministrador($usuario, $password) {
        try {
            // Buscar en LOGIN_USUARIOS con tipo ADMIN
            $sql = "{CALL SP_AUTENTICAR_ADMIN(?, ?)}";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindParam(1, $usuario);
            $stmt->bindParam(2, $password);
            
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result;
        } catch(PDOException $e) {
            return ['Status' => 'ERROR', 'Mensaje' => $e->getMessage()];
        }
    }
}
?>
