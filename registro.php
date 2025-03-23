<?php
session_start();

// Incluir el archivo de conexión a la base de datos
include("conexion.php");

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $nombre_completo = $_POST['nombre_completo'];
    $correo_electronico = $_POST['correo_electronico'];
    $contrasena = $_POST['contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];
    $terminos_condiciones = isset($_POST['terminos_condiciones']) ? 1 : 0; // Si está marcado, será 1

    // Verificar si las contraseñas coinciden
    if ($contrasena != $confirmar_contrasena) {
        echo "Las contraseñas no coinciden.";
        exit();
    }

    // Encriptar la contraseña
    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

    // Insertar los datos en la base de datos
    $sql = "INSERT INTO usuarios (nombre_completo, correo_electronico, contrasena) 
            VALUES ('$nombre_completo', '$correo_electronico', '$contrasena_hash')";

    if ($conn->query($sql) === TRUE) {
        // Aseguramos que no haya salida antes de la redirección
        ob_end_clean(); // Limpiar cualquier salida previa

        // Redirigir automáticamente a login.html sin mostrar ningún mensaje
        header("Location: login.html");
        exit(); // Detener la ejecución del script
    } else {
        // Si ocurre un error en la base de datos
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
}
?>
