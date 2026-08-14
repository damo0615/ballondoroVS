<?php
// models/Categoria.php

class Categoria {
    private $conn;
    private $table_name = "categorias";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todas las categorías activas junto con sus imágenes
    public function obtenerCategoriasConImagenes() {
        // 1. Obtenemos todas las categorías
        $query = "SELECT id, nombre, subtitulo, descripcion FROM " . $this->table_name . " WHERE activo = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 2. Para cada categoría, buscamos sus imágenes asociadas
        foreach ($categorias as &$categoria) {
            $queryImg = "SELECT imagen_url FROM categoria_imagenes WHERE categoria_id = :categoria_id";
            $stmtImg = $this->conn->prepare($queryImg);
            $stmtImg->bindParam(':categoria_id', $categoria['id']);
            $stmtImg->execute();
            
            // Guardamos las imágenes en un array dentro de la categoría
            $categoria['imagenes'] = $stmtImg->fetchAll(PDO::FETCH_COLUMN);
        }

        return $categorias;
    }
}
?>