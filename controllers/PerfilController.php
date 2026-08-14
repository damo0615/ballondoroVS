<?php
// controllers/PerfilController.php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Voto.php';

class PerfilController {

    public function mostrarPerfil() {
        session_start();

        // Validar que el usuario haya iniciado sesión
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?action=login");
            exit();
        }

        $usuario_id = $_SESSION['usuario_id'];
        $usuario_nombre = $_SESSION['usuario_nombre'];

        $database = new Database();
        $db = $database->getConnection();

        $votoModel = new Voto($db);
        $misVotos = $votoModel->obtenerVotosPorUsuario($usuario_id);

        require_once __DIR__ . '/../views/perfil.php';
    }
}
?>