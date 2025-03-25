<?php
session_start();
require 'conexion.php'; // Asegúrate de que este archivo conecta correctamente a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Conectar a la base de datos
    $conexion = new mysqli("localhost", "root", "", "inventarioo");

    // Verificar conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Preparar la consulta con el nombre correcto de la columna
    $sql = "SELECT id_usuario, nombre_usuario, rol, contraseña FROM usuarios WHERE correo = ?";
    $stmt = $conexion->prepare($sql);
    
    if (!$stmt) {
        die("Error en la consulta: " . $conexion->error);
    }

    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $fila = $resultado->fetch_assoc();
        
        // Verificar la contraseña
        if (password_verify($contrasena, $fila['contraseña'])) {
            $_SESSION['usuario'] = $fila['nombre_usuario'];
            $_SESSION['rol'] = $fila['rol'];
            header("Location: index.php"); // Redirigir al inicio
            exit();
        } else {
            $_SESSION['mensaje_error'] = "⚠️ Contraseña incorrecta.";
            header("Location: iniciodesesion.html");
            exit();
        }
    } else {
        $_SESSION['mensaje_error'] = "⚠️ Correo no registrado.";
        header("Location: iniciodesesion.html");
        exit();
    }

    // Cerrar conexión
    $stmt->close();
    $conexion->close();
}
?>
