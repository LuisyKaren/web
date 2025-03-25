<?php
session_start();
include 'config.php'; // Archivo de configuración para la conexión a la base de datos

// Verificar si el usuario está logueado y tiene un ID válido
if (!isset($_SESSION['id_usuario'])) {
    header("Location: iniciodesesion.html");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Eliminar usuario de la base de datos
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id_usuario = :id_usuario");
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->execute();

    // Cerrar sesión después de eliminar la cuenta
    session_destroy();

    // Redirigir al usuario a la página de inicio de sesión con un mensaje
    header("Location: iniciodesesion.html?mensaje=Cuenta eliminada exitosamente");
    exit;
} catch (PDOException $e) {
    echo "Error al eliminar la cuenta: " . $e->getMessage();
}
?>
