<?php
$titulo = "Inicio - Inventario UTN";
include 'header.php';
?>

<?php
require_once('tcpdf/tcpdf.php');

// Conectar a la base de datos
$con = new mysqli("localhost", "root", "", "inventarioo");
if ($con->connect_error) {
    die("Error de conexión: " . $con->connect_error);
}

$prestamo = null;
$herramientas = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $folio = $_POST['folio'];

    // Consulta para obtener la información del préstamo
    $sql = "SELECT * FROM prestamos 
            WHERE id_prestamo = ? 
            AND id_prestamo NOT IN (SELECT id_prestamo FROM devoluciones)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $folio);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $prestamo = $resultado->fetch_assoc();
    $stmt->close();

    if ($prestamo) {
        // Obtener herramientas prestadas en ese préstamo
        $sql_herramientas = "SELECT a.nombre_articulo 
                             FROM detalle_prestamo dp
                             INNER JOIN articulos a ON dp.id_articulo = a.id_articulo
                             WHERE dp.id_prestamo = ?";
        $stmt_herramientas = $con->prepare($sql_herramientas);
        $stmt_herramientas->bind_param("i", $folio);
        $stmt_herramientas->execute();
        $result_herramientas = $stmt_herramientas->get_result();

        while ($row = $result_herramientas->fetch_assoc()) {
            $herramientas[] = $row['nombre_articulo'];
        }

        $stmt_herramientas->close();
    } else {
        echo "<p class='text-red-500 text-center mt-4'>No se encontró el préstamo o ya fue devuelto.</p>";
    }
}

$con->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Préstamo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-lg">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-700">Buscar Préstamo</h2>
        <form action="buscar_prestamo.php" method="POST" class="space-y-4">
            <div>
                <label for="folio" class="block text-gray-600 mb-2">Folio del Préstamo</label>
                <input type="number" id="folio" name="folio" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded-lg shadow hover:bg-blue-600">
                Buscar
            </button>
        </form>

        <?php if ($prestamo) { ?>
            <div class="mt-6 p-4 bg-gray-200 rounded-lg">
                <p><strong>Folio:</strong> <?php echo $prestamo['id_prestamo']; ?></p>
                <p><strong>Solicitante:</strong> <?php echo $prestamo['nombre_solicitante']; ?></p>
                <p><strong>Fecha de Préstamo:</strong> <?php echo $prestamo['fecha_prestamo']; ?></p>
                <p><strong>Fecha de Entrega:</strong> <?php echo $prestamo['fecha_entrega']; ?></p>

                <!-- Mostrar herramientas prestadas -->
                <?php if (!empty($herramientas)) { ?>
                    <p><strong>Herramientas Prestadas:</strong></p>
                    <ul class="list-disc pl-5">
                        <?php foreach ($herramientas as $herramienta) { ?>
                            <li><?php echo $herramienta; ?></li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <p class="text-red-500"><strong>No hay herramientas registradas en este préstamo.</strong></p>
                <?php } ?>

                <div class="mt-4 flex space-x-4">
                    <a href="devolucion_pdf.php?folio=<?php echo $prestamo['id_prestamo']; ?>" class="w-full bg-green-500 text-white p-3 rounded-lg shadow hover:bg-green-600 text-center">Devolución</a>
                    <a href="incidencia.php?folio=<?php echo $prestamo['id_prestamo']; ?>" class="w-full bg-red-500 text-white p-3 rounded-lg shadow hover:bg-red-600 text-center">Devolución con Incidencia</a>
                </div>
            </div>
        <?php } ?>
    </div>
</body>
</html>
