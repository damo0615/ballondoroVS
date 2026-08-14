<?php require 'public\template\header.html'; ?>
<body class="d-flex align-items-center justify-content-center min-vh-100">

    <div class="container text-center" style="max-width: 600px;">
        <div class="cat-card p-5">
            <div class="mb-4">
                <i class="bi bi-exclamation-octagon text-warning display-1"></i>
            </div>
            
            <span class="text-uppercase fw-bold d-block mb-2 badge-edition">Error 404 • Fuera de Juego</span>
            <h1 class="display-3 gold-title mb-3">Página No Encontrada</h1>
            <p class="text-white-50 fs-6 mb-5 lh-lg">
                La jugada que intentas buscar no existe o fue anulada por el VAR. Regresa al terreno de juego principal para continuar con la gala.
            </p>

            <div>
                <a href="index.php" class="btn btn-gold-luxury px-5 py-3">
                    <i class="bi bi-house-door me-2"></i> Volver al Inicio
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>