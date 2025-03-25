<?php 
require_once('tcpdf/tcpdf.php');

// Conectar a la base de datos
$con = new mysqli("localhost", "root", "", "inventarioo");
if ($con->connect_error) {
    die("Error de conexión: " . $con->connect_error);
}

// Obtener datos del formulario
$nombre = $_POST['nombre'] ?? 'No definido';
$fecha_prestamo = $_POST['fecha_prestamo'] ?? 'No definido';
$fecha_entrega = $_POST['fecha_entrega'] ?? 'No definido';
$herramientas = json_decode($_POST['herramientas'], true);

if (empty($herramientas)) {
    die("Error: No se seleccionaron herramientas.");
}

// Insertar préstamo en la tabla prestamos
$stmt = $con->prepare("INSERT INTO prestamos (nombre_solicitante, fecha_prestamo, fecha_entrega) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nombre, $fecha_prestamo, $fecha_entrega);
if (!$stmt->execute()) {
    die("Error al registrar el préstamo: " . $stmt->error);
}
$id_prestamo = $stmt->insert_id;
$stmt->close();

// Registrar herramientas y actualizar stock
foreach ($herramientas as $herramienta) {
    $sql_check = "SELECT id_articulo, stock_actual, stock_salida FROM articulos WHERE nombre_articulo = ? LIMIT 1";
    $stmt_check = $con->prepare($sql_check);
    $stmt_check->bind_param("s", $herramienta);
    $stmt_check->execute();
    $result = $stmt_check->get_result();
    $articulo = $result->fetch_assoc();
    $stmt_check->close();

    if (!$articulo || $articulo['stock_actual'] <= 0) {
        die("Error: La herramienta $herramienta no está disponible en stock.");
    }

    $id_articulo = $articulo['id_articulo'];
    $nuevo_stock_actual = $articulo['stock_actual'] - 1;
    $nuevo_stock_salida = $articulo['stock_salida'] + 1;

    // Insertar en detalle_prestamo
    $stmt_detalle = $con->prepare("INSERT INTO detalle_prestamo (id_prestamo, id_articulo, cantidad) VALUES (?, ?, 1)");
    $stmt_detalle->bind_param("ii", $id_prestamo, $id_articulo);
    $stmt_detalle->execute();
    $stmt_detalle->close();

    // Actualizar stock
    $stmt_update = $con->prepare("UPDATE articulos SET stock_actual = ?, stock_salida = ? WHERE id_articulo = ?");
    $stmt_update->bind_param("iii", $nuevo_stock_actual, $nuevo_stock_salida, $id_articulo);
    $stmt_update->execute();
    $stmt_update->close();
}
$con->close();

// Generar folio único
$folio = "PRE-" . date("Ymd") . "-$id_prestamo";

// Asegurar que la carpeta pdfs/ exista
$ruta_pdfs = __DIR__ . "/pdfs";
if (!is_dir($ruta_pdfs)) {
    mkdir($ruta_pdfs, 0777, true);
}

// Ruta para guardar el PDF
$archivo_pdf = $ruta_pdfs . "/prestamo_$folio.pdf";

// Generar PDF
$pdf = new TCPDF();
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->AddPage();

$html = "<h2 style='text-align:center;'>Folio de Préstamo: $folio</h2>
<p><strong>Nombre del Solicitante:</strong> $nombre</p>
<p><strong>Fecha de Préstamo:</strong> $fecha_prestamo</p>
<p><strong>Fecha de Entrega:</strong> $fecha_entrega</p>
<p><strong>Herramientas:</strong></p>
<ul>";

foreach ($herramientas as $herramienta) {
    $html .= "<li>$herramienta</li>";
}
$html .= "</ul>
<p><strong>Firma del Responsable:</strong> ________________________</p>";

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output($archivo_pdf, 'F');

// Descargar el PDF automáticamente
header('Content-Type: application/pdf');
header("Content-Disposition: attachment; filename=prestamo_$folio.pdf");
readfile($archivo_pdf);

// Redirigir después de la descarga
header("Location: index.php");
exit;
?>
