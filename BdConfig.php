<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "tiendamontes";

// Crear conexión
$conexion = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>

