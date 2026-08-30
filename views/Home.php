<?php require 'public/template/header.html'; ?>
<body>

    <!-- Barra de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-luxury fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
                <img src="public/img/logo2.png" alt="BalonDoroVS" class="logo">
                <span>BALLON D'OR</span>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center gap-3 mt-3 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-white-50 small text-uppercase tracking-wider" href="#categorias-section">Categorías</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white-50 small text-uppercase tracking-wider" href="index.php?action=resultados">Resultados / Gala</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a href="index.php?action=perfil" class="btn btn-profile">
                            <i class="bi bi-person-circle me-2"></i> Mi Cuenta
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header Oficial Balón de Oro -->
    <header class="container text-center py-5" style="margin-top: 100px;">
        <span class="text-uppercase fw-bold d-block mb-3 badge-edition">Ceremonia Oficial • Torneos Diarios</span>
        <h1 class="display-1 gold-title mb-4">BALLON D'OR</h1>
        <p class="text-white-50 fs-5 mb-5 mx-auto" style="max-width: 650px;">
            El reconocimiento supremo a la excelencia, la gloria y los momentos memorables de nuestra temporada en la cancha.
        </p>
        <div>
            <a href="#categorias-section" class="btn btn-gold-luxury px-5 py-3">Explorar Categorías</a>
        </div>
    </header>

    <div class="section-divider"></div>

    <!-- Contenedor Principal con Carruseles Dinámicos -->
    <main id="categorias-section" class="container py-4">
        
        <?php if (!empty($categorias)): ?>
            <?php foreach ($categorias as $index => $cat): 
                $carouselId = "carouselCat" . $cat['id'];
            ?>
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-10">
                        <div class="cat-card p-4 p-md-5">
                            
                            <!-- Carrusel de Imágenes Asociadas -->
                            <?php if (!empty($cat['imagenes'])): ?>
                                <div id="<?php echo $carouselId; ?>" class="carousel slide mb-4 rounded overflow-hidden shadow" data-bs-ride="carousel">
                                    <div class="carousel-indicators">
                                        <?php foreach ($cat['imagenes'] as $imgIndex => $img): ?>
                                            <button type="button" data-bs-target="#<?php echo $carouselId; ?>" data-bs-slide-to="<?php echo $imgIndex; ?>" <?php echo $imgIndex === 0 ? 'class="active" aria-current="true"' : ''; ?>></button>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="carousel-inner">
                                        <?php foreach ($cat['imagenes'] as $imgIndex => $img): ?>
                                            <div class="carousel-item <?php echo $imgIndex === 0 ? 'active' : ''; ?>">
                                                <img src="<?php echo htmlspecialchars($img); ?>" class="d-block w-100" alt="<?php echo htmlspecialchars($cat['nombre']); ?>">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#<?php echo $carouselId; ?>" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#<?php echo $carouselId; ?>" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </button>
                                </div>
                            <?php endif; ?>

                            <!-- Contenido Detallado -->
                            <div class="text-center px-md-4">
                                <span class="text-uppercase text-secondary small fw-bold tracking-widest d-block mb-1" style="letter-spacing: 3px;"><?php echo htmlspecialchars($cat['subtitulo']); ?></span>
                                <h2 class="gold-title display-5 fw-bold mb-3"><?php echo htmlspecialchars($cat['nombre']); ?></h2>
                                <p class="text-white-50 fs-6 mb-4 lh-lg mx-auto" style="max-width: 800px;"><?php echo htmlspecialchars($cat['descripcion']); ?></p>
                                
                                <div class="mt-4">
                                    <a href="index.php?action=votar&categoria_id=<?php echo $cat['id']; ?>" class="btn btn-gold-luxury">
                                        Votar en esta categoría <i class="bi bi-chevron-right ms-2"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <?php if($index < count($categorias) - 1): ?>
                    <div class="section-divider"></div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center py-5">
                <p class="text-white-50 fs-5">No hay categorías disponibles en este momento.</p>
            </div>
        <?php endif; ?>

    </main>

    <!-- Footer Formal -->
    <footer class="text-center py-5 border-top border-secondary mt-5" style="border-color: rgba(197, 160, 89, 0.1) !important;">
        <div class="container text-secondary small">
            <p class="mb-1 text-white fw-bold tracking-widest" style="letter-spacing: 2px;">BALLON D'OR • TORNEOS DIARIOS</p>
            <p class="mb-0 text-white-50">El templo del reconocimiento futbolístico entre amigos.</p>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>