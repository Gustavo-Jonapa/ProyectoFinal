<?
require_once 'models/Producto.php';

class ProductosController{
    public function index(){
        $pageTitle = "Productos - Tres Esencias";

        require_once "views/layouts/header.php";
        require_once "views/productos/index.php";
        require_once "views/layouts/footer.php";
    }
}
?>