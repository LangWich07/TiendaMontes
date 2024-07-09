<?php

include 'BdConfig.php'; 

// Verificar si se recibieron datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $nombre = $_POST['productName'];
    $descripcion = $_POST['productDescription'];
    $precio = $_POST['productPrice'];

    // Llamar a la función para agregar un producto
    if (agregarProducto($nombre, $descripcion, $precio)) {
        // Producto agregado correctamente
        echo json_encode(array("status" => "success", "message" => "Se agregó un nuevo producto."));
    } else {
        // Error al agregar el producto
        echo json_encode(array("status" => "error", "message" => "No se pudo agregar el producto."));
    }
} else {
    // Método no permitido
    echo json_encode(array("status" => "error", "message" => "Método no permitido."));
}

// Función para agregar un nuevo producto
function agregarProducto($nombre, $descripcion, $precio) {
    global $conexion;

    // Preparar la consulta SQL para insertar un nuevo producto
    $sql = "INSERT INTO productos (nombre, descripcion, precio) VALUES (?, ?, ?)";
    if ($stmt = $conexion->prepare($sql)) {
        // Vincular parámetros a la declaración preparada
        $stmt->bind_param("ssd", $nombre, $descripcion, $precio);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true; // Inserción exitosa
        } else {
            return false; // Error en la ejecución
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        return false; // Error en la preparación de la consulta
    }
}
?>
