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
            
            // pendiente
            $_SESSION['mensaje'] = "Reservación creada exitosamente";
            header('Location: index.php?controller=reservacion');
            exit();
        }
    }
}
?>