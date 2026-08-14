<?php
// controllers/HomeController.php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Categoria.php';

class HomeController {
    
    public function index() {
        // 1. Instanciamos la conexión a la base de datos
        $database = new Database();
        $db = $database->getConnection();

        // 2. Instanciamos el modelo de Categoría
        $categoriaModel = new Categoria($db);

        // 3. Obtenemos todas las categorías con sus imágenes asociadas
        $categorias = $categoriaModel->obtenerCategoriasConImagenes();

        // 4. Cargamos la vista de la landing page y le pasamos los datos
        // Nota: Las variables definidas aquí estarán disponibles dentro de la vista.
        require_once __DIR__ . '/../views/home.php';
    }
}
?>