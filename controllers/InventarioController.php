<?
require_once 'models/Inventario.php';

class InventarioController{
    public function index(){
        $pageTitle = "Inventario - Tres Esencias";

        require_once "views/layouts/header.php";
        require_once "views/inventario/index.php";
        require_once "views/layouts/footer.php";
    }
}
?>