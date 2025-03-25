<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: iniciodesesion.html");
    exit;
}

$usuario_logueado = $_SESSION['usuario'];
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
   
        
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devolución de Herramientas</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded-lg shadow-md w-96">
        <h2 class="text-xl font-bold text-center mb-4">Devolución de Herramientas</h2>

        <!-- Campo para ingresar folio -->
        <label for="folio" class="block text-gray-600 mb-2">Folio del Préstamo:</label>
        <input type="text" id="folio" name="folio" class="w-full p-2 border border-gray-300 rounded-lg" autocomplete="off">
        <p id="folio_status" class="text-sm mt-1"></p> <!-- Mensaje dinámico -->

        <!-- Información del préstamo -->
        <div id="prestamo_info" class="hidden mt-4 p-4 bg-gray-50 border rounded-lg">
            <p><strong>Herramienta:</strong> <span id="herramienta_nombre"></span></p>
            <p><strong>Cantidad:</strong> <span id="cantidad_prestada"></span></p>
            <p><strong>Fecha de Préstamo:</strong> <span id="fecha_prestamo"></span></p>
            <p><strong>Responsable:</strong> <span id="responsable"></span></p>

            <!-- Botones de acción -->
            <div class="flex justify-between mt-4">
                <button id="btnDevolucion" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Devolución</button>
                <button id="btnIncidencia" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">Incidencia</button>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function () {
        $('#folio').on('input', function () {
            let folio = $(this).val();

            if (folio.length > 2) {
                $.get("buscar_prestamo.php", { folio: folio }, function (data) {
                    if (data.encontrado) {
                        $('#folio_status').text("✔ Préstamo encontrado").removeClass('text-red-500').addClass('text-green-500');
                        $('#prestamo_info').removeClass('hidden');
                        $('#herramienta_nombre').text(data.herramienta);
                        $('#cantidad_prestada').text(data.cantidad);
                        $('#fecha_prestamo').text(data.fecha);
                        $('#responsable').text(data.responsable);
                    } else {
                        $('#folio_status').text("✖ Folio no encontrado").removeClass('text-green-500').addClass('text-red-500');
                        $('#prestamo_info').addClass('hidden');
                    }
                }, "json");
            } else {
                $('#folio_status').text('');
                $('#prestamo_info').addClass('hidden');
            }
        });

        $('#btnDevolucion').click(function () {
            $.post("procesar_devolucion.php", { folio: $('#folio').val() }, function (response) {
                alert(response);
                location.reload();
            });
        });

        $('#btnIncidencia').click(function () {
            window.location.href = "incidencia.php?folio=" + $('#folio').val();
        });
    });
    </script>
</body>
</html>
