<?php
require_once 'models/Usuario.php';

class AuthController {
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = trim($_POST['usuario'] ?? '');
            $password = trim($_POST['password'] ?? '');
            
            if (empty($usuario) || empty($password)) {
                $_SESSION['error'] = "Usuario y contraseña son obligatorios";
                header('Location: index.php?controller=auth&action=login');
                exit();
            }
            
            $usuarioModel = new Usuario();
            $resultado = $usuarioModel->autenticar($usuario, $password);
            
            if ($resultado && $resultado['Status'] === 'OK') {
                $_SESSION['usuario_id'] = $resultado['ID_CLIENTE'];
                $_SESSION['usuario_nombre'] = $resultado['NOMBRE'];
                $_SESSION['es_recepcion'] = false;
                $_SESSION['es_admin'] = false;
                $_SESSION['mensaje'] = "¡Bienvenido " . $resultado['NOMBRE'] . "!";
                header('Location: index.php?controller=inicio');
            } else {
                $_SESSION['error'] = $resultado['Mensaje'] ?? "Credenciales incorrectas";
                header('Location: index.php?controller=auth&action=login');
            }
            exit();
        }
        
        $pageTitle = "Iniciar Sesión - Tres Esencias";
        require_once "views/layouts/header.php";
        require_once "views/autentificacion/login.php";
        require_once "views/layouts/footer.php";
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $confirm_password = trim($_POST['confirm_password'] ?? '');
            
            if (empty($nombre) || empty($email) || empty($telefono) || empty($password)) {
                $_SESSION['error'] = "Todos los campos son obligatorios";
                header('Location: index.php?controller=auth&action=register');
                exit();
            }
            
            if ($password !== $confirm_password) {
                $_SESSION['error'] = "Las contraseñas no coinciden";
                header('Location: index.php?controller=auth&action=register');
                exit();
            }
            
            $nombrePartes = explode(' ', $nombre, 2);
            $nombrePrimero = $nombrePartes[0];
            $apellido = $nombrePartes[1] ?? '';
            
            $usuario = explode('@', $email)[0];
            
            $usuarioModel = new Usuario();
            $resultado = $usuarioModel->crear([
                'nombre' => $nombrePrimero,
                'apellido' => $apellido,
                'telefono' => $telefono,
                'email' => $email,
                'usuario' => $usuario,
                'password' => $password
            ]);
            
            if ($resultado && $resultado['Status'] === 'OK') {
                $_SESSION['mensaje'] = "Registro exitoso. Por favor inicia sesión.";
                header('Location: index.php?controller=auth&action=login');
            } else {
                $_SESSION['error'] = $resultado['Mensaje'] ?? "Error al registrar usuario";
                header('Location: index.php?controller=auth&action=register');
            }
            exit();
        }
        
        $pageTitle = "Registrarse - Tres Esencias";
        require_once "views/layouts/header.php";
        require_once "views/autentificacion/register.php";
        require_once "views/layouts/footer.php";
    }
    
    public function loginRecepcion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = trim($_POST['usuario'] ?? '');
            $password = trim($_POST['password'] ?? '');
            
            if (empty($usuario) || empty($password)) {
                $_SESSION['error'] = "Usuario y contraseña son obligatorios";
                header('Location: index.php?controller=auth&action=mostrarLoginRecepcion');
                exit();
            }
            
            $usuarioModel = new Usuario();
            $resultado = $usuarioModel->autenticarRecepcion($usuario, $password);
            
            if ($resultado && $resultado['Status'] === 'OK') {
                $_SESSION['recepcion_id'] = $resultado['ID_EMPLEADO'];
                $_SESSION['recepcion_nombre'] = $resultado['NOMBRE'];
                $_SESSION['es_recepcion'] = true;
                $_SESSION['es_admin'] = false;
                $_SESSION['mensaje'] = "Bienvenido al panel de recepción";
                header('Location: index.php?controller=recepcion');
            } else {
                $_SESSION['error'] = "Credenciales incorrectas";
                header('Location: index.php?controller=auth&action=mostrarLoginRecepcion');
            }
            exit();
        }
    }
    
    public function mostrarLoginRecepcion() {
        $pageTitle = "Acceso Recepción - Tres Esencias";
        require_once "views/layouts/header.php";
        require_once "views/autentificacion/login_recepcion.php";
        require_once "views/layouts/footer.php";
    }
    
    public function loginAdministrador() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = trim($_POST['usuario'] ?? '');
            $password = trim($_POST['password'] ?? '');
            
            if (empty($usuario) || empty($password)) {
                $_SESSION['error'] = "Usuario y contraseña son obligatorios";
                header('Location: index.php?controller=auth&action=mostrarLoginAdministrador');
                exit();
            }
            
            $usuarioModel = new Usuario();
            $resultado = $usuarioModel->autenticarAdministrador($usuario, $password);
            
            if ($resultado && $resultado['Status'] === 'OK') {
                $_SESSION['admin_id'] = $resultado['ID_EMPLEADO'];
                $_SESSION['admin_nombre'] = $resultado['NOMBRE'];
                $_SESSION['es_admin'] = true;
                $_SESSION['es_recepcion'] = false;
                $_SESSION['mensaje'] = "Bienvenido al panel de administración";
                header('Location: index.php?controller=administrador');
            } else {
                $_SESSION['error'] = "Credenciales incorrectas";
                header('Location: index.php?controller=auth&action=mostrarLoginAdministrador');
            }
            exit();
        }
    }
    
    public function mostrarLoginAdministrador() {
        $pageTitle = "Acceso Administrador - Tres Esencias";
        require_once "views/layouts/header.php";
        require_once "views/autentificacion/login_administrador.php";
        require_once "views/layouts/footer.php";
    }
    
    public function logout() {
        $esRecepcion = isset($_SESSION['es_recepcion']) && $_SESSION['es_recepcion'] === true;
        $esAdmin = isset($_SESSION['es_admin']) && $_SESSION['es_admin'] === true;
        
        session_destroy();
        
        if ($esRecepcion) {
            header('Location: index.php?controller=auth&action=mostrarLoginRecepcion');
        } elseif ($esAdmin) {
            header('Location: index.php?controller=auth&action=mostrarLoginAdministrador');
        } else {
            header('Location: index.php?controller=inicio');
        }
        exit();
    }
}
?>