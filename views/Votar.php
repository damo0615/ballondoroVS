<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emitir Voto - Ballon d'Or</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="public/css/styles.css">
    <!-- Logo personalizado en la barra del navegador -->
    <link rel="icon" type="image/png" href="public/img/logo.png">
</head>
<body>

    <!-- Barra de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-luxury fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
                <i class="bi bi-trophy-fill text-warning fs-4"></i>
                <span>BALLON D'OR</span>
            </a>
            <div class="ms-auto">
                <a href="index.php" class="btn btn-profile">
                    <i class="bi bi-arrow-left me-2"></i> Volver al Inicio
                </a>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="container py-5" style="margin-top: 100px; max-width: 700px;">
        
        <div class="text-center mb-5">
            <span class="text-uppercase fw-bold d-block mb-2 badge-edition">Papeleta de Votación Oficial</span>
            <h1 class="display-5 gold-title mb-3">Selecciona tu Top 3</h1>
            <p class="text-white-50 small">Asigna tus puntos: 1er Lugar (3 pts), 2do Lugar (2 pts) y 3er Lugar (1 pt).</p>
        </div>

        <div class="cat-card p-4 p-md-5">

            <?php if (isset($mensaje)): ?>
                <!-- Caso: Ya votó -->
                <div class="text-center py-4">
                    <i class="bi bi-check-circle-fill text-warning display-3 mb-3 d-block"></i>
                    <h3 class="text-white mb-3">Voto ya registrado</h3>
                    <p class="text-white-50 mb-4"><?php echo htmlspecialchars($mensaje); ?></p>
                    <a href="index.php" class="btn btn-gold-luxury">Volver a la Galería</a>
                </div>
            <?php else: ?>

                <!-- Mensaje de error si eligió repetidos -->
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger bg-dark text-danger border-danger small mb-4">
                        <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php endif; ?>

                <form action="index.php?action=votar" method="POST">
                    <input type="hidden" name="categoria_id" value="<?php echo htmlspecialchars($categoria_id); ?>">

                    <!-- 1er Puesto -->
                    <div class="mb-4">
                        <label for="puesto1" class="form-label text-warning fw-bold text-uppercase small">
                            <i class="bi bi-trophy me-1"></i> 1er Lugar <span class="text-white-50">(3 Puntos)</span>
                        </label>
                        <select class="form-select bg-dark text-white border-secondary py-2" id="puesto1" name="puesto1" required>
                            <option value="">Selecciona un nominado...</option>
                            <?php foreach ($nominados as $nom): ?>
                                <option value="<?php echo $nom['id']; ?>">
                                    <?php echo htmlspecialchars($nom['nombre']); ?> <?php echo !empty($nom['equipo_o_detalles']) ? '- ' . htmlspecialchars($nom['equipo_o_detalles']) : ''; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- 2do Puesto -->
                    <div class="mb-4">
                        <label for="puesto2" class="form-label text-white fw-bold text-uppercase small">
                            <i class="bi bi-award me-1 text-secondary"></i> 2do Lugar <span class="text-white-50">(2 Puntos)</span>
                        </label>
                        <select class="form-select bg-dark text-white border-secondary py-2" id="puesto2" name="puesto2" required>
                            <option value="">Selecciona un nominado...</option>
                            <?php foreach ($nominados as $nom): ?>
                                <option value="<?php echo $nom['id']; ?>">
                                    <?php echo htmlspecialchars($nom['nombre']); ?> <?php echo !empty($nom['equipo_o_detalles']) ? '- ' . htmlspecialchars($nom['equipo_o_detalles']) : ''; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- 3er Puesto -->
                    <div class="mb-4">
                        <label for="puesto3" class="form-label text-white-50 fw-bold text-uppercase small">
                            <i class="bi bi-award me-1"></i> 3er Lugar <span class="text-white-50">(1 Punto)</span>
                        </label>
                        <select class="form-select bg-dark text-white border-secondary py-2" id="puesto3" name="puesto3" required>
                            <option value="">Selecciona un nominado...</option>
                            <?php foreach ($nominados as $nom): ?>
                                <option value="<?php echo $nom['id']; ?>">
                                    <?php echo htmlspecialchars($nom['nombre']); ?> <?php echo !empty($nom['equipo_o_detalles']) ? '- ' . htmlspecialchars($nom['equipo_o_detalles']) : ''; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="d-grid mt-5">
                        <button type="submit" class="btn btn-gold-luxury py-3">Confirmar y Emitir Voto</button>
                    </div>
                </form>

            <?php endif; ?>

        </div>
    </main>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>