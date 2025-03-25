<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexion = new mysqli("localhost", "root", "", "inventarioo");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $fecha_prestamo = $conexion->real_escape_string($_POST['fecha_prestamo']);
    $fecha_entrega = $conexion->real_escape_string($_POST['fecha_entrega']);
    $herramienta = $conexion->real_escape_string($_POST['herramienta']);

    $conexion->query("UPDATE articulos SET stock_actual = stock_actual - 1 WHERE nombre_articulo = '$herramienta'");
    $conexion->query("INSERT INTO prestamos (nombre, fecha_prestamo, fecha_entrega, herramienta) VALUES ('$nombre', '$fecha_prestamo', '$fecha_entrega', '$herramienta')");

    if (isset($_POST['pdf'])) {
        header("Location: generar_pdf.php?nombre=$nombre&fecha_prestamo=$fecha_prestamo&fecha_entrega=$fecha_entrega&herramienta=$herramienta");
        exit();
    }

    $conexion->close();
    header("Location: prestamos.php?success=1");
    exit();
}
?>
