<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: iniciodesesion.html");
    exit;
}

// Obtener información del usuario
$usuario_logueado = $_SESSION['usuario'] ?? 'Usuario no definido';
$correo_usuario = $_SESSION['correo'] ?? 'Correo no definido';
$id_usuario = $_SESSION['id_usuario'] ?? 'ID no definido';
$rol_usuario = $_SESSION['rol'] ?? 'Rol no definido';
$puntos = $_SESSION['puntos'] ?? 'Puntos no disponibles';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Página de Editar Perfil - Inventario Biblioteca UTN">
    <title>Editar Perfil - Inventario Biblioteca UTN</title>

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

        .btn-custom {
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
                    <h1>Editar Perfil</h1>
                    <p><a href="perfil.php">Regresar al perfil</a> / <span>Editar Perfil</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div class="container">
        <div class="highlight-box">
            <h3>Datos de Usuario</h3>

            <form action="actualizar_usuario.php" method="POST">
                <div class="form-group">
                    <label for="correo">Correo Electrónico</label>
                    <input type="email" class="form-control" id="correo" name="correo" value="<?php echo htmlspecialchars($correo_usuario); ?>" required>
                </div>
                <div class="form-group">
                    <label for="rol">Rol</label>
                    <input type="text" class="form-control" id="rol" name="rol" value="<?php echo htmlspecialchars($rol_usuario); ?>" required>
                </div>
                <div class="form-group">
                    <label for="puntos">Puntos</label>
                    <input type="number" class="form-control" id="puntos" name="puntos" value="<?php echo htmlspecialchars($puntos); ?>" required>
                </div>

                <button type="submit" class="btn btn-custom">Actualizar Información</button>
            </form>
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
