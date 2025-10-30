<div class="container-fluid my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 fw-bold" style="color: #8C451C;">
            <i class="bi bi-truck"></i> Gestión de Proveedores
        </h1>
        <div>
            <a href="index.php?controller=administrador" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Volver al Panel
            </a>
            <button class="btn text-white" style="background-color: #F28322;" data-bs-toggle="modal" data-bs-target="#modalNuevoProveedor">
                <i class="bi bi-plus-circle"></i> Nuevo Proveedor
            </button>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-white h-100" style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase mb-2">Total Proveedores</h6>
                            <h2 class="mb-0 fw-bold"><?php echo count($proveedores); ?></h2>
                        </div>
                        <i class="bi bi-truck fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white h-100 bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase mb-2">Alimentos</h6>
                            <h2 class="mb-0 fw-bold">
                                <?php 
                                echo count(array_filter($proveedores, function($p) {
                                    return isset($p['TIPO_PRODUCTO']) && stripos($p['TIPO_PRODUCTO'], 'Alimento') !== false;
                                }));
                                ?>
                            </h2>
                        </div>
                        <i class="bi bi-shop fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white h-100 bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase mb-2">Bebidas</h6>
                            <h2 class="mb-0 fw-bold">
                                <?php 
                                echo count(array_filter($proveedores, function($p) {
                                    return isset($p['TIPO_PRODUCTO']) && stripos($p['TIPO_PRODUCTO'], 'Bebida') !== false;
                                }));
                                ?>
                            </h2>
                        </div>
                        <i class="bi bi-cup-straw fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white h-100 bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase mb-2">Otros</h6>
                            <h2 class="mb-0 fw-bold">
                                <?php 
                                echo count(array_filter($proveedores, function($p) {
                                    return isset($p['TIPO_PRODUCTO']) && 
                                           stripos($p['TIPO_PRODUCTO'], 'Alimento') === false &&
                                           stripos($p['TIPO_PRODUCTO'], 'Bebida') === false;
                                }));
                                ?>
                            </h2>
                        </div>
                        <i class="bi bi-box fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" id="filtroNombre" class="form-control" placeholder="Buscar por nombre o contacto...">
                </div>
                <div class="col-md-3">
                    <select id="filtroTipo" class="form-select">
                        <option value="">Todos los tipos</option>
                        <option value="Alimentos">Alimentos</option>
                        <option value="Bebidas">Bebidas</option>
                        <option value="Lácteos">Lácteos</option>
                        <option value="Carnes">Carnes</option>
                        <option value="Verduras">Verduras</option>
                        <option value="Limpieza">Limpieza</option>
                        <option value="Empaques">Empaques</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn w-100" style="background-color: #8C451C; color: white;" onclick="filtrarProveedores()">
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

    <!-- Tabla de Proveedores -->
    <div class="card shadow-sm">
        <div class="card-header" style="background-color: #8C451C; color: white;">
            <h5 class="mb-0"><i class="bi bi-list-ul"></i> Lista de Proveedores</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="tablaProveedores">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Contacto</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Tipo Producto</th>
                            <th>Dirección</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($proveedores)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                <i class="bi bi-inbox fs-1"></i>
                                <p class="mt-2">No hay proveedores registrados</p>
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($proveedores as $proveedor): ?>
                            <tr>
                                <td><?php echo $proveedor['ID_PROVEEDOR'] ?? ''; ?></td>
                                <td><strong><?php echo $proveedor['NOMBRE'] ?? ''; ?></strong></td>
                                <td><?php echo $proveedor['CONTACTO'] ?? ''; ?></td>
                                <td>
                                    <i class="bi bi-telephone"></i> <?php echo $proveedor['TELEFONO'] ?? ''; ?>
                                </td>
                                <td>
                                    <?php if (!empty($proveedor['EMAIL'])): ?>
                                        <i class="bi bi-envelope"></i> <?php echo $proveedor['EMAIL']; ?>
                                    <?php else: ?>
                                        <span class="text-muted">Sin email</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge" style="background-color: #F28322;">
                                        <?php echo $proveedor['TIPO_PRODUCTO'] ?? 'General'; ?>
                                    </span>
                                </td>
                                <td><?php echo $proveedor['DIRECCION'] ?? ''; ?></td>
                                <td>
                                    <button class="btn btn-sm btn-info text-white" onclick="verProveedor(<?php echo $proveedor['ID_PROVEEDOR'] ?? 0; ?>)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning" onclick="editarProveedor(<?php echo $proveedor['ID_PROVEEDOR'] ?? 0; ?>)">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="eliminarProveedor(<?php echo $proveedor['ID_PROVEEDOR'] ?? 0; ?>)">
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

