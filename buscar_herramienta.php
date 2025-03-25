<?php
include 'conexion.php';

if (isset($_GET['query'])) {
    $search = $conn->real_escape_string($_GET['query']);
    $sql = "SELECT id_articulo, nombre_articulo, stock_actual 
            FROM articulos 
            WHERE nombre_articulo LIKE '%$search%' 
            LIMIT 10";
    $result = $conn->query($sql);

    $articulos = [];
    while ($row = $result->fetch_assoc()) {
        $articulos[] = $row;
    }
    echo json_encode($articulos);
}
?>
