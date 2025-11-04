
<?php
require_once 'models/Inventario.php';
require_once 'models/Proveedor.php';

/**
 * Controlador de Inventario
 * Adaptado para trabajar con la vista Bootstrap existente
 * Usa Stored Procedures y responde a peticiones AJAX
 */
class InventarioController {
    
    private function verificarAcceso() {
        if (!isset($_SESSION['es_admin']) || $_SESSION['es_admin'] !== true) {
            $_SESSION['error'] = "Acceso denegado. Solo administradores.";
            header('Location: index.php');
            exit();
        }
    }
    
    /**
     * Página principal del inventario
     * Carga todos los items para mostrar en la vista
     */
    public function index() {
        $this->verificarAcceso();
        
        $inventarioModel = new Inventario();
        
        // Obtener todos los items - La vista calcula las estadísticas
        $items = $inventarioModel->obtenerTodos();
        
        // La vista ya tiene el código para mostrar todo
        $pageTitle = "Gestión de Inventario";
        include 'views/administrador/inventario/index.php';
    }
    
    /**
     * Crear nuevo item de inventario
     * Llamado desde el modal (POST con form)
     * URL: index.php?controller=administrador&action=crearItemInventario
     */
    public function crearItemInventario() {
        $this->verificarAcceso();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inventarioModel = new Inventario();
            
            // Preparar datos del formulario modal
            $datos = [
                'nombre' => trim($_POST['nombre']),
                'descripcion' => trim($_POST['descripcion'] ?? ''),
                'cantidad' => floatval($_POST['cantidad']),
                'unidad_medida' => trim($_POST['unidad_medida']),
                'cantidad_minima' => floatval($_POST['cantidad_minima']),
                'precio_unitario' => floatval($_POST['precio_unitario']),
                'id_proveedor' => !empty($_POST['id_proveedor']) ? intval($_POST['id_proveedor']) : null
            ];
            
            $resultado = $inventarioModel->crear($datos);
            
            if (isset($resultado['Status']) && $resultado['Status'] === 'OK') {
                $_SESSION['mensaje'] = "Item agregado al inventario exitosamente";
            } else {
                $_SESSION['error'] = $resultado['Mensaje'] ?? "Error al crear el item";
            }
            
            // Redirigir de vuelta al inventario
            header('Location: index.php?controller=administrador&action=inventario');
            exit();
        }
    }
    
    /**
     * Actualizar stock del inventario (AJAX)
     * Responde a las peticiones de los botones + y -
     * URL: index.php?controller=administrador&action=actualizarInventario
     */
    public function actualizarInventario() {
        $this->verificarAcceso();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inventarioModel = new Inventario();
            
            $id = intval($_POST['id']);
            $cantidad = floatval($_POST['cantidad']);
            $tipo_movimiento = $_POST['tipo_movimiento']; // 'ENTRADA' o 'SALIDA'
            
            // Validaciones
            if ($cantidad <= 0) {
                echo json_encode([
                    'Status' => 'ERROR',
                    'Mensaje' => 'La cantidad debe ser mayor a cero'
                ]);
                exit();
            }
            
            if (!in_array($tipo_movimiento, ['ENTRADA', 'SALIDA'])) {
                echo json_encode([
                    'Status' => 'ERROR',
                    'Mensaje' => 'Tipo de movimiento inválido'
                ]);
                exit();
            }
            
            // Llamar al stored procedure
            $resultado = $inventarioModel->actualizarStock($id, $cantidad, $tipo_movimiento);
            
            // Responder en formato JSON para el AJAX
            header('Content-Type: application/json');
            echo json_encode($resultado);
            exit();
        }
    }
    
    /**
     * Obtener detalles de un item (AJAX)
     * Para el modal de ver detalles
     */
    public function obtenerDetalleItem() {
        $this->verificarAcceso();
        
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            
            $inventarioModel = new Inventario();
            $item = $inventarioModel->obtenerPorId($id);
            
            if ($item) {
                // Calcular valores adicionales
                $item['VALOR_TOTAL'] = $item['CANTIDAD'] * $item['PRECIO_UNITARIO'];
                $item['ES_BAJO_STOCK'] = $item['CANTIDAD'] <= $item['CANTIDAD_MINIMA'];
                
                header('Content-Type: application/json');
                echo json_encode([
                    'Status' => 'OK',
                    'item' => $item
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    'Status' => 'ERROR',
                    'Mensaje' => 'Item no encontrado'
                ]);
            }
            exit();
        }
    }
    
    /**
     * Editar item del inventario
     * Similar a crear pero actualiza
     */
    public function editarItemInventario() {
        $this->verificarAcceso();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inventarioModel = new Inventario();
            
            $id = intval($_POST['id']);
            
            $datos = [
                'nombre' => trim($_POST['nombre']),
                'descripcion' => trim($_POST['descripcion'] ?? ''),
                'cantidad' => floatval($_POST['cantidad']),
                'unidad_medida' => trim($_POST['unidad_medida']),
                'cantidad_minima' => floatval($_POST['cantidad_minima']),
                'precio_unitario' => floatval($_POST['precio_unitario']),
                'id_proveedor' => !empty($_POST['id_proveedor']) ? intval($_POST['id_proveedor']) : null
            ];
            
            $resultado = $inventarioModel->actualizar($id, $datos);
            
            if (isset($resultado['Status']) && $resultado['Status'] === 'OK') {
                $_SESSION['mensaje'] = "Item actualizado exitosamente";
            } else {
                $_SESSION['error'] = $resultado['Mensaje'] ?? "Error al actualizar el item";
            }
            
            header('Location: index.php?controller=administrador&action=inventario');
            exit();
        }
    }
    
    /**
     * Eliminar item del inventario (AJAX)
     */
    public function eliminarItemInventario() {
        $this->verificarAcceso();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id']);
            
            $inventarioModel = new Inventario();
            $resultado = $inventarioModel->eliminar($id);
            
            header('Content-Type: application/json');
            echo json_encode($resultado);
            exit();
        }
    }
    
    /**
     * Obtener items bajo stock (AJAX)
     * Para mostrar alertas o reportes específicos
     */
    public function obtenerItemsBajoStock() {
        $this->verificarAcceso();
        
        $inventarioModel = new Inventario();
        $items = $inventarioModel->obtenerItemsBajoStock();
        
        header('Content-Type: application/json');
        echo json_encode([
            'Status' => 'OK',
            'items' => $items,
            'total' => count($items)
        ]);
        exit();
    }
    
    /**
     * Obtener lista de proveedores para el select del modal
     */
    public function obtenerProveedoresSelect() {
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
     * Exportar inventario a CSV (opcional)
     */
    public function exportarInventarioCSV() {
        $this->verificarAcceso();
        
        $inventarioModel = new Inventario();
        $items = $inventarioModel->obtenerTodos();
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=inventario_' . date('Y-m-d') . '.csv');
        
        $output = fopen('php://output', 'w');
        
        // Encabezados
        fputcsv($output, [
            'ID',
            'Nombre',
            'Descripción',
            'Cantidad',
            'Unidad',
            'Stock Mínimo',
            'Precio Unitario',
            'Valor Total',
            'Estado'
        ]);
        
        // Datos
        foreach ($items as $item) {
            $valorTotal = $item['CANTIDAD'] * $item['PRECIO_UNITARIO'];
            $estado = $item['CANTIDAD'] <= $item['CANTIDAD_MINIMA'] ? 'BAJO' : 'ÓPTIMO';
            
            fputcsv($output, [
                $item['ID_INVENTARIO'],
                $item['NOMBRE'],
                $item['DESCRIPCION'],
                $item['CANTIDAD'],
                $item['UNIDAD_MEDIDA'],
                $item['CANTIDAD_MINIMA'],
                $item['PRECIO_UNITARIO'],
                $valorTotal,
                $estado
            ]);
        }
        
        fclose($output);
        exit();
    }
}
?>