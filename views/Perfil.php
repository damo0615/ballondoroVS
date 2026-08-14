<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Cuenta y Votos - Ballon d'Or</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>

    <!-- Barra de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-luxury fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
                <i class="bi bi-trophy-fill text-warning fs-4"></i>
                <span>BALLON D'OR</span>
            </a>
            <div class="d-flex align-items-center gap-3">
                <a href="index.php" class="btn btn-profile">
                    <i class="bi bi-house-door me-1"></i> Inicio
                </a>
                <a href="index.php?action=logout" class="btn btn-outline-danger btn-sm rounded-pill px-3 py-1 text-uppercase" style="font-size: 0.75rem;">
                    <i class="bi bi-box-arrow-right me-1"></i> Salir
                </a>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="container py-5" style="margin-top: 100px; max-width: 800px;">
        
        <!-- Alerta de éxito al votar -->
        <?php if (isset($_GET['voto_exitoso']) && $_GET['voto_exitoso'] == 1): ?>
            <div class="alert alert-success bg-dark text-success border-success mb-4 text-center">
                <i class="bi bi-check-circle-fill me-2"></i> ¡Tus votos del Top 3 han sido registrados correctamente!
            </div>
        <?php endif; ?>
        
        <!-- Alertas de Estado -->
        <?php if (isset($_GET['voto_exitoso']) && $_GET['voto_exitoso'] == 1): ?>
            <div class="alert alert-success bg-dark text-success border-success mb-4 text-center">
                <i class="bi bi-check-circle-fill me-2"></i> ¡Tus votos del Top 3 han sido registrados correctamente!
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['aviso']) && $_GET['aviso'] == 'ya_votaste'): ?>
            <div class="alert alert-warning bg-dark text-warning border-warning mb-4 text-center">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> Ya habías emitido tu voto en esa categoría. No puedes votar dos veces.
            </div>
        <?php endif; ?>

        <!-- Cabecera de Perfil -->
        <div class="cat-card p-4 p-md-5 mb-5 text-center">
            <div class="mb-3">
                <i class="bi bi-person-circle text-warning display-3"></i>
            </div>
            <h1 class="gold-title h2 mb-1">¡Hola, <?php echo htmlspecialchars($usuario_nombre); ?>!</h1>
            <p class="text-white-50 small mb-0">Este es tu panel de control y el registro oficial de tus votaciones en la gala.</p>
        </div>

        <!-- Historial de Votos -->
        <h2 class="text-white h4 mb-4 text-uppercase tracking-wider">Tus Votos Emitidos</h2>

        <?php if (!empty($misVotos)): ?>
            <?php foreach ($misVotos as $catId => $datosCat): ?>
                <div class="cat-card p-4 mb-4">
                    <h3 class="gold-title h5 mb-3 border-bottom border-secondary pb-2">
                        <i class="bi bi-award-fill me-2 text-warning"></i><?php echo htmlspecialchars($datosCat['categoria_nombre']); ?>
                    </h3>
                    <ul class="list-unstyled mb-0">
                        <?php foreach ($datosCat['puestos'] as $p): ?>
                            <li class="py-2 border-bottom border-secondary border-opacity-25 d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge 
                                        <?php echo $p['puesto'] == 1 ? 'bg-warning text-dark' : ($p['puesto'] == 2 ? 'bg-secondary text-white' : 'bg-dark border border-secondary text-white-50'); ?> 
                                        me-2">
                                        <?php echo $p['puesto'] == 1 ? '1er Lugar (3 pts)' : ($p['puesto'] == 2 ? '2do Lugar (2 pts)' : '3er Lugar (1 pt)'); ?>
                                    </span>
                                    <strong class="text-white"><?php echo htmlspecialchars($p['nominado']); ?></strong>
                                    <?php if (!empty($p['detalles'])): ?>
                                        <span class="text-white-50 small ms-1">- <?php echo htmlspecialchars($p['detalles']); ?></span>
                                    <?php endif; ?>
                                </div>
                                <i class="bi bi-check2 text-warning fs-5"></i>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="cat-card p-5 text-center">
                <p class="text-white-50 mb-3">Aún no has emitido votos en ninguna categoría.</p>
                <a href="index.php" class="btn btn-gold-luxury">Explorar Categorías y Votar</a>
            </div>
        <?php endif; ?>

    </main>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>