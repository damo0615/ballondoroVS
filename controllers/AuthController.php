<?php
// controllers/AuthController.php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Usuario.php';

class AuthController {

    public function mostrarLogin() {
        session_start();
        if (isset($_SESSION['usuario_id'])) {
            header("Location: index.php");
            exit();
        }
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function mostrarRegistro() {
        session_start();
        if (isset($_SESSION['usuario_id'])) {
            header("Location: index.php");
            exit();
        }
        require_once __DIR__ . '/../views/auth/register.php';
    }

    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $usuarioInput = trim($_POST['usuario'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($nombre) || empty($usuarioInput) || empty($password)) {
                $error = "Por favor completa todos los campos.";
                require_once __DIR__ . '/../views/auth/register.php';
                return;
            }

            $database = new Database();
            $db = $database->getConnection();
            $usuario = new Usuario($db);

            if ($usuario->existeUsuario($usuarioInput)) {
                $error = "El nombre de usuario ya está en uso. Elige otro.";
                require_once __DIR__ . '/../views/auth/register.php';
                return;
            }

            $usuario->nombre = $nombre;
            $usuario->usuario = $usuarioInput;
            $usuario->password = $password;

            if ($usuario->registrar()) {
                header("Location: index.php?action=login&registro=exitoso");
                exit();
            } else {
                $error = "Hubo un error al registrarse. Inténtalo de nuevo.";
                require_once __DIR__ . '/../views/auth/register.php';
            }
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuarioInput = trim($_POST['usuario'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($usuarioInput) || empty($password)) {
                $error = "Por favor completa todos los campos.";
                require_once __DIR__ . '/../views/auth/login.php';
                return;
            }

            $database = new Database();
            $db = $database->getConnection();
            $usuario = new Usuario($db);

            $usuario->usuario = $usuarioInput;
            $usuario->password = $password;

            if ($usuario->login()) {
                session_start();
                $_SESSION['usuario_id'] = $usuario->id;
                $_SESSION['usuario_nombre'] = $usuario->nombre;
                header("Location: index.php");
                exit();
            } else {
                $error = "Usuario o contraseña incorrectos.";
                require_once __DIR__ . '/../views/auth/login.php';
            }
        }
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }
}
?>