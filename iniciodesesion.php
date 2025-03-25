<?php
session_start();

// Verificar si ya hay una sesión activa
if (isset($_SESSION['usuario']) && isset($_SESSION['correo'])) {
    // Si el usuario ya está logueado, no necesitas volver a hacer la verificación
    header("Location: index.php");
    exit;
}

// Configuración de conexión a la base de datos
$host = "localhost";
$dbname = "inventarioo";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Sanitizar y validar los datos del formulario
        $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
        $contrasena = $_POST['contrasena'];

        // Verificar si el correo existe
        $sql = "SELECT * FROM Usuarios WHERE correo = :correo";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($contrasena, $usuario['contraseña'])) {
            // Regenerar la sesión
            session_regenerate_id(true);

            // Almacenar datos del usuario en la sesión
            $_SESSION['usuario'] = htmlspecialchars($usuario['nombre_usuario']);
            $_SESSION['correo'] = htmlspecialchars($usuario['correo']);

            // Redirigir a la página principal (index.php)
            header("Location: index.php");
            exit;
        } else {
            // Mensaje de error para el usuario
            $_SESSION['mensaje_error'] = "Correo o contraseña incorrectos.";
            header("Location: iniciodesesion.html");
            exit;
        }
    } else {
        // Si no es una solicitud POST, redirige al formulario de inicio de sesión
        header("Location: iniciodesesion.html");
        exit;
    }
} catch (PDOException $e) {
    // Registrar el error en el log y mostrar un mensaje genérico
    error_log("Error en la conexión: " . $e->getMessage());
    $_SESSION['mensaje_error'] = "Ocurrió un problema. Inténtalo más tarde.";
    header("Location: iniciodesesion.html");
    exit;
}
?>
