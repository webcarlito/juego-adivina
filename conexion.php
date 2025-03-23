<?php
$host = "localhost";
$usuario = "root";
$contrasena = "";
$baseDeDatos = "adBD";

// Crear la conexión
$conn = new mysqli($host, $usuario, $contrasena, $baseDeDatos);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
