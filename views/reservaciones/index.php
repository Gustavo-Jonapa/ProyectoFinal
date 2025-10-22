<div class="container my-5">
    <h1 class="text-center mb-5 display-4 fw-bold" style="color: #8C451C;">Reservaciones</h1>
    
    <!-- Contacto -->
    <div class="card mb-4 shadow border-0" style="background: linear-gradient(135deg, #FFF5E1 0%, #FFE4B5 100%);">
        <div class="card-body p-4">
            <h3 class="fw-bold mb-4" style="color: #F28322;">Información de Contacto</h3>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <i class="bi bi-clock-fill fs-4" style="color: #F28322;"></i>
                    <strong class="d-block mt-2">Horario de Servicio</strong>
                    <p class="text-muted mb-0">Lunes a Domingo<br>1:00 PM - 11:00 PM</p>
                </div>
                <div class="col-md-4 mb-3">
                    <i class="bi bi-telephone-fill fs-4" style="color: #F28322;"></i>
                    <strong class="d-block mt-2">Teléfono</strong>
                    <p class="text-muted mb-0">961-</p>
                </div>
                <div class="col-md-4 mb-3">
                    <i class="bi bi-whatsapp fs-4" style="color: #F28322;"></i>
                    <strong class="d-block mt-2">WhatsApp</strong>
                    <p class="text-muted mb-0">961-</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Reservación -->
    <div class="card shadow border-0">
        <div class="card-body p-5">
            <h3 class="fw-bold mb-4" style="color: #F28322;">Reservación en Línea</h3>
            
            <form action="index.php?controller=reservacion&action=crear" method="POST" id="formReservacion">
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Fecha</label>
                        <input type="date" name="fecha" class="form-control form-control-lg" required 
                               min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Hora</label>
                        <input type="time" name="hora" class="form-control form-control-lg" required
                               min="13:00" max="22:00">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Personas</label>
                        <select name="personas" class="form-select form-select-lg" required>
                            <option value="">Seleccionar</option>
                            <?php for($i = 1; $i <= 8; $i++): ?>
                            <option value="<?php echo $i; ?>">
                                <?php echo $i . ($i == 1 ? ' persona' : ' personas'); ?>
                            </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                
                <!-- Mesas-->
                <div class="mb-4">
                    <h4 class="fw-bold mb-3">Mesas</h4>
                    <div class="row g-3">
                        <?php foreach ($mesas as $mesa): ?>
                        <div class="col-md-2 col-6">
                            <input type="radio" class="btn-check" name="mesa_id" id="mesa<?php echo $mesa['id']; ?>" 
                                   value="<?php echo $mesa['id']; ?>" required
                                   <?php echo !$mesa['disponible'] ? 'disabled' : ''; ?>>
                            <label class="btn w-100 <?php echo $mesa['disponible'] ? 'btn-outline-success' : 'btn-outline-danger'; ?>" 
                                   for="mesa<?php echo $mesa['id']; ?>"
                                   style="<?php echo !$mesa['disponible'] ? 'opacity: 0.5; cursor: not-allowed;' : ''; ?>">
                                <strong>Mesa <?php echo $mesa['numero']; ?></strong><br>
                                <small><?php echo $mesa['capacidad']; ?> personas</small><br>
                                <small class="<?php echo $mesa['disponible'] ? 'text-success' : 'text-danger'; ?>">
                                    <?php echo $mesa['disponible'] ? 'Disponible' : 'Ocupada'; ?>
                                </small>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-lg w-100 fw-bold text-white" style="background-color: #F28322; border: none; margin-bottom: 10px;">
                    <i class="bi bi-calendar-check"></i> Enviar reservación al correo
                </button>
                <button type="submit" class="btn btn-lg w-100 fw-bold text-white" style="background-color: #F28322; border: none;">
                    <i class="bi bi-calendar-check"></i> Enviar reservación al número de celular
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    .btn-check:checked + .btn-outline-success {
        background-color: #F28322 !important;
        border-color: #F28322 !important;
        color: white !important;
    }
    
</style>