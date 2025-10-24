<div class="container my-5">
    <h1 class="text-center mb-5 display-4 fw-bold" style="color: #8C451C;">Califícanos</h1>
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Formulario de calificación -->
            <div class="card shadow-lg border-0 mb-5">
                <div class="card-body p-5">
                    <h3 class="text-center mb-4 fw-bold" style="color: #F28322;">Tu opinión es importante para nosotros</h3>
                    
                    <form action="index.php?controller=calificacion&action=enviar" method="POST" id="formCalificacion">
                        <!-- Calificación con estrellas -->
                        <div class="text-center mb-4">
                            <label class="form-label fw-bold d-block mb-3">Calificación General</label>
                            <div class="rating" id="rating">
                                <input type="radio" name="calificacion" value="5" id="star5" required>
                                <label for="star5" title="5 estrellas">
                                    <i class="bi bi-star-fill"></i>
                                </label>
                                
                                <input type="radio" name="calificacion" value="4" id="star4">
                                <label for="star4" title="4 estrellas">
                                    <i class="bi bi-star-fill"></i>
                                </label>
                                
                                <input type="radio" name="calificacion" value="3" id="star3">
                                <label for="star3" title="3 estrellas">
                                    <i class="bi bi-star-fill"></i>
                                </label>
                                
                                <input type="radio" name="calificacion" value="2" id="star2">
                                <label for="star2" title="2 estrellas">
                                    <i class="bi bi-star-fill"></i>
                                </label>
                                
                                <input type="radio" name="calificacion" value="1" id="star1">
                                <label for="star1" title="1 estrella">
                                    <i class="bi bi-star-fill"></i>
                                </label>
                            </div>
                            <small class="text-muted d-block mt-2">Haz clic en las estrellas para calificar</small>
                        </div>
                        
                        <!-- Tipo de comentario -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Tipo de comentario</label>
                            <select name="tipo" class="form-select form-select-lg" required>
                                <option value="">Seleccionar...</option>
                                <option value="sugerencia">Sugerencia</option>
                                <option value="queja">Queja</option>
                                <option value="felicitacion">Felicitación</option>
                            </select>
                        </div>
                        
                        <!-- Comentario -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Cuéntanos tu experiencia</label>
                            <textarea name="comentario" class="form-control form-control-lg" rows="5" 
                                      placeholder="Escribe aquí tu comentario, sugerencia o queja..." required></textarea>
                        </div>
                        
                        <!-- Datos de contacto (opcional) -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nombre (opcional)</label>
                                <input type="text" name="nombre" class="form-control form-control-lg" 
                                       placeholder="Tu nombre">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email (opcional)</label>
                                <input type="email" name="email" class="form-control form-control-lg" 
                                       placeholder="tu@email.com">
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-lg w-100 fw-bold text-white" style="background-color: #F28322;">
                            <i class="bi bi-send"></i> Enviar Calificación
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Estadísticas de calificaciones -->
            <div class="card shadow-lg border-0 mb-5">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4" style="color: #8C451C;">Calificación Promedio</h4>
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center">
                            <h1 class="display-1 fw-bold" style="color: #F28322;">4.5</h1>
                            <div class="mb-2">
                                <i class="bi bi-star-fill fs-4" style="color: #FFD700;"></i>
                                <i class="bi bi-star-fill fs-4" style="color: #FFD700;"></i>
                                <i class="bi bi-star-fill fs-4" style="color: #FFD700;"></i>
                                <i class="bi bi-star-fill fs-4" style="color: #FFD700;"></i>
                                <i class="bi bi-star-half fs-4" style="color: #FFD700;"></i>
                            </div>
                            <p class="text-muted">Basado en 150 opiniones</p>
                        </div>
                        <div class="col-md-8">
                            <!-- Barras de progreso -->
                            <div class="mb-2">
                                <div class="d-flex align-items-center">
                                    <span class="me-2">5 <i class="bi bi-star-fill" style="color: #FFD700;"></i></span>
                                    <div class="progress flex-grow-1" style="height: 20px;">
                                        <div class="progress-bar" style="width: 70%; background-color: #F28322;"></div>
                                    </div>
                                    <span class="ms-2">70%</span>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="d-flex align-items-center">
                                    <span class="me-2">4 <i class="bi bi-star-fill" style="color: #FFD700;"></i></span>
                                    <div class="progress flex-grow-1" style="height: 20px;">
                                        <div class="progress-bar" style="width: 20%; background-color: #F28322;"></div>
                                    </div>
                                    <span class="ms-2">20%</span>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="d-flex align-items-center">
                                    <span class="me-2">3 <i class="bi bi-star-fill" style="color: #FFD700;"></i></span>
                                    <div class="progress flex-grow-1" style="height: 20px;">
                                        <div class="progress-bar" style="width: 7%; background-color: #F28322;"></div>
                                    </div>
                                    <span class="ms-2">7%</span>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="d-flex align-items-center">
                                    <span class="me-2">2 <i class="bi bi-star-fill" style="color: #FFD700;"></i></span>
                                    <div class="progress flex-grow-1" style="height: 20px;">
                                        <div class="progress-bar" style="width: 2%; background-color: #F28322;"></div>
                                    </div>
                                    <span class="ms-2">2%</span>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="d-flex align-items-center">
                                    <span class="me-2">1 <i class="bi bi-star-fill" style="color: #FFD700;"></i></span>
                                    <div class="progress flex-grow-1" style="height: 20px;">
                                        <div class="progress-bar" style="width: 1%; background-color: #F28322;"></div>
                                    </div>
                                    <span class="ms-2">1%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Comentarios recientes -->
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4" style="color: #8C451C;">Comentarios Recientes</h4>
                    
                    <!-- Comentario 1 -->
                    <div class="mb-4 pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="fw-bold mb-1">María García</h6>
                                <div class="mb-1">
                                    <i class="bi bi-star-fill" style="color: #FFD700;"></i>
                                    <i class="bi bi-star-fill" style="color: #FFD700;"></i>
                                    <i class="bi bi-star-fill" style="color: #FFD700;"></i>
                                    <i class="bi bi-star-fill" style="color: #FFD700;"></i>
                                    <i class="bi bi-star-fill" style="color: #FFD700;"></i>
                                </div>
                            </div>
                            <small class="text-muted">Hace 2 días</small>
                        </div>
                        <p class="text-muted mb-0">Excelente servicio y comida deliciosa. El ambiente es muy acogedor y el personal muy atento. Definitivamente regresaremos.</p>
                    </div>
                    
                    <!-- Comentario 2 -->
                    <div class="mb-4 pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="fw-bold mb-1">Carlos Mendoza</h6>
                                <div class="mb-1">
                                    <i class="bi bi-star-fill" style="color: #FFD700;"></i>
                                    <i class="bi bi-star-fill" style="color: #FFD700;"></i>
                                    <i class="bi bi-star-fill" style="color: #FFD700;"></i>
                                    <i class="bi bi-star-fill" style="color: #FFD700;"></i>
                                    <i class="bi bi-star" style="color: #FFD700;"></i>
                                </div>
                            </div>
                            <small class="text-muted">Hace 1 semana</small>
                        </div>
                        <p class="text-muted mb-0">Muy buena experiencia. Los platillos tienen muy buen sabor. Solo sugeriría más opciones vegetarianas en el menú.</p>
                    </div>
                    
                    <!-- Comentario 3 -->
                    <div class="mb-0">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="fw-bold mb-1">Ana Rodríguez</h6>
                                <div class="mb-1">
                                    <i class="bi bi-star-fill" style="color: #FFD700;"></i>
                                    <i class="bi bi-star-fill" style="color: #FFD700;"></i>
                                    <i class="bi bi-star-fill" style="color: #FFD700;"></i>
                                    <i class="bi bi-star-fill" style="color: #FFD700;"></i>
                                    <i class="bi bi-star-fill" style="color: #FFD700;"></i>
                                </div>
                            </div>
                            <small class="text-muted">Hace 2 semanas</small>
                        </div>
                        <p class="text-muted mb-0">Celebramos nuestro aniversario aquí y fue perfecto. La atención fue excepcional y la comida estuvo deliciosa. ¡Altamente recomendado!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estrellas de calificación */
    .rating {
        display: inline-flex;
        flex-direction: row-reverse;
        justify-content: center;
        gap: 5px;
    }
    
    .rating input {
        display: none;
    }
    
    .rating label {
        cursor: pointer;
        font-size: 3rem;
        color: #ddd;
        transition: color 0.2s;
    }
    
    .rating label:hover,
    .rating label:hover ~ label,
    .rating input:checked ~ label {
        color: #FFD700;
    }
    
    .rating label i {
        transition: transform 0.2s;
    }
    
    .rating label:hover i {
        transform: scale(1.1);
    }
</style>

<script>
    // Validación del formulario
    document.getElementById('formCalificacion').addEventListener('submit', function(e) {
        const calificacion = document.querySelector('input[name="calificacion"]:checked');
        
        if (!calificacion) {
            e.preventDefault();
            alert('Por favor selecciona una calificación con estrellas');
            return false;
        }
    });
</script>
