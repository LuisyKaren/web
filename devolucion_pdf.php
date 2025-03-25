<?php
require_once('tcpdf/tcpdf.php');

// Conectar a la base de datos
$con = new mysqli("localhost", "root", "", "inventarioo");
if ($con->connect_error) {
    die("Error de conexión: " . $con->connect_error);
}

if (!isset($_GET['folio'])) {
    die("Error: No se proporcionó un folio válido.");
}

$id_prestamo = $_GET['folio'];
$fecha_devolucion = date('Y-m-d');

// Insertar la devolución en la base de datos
$stmt = $con->prepare("INSERT INTO devoluciones (id_prestamo, fecha_devolucion) VALUES (?, ?)");
$stmt->bind_param("is", $id_prestamo, $fecha_devolucion);
if (!$stmt->execute()) {
    die("Error al guardar en la base de datos: " . $stmt->error);
}
$stmt->close();

// Obtener los detalles del préstamo
$sql = "SELECT * FROM prestamos WHERE id_prestamo = ?";
$stmt_prestamo = $con->prepare($sql);
$stmt_prestamo->bind_param("i", $id_prestamo);
$stmt_prestamo->execute();
$resultado = $stmt_prestamo->get_result();
$prestamo = $resultado->fetch_assoc();
$stmt_prestamo->close();

if (!$prestamo) {
    die("No se encontró la información del préstamo.");
}

// Obtener herramientas prestadas en ese préstamo
$herramientas = [];
$sql_herramientas = "SELECT a.nombre_articulo 
                     FROM detalle_prestamo dp
                     INNER JOIN articulos a ON dp.id_articulo = a.id_articulo
                     WHERE dp.id_prestamo = ?";
$stmt_herramientas = $con->prepare($sql_herramientas);
$stmt_herramientas->bind_param("i", $id_prestamo);
$stmt_herramientas->execute();
$result_herramientas = $stmt_herramientas->get_result();

while ($row = $result_herramientas->fetch_assoc()) {
    $herramientas[] = $row['nombre_articulo'];
}
$stmt_herramientas->close();
$con->close();

// Generar PDF
$pdf = new TCPDF();
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->AddPage();

$folio = "PREST-" . $id_prestamo;
$html = "
<style>
    h2 { text-align: center; }
    p { font-size: 14px; }
    ul { margin-left: 20px; }
</style>
<h2>Folio de Devolución: $folio</h2>
<p><strong>Nombre del Solicitante:</strong> {$prestamo['nombre_solicitante']}</p>
<p><strong>Fecha de Préstamo:</strong> {$prestamo['fecha_prestamo']}</p>
<p><strong>Fecha de Entrega:</strong> {$prestamo['fecha_entrega']}</p>
<p><strong>Fecha de Devolución:</strong> $fecha_devolucion</p>
<p><strong>Herramientas Devueltas:</strong></p>
<ul>";

// Agregar herramientas al PDF
foreach ($herramientas as $herramienta) {
    $html .= "<li>$herramienta</li>";
}
$html .= "</ul>
<p><strong>Firma del Responsable:</strong> ________________________</p>";

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output("devolucion_$folio.pdf", 'D');
?>
