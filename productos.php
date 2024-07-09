<?php

include 'BdConfig.php';

// Consulta SQL para obtener todos los productos ordenados por fecha de creación descendente
$sql = "SELECT id, nombre, descripcion, precio FROM productos ORDER BY fecha_creacion DESC";
$result = $conexion->query($sql);

$productos = array();

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Iterar sobre los resultados y almacenar en un arreglo asociativo
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}

// Liberar el resultado
$result->free_result();

// Devolver productos como JSON
header('Content-Type: application/json');
echo json_encode($productos);

// Cerrar la conexión a la base de datos
$conexion->close();
?>
