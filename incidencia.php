<?php
$titulo = "Inicio - Inventario UTN";
include 'header.php';
require_once('tcpdf/tcpdf.php');

// Conectar a la base de datos
$con = new mysqli("localhost", "root", "", "inventarioo");
if ($con->connect_error) {
    die("Error de conexión: " . $con->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_prestamo = $_POST['id_prestamo'];
    $incidencia = $_POST['incidencia'];
    $fecha_devolucion = date('Y-m-d');

    // Insertar la devolución con incidencia en la base de datos
    $stmt = $con->prepare("INSERT INTO devoluciones (id_prestamo, fecha_devolucion, incidencia) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $id_prestamo, $fecha_devolucion, $incidencia);
    if (!$stmt->execute()) {
        die("Error al guardar en la base de datos: " . $stmt->error);
    }
    $stmt->close();

    // Obtener detalles del préstamo
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

    // Generar PDF de la devolución con incidencia
    ob_end_clean(); // Evitar errores de TCPDF por salida previa

    $pdf = new TCPDF();
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->AddPage();

    $folio = "PREST-" . $id_prestamo;
    $html = "
    <style>
        h2 { text-align: center; }
        p, li { font-size: 14px; }
        ul { margin-left: 20px; }
    </style>
    <h2>Folio de Devolución con Incidencia: $folio</h2>
    <p><strong>Nombre del Solicitante:</strong> {$prestamo['nombre_solicitante']}</p>
    <p><strong>Fecha de Préstamo:</strong> {$prestamo['fecha_prestamo']}</p>
    <p><strong>Fecha de Entrega:</strong> {$prestamo['fecha_entrega']}</p>
    <p><strong>Fecha de Devolución:</strong> $fecha_devolucion</p>
    <p><strong>Herramientas Devueltas:</strong></p>
    <ul>";

    foreach ($herramientas as $herramienta) {
        $html .= "<li>$herramienta</li>";
    }

    $html .= "</ul>
    <p><strong>Incidencia Reportada:</strong> $incidencia</p>
    <p><strong>Firma del Responsable:</strong> ________________________</p>";

    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output("incidencia_$folio.pdf", 'D');
    exit;
}

// Verificar si se pasó un folio válido
if (!isset($_GET['folio'])) {
    die("Error: No se proporcionó un folio válido.");
}

$id_prestamo = $_GET['folio'];

// Obtener información del préstamo
$sql = "SELECT * FROM prestamos WHERE id_prestamo = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id_prestamo);
$stmt->execute();
$resultado = $stmt->get_result();
$prestamo = $resultado->fetch_assoc();
$stmt->close();

if (!$prestamo) {
    die("No se encontró el préstamo.");
}

// Obtener herramientas prestadas
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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devolución con Incidencia</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-lg">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-700">Devolución con Incidencia</h2>
        <form action="incidencia.php" method="POST" class="space-y-4">
            <input type="hidden" name="id_prestamo" value="<?php echo $prestamo['id_prestamo']; ?>">
            <p><strong>Folio:</strong> <?php echo $prestamo['id_prestamo']; ?></p>
            <p><strong>Solicitante:</strong> <?php echo $prestamo['nombre_solicitante']; ?></p>
            <p><strong>Fecha de Préstamo:</strong> <?php echo $prestamo['fecha_prestamo']; ?></p>
            <p><strong>Fecha de Entrega:</strong> <?php echo $prestamo['fecha_entrega']; ?></p>
            <p><strong>Herramientas Prestadas:</strong></p>
            <ul class="list-disc list-inside text-gray-700">
                <?php foreach ($herramientas as $herramienta) { echo "<li>$herramienta</li>"; } ?>
            </ul>
            <div>
                <label for="incidencia" class="block text-gray-600 mb-2">Describa la Incidencia</label>
                <textarea id="incidencia" name="incidencia" class="w-full p-2 border border-gray-300 rounded-lg" required></textarea>
            </div>
            <button type="submit" class="w-full bg-red-500 text-white p-3 rounded-lg shadow hover:bg-red-600">
                Registrar Devolución con Incidencia
            </button>
        </form>
    </div>
</body>
</html>
