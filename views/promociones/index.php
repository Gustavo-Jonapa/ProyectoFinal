<div class="container my-5">
    <h1 class="text-center mb-5 display-4 fw-bold" style="color: #8C451C;">Promociones Especiales</h1>
    
    <div class="row g-4">
        <?php foreach ($promociones as $promo): ?>
        <div class="col-md-6">
            <div class="card h-100 shadow-lg border-0" style="transition: all 0.3s ease;">
                <img src="<?php echo $promo['imagen']; ?>" class="card-img-top" alt="<?php echo $promo['titulo']; ?>" 
                     style="height: 300px; object-fit: cover;">
                <div class="card-body">
                    <h3 class="card-title fw-bold"><?php echo $promo['titulo']; ?></h3>
                    <p class="card-text text-muted"><?php echo $promo['descripcion']; ?></p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="display-6 fw-bold" style="color: #F28322;">$<?php echo number_format($promo['precio'], 2); ?></span>
                        <a href="index.php?controller=reservacion" class="btn btn-lg text-white" style="background-color: #F28322;">
                            <i class="bi bi-calendar-check"></i> Reservar
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3) !important;
    }
</style>