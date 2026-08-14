<?php
// public/index.php

// Iniciar manejo de errores para desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Obtener la acción solicitada por URL (por defecto es 'home')
$action = isset($_GET['action']) ? $_GET['action'] : 'home';

// Cargar controladores necesarios usando un solo nivel para subir desde public/
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/HomeController.php';
require_once __DIR__ . '/../controllers/PerfilController.php';
require_once __DIR__ . '/../controllers/ResultadoController.php';
require_once __DIR__ . '/../controllers/VotoController.php';

$authController = new AuthController();
$homeController = new HomeController();
$perfilController = new PerfilController();
$resultadoController = new ResultadoController();
$votoController = new VotoController();

switch ($action) {
    case 'home':
        $homeController->index();
        break;

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->login();
        } else {
            $authController->mostrarLogin();
        }
        break;

    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->registrar();
        } else {
            $authController->mostrarRegistro();
        }
        break;

    case 'logout':
        $authController->logout();
        break;

    case 'votar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $votoController->procesarVoto();
        } else {
            $votoController->mostrarFormulario();
        }
        break;

    case 'resultados':
        $resultadoController->mostrarResultados();
        break;

    case 'perfil':
        $perfilController->mostrarPerfil();
        break;

    default:
        http_response_code(404);
        require_once __DIR__ . '/../views/404.php';
        break;
}
?>