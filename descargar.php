<?php
// Verificar si se pasó el archivo como parámetro
if (!isset($_GET['archivo'])) {
    die("Error: No se especificó ningún archivo.");
}

$archivo = basename($_GET['archivo']); // Evitar rutas inseguras
$ruta_archivo = __DIR__ . "/pdfs/" . $archivo;

if (!file_exists($ruta_archivo)) {
    die("Error: El archivo no existe.");
}

// Configurar cabeceras para la descarga del PDF
header('Content-Type: application/pdf');
header("Content-Disposition: attachment; filename=\"$archivo\"");
readfile($ruta_archivo);

// Usar JavaScript para redirigir después de la descarga
echo "<script>
    setTimeout(function() {
        window.location.href = 'prestamos.php';
    }, 1000);
</script>";
exit;
?>
