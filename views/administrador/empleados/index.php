<div class="container-fluid my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 fw-bold" style="color: #8C451C;">
            <i class="bi bi-people"></i> Gestión de Empleados
        </h1>
        <div>
            <a href="index.php?controller=administrador" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Volver al Panel
            </a>
            <button class="btn text-white" style="background-color: #F28322;" data-bs-toggle="modal" data-bs-target="#modalNuevoEmpleado">
                <i class="bi bi-person-plus"></i> Nuevo Empleado
            </button>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h6 class="card-title">Total Empleados</h6>
                    <h2 class="mb-0"><?php echo count($empleados); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h6 class="card-title">Meseros</h6>
                    <h2 class="mb-0">
                        <?php 
                        echo count(array_filter($empleados, function($e) { 
                            return isset($e['PUESTO']) && $e['PUESTO'] === 'Mesero'; 
                        })); 
                        ?>
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h6 class="card-title">Cocineros</h6>
                    <h2 class="mb-0">
                        <?php 
                        echo count(array_filter($empleados, function($e) { 
                            return isset($e['PUESTO']) && $e['PUESTO'] === 'Cocinero'; 
                        })); 
                        ?>
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h6 class="card-title">Otros</h6>
                    <h2 class="mb-0">
                        <?php 
                        echo count(array_filter($empleados, function($e) { 
                            return isset($e['PUESTO']) && !in_array($e['PUESTO'], ['Mesero', 'Cocinero']); 
                        })); 
                        ?>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" id="filtroNombre" class="form-control" placeholder="Buscar por nombre...">
                </div>
                <div class="col-md-3">
                    <select id="filtroPuesto" class="form-select">
                        <option value="">Todos los puestos</option>
                        <option value="Mesero">Mesero</option>
                        <option value="Cocinero">Cocinero</option>
                        <option value="Chef">Chef</option>
                        <option value="Recepcionista">Recepcionista</option>
                        <option value="Cajero">Cajero</option>
                        <option value="Gerente">Gerente</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn w-100" style="background-color: #8C451C; color: white;" onclick="filtrarEmpleados()">
                        <i class="bi bi-funnel"></i> Filtrar
                    </button>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100" onclick="limpiarFiltros()">
                        <i class="bi bi-x-circle"></i> Limpiar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Empleados -->
    <div class="card shadow-sm">
        <div class="card-header" style="background-color: #8C451C; color: white;">
            <h5 class="mb-0"><i class="bi bi-people"></i> Lista de Empleados</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="tablaEmpleados">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Puesto</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Salario</th>
                            <th>Fecha Contratación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($empleados)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                <i class="bi bi-inbox fs-1"></i>
                                <p class="mt-2">No hay empleados registrados</p>
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($empleados as $empleado): ?>
                            <tr>
                                <td><?php echo $empleado['ID_EMPLEADO'] ?? ''; ?></td>
                                <td>
                                    <strong><?php echo ($empleado['NOMBRE'] ?? '') . ' ' . ($empleado['APELLIDO'] ?? ''); ?></strong>
                                </td>
                                <td>
                                    <span class="badge" style="background-color: #F28322;">
                                        <?php echo $empleado['PUESTO'] ?? ''; ?>
                                    </span>
                                </td>
                                <td><?php echo $empleado['TELEFONO'] ?? ''; ?></td>
                                <td><?php echo $empleado['EMAIL'] ?? ''; ?></td>
                                <td>$<?php echo number_format($empleado['SALARIO'] ?? 0, 2); ?></td>
                                <td><?php echo isset($empleado['FECHA_CONTRATACION']) ? date('d/m/Y', strtotime($empleado['FECHA_CONTRATACION'])) : ''; ?></td>
                                <td>
                                    <button class="btn btn-sm btn-info text-white" onclick="verEmpleado(<?php echo $empleado['ID_EMPLEADO'] ?? 0; ?>)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning" onclick="editarEmpleado(<?php echo $empleado['ID_EMPLEADO'] ?? 0; ?>)">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="eliminarEmpleado(<?php echo $empleado['ID_EMPLEADO'] ?? 0; ?>)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nuevo Empleado -->
