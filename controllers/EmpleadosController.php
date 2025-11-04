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
<?php
require_once 'models/Empleado.php';

/**
 * Controlador de Empleados
 * Adaptado para trabajar con la vista Bootstrap existente
 * Usa Stored Procedures y responde a peticiones AJAX
 */
class EmpleadoController {
    
    private function verificarAcceso() {
        if (!isset($_SESSION['es_admin']) || $_SESSION['es_admin'] !== true) {
            $_SESSION['error'] = "Acceso denegado. Solo administradores.";
            header('Location: index.php');
            exit();
        }
    }
    
    /**
     * Página principal de empleados
     * Carga todos los empleados para mostrar en la vista
     */
    public function index() {
        $this->verificarAcceso();
        
        $empleadoModel = new Empleado();
        
        // Obtener todos los empleados - La vista calcula las estadísticas
        $empleados = $empleadoModel->obtenerTodos();
        
        $pageTitle = "Gestión de Empleados";
        include 'views/administrador/empleados/index.php';
    }
    
    /**
     * Crear nuevo empleado
     * Llamado desde el modal (POST con form)
     * URL: index.php?controller=administrador&action=crearEmpleado
     */
    public function crearEmpleado() {
        $this->verificarAcceso();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $empleadoModel = new Empleado();
            
            // Validar email único
            if (!empty($_POST['email'])) {
                if ($empleadoModel->existeEmail($_POST['email'])) {
                    $_SESSION['error'] = "El email ya está registrado para otro empleado";
                    header('Location: index.php?controller=administrador&action=empleados');
                    exit();
                }
            }
            
            // Preparar datos del formulario modal
            $datos = [
                'nombre' => trim($_POST['nombre']),
                'apellido' => trim($_POST['apellido']),
                'puesto' => trim($_POST['puesto']),
                'telefono' => trim($_POST['telefono']),
                'email' => trim($_POST['email'] ?? ''),
                'salario' => floatval($_POST['salario']),
                'fecha_contratacion' => $_POST['fecha_contratacion'],
                'id_colonia' => !empty($_POST['id_colonia']) ? intval($_POST['id_colonia']) : 1
            ];
            
            $resultado = $empleadoModel->crear($datos);
            
            if (isset($resultado['Status']) && $resultado['Status'] === 'OK') {
                $_SESSION['mensaje'] = "Empleado registrado exitosamente";
            } else {
                $_SESSION['error'] = $resultado['Mensaje'] ?? "Error al crear el empleado";
            }
            
            // Redirigir de vuelta a empleados
            header('Location: index.php?controller=administrador&action=empleados');
            exit();
        }
    }
    
    /**
     * Editar empleado
     * Llamado desde el modal (POST con form)
     * URL: index.php?controller=administrador&action=editarEmpleado
     */
    public function editarEmpleado() {
        $this->verificarAcceso();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $empleadoModel = new Empleado();
            
            $id = intval($_POST['id']);
            
            // Validar email único (excluyendo el empleado actual)
            if (!empty($_POST['email'])) {
                if ($empleadoModel->existeEmail($_POST['email'], $id)) {
                    $_SESSION['error'] = "El email ya está registrado para otro empleado";
                    header('Location: index.php?controller=administrador&action=empleados');
                    exit();
                }
            }
            
            $datos = [
                'nombre' => trim($_POST['nombre']),
                'apellido' => trim($_POST['apellido']),
                'puesto' => trim($_POST['puesto']),
                'telefono' => trim($_POST['telefono']),
                'email' => trim($_POST['email'] ?? ''),
                'salario' => floatval($_POST['salario']),
                'fecha_contratacion' => $_POST['fecha_contratacion'],
                'id_colonia' => !empty($_POST['id_colonia']) ? intval($_POST['id_colonia']) : 1
            ];
            
            $resultado = $empleadoModel->actualizar($id, $datos);
            
            if (isset($resultado['Status']) && $resultado['Status'] === 'OK') {
                $_SESSION['mensaje'] = "Empleado actualizado exitosamente";
            } else {
                $_SESSION['error'] = $resultado['Mensaje'] ?? "Error al actualizar el empleado";
            }
            
            header('Location: index.php?controller=administrador&action=empleados');
            exit();
        }
    }
    
    /**
     * Obtener detalles de un empleado (AJAX)
     * Para el modal de ver detalles
     * URL: index.php?controller=administrador&action=obtenerDetalleEmpleado&id=X
     */
    public function obtenerDetalleEmpleado() {
        $this->verificarAcceso();
        
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            
            $empleadoModel = new Empleado();
            $empleado = $empleadoModel->obtenerPorId($id);
            
            if ($empleado) {
                // Calcular antigüedad
                $antiguedad = $empleadoModel->calcularAntiguedad($id);
                $empleado['ANTIGUEDAD'] = $antiguedad;
                
                header('Content-Type: application/json');
                echo json_encode([
                    'Status' => 'OK',
                    'empleado' => $empleado
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    'Status' => 'ERROR',
                    'Mensaje' => 'Empleado no encontrado'
                ]);
            }
            exit();
        }
    }
    
    /**
     * Obtener datos para editar (AJAX)
     * Llena el formulario del modal de edición
     * URL: index.php?controller=administrador&action=obtenerEmpleadoParaEditar&id=X
     */
    public function obtenerEmpleadoParaEditar() {
        $this->verificarAcceso();
        
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            
            $empleadoModel = new Empleado();
            $empleado = $empleadoModel->obtenerPorId($id);
            
            header('Content-Type: application/json');
            if ($empleado) {
                echo json_encode([
                    'Status' => 'OK',
                    'empleado' => $empleado
                ]);
            } else {
                echo json_encode([
                    'Status' => 'ERROR',
                    'Mensaje' => 'Empleado no encontrado'
                ]);
            }
            exit();
        }
    }
    
    /**
     * Eliminar empleado (AJAX)
     * URL: index.php?controller=administrador&action=eliminarEmpleado
     */
    public function eliminarEmpleado() {
        $this->verificarAcceso();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id']);
            
            $empleadoModel = new Empleado();
            $resultado = $empleadoModel->eliminar($id);
            
            header('Content-Type: application/json');
            echo json_encode($resultado);
            exit();
        }
    }
    
    /**
     * Buscar empleados (AJAX)
     * URL: index.php?controller=administrador&action=buscarEmpleados&q=termino
     */
    public function buscarEmpleados() {
        $this->verificarAcceso();
        
        if (isset($_GET['q'])) {
            $termino = $_GET['q'];
            
            $empleadoModel = new Empleado();
            $empleados = $empleadoModel->buscar($termino);
            
            header('Content-Type: application/json');
            echo json_encode([
                'Status' => 'OK',
                'empleados' => $empleados,
                'total' => count($empleados)
            ]);
            exit();
        }
    }
    
    /**
     * Filtrar por puesto (AJAX)
     * URL: index.php?controller=administrador&action=filtrarPorPuesto&puesto=X
     */
    public function filtrarPorPuesto() {
        $this->verificarAcceso();
        
        if (isset($_GET['puesto'])) {
            $puesto = $_GET['puesto'];
            
            $empleadoModel = new Empleado();
            $empleados = $empleadoModel->obtenerPorPuesto($puesto);
            
            header('Content-Type: application/json');
            echo json_encode([
                'Status' => 'OK',
                'empleados' => $empleados,
                'total' => count($empleados)
            ]);
            exit();
        }
    }
    
    /**
     * Obtener estadísticas (AJAX)
     * URL: index.php?controller=administrador&action=obtenerEstadisticasEmpleados
     */
    public function obtenerEstadisticasEmpleados() {
        $this->verificarAcceso();
        
        $empleadoModel = new Empleado();
        $estadisticas = $empleadoModel->obtenerEstadisticas();
        
        header('Content-Type: application/json');
        echo json_encode([
            'Status' => 'OK',
            'estadisticas' => $estadisticas
        ]);
        exit();
    }
    
    /**
     * Exportar empleados a CSV
     * URL: index.php?controller=administrador&action=exportarEmpleadosCSV
     */
    public function exportarEmpleadosCSV() {
        $this->verificarAcceso();
        
        $empleadoModel = new Empleado();
        $empleados = $empleadoModel->obtenerTodos();
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=empleados_' . date('Y-m-d') . '.csv');
        
        $output = fopen('php://output', 'w');
        
        // Encabezados
        fputcsv($output, [
            'ID',
            'Nombre',
            'Apellido',
            'Nombre Completo',
            'Puesto',
            'Teléfono',
            'Email',
            'Salario',
            'Fecha Contratación'
        ]);
        
        // Datos
        foreach ($empleados as $empleado) {
            fputcsv($output, [
                $empleado['ID_EMPLEADO'],
                $empleado['NOMBRE'],
                $empleado['APELLIDO'],
                $empleado['NOMBRE'] . ' ' . $empleado['APELLIDO'],
                $empleado['PUESTO'],
                $empleado['TELEFONO'],
                $empleado['EMAIL'] ?? '',
                number_format($empleado['SALARIO'], 2),
                $empleado['FECHA_CONTRATACION']
            ]);
        }
        
        fclose($output);
        exit();
    }
    
    /**
     * Obtener nómina por puesto (AJAX)
     * URL: index.php?controller=administrador&action=obtenerNominaPorPuesto
     */
    public function obtenerNominaPorPuesto() {
        $this->verificarAcceso();
        
        $empleadoModel = new Empleado();
        $nomina = $empleadoModel->obtenerNominaPorPuesto();
        
        header('Content-Type: application/json');
        echo json_encode([
            'Status' => 'OK',
            'nomina' => $nomina
        ]);
        exit();
    }
    
    /**
     * Obtener puestos únicos para select (AJAX)
     * URL: index.php?controller=administrador&action=obtenerPuestosUnicos
     */
    public function obtenerPuestosUnicos() {
        $this->verificarAcceso();
        
        $empleadoModel = new Empleado();
        $puestos = $empleadoModel->obtenerPuestosUnicos();
        
        header('Content-Type: application/json');
        echo json_encode([
            'Status' => 'OK',
            'puestos' => $puestos
        ]);
        exit();
    }
    
    /**
     * Calcular antigüedad de un empleado (AJAX)
     * URL: index.php?controller=administrador&action=calcularAntiguedadEmpleado&id=X
     */
    public function calcularAntiguedadEmpleado() {
        $this->verificarAcceso();
        
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            
            $empleadoModel = new Empleado();
            $antiguedad = $empleadoModel->calcularAntiguedad($id);
            
            header('Content-Type: application/json');
            if ($antiguedad) {
                echo json_encode([
                    'Status' => 'OK',
                    'antiguedad' => $antiguedad
                ]);
            } else {
                echo json_encode([
                    'Status' => 'ERROR',
                    'Mensaje' => 'No se pudo calcular la antigüedad'
                ]);
            }
            exit();
        }
    }
    
    /**
     * Validar si existe un email (AJAX)
     * URL: index.php?controller=administrador&action=validarEmailEmpleado&email=X&excluir=Y
     */
    public function validarEmailEmpleado() {
        $this->verificarAcceso();
        
        if (isset($_GET['email'])) {
            $email = $_GET['email'];
            $excluirId = isset($_GET['excluir']) ? intval($_GET['excluir']) : null;
            
            $empleadoModel = new Empleado();
            $existe = $empleadoModel->existeEmail($email, $excluirId);
            
            header('Content-Type: application/json');
            echo json_encode([
                'Status' => 'OK',
                'existe' => $existe
            ]);
            exit();
        }
    }
    
    /**
     * Reporte de nómina completo
     * URL: index.php?controller=administrador&action=reporteNomina
     */
    public function reporteNomina() {
        $this->verificarAcceso();
        
        $empleadoModel = new Empleado();
        $empleados = $empleadoModel->obtenerTodos();
        $estadisticas = $empleadoModel->obtenerEstadisticas();
        $nominaPorPuesto = $empleadoModel->obtenerNominaPorPuesto();
        
        $pageTitle = "Reporte de Nómina";
        include 'views/administrador/empleados/reporte_nomina.php';
    }
}
?>