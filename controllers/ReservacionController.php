<?php
require_once 'models/Reservacion.php';

class ReservacionController {
    public function index() {
        $pageTitle = "Reservaciones - Las Tres Esencias";
        
        // Datos estáticos para prueba
        $mesas = [
            ['id' => 1, 'numero' => 1, 'capacidad' => 2, 'disponible' => true],
            ['id' => 2, 'numero' => 2, 'capacidad' => 4, 'disponible' => true],
            ['id' => 3, 'numero' => 3, 'capacidad' => 4, 'disponible' => false],
            ['id' => 4, 'numero' => 4, 'capacidad' => 6, 'disponible' => true],
            ['id' => 5, 'numero' => 5, 'capacidad' => 8, 'disponible' => true],
            ['id' => 6, 'numero' => 6, 'capacidad' => 2, 'disponible' => false]
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
            
            // Aquí iría la lógica para guardar en BD
            $_SESSION['mensaje'] = "Reservación creada exitosamente";
            header('Location: index.php?controller=reservacion');
            exit();
        }
    }
}
?>