<?php

include 'BdConfig.php'; 

// Verificar si se recibieron datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener ID del producto a eliminar
    $id = $_POST['productId'];

    // Llamar a la función para eliminar un producto
    if (eliminarProducto($id)) {
        // Producto eliminado correctamente
        echo json_encode(array("status" => "success", "message" => "Se eliminó correctamente el producto."));
    } else {
        // Error al eliminar el producto
        echo json_encode(array("status" => "error", "message" => "No se pudo eliminar el producto."));
    }
} else {
    // Método no permitido
    echo json_encode(array("status" => "error", "message" => "Método no permitido."));
}

// Función para eliminar un producto
function eliminarProducto($id) {
    global $conexion;

    // Preparar la consulta SQL para eliminar el producto
    $sql = "DELETE FROM productos WHERE id = ?";
    if ($stmt = $conexion->prepare($sql)) {
        // Vincular parámetros a la declaración preparada
        $stmt->bind_param("i", $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true; // Eliminación exitosa
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
