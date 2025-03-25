<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $unidad = $_POST['unidad_medida'];
    $stock = $_POST['stock'];

    $sql = "INSERT INTO articulos (nombre_articulo, descripcion, unidad_medida, stock_inicial, stock_actual) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $nombre, $descripcion, $unidad, $stock, $stock);
    
    if ($stmt->execute()) {
        echo "Producto agregado correctamente.";
    } else {
        echo "Error al agregar el producto.";
    }

    $stmt->close();
    $conn->close();
}
?>
