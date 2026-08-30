<?php
// config/database.php

class Database {
    private $host = "localhost";
    private $db_name = "ballon_dor_db";
    private $username = "Damo"; // Cambia por tu usuario de BD
    private $password = "Damo";     // Cambia por tu contraseña de BD
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8",
                $this->username,
                $this->password
            );
            // Configurar errores de PDO para excepciones
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>