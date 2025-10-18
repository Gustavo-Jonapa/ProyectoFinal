<div class="container my-5">
    <h1 class="text-center mb-5 display-4 fw-bold" style="color: #8C451C;">Nuestro Menú</h1>
    
    <?php 
    $categorias = ['Platos Fuertes', 'Postres', 'Bebidas'];
    foreach ($categorias as $categoria): 
        $platillosCategoria = array_filter($platillos, function($p) use ($categoria) {
            return $p['categoria'] === $categoria;
        });
        if (count($platillosCategoria) > 0):
    ?>
    
    <div class="mb-5">
        <h2 class="mb-4 pb-2 fw-bold" style="color: #F28322; border-bottom: 3px solid #F28322;">
            <?php echo $categoria; ?>
        </h2>
        <div class="row g-4">
            <?php foreach ($platillosCategoria as $platillo): ?>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0" style="transition: all 0.3s ease;">
                    <img src="<?php echo $platillo['imagen']; ?>" class="card-img-top" alt="<?php echo $platillo['nombre']; ?>" style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title fw-bold"><?php echo $platillo['nombre']; ?></h5>
                        <?php if (!empty($platillo['descripcion'])): ?>
                        <p class="card-text text-muted small"><?php echo $platillo['descripcion']; ?></p>
                        <?php endif; ?>
                        <p class="fs-3 fw-bold mb-0" style="color: #F28322;">$<?php echo number_format($platillo['precio'], 2); ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <?php 
        endif;
    endforeach; 
    ?>
</div>

<style>
    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.2) !important;
    }
</style>