<div class="modal fade" id="modalNuevoEmpleado" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #F28322; color: white;">
                <h5 class="modal-title"><i class="bi bi-person-plus"></i> Registrar Nuevo Empleado</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formNuevoEmpleado" method="POST" action="index.php?controller=administrador&action=crearEmpleado">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nombre *</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Apellido *</label>
                            <input type="text" name="apellido" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Puesto *</label>
                            <select name="puesto" class="form-select" required>
                                <option value="">Seleccionar...</option>
                                <option value="Mesero">Mesero</option>
                                <option value="Cocinero">Cocinero</option>
                                <option value="Chef">Chef</option>
                                <option value="Recepcionista">Recepcionista</option>
                                <option value="Cajero">Cajero</option>
                                <option value="Gerente">Gerente</option>
                                <option value="Limpieza">Limpieza</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Teléfono *</label>
                            <input type="tel" name="telefono" class="form-control" required placeholder="961-123-4567">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="empleado@ejemplo.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Salario Mensual *</label>
                            <input type="number" name="salario" class="form-control" required step="0.01" min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Fecha de Contratación *</label>
                            <input type="date" name="fecha_contratacion" class="form-control" required value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Colonia/Dirección</label>
                            <input type="number" name="id_colonia" class="form-control" value="1">
                            <small class="text-muted">ID de la colonia en el sistema</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNuevoEmpleado" class="btn text-white" style="background-color: #F28322;">
                    <i class="bi bi-save"></i> Guardar Empleado
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Empleado -->
<div class="modal fade" id="modalEditarEmpleado" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #8C451C; color: white;">
                <h5 class="modal-title"><i class="bi bi-pencil"></i> Editar Empleado</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarEmpleado" method="POST" action="index.php?controller=administrador&action=editarEmpleado">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nombre *</label>
                            <input type="text" name="nombre" id="edit_nombre" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Apellido *</label>
                            <input type="text" name="apellido" id="edit_apellido" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Puesto *</label>
                            <select name="puesto" id="edit_puesto" class="form-select" required>
                                <option value="Mesero">Mesero</option>
                                <option value="Cocinero">Cocinero</option>
                                <option value="Chef">Chef</option>
                                <option value="Recepcionista">Recepcionista</option>
                                <option value="Cajero">Cajero</option>
                                <option value="Gerente">Gerente</option>
                                <option value="Limpieza">Limpieza</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Teléfono *</label>
                            <input type="tel" name="telefono" id="edit_telefono" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Salario Mensual *</label>
                            <input type="number" name="salario" id="edit_salario" class="form-control" required step="0.01">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Fecha de Contratación *</label>
                            <input type="date" name="fecha_contratacion" id="edit_fecha_contratacion" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Colonia/Dirección</label>
                            <input type="number" name="id_colonia" id="edit_id_colonia" class="form-control">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formEditarEmpleado" class="btn text-white" style="background-color: #8C451C;">
                    <i class="bi bi-save"></i> Actualizar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function filtrarEmpleados() {
    const nombre = document.getElementById('filtroNombre').value.toLowerCase();
    const puesto = document.getElementById('filtroPuesto').value;
    const filas = document.querySelectorAll('#tablaEmpleados tbody tr');
    
    filas.forEach(fila => {
        const textoFila = fila.textContent.toLowerCase();
        const puestoFila = fila.querySelector('.badge')?.textContent || '';
        
        const coincideNombre = nombre === '' || textoFila.includes(nombre);
        const coincidePuesto = puesto === '' || puestoFila === puesto;
        
        if (coincideNombre && coincidePuesto) {
            fila.style.display = '';
        } else {
            fila.style.display = 'none';
        }
    });
}

function limpiarFiltros() {
    document.getElementById('filtroNombre').value = '';
    document.getElementById('filtroPuesto').value = '';
    filtrarEmpleados();
}

function verEmpleado(id) {
    alert('Ver detalles del empleado ID: ' + id);
}

function editarEmpleado(id) {
    // Aquí cargarías los datos del empleado desde el servidor
    // Por ahora solo abrimos el modal
    const modal = new bootstrap.Modal(document.getElementById('modalEditarEmpleado'));
    modal.show();
}

function eliminarEmpleado(id) {
    if (confirm('¿Estás seguro de eliminar este empleado?')) {
        fetch('index.php?controller=administrador&action=eliminarEmpleado', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + id
        })
        .then(response => response.json())
        .then(data => {
            if (data.Status === 'OK') {
                alert('Empleado eliminado exitosamente');
                location.reload();
            } else {
                alert('Error: ' + data.Mensaje);
            }
        });
    }
}
</script>