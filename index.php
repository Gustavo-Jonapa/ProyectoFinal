<?php
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'inicio';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

$controllerName = ucfirst($controller) . 'Controller';

$controllerFile = "controllers/{$controllerName}.php";

if (!file_exists($controllerFile)) {
    die("Error: El controlador <b>{$controllerName}</b> no existe.");
}

require_once $controllerFile;

if (!class_exists($controllerName)) {
    die("Error: La clase <b>{$controllerName}</b> no está definida.");
}

$controllerObj = new $controllerName();

if (!method_exists($controllerObj, $action)) {
    die("Error: La acción <b>{$action}</b> no existe en el controlador <b>{$controllerName}</b>.");
}

$controllerObj->$action();
?>