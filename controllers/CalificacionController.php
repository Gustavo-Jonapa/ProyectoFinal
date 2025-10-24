<?php
require_once 'models/Calificacion.php';

class CalificacionController {
    public function index() {
        $pageTitle = "Calificaciones - Tres Esencias";
        
        require_once "views/layouts/header.php";
        require_once "views/calificacion/index.php";
        require_once "views/layouts/footer.php";
    }
    
    public function enviar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $calificacion = $_POST['calificacion'] ?? '';
            $tipo = $_POST['tipo'] ?? '';
            $comentario = $_POST['comentario'] ?? '';
            $nombre = $_POST['nombre'] ?? 'Anónimo';
            $email = $_POST['email'] ?? '';
            
            // Validación básica
            if (empty($calificacion) || empty($tipo) || empty($comentario)) {
                $_SESSION['error'] = "Por favor completa todos los campos obligatorios";
                header('Location: index.php?controller=calificacion');
                exit();
            }
            
            // Aquí se guardaría en la base de datos
            // $calificacionModel = new Calificacion();
            // $resultado = $calificacionModel->crear([...]);
            
            $_SESSION['mensaje'] = "¡Gracias por tu calificación! Tu opinión es muy importante para nosotros.";
            header('Location: index.php?controller=calificacion');
            exit();
        }
    }
}
?>
