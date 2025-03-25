<?php
include 'conexion.php'; // Asegúrate de que tienes este archivo para la conexión a la BD

if (isset($_GET['q'])) {
    $busqueda = $_GET['q'];
    $query = "SELECT * FROM articulos WHERE nombre_articulo LIKE ?";
    
    $stmt = $conn->prepare($query);
    $busqueda = "%$busqueda%";
    $stmt->bind_param("s", $busqueda);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h2>Resultados de la búsqueda:</h2>";
    if ($result->num_rows > 0) {
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>" . htmlspecialchars($row['nombre_articulo']) . " - " . htmlspecialchars($row['descripcion']) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "No se encontraron resultados.";
    }
    
    $stmt->close();
    $conn->close();
}
?>
