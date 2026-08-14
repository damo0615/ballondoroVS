<?php
// controllers/VotoController.php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Nominado.php';
require_once __DIR__ . '/../models/Voto.php';

class VotoController {
    
    public function mostrarFormulario() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // 1. Validar que el usuario esté logueado
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?action=login");
            exit();
        }

        // 2. Validar que venga el ID de la categoría por la URL
        if (!isset($_GET['categoria_id'])) {
            header("Location: index.php?action=home");
            exit();
        }

        $categoria_id = $_GET['categoria_id'];
        $usuario_id = $_SESSION['usuario_id'];

        $database = new Database();
        $db = $database->getConnection();
        
        $votoModel = new Voto($db);
        
        // 3. BLINDAJE: Si el usuario ya votó, prohibir el acceso por URL y redirigir al perfil con aviso
        if ($votoModel->yaVoto($usuario_id, $categoria_id)) {
            header("Location: index.php?action=perfil&aviso=ya_votaste");
            exit();
        }

        // 4. Obtener los nominados para mostrarlos en el select
        $nominadoModel = new Nominado($db);
        $nominados = $nominadoModel->obtenerPorCategoria($categoria_id);

        // 5. Cargar la vista de votación
        require_once __DIR__ . '/../views/votar.php';
    }

    public function procesarVoto() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?action=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoria_id = $_POST['categoria_id'] ?? null;
            $puesto1 = $_POST['puesto1'] ?? null;
            $puesto2 = $_POST['puesto2'] ?? null;
            $puesto3 = $_POST['puesto3'] ?? null;
            $usuario_id = $_SESSION['usuario_id'];

            if (!$categoria_id || !$puesto1 || !$puesto2 || !$puesto3) {
                header("Location: index.php?action=home&error=" . urlencode("Faltan datos en la votación."));
                exit();
            }

            $database = new Database();
            $db = $database->getConnection();
            $votoModel = new Voto($db);

            // Doble validación de seguridad por si intentan saltar el formulario mediante POST directo
            if ($votoModel->yaVoto($usuario_id, $categoria_id)) {
                header("Location: index.php?action=perfil&aviso=ya_votaste");
                exit();
            }

            // Validar que no haya elegido al mismo nominado dos veces
            if ($puesto1 == $puesto2 || $puesto1 == $puesto3 || $puesto2 == $puesto3) {
                $error = "No puedes elegir al mismo jugador en diferentes puestos.";
                header("Location: index.php?action=votar&categoria_id=$categoria_id&error=" . urlencode($error));
                exit();
            }

            if ($votoModel->registrarTop3($usuario_id, $categoria_id, $puesto1, $puesto2, $puesto3)) {
                header("Location: index.php?action=perfil&voto_exitoso=1");
                exit();
            } else {
                $error = "Hubo un problema al registrar tu voto. Inténtalo de nuevo.";
                header("Location: index.php?action=votar&categoria_id=$categoria_id&error=" . urlencode($error));
                exit();
            }
        }
    }
}
?>