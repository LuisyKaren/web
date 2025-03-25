<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        die("Error: ID de artículo no proporcionado.");
    }

    $id = intval($_POST['id']);
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $unidad_medida = trim($_POST['unidad_medida']);
    $stock_actual = intval($_POST['stock_actual']);

    $sql = "UPDATE articulos SET nombre_articulo = ?, descripcion = ?, unidad_medida = ?, stock_actual = ? WHERE id_articulo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $nombre, $descripcion, $unidad_medida, $stock_actual, $id);

    if ($stmt->execute()) {
        echo "Artículo actualizado correctamente.";
        header("Location: index.php");
exit;

    } else {
        echo "Error al actualizar el artículo.";
    }

    $stmt->close();
    $conn->close();
}
?>
