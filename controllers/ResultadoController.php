<?php
// controllers/ResultadoController.php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Voto.php';

class ResultadoController {

    public function mostrarResultados() {
        session_start();

        $database = new Database();
        $db = $database->getConnection();

        $votoModel = new Voto($db);
        $rankingCategorias = $votoModel->obtenerResultadosGala();

        require_once __DIR__ . '/../views/resultados.php';
    }
}
?>