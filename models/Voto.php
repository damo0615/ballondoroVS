<?php
// models/Voto.php

class Voto {
    private $conn;
    private $table_name = "votos";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Comprobar si el usuario ya votó en esta categoría
    public function yaVoto($usuario_id, $categoria_id) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE usuario_id = :usuario_id AND categoria_id = :categoria_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['total'] > 0;
    }

    // Registrar el voto del Top 3 (recibe IDs)
    public function registrarTop3($usuario_id, $categoria_id, $puesto1_id, $puesto2_id, $puesto3_id) {
        try {
            // Usamos una transacción para asegurar que los 3 votos se guarden juntos o no se guarde ninguno
            $this->conn->beginTransaction();

            $query = "INSERT INTO " . $this->table_name . " (usuario_id, categoria_id, nominado_id, puesto) VALUES (:usuario_id, :categoria_id, :nominado_id, :puesto)";
            $stmt = $this->conn->prepare($query);

            // Preparar variables fijas
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
            
            // Insertar 1er puesto (3 Puntos)
            $puesto = 1;
            $stmt->bindParam(':nominado_id', $puesto1_id, PDO::PARAM_INT);
            $stmt->bindParam(':puesto', $puesto, PDO::PARAM_INT);
            $stmt->execute();

            // Insertar 2do puesto (2 Puntos)
            $puesto = 2;
            $stmt->bindParam(':nominado_id', $puesto2_id, PDO::PARAM_INT);
            $stmt->bindParam(':puesto', $puesto, PDO::PARAM_INT);
            $stmt->execute();

            // Insertar 3er puesto (1 Punto)
            $puesto = 3;
            $stmt->bindParam(':nominado_id', $puesto3_id, PDO::PARAM_INT);
            $stmt->bindParam(':puesto', $puesto, PDO::PARAM_INT);
            $stmt->execute();

            // Confirmar transacción
            $this->conn->commit();
            return true;

        } catch(Exception $e) {
            // Si hay un error, revertimos todo
            $this->conn->rollBack();
            return false;
        }
    }

    // Obtener los votos emitidos por un usuario con los detalles del nominado y la categoría
    public function obtenerVotosPorUsuario($usuario_id) {
        $query = "SELECT v.puesto, v.categoria_id, c.nombre as categoria_nombre, n.nombre as nominado_nombre, n.equipo_o_detalles
                  FROM " . $this->table_name . " v
                  JOIN categorias c ON v.categoria_id = c.id
                  JOIN nominados n ON v.nominado_id = n.id
                  WHERE v.usuario_id = :usuario_id
                  ORDER BY v.categoria_id ASC, v.puesto ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Agrupamos por categoría para mostrarlos ordenadamente en la vista
        $votosAgrupados = [];
        foreach ($resultados as $row) {
            $catId = $row['categoria_id'];
            if (!isset($votosAgrupados[$catId])) {
                $votosAgrupados[$catId] = [
                    'categoria_nombre' => $row['categoria_nombre'],
                    'puestos' => []
                ];
            }
            $votosAgrupados[$catId]['puestos'][] = [
                'puesto' => $row['puesto'],
                'nominado' => $row['nominado_nombre'],
                'detalles' => $row['equipo_o_detalles']
            ];
        }

        return $votosAgrupados;
    }

    public function obtenerResultadosGala() {
        $query = "SELECT c.id as categoria_id, c.nombre as categoria_nombre, 
                         n.id as nominado_id, n.nombre as nominado_nombre, n.equipo_o_detalles,
                         SUM(CASE 
                             WHEN v.puesto = 1 THEN 3 
                             WHEN v.puesto = 2 THEN 2 
                             WHEN v.puesto = 3 THEN 1 
                             ELSE 0 
                         END) as total_puntos,
                         SUM(CASE WHEN v.puesto = 1 THEN 1 ELSE 0 END) as votos_primer_lugar
                  FROM categorias c
                  LEFT JOIN nominados n ON c.id = n.categoria_id
                  LEFT JOIN votos v ON n.id = v.nominado_id
                  WHERE c.activo = 1
                  GROUP BY c.id, n.id
                  ORDER BY c.id ASC, total_puntos DESC, votos_primer_lugar DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $resultadosBrutos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Agrupamos los nominados por categoría para estructurar el ranking
        $ranking = [];
        foreach ($resultadosBrutos as $row) {
            $catId = $row['categoria_id'];
            if (!isset($ranking[$catId])) {
                $ranking[$catId] = [
                    'categoria_nombre' => $row['categoria_nombre'],
                    'nominados' => []
                ];
            }
            if ($row['nominado_id'] !== null) {
                $ranking[$catId]['nominados'][] = [
                    'nombre' => $row['nominado_nombre'],
                    'detalles' => $row['equipo_o_detalles'],
                    'puntos' => $row['total_puntos'] ?? 0,
                    'votos_oro' => $row['votos_primer_lugar'] ?? 0
                ];
            }
        }

        return $ranking;
    }
}
?>