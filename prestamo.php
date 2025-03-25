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
    <title>Formulario de Préstamos</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-lg">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-700">Formulario de Préstamo de Herramientas</h2>
        
        <form action="generar_pdf.php" method="POST" target="_blank" class="space-y-4">
            <div>
                <label for="nombre" class="block text-gray-600 mb-2">Nombre del Solicitante</label>
                <input type="text" id="nombre" name="nombre" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Ingrese su nombre" required>
            </div>
            <div>
                <label for="fecha_prestamo" class="block text-gray-600 mb-2">Fecha de Préstamo</label>
                <input type="date" id="fecha_prestamo" name="fecha_prestamo" class="w-full p-2 border border-gray-300 rounded-lg" value="<?= date('Y-m-d'); ?>" readonly required>
            </div>
            <div>
                <label for="fecha_entrega" class="block text-gray-600 mb-2">Fecha de Entrega</label>
                <input type="date" id="fecha_entrega" name="fecha_entrega" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>

            <div class="relative">
                <label for="herramienta" class="block text-gray-600 mb-2">Nombre de la Herramienta:</label>
                <input type="text" id="herramienta" class="w-full p-2 border border-gray-300 rounded-lg" autocomplete="off">
                <ul id="herramienta_list" class="bg-white border rounded shadow-sm w-full max-h-40 overflow-auto absolute z-10 hidden"></ul>
                <p id="herramienta_status" class="text-sm mt-1"></p>
            </div>

            <button type="button" id="agregar_herramienta" class="w-full bg-green-500 text-white p-3 rounded-lg shadow hover:bg-green-600">
                Agregar Herramienta
            </button>

            <ul id="lista_herramientas" class="bg-gray-100 p-3 rounded-lg mt-4"></ul>

            <input type="hidden" name="herramientas" id="herramientas_input">

            <div class="flex space-x-4 mt-6">
                <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded-lg shadow hover:bg-blue-600">
                    Guardar y Descargar PDF
                </button>
            </div>
        </form>
    </div>

    <script>
    let herramientasSeleccionadas = [];

    $(document).ready(function () {
        $('#herramienta').on('input', function () {
            let query = $(this).val();
            if (query.length >= 2) {
                $.get("buscar_herramienta.php", { query: query }, function (data) {
                    let items = JSON.parse(data);
                    $('#herramienta_list').empty().removeClass('hidden');

                    if (items.length > 0) {
                        $('#herramienta_status').text("✔ Herramienta disponible").removeClass('text-red-500').addClass('text-green-500');
                        items.forEach(function(item) {
                            $('#herramienta_list').append(
                                `<li class="p-2 cursor-pointer hover:bg-gray-300" onclick="selectHerramienta('${item.nombre_articulo}')">${item.nombre_articulo} (Stock: ${item.stock_actual})</li>`
                            );
                        });
                    } else {
                        $('#herramienta_list').append('<li class="p-2 text-gray-500">No hay herramientas disponibles</li>');
                        $('#herramienta_status').text("✖ La herramienta no existe en la base de datos").removeClass('text-green-500').addClass('text-red-500');
                    }
                });
            } else {
                $('#herramienta_list').empty().addClass('hidden');
                $('#herramienta_status').text('');
            }
        });

        $('#agregar_herramienta').click(function () {
            let herramienta = $('#herramienta').val();
            if (herramienta && !herramientasSeleccionadas.includes(herramienta)) {
                herramientasSeleccionadas.push(herramienta);
                $('#lista_herramientas').append(`<li class="p-2 bg-white shadow rounded-lg flex justify-between">${herramienta} <button onclick="eliminarHerramienta('${herramienta}')" class="text-red-500">X</button></li>`);
                $('#herramientas_input').val(JSON.stringify(herramientasSeleccionadas));
                $('#herramienta').val('');
                $('#herramienta_status').text('');
            }
        });

        $(document).click(function (e) {
            if (!$(e.target).closest('#herramienta, #herramienta_list').length) {
                $('#herramienta_list').empty().addClass('hidden');
            }
        });
    });

    function selectHerramienta(name) {
        $('#herramienta').val(name);
        $('#herramienta_list').empty().addClass('hidden');
        $('#herramienta_status').text("✔ Herramienta seleccionada").removeClass('text-red-500').addClass('text-green-500');
    }

    function eliminarHerramienta(name) {
        herramientasSeleccionadas = herramientasSeleccionadas.filter(h => h !== name);
        $('#herramientas_input').val(JSON.stringify(herramientasSeleccionadas));
        $('#lista_herramientas').find(`li:contains('${name}')`).remove();
    }
    
    </script>
</body>
</html>



















































