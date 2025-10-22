<?
require_once 'models/Empleado.php';

class EmpleadosController{
    public function index(){
        $pageTitle = "Empleados - Tres Esencias";

        require_once "views/layouts/header.php";
        require_once "views/empleados/index.php";
        require_once "views/layouts/footer.php";
    }
}
?>