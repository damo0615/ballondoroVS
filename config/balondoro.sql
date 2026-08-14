CREATE DATABASE IF NOT EXISTS ballon_dor_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ballon_dor_db;

-- 1. Usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Categorías
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    subtitulo VARCHAR(100),
    descripcion TEXT,
    activo TINYINT(1) DEFAULT 1
);

-- 3. Imágenes para los carruseles de la Landing Page
CREATE TABLE categoria_imagenes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT NOT NULL,
    imagen_url VARCHAR(255) NOT NULL,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE CASCADE
);

-- 4. Nominados (jugadores, arqueros o jugadas por categoría)
CREATE TABLE nominados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT NOT NULL,
    nombre VARCHAR(150) NOT NULL,
    equipo_o_detalles VARCHAR(150),
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE CASCADE
);

-- 5. Votos (Top 3 por usuario y categoría)
CREATE TABLE votos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    categoria_id INT NOT NULL,
    nominado_id INT NOT NULL,
    puesto TINYINT NOT NULL CHECK (puesto IN (1, 2, 3)),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE CASCADE,
    FOREIGN KEY (nominado_id) REFERENCES nominados(id) ON DELETE CASCADE,
    UNIQUE KEY unique_voto_usuario (usuario_id, categoria_id, puesto)
);