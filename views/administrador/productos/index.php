<div class="container-fluid my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 fw-bold" style="color: #8C451C;">
            <i class="bi bi-bag"></i> Gestión de Productos
        </h1>
        <div>
            <a href="index.php?controller=administrador" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Volver al Panel
            </a>
            <button class="btn text-white" style="background-color: #F28322;" data-bs-toggle="modal" data-bs-target="#modalNuevoProducto">
                <i class="bi bi-plus-circle"></i> Nuevo Producto
            </button>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-white h-100" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase mb-2">Total Productos</h6>
                            <h2 class="mb-0 fw-bold"><?php echo count($productos); ?></h2>
                        </div>
                        <i class="bi bi-bag fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white h-100 bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase mb-2">Valor Inventario</h6>
                            <h2 class="mb-0 fw-bold">
                                $<?php 
                                $valorTotal = array_sum(array_map(function($p) {
                                    return ($p['STOCK_ACTUAL'] ?? 0) * ($p['PRECIO_COMPRA'] ?? 0);
                                }, $productos));
                                echo number_format($valorTotal, 2);
                                ?>
                            </h2>
                        </div>
                        <i class="bi bi-cash-stack fs-1 opacity-50"></i>
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
                                echo count(array_filter($productos, function($p) {
                                    return isset($p['STOCK_ACTUAL']) && isset($p['STOCK_MINIMO']) 
                                           && $p['STOCK_ACTUAL'] <= $p['STOCK_MINIMO'];
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
            <div class="card text-white h-100 bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-uppercase mb-2">Margen Prom.</h6>
                            <h2 class="mb-0 fw-bold">
                                <?php 
                                $promedioMargen = 0;
                                $productosConMargen = 0;
                                foreach ($productos as $p) {
                                    if (isset($p['PRECIO_COMPRA']) && $p['PRECIO_COMPRA'] > 0) {
                                        $margen = (($p['PRECIO_VENTA'] ?? 0) - $p['PRECIO_COMPRA']) / $p['PRECIO_COMPRA'] * 100;
                                        $promedioMargen += $margen;
                                        $productosConMargen++;
                                    }
                                }
                                echo $productosConMargen > 0 ? number_format($promedioMargen / $productosConMargen, 1) . '%' : '0%';
                                ?>
                            </h2>
                        </div>
                        <i class="bi bi-graph-up fs-1 opacity-50"></i>
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
                    <input type="text" id="filtroNombre" class="form-control" placeholder="Buscar por nombre del producto...">
                </div>
                <div class="col-md-3">
                    <select id="filtroEstado" class="form-select">
                        <option value="">Todos los estados</option>
                        <option value="BAJO">Stock Bajo</option>
                        <option value="OPTIMO">Stock Óptimo</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn w-100" style="background-color: #8C451C; color: white;" onclick="filtrarProductos()">
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

    <!-- Tabla de Productos -->
    <div class="card shadow-sm">
        <div class="card-header" style="background-color: #8C451C; color: white;">
            <h5 class="mb-0"><i class="bi bi-list-ul"></i> Catálogo de Productos</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="tablaProductos">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Stock Actual</th>
                            <th>Stock Mínimo</th>
                            <th>P. Compra</th>
                            <th>P. Venta</th>
                            <th>Margen</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($productos)): ?>
                        <tr>
                            <td colspan="10" class="text-center text-muted">
                                <i class="bi bi-inbox fs-1"></i>
                                <p class="mt-2">No hay productos registrados</p>
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($productos as $producto): ?>
                            <?php 
                            $stockActual = $producto['STOCK_ACTUAL'] ?? 0;
                            $stockMinimo = $producto['STOCK_MINIMO'] ?? 0;
                            $esBajo = $stockActual <= $stockMinimo;
                            
                            $precioCompra = $producto['PRECIO_COMPRA'] ?? 0;
                            $precioVenta = $producto['PRECIO_VENTA'] ?? 0;
                            $margen = $precioCompra > 0 ? (($precioVenta - $precioCompra) / $precioCompra * 100) : 0;
                            ?>
                            <tr class="<?php echo $esBajo ? 'table-danger' : ''; ?>">
                                <td><?php echo $producto['ID_PRODUCTO'] ?? ''; ?></td>
                                <td><strong><?php echo $producto['NOMBRE'] ?? ''; ?></strong></td>
                                <td><?php echo $producto['DESCRIPCION'] ?? ''; ?></td>
                                <td>
                                    <strong class="<?php echo $esBajo ? 'text-danger' : 'text-success'; ?>">
                                        <?php echo $stockActual; ?>
                                    </strong>
                                </td>
                                <td><?php echo $stockMinimo; ?></td>
                                <td>$<?php echo number_format($precioCompra, 2); ?></td>
                                <td>$<?php echo number_format($precioVenta, 2); ?></td>
                                <td>
                                    <span class="badge <?php echo $margen >= 30 ? 'bg-success' : ($margen >= 15 ? 'bg-warning' : 'bg-danger'); ?>">
                                        <?php echo number_format($margen, 1); ?>%
                                    </span>
                                </td>
                                <td>
                                    <?php if ($esBajo): ?>
                                        <span class="badge bg-danger">
                                            <i class="bi bi-exclamation-triangle"></i> BAJO
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> OK
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info text-white" onclick="verProducto(<?php echo $producto['ID_PRODUCTO'] ?? 0; ?>)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning" onclick="editarProducto(<?php echo $producto['ID_PRODUCTO'] ?? 0; ?>)">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="eliminarProducto(<?php echo $producto['ID_PRODUCTO'] ?? 0; ?>)">
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

<!-- Modal Nuevo Producto -->
<div class="modal fade" id="modalNuevoProducto" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #F28322; color: white;">
                <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Registrar Nuevo Producto</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formNuevoProducto" method="POST" action="index.php?controller=administrador&action=crearProducto">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nombre del Producto *</label>
                            <input type="text" name="nombre" class="form-control" required placeholder="Ej: Refresco Coca-Cola">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Proveedor (opcional)</label>
                            <select name="id_proveedor" class="form-select">
                                <option value="">Sin proveedor asignado</option>
                                <!-- Aquí se cargarían los proveedores desde la BD -->
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="2" placeholder="Descripción del producto..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Precio de Compra *</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="precio_compra" class="form-control" required step="0.01" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Precio de Venta *</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="precio_venta" id="precio_venta" class="form-control" required step="0.01" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Stock Actual *</label>
                            <input type="number" name="stock_actual" class="form-control" required step="1" min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Stock Mínimo *</label>
                            <input type="number" name="stock_minimo" class="form-control" required step="1" min="0">
                            <small class="text-muted">Nivel de alerta para reabastecimiento</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNuevoProducto" class="btn text-white" style="background-color: #F28322;">
                    <i class="bi bi-save"></i> Guardar Producto
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function filtrarProductos() {
    const nombre = document.getElementById('filtroNombre').value.toLowerCase();
    const estado = document.getElementById('filtroEstado').value;
    const filas = document.querySelectorAll('#tablaProductos tbody tr');
    
    filas.forEach(fila => {
        const textoFila = fila.textContent.toLowerCase();
        const estadoBadge = fila.querySelectorAll('.badge')[1]?.textContent || '';
        
        const coincideNombre = nombre === '' || textoFila.includes(nombre);
        const coincideEstado = estado === '' || estadoBadge.includes(estado);
        
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
    filtrarProductos();
}

function verProducto(id) {
    alert('Ver detalles del producto ID: ' + id);
}

function editarProducto(id) {
    alert('Editar producto ID: ' + id);
}

function eliminarProducto(id) {
    if (confirm('¿Estás seguro de eliminar este producto?')) {
        alert('Producto eliminado - ID: ' + id);
    }
}
</script>