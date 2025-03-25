<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: iniciodesesion.html");
    exit;
}

// Obtener información básica del usuario
$usuario_logueado = $_SESSION['usuario'] ?? ''; // Se cambia 'Usuario no definido' a un string vacío
$correo_usuario = $_SESSION['correo'] ?? ''; // Cambiado para evitar mostrar "Correo no definido"
$rol_usuario = $_SESSION['rol'] ?? ''; // Cambiado para evitar mostrar "Rol no definido"
$id_usuario = $_SESSION['id_usuario'] ?? ''; // Cambiado para evitar mostrar "ID no definido"
$fecha_registro = $_SESSION['fecha_registro'] ?? ''; // Cambiado para evitar mostrar "Fecha no disponible"
$puntos = $_SESSION['puntos'] ?? ''; // Cambiado para evitar mostrar "Puntos no disponibles"
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Página de Perfil - Inventario Biblioteca UTN">
    <title>Tu Perfil - Inventario Biblioteca UTN</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-host-cloud.css">
    <link rel="stylesheet" href="assets/css/owl.css">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #74b9ff, #6a1b9a);
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: rgba(51, 51, 51, 0.8) !important;
            backdrop-filter: blur(8px);
            box-shadow: none;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 9999;
        }

        .page-heading {
            background-color: #333;
            color: white;
            padding: 50px 0;
            text-align: center;
            border-radius: 10px;
            margin-top: 90px;
            margin-bottom: 30px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .highlight-box {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 6px 18px rgba(0, 0, 0, 0.15);
            max-width: 600px;
            margin: 0 auto 40px;
        }

        .btn-custom, .btn-danger {
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            text-align: center;
            width: 100%;
            display: block;
            transition: all 0.3s ease-in-out;
        }

        .btn-custom {
            background-color: #6a1b9a;
            color: white;
        }

        .btn-custom:hover {
            background-color: #4a148c;
        }

        .btn-danger {
            background-color: #d32f2f;
        }

        .btn-danger:hover {
            background-color: #b71c1c;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-top: 50px;
        }

        @media (max-width: 768px) {
            .highlight-box {
                padding: 20px;
            }

            .page-heading {
                margin-top: 100px;
            }
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a class="navbar-brand" href="index.php"><h2>Inventario <em>UTN</em></h2></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Page Heading -->
    <div class="page-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Tu Perfil</h1>
                    <p><a href="index.php">Inicio</a> / <span>Tu Perfil</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div class="container">
        <div class="highlight-box">
            <h3>Bienvenido, <?php echo htmlspecialchars($usuario_logueado); ?>!</h3>

            <!-- Botón para ir a editar perfil -->
            <form action="editar_perfil.php" method="GET">
                <button type="submit" class="btn btn-custom">Editar Perfil</button>
            </form>

            <!-- Botón para Eliminar Usuario -->
            <form action="eliminar_usuario.php" method="POST" style="margin-top: 15px;">
                <input type="hidden" name="usuario_id" value="<?php echo htmlspecialchars($id_usuario); ?>">
                <button type="submit" class="btn btn-danger">Eliminar Usuario</button>
            </form>

            <!-- Botón para Cerrar Sesión -->
            <a href="logout.php" class="btn btn-custom" style="margin-top: 15px;">Cerrar sesión</a>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Inventario UTN. Todos los derechos reservados.</p>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
