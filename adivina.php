<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario está logueado, si no redirigir al login
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Adivinanza</title>
</head>
<body>

    <!-- Saludo al usuario -->
    <h1>Bienvenido, <?php echo $_SESSION['usuario']; ?>!</h1>

    <p>Ingresa un número entero:</p>
    <input type="number" id="num1">
    <button onclick="pedirSegundoNumero()">Continuar</button>

    <div id="paso2" style="display: none;">
        <p>Ingresa otro número mayor:</p>
        <input type="number" id="num2">
        <button onclick="mostrarRango()">Continuar</button>
    </div>

    <div id="rango" style="display: none;">
        <p>Números en el rango:</p>
        <p id="numeros"></p>
        <button onclick="generarNumeroAleatorio()">Generar número aleatorio</button>
    </div>

    <div id="adivinanza" style="display: none;">
        <p>Elige uno de los números mostrados:</p>
        <input type="number" id="eleccion">
        <button onclick="verificarAdivinanza()">Adivinar</button>
    </div>

    <p id="resultado"></p>

    <script>
        let num1, num2, randomNumber; 

        function pedirSegundoNumero() {
            num1 = parseInt(document.getElementById("num1").value);
            if (isNaN(num1)) {
                alert("Por favor, ingresa un número válido.");
                return;
            }
            document.getElementById("paso2").style.display = "block";
        }

        function mostrarRango() {
            num2 = parseInt(document.getElementById("num2").value);
            if (isNaN(num2) || num2 <= num1) {
                alert("El número debe ser mayor al primero.");
                return;
            }

            let numeros = "";
            for (let i = num1; i <= num2; i++) {
                numeros += i + (i === num2 ? "" : "-");
            }
            document.getElementById("numeros").textContent = numeros;
            document.getElementById("rango").style.display = "block";
        }

        function generarNumeroAleatorio() {
            randomNumber = Math.floor(Math.random() * (num2 - num1 + 1)) + num1;
            document.getElementById("adivinanza").style.display = "block";
        }

        function verificarAdivinanza() {
            let eleccion = parseInt(document.getElementById("eleccion").value);
            let resultadoTexto = "";

            if (eleccion === randomNumber) {
                resultadoTexto = "¡Has adivinado el número! Era: " + eleccion;
            } else {
                resultadoTexto = "Número incorrecto. El correcto era: " + randomNumber;
            }

            // Mostrar el mensaje de resultado
            document.getElementById("resultado").textContent = resultadoTexto;

            // Limpiar los campos de entrada
            document.getElementById("num1").value = "";
            document.getElementById("num2").value = "";
            document.getElementById("eleccion").value = "";

            // Opcional: Ocultar los formularios después de jugar
            document.getElementById("paso2").style.display = "none";
            document.getElementById("rango").style.display = "none";
            document.getElementById("adivinanza").style.display = "none";
        }
    </script>

</body>
</html>
