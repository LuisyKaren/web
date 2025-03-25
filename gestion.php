<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: iniciodesesion.html");
    exit;
}

$usuario_logueado = $_SESSION['usuario'];
$correo_usuario = $_SESSION['correo'];
$rol_usuario = $_SESSION['rol'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tu Perfil - Inventario Biblioteca UTN</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-host-cloud.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <style>
        body { font-family: 'Roboto', sans-serif; background: linear-gradient(135deg, #74b9ff, #6a1b9a); margin: 0; padding: 0; }
        .navbar { background-color: rgba(51, 51, 51, 0.7) !important; backdrop-filter: blur(10px); position: fixed; width: 100%; top: 0; z-index: 9999; }
        .page-heading { background-color: #333; color: white; padding: 60px 0; text-align: center; margin-top: 80px; margin-bottom: 50px; }
        .highlight-box { background-color: #fff; padding: 30px; border-radius: 10px; box-shadow: 0px 6px 18px rgba(0, 0, 0, 0.1); max-width: 600px; margin: auto; }
        .btn-custom { background-color: #6a1b9a; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; width: 100%; display: block; text-align: center; }
        .btn-danger { background-color: #d32f2f; color: white; }
        footer { background-color: #333; color: white; text-align: center; padding: 20px 0; margin-top: 50px; }
        .form-container { background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 6px 18px rgba(0, 0, 0, 0.1); margin-top: 20px; }
        .form-container input, .form-container button { width: 100%; margin-top: 10px; padding: 10px; }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a class="navbar-brand" href="#"><h2>Inventario <em>UTN</em></h2></a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="page-heading header-text">
        <div class="container">
            <h1>INVENTARIO DE MATERIAL EN BODEGA DE VINCULACION</h1>
        </div>
    </div>
        
        <div class="form-container">
            <h3>Agregar Nuevo Producto</h3>
            <form id="add-product-form">
                <input type="text" id="new-name" placeholder="Nombre del producto" required>
                <input type="text" id="new-description" placeholder="Descripción" required>
                <input type="text" id="new-unit" placeholder="Unidad de medida" required>
                <input type="number" id="new-stock" placeholder="Stock inicial" required>
                <button type="submit">Agregar</button>
            </form>
        </div>
    </div>

    <style>
            
            /* Estilos del formulario de agregar productos */
            .form-container {
                width: 50%;
                margin: auto;
                background: rgba(255, 255, 255, 0.1);
                padding: 20px;
                border-radius: 10px;
                text-align: center;
            }
            
            .form-container input {
                display: block;
                width: 100%;
                padding: 10px;
                margin: 5px 0;
                border-radius: 5px;
            }
            
            .form-container button {
                background: green;
                color: white;
                border: none;
                padding: 10px;
                cursor: pointer;
            }
            </style>

<script>
            
            // Agregar producto
            document.getElementById('add-product-form').addEventListener('submit', function(e) {
                e.preventDefault();
            
                let formData = new FormData();
                formData.append('nombre', document.getElementById('new-name').value);
                formData.append('descripcion', document.getElementById('new-description').value);
                formData.append('unidad_medida', document.getElementById('new-unit').value);
                formData.append('stock', document.getElementById('new-stock').value);
            
                fetch('agregar_articulo.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    location.reload();
                })
                .catch(error => console.error('Error:', error));
            });
            
            </script>

    <footer>
        <p>&copy; 2025 Inventario UTN. Todos los derechos reservados.</p>
    </footer>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
