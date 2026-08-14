<?php
// models/Usuario.php

class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public $id;
    public $nombre;
    public $usuario;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Registrar un nuevo usuario
    public function registrar() {
        $query = "INSERT INTO " . $this->table_name . " (nombre, usuario, password) VALUES (:nombre, :usuario, :password)";
        $stmt = $this->conn->prepare($query);

        // Limpiar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->usuario = htmlspecialchars(strip_tags($this->usuario));
        $password_hashed = password_hash($this->password, PASSWORD_BCRYPT);

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":usuario", $this->usuario);
        $stmt->bindParam(":password", $password_hashed);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Verificar si el usuario ya existe
    public function existeUsuario($usuario) {
        $query = "SELECT id FROM " . $this->table_name . " WHERE usuario = :usuario LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":usuario", $usuario);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    // Autenticar usuario por nombre de usuario
    public function login() {
        $query = "SELECT id, nombre, usuario, password FROM " . $this->table_name . " WHERE usuario = :usuario LIMIT 1";
        $stmt = $this->conn->prepare($query);
        
        $this->usuario = htmlspecialchars(strip_tags($this->usuario));
        $stmt->bindParam(":usuario", $this->usuario);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($this->password, $row['password'])) {
                $this->id = $row['id'];
                $this->nombre = $row['nombre'];
                return true;
            }
        }
        return false;
    }
}
?>