<!-- Modal Nuevo Proveedor -->
<div class="modal fade" id="modalNuevoProveedor" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #F28322; color: white;">
                <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Registrar Nuevo Proveedor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formNuevoProveedor" method="POST" action="index.php?controller=administrador&action=crearProveedor">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nombre de la Empresa *</label>
                            <input type="text" name="nombre" class="form-control" required placeholder="Ej: Distribuidora La Esperanza">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nombre del Contacto *</label>
                            <input type="text" name="contacto" class="form-control" required placeholder="Ej: Juan Pérez">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Teléfono *</label>
                            <input type="tel" name="telefono" class="form-control" required placeholder="961-123-4567">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="contacto@proveedor.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tipo de Producto *</label>
                            <select name="tipo_producto" class="form-select" required>
                                <option value="">Seleccionar...</option>
                                <option value="Alimentos">Alimentos</option>
                                <option value="Bebidas">Bebidas</option>
                                <option value="Lácteos">Lácteos</option>
                                <option value="Carnes">Carnes y Pescados</option>
                                <option value="Verduras">Verduras y Frutas</option>
                                <option value="Panadería">Panadería</option>
                                <option value="Limpieza">Productos de Limpieza</option>
                                <option value="Empaques">Empaques y Desechables</option>
                                <option value="Equipos">Equipos y Utensilios</option>
                                <option value="Varios">Varios</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Dirección</label>
                            <input type="text" name="direccion" class="form-control" placeholder="Dirección completa">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Notas adicionales</label>
                            <textarea class="form-control" rows="2" placeholder="Horarios de entrega, condiciones de pago, etc."></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNuevoProveedor" class="btn text-white" style="background-color: #F28322;">
                    <i class="bi bi-save"></i> Guardar Proveedor
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Proveedor -->
<div class="modal fade" id="modalEditarProveedor" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #8C451C; color: white;">
                <h5 class="modal-title"><i class="bi bi-pencil"></i> Editar Proveedor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarProveedor" method="POST" action="index.php?controller=administrador&action=editarProveedor">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nombre de la Empresa *</label>
                            <input type="text" name="nombre" id="edit_nombre" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nombre del Contacto *</label>
                            <input type="text" name="contacto" id="edit_contacto" class="form-control" required>
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
                            <label class="form-label fw-bold">Tipo de Producto *</label>
                            <select name="tipo_producto" id="edit_tipo_producto" class="form-select" required>
                                <option value="Alimentos">Alimentos</option>
                                <option value="Bebidas">Bebidas</option>
                                <option value="Lácteos">Lácteos</option>
                                <option value="Carnes">Carnes y Pescados</option>
                                <option value="Verduras">Verduras y Frutas</option>
                                <option value="Panadería">Panadería</option>
                                <option value="Limpieza">Productos de Limpieza</option>
                                <option value="Empaques">Empaques y Desechables</option>
                                <option value="Equipos">Equipos y Utensilios</option>
                                <option value="Varios">Varios</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Dirección</label>
                            <input type="text" name="direccion" id="edit_direccion" class="form-control">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formEditarProveedor" class="btn text-white" style="background-color: #8C451C;">
                    <i class="bi bi-save"></i> Actualizar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ver Proveedor -->
<div class="modal fade" id="modalVerProveedor" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Información del Proveedor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detalleProveedor">
                <!-- Aquí se cargarían los detalles del proveedor -->
            </div>
        </div>
    </div>
</div>

<script>
function filtrarProveedores() {
    const nombre = document.getElementById('filtroNombre').value.toLowerCase();
    const tipo = document.getElementById('filtroTipo').value;
    const filas = document.querySelectorAll('#tablaProveedores tbody tr');
    
    filas.forEach(fila => {
        const textoFila = fila.textContent.toLowerCase();
        const tipoBadge = fila.querySelector('.badge')?.textContent || '';
        
        const coincideNombre = nombre === '' || textoFila.includes(nombre);
        const coincideTipo = tipo === '' || tipoBadge.includes(tipo);
        
        if (coincideNombre && coincideTipo) {
            fila.style.display = '';
        } else {
            fila.style.display = 'none';
        }
    });
}

function limpiarFiltros() {
    document.getElementById('filtroNombre').value = '';
    document.getElementById('filtroTipo').value = '';
    filtrarProveedores();
}

function verProveedor(id) {
    const modal = new bootstrap.Modal(document.getElementById('modalVerProveedor'));
    modal.show();
}

function editarProveedor(id) {
    // Aquí cargarías los datos del proveedor
    const modal = new bootstrap.Modal(document.getElementById('modalEditarProveedor'));
    modal.show();
}

function eliminarProveedor(id) {
    if (confirm('¿Estás seguro de eliminar este proveedor?')) {
        alert('Proveedor eliminado - ID: ' + id);
    }
}
</script>