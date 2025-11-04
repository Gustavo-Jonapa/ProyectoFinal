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
<?php
require_once 'models/Proveedor.php';

/**
 * Controlador de Proveedores
 * Adaptado para trabajar con la vista Bootstrap existente
 * Usa Stored Procedures y responde a peticiones AJAX
 */
class ProveedorController {
    
    private function verificarAcceso() {
        if (!isset($_SESSION['es_admin']) || $_SESSION['es_admin'] !== true) {
            $_SESSION['error'] = "Acceso denegado. Solo administradores.";
            header('Location: index.php');
            exit();
        }
    }
    
    /**
     * Página principal de proveedores
     * Carga todos los proveedores para mostrar en la vista
     */
    public function index() {
        $this->verificarAcceso();
        
        $proveedorModel = new Proveedor();
        
        // Obtener todos los proveedores - La vista calcula las estadísticas
        $proveedores = $proveedorModel->obtenerTodos();
        
        $pageTitle = "Gestión de Proveedores";
        include 'views/administrador/proveedores/index.php';
    }
    
    /**
     * Crear nuevo proveedor
     * Llamado desde el modal (POST con form)
     * URL: index.php?controller=administrador&action=crearProveedor
     */
    public function crearProveedor() {
        $this->verificarAcceso();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proveedorModel = new Proveedor();
            
            // Preparar datos del formulario modal
            $datos = [
                'nombre' => trim($_POST['nombre']),
                'contacto' => trim($_POST['contacto']),
                'telefono' => trim($_POST['telefono']),
                'email' => trim($_POST['email'] ?? ''),
                'direccion' => trim($_POST['direccion'] ?? ''),
                'tipo_producto' => trim($_POST['tipo_producto'])
            ];
            
            $resultado = $proveedorModel->crear($datos);
            
            if (isset($resultado['Status']) && $resultado['Status'] === 'OK') {
                $_SESSION['mensaje'] = "Proveedor registrado exitosamente";
            } else {
                $_SESSION['error'] = $resultado['Mensaje'] ?? "Error al crear el proveedor";
            }
            
            // Redirigir de vuelta a proveedores
            header('Location: index.php?controller=administrador&action=proveedores');
            exit();
        }
    }
    
    /**
     * Editar proveedor
     * Llamado desde el modal (POST con form)
     * URL: index.php?controller=administrador&action=editarProveedor
     */
    public function editarProveedor() {
        $this->verificarAcceso();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proveedorModel = new Proveedor();
            
            $id = intval($_POST['id']);
            
            $datos = [
                'nombre' => trim($_POST['nombre']),
                'contacto' => trim($_POST['contacto']),
                'telefono' => trim($_POST['telefono']),
                'email' => trim($_POST['email'] ?? ''),
                'direccion' => trim($_POST['direccion'] ?? ''),
                'tipo_producto' => trim($_POST['tipo_producto'])
            ];
            
            $resultado = $proveedorModel->actualizar($id, $datos);
            
            if (isset($resultado['Status']) && $resultado['Status'] === 'OK') {
                $_SESSION['mensaje'] = "Proveedor actualizado exitosamente";
            } else {
                $_SESSION['error'] = $resultado['Mensaje'] ?? "Error al actualizar el proveedor";
            }
            
            header('Location: index.php?controller=administrador&action=proveedores');
            exit();
        }
    }
    
    /**
     * Obtener detalles de un proveedor (AJAX)
     * Para el modal de ver detalles
     * URL: index.php?controller=administrador&action=obtenerDetalleProveedor&id=X
     */
    public function obtenerDetalleProveedor() {
        $this->verificarAcceso();
        
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            
            $proveedorModel = new Proveedor();
            $proveedor = $proveedorModel->obtenerPorId($id);
            
            if ($proveedor) {
                header('Content-Type: application/json');
                echo json_encode([
                    'Status' => 'OK',
                    'proveedor' => $proveedor
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    'Status' => 'ERROR',
                    'Mensaje' => 'Proveedor no encontrado'
                ]);
            }
            exit();
        }
    }
    
    /**
     * Obtener datos para editar (AJAX)
     * Llena el formulario del modal de edición
     * URL: index.php?controller=administrador&action=obtenerProveedorParaEditar&id=X
     */
    public function obtenerProveedorParaEditar() {
        $this->verificarAcceso();
        
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            
            $proveedorModel = new Proveedor();
            $proveedor = $proveedorModel->obtenerPorId($id);
            
            header('Content-Type: application/json');
            if ($proveedor) {
                echo json_encode([
                    'Status' => 'OK',
                    'proveedor' => $proveedor
                ]);
            } else {
                echo json_encode([
                    'Status' => 'ERROR',
                    'Mensaje' => 'Proveedor no encontrado'
                ]);
            }
            exit();
        }
    }
    
    /**
     * Eliminar proveedor (AJAX)
     * URL: index.php?controller=administrador&action=eliminarProveedor
     */
    public function eliminarProveedor() {
        $this->verificarAcceso();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id']);
            
            $proveedorModel = new Proveedor();
            $resultado = $proveedorModel->eliminar($id);
            
            header('Content-Type: application/json');
            echo json_encode($resultado);
            exit();
        }
    }
    
    /**
     * Desactivar proveedor (soft delete) - AJAX
     * URL: index.php?controller=administrador&action=desactivarProveedor
     */
    public function desactivarProveedor() {
        $this->verificarAcceso();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id']);
            
            $proveedorModel = new Proveedor();
            $resultado = $proveedorModel->desactivar($id);
            
            header('Content-Type: application/json');
            echo json_encode($resultado);
            exit();
        }
    }
    
    /**
     * Activar proveedor - AJAX
     * URL: index.php?controller=administrador&action=activarProveedor
     */
    public function activarProveedor() {
        $this->verificarAcceso();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id']);
            
            $proveedorModel = new Proveedor();
            $resultado = $proveedorModel->activar($id);
            
            header('Content-Type: application/json');
            echo json_encode($resultado);
            exit();
        }
    }
    
    /**
     * Buscar proveedores (AJAX)
     * URL: index.php?controller=administrador&action=buscarProveedores&q=termino
     */
    public function buscarProveedores() {
        $this->verificarAcceso();
        
        if (isset($_GET['q'])) {
            $termino = $_GET['q'];
            
            $proveedorModel = new Proveedor();
            $proveedores = $proveedorModel->buscar($termino);
            
            header('Content-Type: application/json');
            echo json_encode([
                'Status' => 'OK',
                'proveedores' => $proveedores,
                'total' => count($proveedores)
            ]);
            exit();
        }
    }
    
    /**
     * Filtrar por tipo de producto (AJAX)
     * URL: index.php?controller=administrador&action=filtrarPorTipo&tipo=X
     */
    public function filtrarPorTipo() {
        $this->verificarAcceso();
        
        if (isset($_GET['tipo'])) {
            $tipo = $_GET['tipo'];
            
            $proveedorModel = new Proveedor();
            $proveedores = $proveedorModel->buscarPorTipo($tipo);
            
            header('Content-Type: application/json');
            echo json_encode([
                'Status' => 'OK',
                'proveedores' => $proveedores,
                'total' => count($proveedores)
            ]);
            exit();
        }
    }
    
    /**
     * Obtener estadísticas (AJAX)
     * URL: index.php?controller=administrador&action=obtenerEstadisticasProveedores
     */
    public function obtenerEstadisticasProveedores() {
        $this->verificarAcceso();
        
        $proveedorModel = new Proveedor();
        $estadisticas = $proveedorModel->obtenerEstadisticas();
        
        header('Content-Type: application/json');
        echo json_encode([
            'Status' => 'OK',
            'estadisticas' => $estadisticas
        ]);
        exit();
    }
    
    /**
     * Exportar proveedores a CSV
     * URL: index.php?controller=administrador&action=exportarProveedoresCSV
     */
    public function exportarProveedoresCSV() {
        $this->verificarAcceso();
        
        $proveedorModel = new Proveedor();
        $proveedores = $proveedorModel->obtenerTodos();
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=proveedores_' . date('Y-m-d') . '.csv');
        
        $output = fopen('php://output', 'w');
        
        // Encabezados
        fputcsv($output, [
            'ID',
            'Nombre Empresa',
            'Contacto',
            'Teléfono',
            'Email',
            'Dirección',
            'Tipo Producto',
            'Estado'
        ]);
        
        // Datos
        foreach ($proveedores as $proveedor) {
            $estado = isset($proveedor['ACTIVO']) && $proveedor['ACTIVO'] ? 'Activo' : 'Inactivo';
            
            fputcsv($output, [
                $proveedor['ID_PROVEEDOR'],
                $proveedor['NOMBRE'],
                $proveedor['CONTACTO'],
                $proveedor['TELEFONO'],
                $proveedor['EMAIL'] ?? '',
                $proveedor['DIRECCION'] ?? '',
                $proveedor['TIPO_PRODUCTO'],
                $estado
            ]);
        }
        
        fclose($output);
        exit();
    }
    
    /**
     * Obtener proveedores activos para select (AJAX)
     * Usado en otros módulos que necesiten lista de proveedores
     * URL: index.php?controller=administrador&action=obtenerProveedoresActivos
     */
    public function obtenerProveedoresActivos() {
        $this->verificarAcceso();
        
        $proveedorModel = new Proveedor();
        $proveedores = $proveedorModel->obtenerActivos();
        
        header('Content-Type: application/json');
        echo json_encode([
            'Status' => 'OK',
            'proveedores' => $proveedores
        ]);
        exit();
    }
    
    /**
     * Validar si existe un proveedor con el mismo nombre (AJAX)
     * Para evitar duplicados
     * URL: index.php?controller=administrador&action=validarNombreProveedor&nombre=X
     */
    public function validarNombreProveedor() {
        $this->verificarAcceso();
        
        if (isset($_GET['nombre'])) {
            $nombre = $_GET['nombre'];
            
            $proveedorModel = new Proveedor();
            $proveedores = $proveedorModel->buscar($nombre);
            
            $existe = false;
            foreach ($proveedores as $proveedor) {
                if (strcasecmp($proveedor['NOMBRE'], $nombre) === 0) {
                    $existe = true;
                    break;
                }
            }
            
            header('Content-Type: application/json');
            echo json_encode([
                'Status' => 'OK',
                'existe' => $existe
            ]);
            exit();
        }
    }
}
?>