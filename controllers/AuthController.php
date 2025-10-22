<?php
require_once 'models/Usuario.php';

class AuthController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // pendiente
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            // Validación- pendiente
            if ($email === 'gustavo.jonapa24@unach.mx' && $password === 'iewlrgs7V_') {
                $_SESSION['usuario_id'] = 1;
                $_SESSION['usuario_nombre'] = 'Nombre';
                $_SESSION['mensaje'] = "Bienvenido!";
                header('Location: index.php?controller=inicio');
                exit();
            } else {
                $_SESSION['error'] = "Credenciales incorrectas";
            }
        }
        
        $pageTitle = "Iniciar Sesión - Tres Esencias";
        require_once "views/layouts/header.php";
        require_once "views/autentificacion/login.php";
        require_once "views/layouts/footer.php";
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // pendiente
            $_SESSION['mensaje'] = "Registro exitoso. Por favor inicia sesión.";
            header('Location: index.php?controller=auth&action=login');
            exit();
        }
        
        $pageTitle = "Registrarse - Tres Esencias";
        require_once "views/layouts/header.php";
        require_once "views/autentificacion/register.php";
        require_once "views/layouts/footer.php";
    }
    
    public function logout() {
        session_destroy();
        header('Location: index.php?controller=inicio');
        exit();
    }
}
?>