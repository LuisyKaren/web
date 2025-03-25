<?php
$servername = "localhost";
$username = "root"; // Cambia si tu servidor tiene usuario diferente
$password = ""; // Si tienes contraseña en MySQL, agrégala aquí
$database = "inventarioo"; // Nombre de tu base de datos

$conn = new mysqli($servername, $username, $password, $database);

// Verifica si hay errores en la conexión
if ($conn->connect_error) {
    die("❌ Conexión fallida: " . $conn->connect_error);
} else {
    // echo "✅ Conexión exitosa a la base de datos"; // Puedes activarlo para pruebas
}
?>
