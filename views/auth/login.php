<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Ballon d'Or</title>
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
<body class="d-flex align-items-center justify-content-center min-vh-100">

    <main class="container" style="max-width: 450px;">
        <div class="cat-card p-4 p-md-5">
            
            <div class="text-center mb-4">
                <a href="index.php" class="text-decoration-none">
                    <i class="bi bi-trophy-fill text-warning display-4 mb-2 d-block"></i>
                </a>
                <h1 class="h3 gold-title mb-1">Iniciar Sesión</h1>
                <p class="text-white-50 small">Ingresa con tu usuario para emitir tus votos.</p>
            </div>

            <?php if (isset($_GET['registro']) && $_GET['registro'] == 'exitoso'): ?>
                <div class="alert alert-success bg-dark text-success border-success small mb-4 text-center">
                    ¡Registro exitoso! Ya puedes iniciar sesión.
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger bg-dark text-danger border-danger small mb-4 text-center">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form action="index.php?action=login" method="POST">
                
                <div class="mb-3">
                    <label for="usuario" class="form-label text-warning small fw-bold text-uppercase">Nombre de Usuario</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-secondary"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control bg-dark text-white border-secondary" id="usuario" name="usuario" placeholder="Ej: carlitos99" required autocomplete="username">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label text-warning small fw-bold text-uppercase">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-secondary"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control bg-dark text-white border-secondary border-end-0" id="password" name="password" placeholder="••••••••" required autocomplete="current-password">
                        <button class="btn btn-outline-secondary bg-dark border-secondary text-white-50" type="button" id="togglePassword">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-gold-luxury py-2">Entrar a la Gala</button>
                </div>

                <div class="text-center">
                    <p class="text-white-50 small mb-0">¿No tienes cuenta? <a href="index.php?action=register" class="text-warning text-decoration-none fw-bold">Regístrate aquí</a></p>
                </div>

            </form>
        </div>
    </main>

    <!-- Script para el Botón de Ver/Ocultar Contraseña -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function () {
            // Alternar el tipo de input
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Cambiar el icono del ojito
            eyeIcon.classList.toggle('bi-eye');
            eyeIcon.classList.toggle('bi-eye-slash');
        });
    </script>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>