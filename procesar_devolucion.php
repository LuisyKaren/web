<?php
include 'conexion.php';

if (isset($_POST['folio'])) {
    $folio = mysqli_real_escape_string($con, $_POST['folio']);

    // Verificar si el préstamo existe
    $sql = "SELECT * FROM prestamos WHERE folio = '$folio'";
    $result = mysqli_query($con, $sql);

    if (!$result) {
        die("Error en la consulta: " . mysqli_error($con));
    }

    if ($row = mysqli_fetch_assoc($result)) {
        $herramienta = mysqli_real_escape_string($con, $row['nombre_articulo']);
        $cantidad = (int) $row['cantidad_prestada'];

        // Actualizar el stock de herramientas
        $updateStock = "UPDATE herramientas SET stock_actual = stock_actual + $cantidad WHERE nombre_articulo = '$herramienta'";
        if (mysqli_query($con, $updateStock)) {
            // Eliminar el préstamo de la tabla
            $deletePrestamo = "DELETE FROM prestamos WHERE folio = '$folio'";
            if (mysqli_query($con, $deletePrestamo)) {
                echo "Herramienta devuelta con éxito.";
            } else {
                echo "Error al eliminar el préstamo: " . mysqli_error($con);
            }
        } else {
            echo "Error al actualizar el stock: " . mysqli_error($con);
        }
    } else {
        echo "Error: No se encontró el préstamo.";
    }
} else {
    echo "Error: No se recibió un folio.";
}
?>
