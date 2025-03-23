<?php
// Iniciar la sesión
session_start();

// Verificar si ya está logueado, si es así redirigir a adivina.php
if (isset($_SESSION['usuario'])) {
    header("Location: adivina.php");
    exit();
}

// Conexión a la base de datos
include("conexion.php");

// Verificar si el formulario de inicio de sesión ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $correo_electronico = $_POST['correo_electronico'];
    $contrasena = $_POST['contrasena'];

    // Consultar la base de datos para verificar las credenciales
    $sql = "SELECT * FROM usuarios WHERE correo_electronico = '$correo_electronico'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($contrasena, $usuario['contrasena'])) {
            // Iniciar la sesión y almacenar el nombre de usuario
            $_SESSION['usuario'] = $usuario['nombre_completo'];
            // Redirigir al juego
            header("Location: adivina.php");
            exit();
        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "Correo electrónico no registrado";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
</head>
<body>

    <h1>Iniciar Sesión</h1>

    <?php
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>

    <form action="login.php" method="POST">
        <label for="correo_electronico">Correo Electrónico:</label>
        <input type="email" name="correo_electronico" required><br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required><br>
        <button type="submit">Iniciar Sesión</button>
    </form>

    <p>¿No tienes cuenta? <a href="registro.html">Regístrate aquí</a></p>

</body>
</html>
