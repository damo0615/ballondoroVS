<?php
// models/Nominado.php

class Nominado {
    private $conn;
    private $table_name = "nominados";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener los nominados de una categoría en específico
    public function obtenerPorCategoria($categoria_id) {
        $query = "SELECT id, nombre, equipo_o_detalles FROM " . $this->table_name . " WHERE categoria_id = :categoria_id ORDER BY nombre ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>