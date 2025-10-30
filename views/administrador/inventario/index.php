<div class="container-fluid my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 fw-bold" style="color: #8C451C;">
            <i class="bi bi-box-seam"></i> Gestión de Inventario
        </h1>
        <div>
            <a href="index.php?controller=administrador" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Volver al Panel
            </a>
            <button class="btn text-white" style="background-color: #F28322;" data-bs-toggle="modal" data-bs-target="#modalNuevoItem">
                <i class="bi bi-plus-circle"></i> Nuevo Item
            </button>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-white h-100" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase mb-2">Total Items</h6>
                            <h2 class="mb-0 fw-bold"><?php echo count($items); ?></h2>
                        </div>
                        <i class="bi bi-box-seam fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white h-100 bg-danger">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase mb-2">Stock Bajo</h6>
                            <h2 class="mb-0 fw-bold">
                                <?php 
                                echo count(array_filter($items, function($item) {
                                    return isset($item['CANTIDAD']) && isset($item['CANTIDAD_MINIMA']) 
                                           && $item['CANTIDAD'] <= $item['CANTIDAD_MINIMA'];
                                }));
                                ?>
                            </h2>
                        </div>
                        <i class="bi bi-exclamation-triangle fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white h-100 bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase mb-2">Valor Total</h6>
                            <h2 class="mb-0 fw-bold">
                                $<?php 
                                $total = array_sum(array_map(function($item) {
                                    return ($item['CANTIDAD'] ?? 0) * ($item['PRECIO_UNITARIO'] ?? 0);
                                }, $items));
                                echo number_format($total, 2);
                                ?>
                            </h2>
                        </div>
                        <i class="bi bi-cash-stack fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white h-100 bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase mb-2">Stock Óptimo</h6>
                            <h2 class="mb-0 fw-bold">
                                <?php 
                                echo count(array_filter($items, function($item) {
                                    return isset($item['CANTIDAD']) && isset($item['CANTIDAD_MINIMA']) 
                                           && $item['CANTIDAD'] > $item['CANTIDAD_MINIMA'];
                                }));
                                ?>
                            </h2>
                        </div>
                        <i class="bi bi-check-circle fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-5">
                    <input type="text" id="filtroNombre" class="form-control" placeholder="Buscar por nombre del item...">
                </div>
                <div class="col-md-3">
                    <select id="filtroEstado" class="form-select">
                        <option value="">Todos los estados</option>
                        <option value="BAJO">Stock Bajo</option>
                        <option value="OPTIMO">Stock Óptimo</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn w-100" style="background-color: #8C451C; color: white;" onclick="filtrarInventario()">
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

    <!-- Alerta de Items Bajo Stock -->
    <?php 
    $itemsBajos = array_filter($items, function($item) {
        return isset($item['CANTIDAD']) && isset($item['CANTIDAD_MINIMA']) 
               && $item['CANTIDAD'] <= $item['CANTIDAD_MINIMA'];
    });
    
    if (!empty($itemsBajos)):
    ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h5 class="alert-heading"><i class="bi bi-exclamation-triangle-fill"></i> ¡Atención!</h5>
        <p class="mb-0">Hay <strong><?php echo count($itemsBajos); ?></strong> item(s) con stock bajo o crítico. Considere realizar un pedido.</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <!-- Tabla de Inventario -->
    <div class="card shadow-sm">
        <div class="card-header" style="background-color: #8C451C; color: white;">
            <h5 class="mb-0"><i class="bi bi-list-ul"></i> Items en Inventario</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="tablaInventario">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>Unidad</th>
                            <th>Stock Mínimo</th>
                            <th>Precio Unit.</th>
                            <th>Valor Total</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($items)): ?>
                        <tr>
                            <td colspan="10" class="text-center text-muted">
                                <i class="bi bi-inbox fs-1"></i>
                                <p class="mt-2">No hay items en el inventario</p>
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($items as $item): ?>
                            <?php 
                            $cantidad = $item['CANTIDAD'] ?? 0;
                            $minimo = $item['CANTIDAD_MINIMA'] ?? 0;
                            $esBajo = $cantidad <= $minimo;
                            $valorTotal = $cantidad * ($item['PRECIO_UNITARIO'] ?? 0);
                            ?>
                            <tr class="<?php echo $esBajo ? 'table-danger' : ''; ?>">
                                <td><?php echo $item['ID_INVENTARIO'] ?? ''; ?></td>
                                <td><strong><?php echo $item['NOMBRE'] ?? ''; ?></strong></td>
                                <td><?php echo $item['DESCRIPCION'] ?? ''; ?></td>
                                <td>
                                    <strong class="<?php echo $esBajo ? 'text-danger' : 'text-success'; ?>">
                                        <?php echo number_format($cantidad, 2); ?>
                                    </strong>
                                </td>
                                <td><?php echo $item['UNIDAD_MEDIDA'] ?? ''; ?></td>
                                <td><?php echo number_format($minimo, 2); ?></td>
                                <td>$<?php echo number_format($item['PRECIO_UNITARIO'] ?? 0, 2); ?></td>
                                <td><strong>$<?php echo number_format($valorTotal, 2); ?></strong></td>
                                <td>
                                    <?php if ($esBajo): ?>
                                        <span class="badge bg-danger">
                                            <i class="bi bi-exclamation-triangle"></i> BAJO
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> ÓPTIMO
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-success" onclick="agregarStock(<?php echo $item['ID_INVENTARIO'] ?? 0; ?>)">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning" onclick="restarStock(<?php echo $item['ID_INVENTARIO'] ?? 0; ?>)">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <button class="btn btn-sm btn-info text-white" onclick="verDetalle(<?php echo $item['ID_INVENTARIO'] ?? 0; ?>)">
                                        <i class="bi bi-eye"></i>
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

