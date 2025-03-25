<?php
// Configuración de la base de datos
$host = "localhost";
$dbname = "inventarioo";
$username = "root";
$password = "";

try {
    // Conexión a la base de datos
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar si el formulario fue enviado
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Sanitización y validación de datos
        $nombre_usuario = htmlspecialchars(trim($_POST['nombre_usuario']));
        $correo = filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL);
        $contrasena = $_POST['contrasena'];
        $confirmar_contrasena = $_POST['confirmar_contrasena'];
        $rol = $_POST['rol'];
        $activo = true;

        // Validar que las contraseñas coincidan
        if ($contrasena !== $confirmar_contrasena) {
            echo "<script>alert('Las contraseñas no coinciden.'); window.history.back();</script>";
            exit;
        }

        // Validar si el correo ya está registrado
        $sql = "SELECT COUNT(*) FROM Usuarios WHERE correo = :correo";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        $correo_existente = $stmt->fetchColumn();

        if ($correo_existente > 0) {
            echo "<script>alert('El correo ya está registrado. Por favor, utiliza otro.'); window.history.back();</script>";
            exit;
        }

        // Cifrar la contraseña antes de guardarla
        $contrasena_cifrada = password_hash($contrasena, PASSWORD_BCRYPT);

        // Insertar datos en la tabla Usuarios
        $sql = "INSERT INTO Usuarios (nombre_usuario, correo, contraseña, rol, activo) 
                VALUES (:nombre_usuario, :correo, :contrasena, :rol, :activo)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre_usuario', $nombre_usuario);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':contrasena', $contrasena_cifrada);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':activo', $activo);

        if ($stmt->execute()) {
            // Redirigir al inicio tras el registro exitoso
            echo "<script>alert('Registro exitoso. Ahora puedes iniciar sesión.'); window.location.href = 'iniciodesesion.html';</script>";
            exit;
        } else {
            echo "<script>alert('Error al registrar el usuario.'); window.history.back();</script>";
        }
    }
} catch (PDOException $e) {
    echo "<script>alert('Error en la conexión a la base de datos: " . $e->getMessage() . "');</script>";
}
?>
