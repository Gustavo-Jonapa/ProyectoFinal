<!-- Footer -->
    <footer class="text-white py-4 mt-5" style="background: linear-gradient(135deg, #8C451C 0%, #F28322 100%);">
        <div class="container text-center">
            <p class="mb-1 fs-5 fw-bold">&copy; 2025 Las Tres Esencias - Todos los derechos reservados</p>
            <p class="mb-0">Tuxtla Gutiérrez, Chiapas, México</p>
            <div class="mt-3">
                <a href="#" class="text-white me-3"><i class="bi bi-facebook fs-4"></i></a>
                <a href="#" class="text-white me-3"><i class="bi bi-instagram fs-4"></i></a>
                <a href="#" class="text-white"><i class="bi bi-whatsapp fs-4"></i></a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script para carrusel automático -->
    <script>
        // Auto-cerrar alertas después de 5 segundos
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>