<!-- Modal Nuevo Item -->
<div class="modal fade" id="modalNuevoItem" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #F28322; color: white;">
                <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Agregar Nuevo Item al Inventario</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formNuevoItem" method="POST" action="index.php?controller=administrador&action=crearItemInventario">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nombre del Item *</label>
                            <input type="text" name="nombre" class="form-control" required placeholder="Ej: Tomate">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Unidad de Medida *</label>
                            <select name="unidad_medida" class="form-select" required>
                                <option value="">Seleccionar...</option>
                                <option value="Kg">Kilogramo (Kg)</option>
                                <option value="g">Gramos (g)</option>
                                <option value="L">Litros (L)</option>
                                <option value="mL">Mililitros (mL)</option>
                                <option value="Pza">Pieza (Pza)</option>
                                <option value="Caja">Caja</option>
                                <option value="Paquete">Paquete</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="2" placeholder="Descripción del item..."></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Cantidad Inicial *</label>
                            <input type="number" name="cantidad" class="form-control" required step="0.01" min="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Cantidad Mínima *</label>
                            <input type="number" name="cantidad_minima" class="form-control" required step="0.01" min="0">
                            <small class="text-muted">Nivel de alerta</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Precio Unitario *</label>
                            <input type="number" name="precio_unitario" class="form-control" required step="0.01" min="0">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Proveedor (opcional)</label>
                            <select name="id_proveedor" class="form-select">
                                <option value="">Sin proveedor asignado</option>
                                <!-- Aquí se cargarían los proveedores desde la BD -->
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNuevoItem" class="btn text-white" style="background-color: #F28322;">
                    <i class="bi bi-save"></i> Guardar Item
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Actualizar Stock -->
<div class="modal fade" id="modalActualizarStock" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #28a745; color: white;">
                <h5 class="modal-title" id="tituloModalStock">Actualizar Stock</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formActualizarStock">
                    <input type="hidden" id="stock_item_id" name="id">
                    <input type="hidden" id="stock_tipo" name="tipo_movimiento" value="ENTRADA">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Cantidad</label>
                        <input type="number" id="stock_cantidad" name="cantidad" class="form-control" required step="0.01" min="0.01">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Motivo</label>
                        <textarea class="form-control" rows="2" placeholder="Motivo del movimiento..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" onclick="guardarMovimiento()">
                    <i class="bi bi-save"></i> Confirmar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function filtrarInventario() {
    const nombre = document.getElementById('filtroNombre').value.toLowerCase();
    const estado = document.getElementById('filtroEstado').value;
    const filas = document.querySelectorAll('#tablaInventario tbody tr');
    
    filas.forEach(fila => {
        const textoFila = fila.textContent.toLowerCase();
        const estadoFila = fila.querySelector('.badge')?.textContent || '';
        
        const coincideNombre = nombre === '' || textoFila.includes(nombre);
        const coincideEstado = estado === '' || estadoFila.includes(estado);
        
        if (coincideNombre && coincideEstado) {
            fila.style.display = '';
        } else {
            fila.style.display = 'none';
        }
    });
}

function limpiarFiltros() {
    document.getElementById('filtroNombre').value = '';
    document.getElementById('filtroEstado').value = '';
    filtrarInventario();
}

function agregarStock(id) {
    document.getElementById('stock_item_id').value = id;
    document.getElementById('stock_tipo').value = 'ENTRADA';
    document.getElementById('tituloModalStock').textContent = 'Agregar Stock (Entrada)';
    
    const modal = new bootstrap.Modal(document.getElementById('modalActualizarStock'));
    modal.show();
}

function restarStock(id) {
    document.getElementById('stock_item_id').value = id;
    document.getElementById('stock_tipo').value = 'SALIDA';
    document.getElementById('tituloModalStock').textContent = 'Restar Stock (Salida)';
    
    const modal = new bootstrap.Modal(document.getElementById('modalActualizarStock'));
    modal.show();
}

function guardarMovimiento() {
    const formData = new FormData(document.getElementById('formActualizarStock'));
    
    fetch('index.php?controller=administrador&action=actualizarInventario', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.Status === 'OK') {
            alert('Stock actualizado exitosamente');
            location.reload();
        } else {
            alert('Error: ' + data.Mensaje);
        }
    });
}

function verDetalle(id) {
    alert('Ver detalles del item ID: ' + id);
}
</script>