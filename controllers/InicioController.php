<?php
class InicioController {
    public function index() {
        $pageTitle = "Inicio - Las Tres Esencias";
        require_once "views/layouts/header.php";
        require_once "views/inicio/index.php";
        require_once "views/layouts/footer.php";
    }
}
?>