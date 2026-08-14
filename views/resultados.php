<?php require 'public\template\header.html'; ?>

    <!-- Contenido Principal -->
    <main class="container py-5" style="margin-top: 100px; max-width: 800px;">
        
        <div class="text-center mb-5">
            <span class="text-uppercase fw-bold d-block mb-2 badge-edition">Conteo Oficial en Vivo</span>
            <h1 class="display-5 gold-title mb-3">Resultados de la Gala</h1>
            <p class="text-white-50 small">Puntajes calculados: 1er Lugar (3 pts), 2do Lugar (2 pts) y 3er Lugar (1 pt).</p>
        </div>

        <?php if (!empty($rankingCategorias)): ?>
            <?php foreach ($rankingCategorias as $catId => $catData): ?>
                <div class="cat-card p-4 p-md-5 mb-5">
                    <h2 class="gold-title h4 mb-4 pb-2 border-bottom border-secondary text-center">
                        <i class="bi bi-trophy me-2 text-warning"></i><?php echo htmlspecialchars($catData['categoria_nombre']); ?>
                    </h2>

                    <?php if (!empty($catData['nominados'])): ?>
                        <div class="table-responsive">
                            <table class="table table-dark table-borderless align-middle mb-0">
                                <thead>
                                    <tr class="text-secondary small text-uppercase border-bottom border-secondary">
                                        <th scope="col" style="width: 10%;">Pos</th>
                                        <th scope="col" style="width: 60%;">Nominado</th>
                                        <th scope="col" class="text-end" style="width: 30%;">Puntaje</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($catData['nominados'] as $index => $nom): 
                                        $posicion = $index + 1;
                                    ?>
                                        <tr class="border-bottom border-secondary border-opacity-10">
                                            <th scope="row" class="text-center">
                                                <?php if ($posicion == 1): ?>
                                                    <span class="badge bg-warning text-dark fs-6 rounded-circle p-2 shadow-sm">1</span>
                                                <?php elseif ($posicion == 2): ?>
                                                    <span class="badge bg-secondary text-white fs-6 rounded-circle p-2">2</span>
                                                <?php elseif ($posicion == 3): ?>
                                                    <span class="badge bg-dark border border-secondary text-white-50 fs-6 rounded-circle p-2">3</span>
                                                <?php else: ?>
                                                    <span class="text-white-50 fw-normal"><?php echo $posicion; ?></span>
                                                <?php endif; ?>
                                            </th>
                                            <td>
                                                <strong class="text-white fs-6"><?php echo htmlspecialchars($nom['nombre']); ?></strong>
                                                <?php if (!empty($nom['detalles'])): ?>
                                                    <span class="text-white-50 small d-block"><?php echo htmlspecialchars($nom['detalles']); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-end">
                                                <span class="fw-bold text-warning fs-5"><?php echo $nom['puntos']; ?></span> 
                                                <span class="text-white-50 small">pts</span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-white-50 text-center mb-0">No hay nominados registrados en esta categoría.</p>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="cat-card p-5 text-center">
                <p class="text-white-50 mb-0">No hay resultados disponibles en este momento.</p>
            </div>
        <?php endif; ?>

    </main>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>