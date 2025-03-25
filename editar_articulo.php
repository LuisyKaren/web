<?php
$titulo = "Inicio - Inventario UTN";
include 'header.php';
?>

<?php
require 'conexion.php'; // Asegúrate de que este archivo contiene la conexión a tu base de datos

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Solicitud no válida: ID de artículo no proporcionado.");
}

$id = intval($_GET['id']); // Sanitizar el ID para evitar SQL Injection

// Consultar los datos actuales del producto
$sql = "SELECT * FROM articulos WHERE id_articulo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Error: El artículo no existe.");
}

$articulo = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Artículo</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin: 40px; }
        form { width: 50%; margin: auto; background: #f4f4f4; padding: 20px; border-radius: 10px; }
        input, button { width: 100%; padding: 10px; margin: 5px 0; border-radius: 5px; }
        button { background: blue; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>

<form action="actualizar_articulo.php" method="post">
    <h2>Editar Artículo</h2> <!-- Título dentro del formulario -->

    <input type="hidden" name="id" value="<?= $articulo['id_articulo'] ?>">
    
    <label>Nombre del producto:</label>
    <input type="text" name="nombre" value="<?= htmlspecialchars($articulo['nombre_articulo']) ?>" required>

    <label>Descripción:</label>
    <input type="text" name="descripcion" value="<?= htmlspecialchars($articulo['descripcion']) ?>" required>

    <label>Unidad de medida:</label>
    <input type="text" name="unidad_medida" value="<?= htmlspecialchars($articulo['unidad_medida']) ?>" required>

    <label>Stock actual:</label>
    <input type="number" name="stock_actual" value="<?= $articulo['stock_actual'] ?>" required>

    <button type="submit">Guardar Cambios</button>
</form>

</body>
</html>
