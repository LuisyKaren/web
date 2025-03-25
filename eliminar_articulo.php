<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Paso 1: Eliminar registros relacionados en la tabla movimientos
    $sql_delete_movimientos = "DELETE FROM movimientos WHERE id_articulo = ?";
    $stmt_mov = $conn->prepare($sql_delete_movimientos);
    $stmt_mov->bind_param("i", $id);
    $stmt_mov->execute();
    $stmt_mov->close();

    // Paso 2: Eliminar el artículo después de eliminar los movimientos
    $sql_delete_articulo = "DELETE FROM articulos WHERE id_articulo = ?";
    $stmt_art = $conn->prepare($sql_delete_articulo);
    $stmt_art->bind_param("i", $id);

    if ($stmt_art->execute()) {
        echo "Producto eliminado correctamente.";
    } else {
        echo "Error al eliminar el producto.";
    }

    $stmt_art->close();
    $conn->close();
} else {
    echo "Solicitud no válida.";
}
?>
