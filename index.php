<?php
session_start();

// Autoload de clases
spl_autoload_register(function ($class) {
    $paths = ['controllers/', 'models/'];
    foreach ($paths as $path) {
        $file = __DIR__ . '/' . $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Obtener el controlador y acción desde GET
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'inicio';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Construir el nombre del controlador
$controllerName = ucfirst($controller) . 'Controller';
$controllerFile = "controllers/{$controllerName}.php";

// Verificar si existe el archivo del controlador
if (!file_exists($controllerFile)) {
    die("Error: El controlador <b>{$controllerName}</b> no existe en {$controllerFile}");
}

// Incluir el controlador
require_once $controllerFile;

// Verificar si la clase existe
if (!class_exists($controllerName)) {
    die("Error: La clase <b>{$controllerName}</b> no está definida en {$controllerFile}");
}

// Crear instancia del controlador
$controllerObj = new $controllerName();

// Verificar si el método existe
if (!method_exists($controllerObj, $action)) {
    die("Error: La acción <b>{$action}</b> no existe en el controlador <b>{$controllerName}</b>.");
}

// Ejecutar el método
$controllerObj->$action();
?>