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
                $_SESSION['es_recepcion'] = false; // Usuario normal, no recepción
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
        $esRecepcion = isset($_SESSION['es_recepcion']) && $_SESSION['es_recepcion'] === true;
        session_destroy();
        
        if ($esRecepcion) {
            header('Location: index.php?controller=auth&action=mostrarLoginRecepcion');
        } else {
            header('Location: index.php?controller=inicio');
        }
        exit();
    }
    
    public function loginRecepcion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = $_POST['usuario'] ?? '';
            $password = $_POST['password'] ?? '';
            
            // Validación - pendiente integrar con BD
            if ($usuario === 'recepcion' && $password === 'recepcion123') {
                $_SESSION['recepcion_id'] = 1;
                $_SESSION['recepcion_nombre'] = 'Recepcionista';
                $_SESSION['es_recepcion'] = true;
                $_SESSION['mensaje'] = "Bienvenido al panel de recepción";
                header('Location: index.php?controller=recepcion');
                exit();
            } else {
                $_SESSION['error'] = "Credenciales incorrectas";
            }
        }
        
        $pageTitle = "Acceso Recepción - Tres Esencias";
        require_once "views/layouts/header.php";
        require_once "views/autentificacion/login_recepcion.php";
        require_once "views/layouts/footer.php";
    }
    
    public function mostrarLoginRecepcion() {
        $pageTitle = "Acceso Recepción - Tres Esencias";
        require_once "views/layouts/header.php";
        require_once "views/autentificacion/login_recepcion.php";
        require_once "views/layouts/footer.php";
    }
}
?>
