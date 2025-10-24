<?php
require_once 'models/Reservacion.php';

class ReservacionController {
    public function index() {
        $pageTitle = "Reservaciones - Tres Esencias";
        
        // ejemplos
        $mesas = [
            ['id' => 1, 'numero' => 1, 'capacidad' => 2, 'disponible' => true],
            ['id' => 2, 'numero' => 2, 'capacidad' => 4, 'disponible' => false],
            ['id' => 3, 'numero' => 3, 'capacidad' => 4, 'disponible' => true],
            ['id' => 4, 'numero' => 4, 'capacidad' => 6, 'disponible' => true],
            ['id' => 5, 'numero' => 5, 'capacidad' => 8, 'disponible' => true],
            ['id' => 6, 'numero' => 6, 'capacidad' => 2, 'disponible' => false],
            ['id' => 7, 'numero' => 7, 'capacidad' => 2, 'disponible' => false],
            ['id' => 8, 'numero' => 8, 'capacidad' => 4, 'disponible' => true],
            ['id' => 9, 'numero' => 9, 'capacidad' => 4, 'disponible' => false],
            ['id' => 10, 'numero' => 10, 'capacidad' => 6, 'disponible' => true],
            ['id' => 11, 'numero' => 11, 'capacidad' => 8, 'disponible' => false],
            ['id' => 12, 'numero' => 12, 'capacidad' => 2, 'disponible' => false]
        ];
        
        require_once "views/layouts/header.php";
        require_once "views/reservaciones/index.php";
        require_once "views/layouts/footer.php";
    }
    
    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['usuario_id'])) {
                $_SESSION['error'] = "Debe iniciar sesión para hacer una reservación";
                header('Location: index.php?controller=auth&action=login');
                exit();
            }
            
            $fecha = $_POST['fecha'] ?? '';
            $hora = $_POST['hora'] ?? '';
            $personas = $_POST['personas'] ?? '';
            $mesa_id = $_POST['mesa_id'] ?? '';
            $envio = $_POST['envio'] ?? 'email';
            
            // Validación
            if (empty($fecha) || empty($hora) || empty($personas) || empty($mesa_id)) {
                $_SESSION['error'] = "Todos los campos son obligatorios";
                header('Location: index.php?controller=reservacion');
                exit();
            }
            
            // Aquí se guardaría en la BD
            // $reservacion = new Reservacion();
            // $resultado = $reservacion->crear([...]);
            
            if ($envio === 'whatsapp') {
                $_SESSION['mensaje'] = "Reservación creada exitosamente. Se enviará confirmación por WhatsApp.";
            } else {
                $_SESSION['mensaje'] = "Reservación creada exitosamente. Se enviará confirmación por email.";
            }
            
            header('Location: index.php?controller=reservacion');
            exit();
        }
    }
    
    public function editar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['usuario_id'])) {
                echo json_encode(['success' => false, 'message' => 'No autorizado']);
                exit();
            }
            
            $reservacion_id = $_POST['reservacion_id'] ?? '';
            $fecha = $_POST['fecha'] ?? '';
            $hora = $_POST['hora'] ?? '';
            $personas = $_POST['personas'] ?? '';
            
            // Validación
            if (empty($reservacion_id) || empty($fecha) || empty($hora) || empty($personas)) {
                echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
                exit();
            }
            
            // Aquí se actualizaría en la BD
            // $reservacion = new Reservacion();
            // $resultado = $reservacion->actualizar($reservacion_id, [...]);
            
            echo json_encode(['success' => true, 'message' => 'Reservación actualizada']);
            exit();
        }
    }
    
    public function cancelar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['usuario_id'])) {
                echo json_encode(['success' => false, 'message' => 'No autorizado']);
                exit();
            }
            
            $reservacion_id = $_POST['reservacion_id'] ?? '';
            
            if (empty($reservacion_id)) {
                echo json_encode(['success' => false, 'message' => 'ID de reservación no válido']);
                exit();
            }
            
            // Aquí se cancelaría en la BD
            // $reservacion = new Reservacion();
            // $resultado = $reservacion->cancelar($reservacion_id);
            
            echo json_encode(['success' => true, 'message' => 'Reservación cancelada']);
            exit();
        }
    }
}
?>
