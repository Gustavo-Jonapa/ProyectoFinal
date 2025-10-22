<?
require_once 'models/Proveedor.php';

class ProveedoresController{
    public function index(){
        $pageTitle = "Proveedores - Tres Esencias";

        require_once "views/layouts/header.php";
        require_once "views/proveedores/index.php";
        require_once "views/layouts/footer.php";
    }
}
?>