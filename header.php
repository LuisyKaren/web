<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($titulo) ? $titulo : 'Inventario UTN'; ?></title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-host-cloud.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <style>
        body { 
            font-family: 'Roboto', sans-serif; 
            background: linear-gradient(135deg, #74b9ff, #6a1b9a); 
            margin: 0; 
            padding: 0; 
            display: flex; 
            flex-direction: column; 
            min-height: 100vh;
        }
        .navbar { 
            background-color: rgba(51, 51, 51, 0.7) !important; 
            backdrop-filter: blur(10px); 
            position: fixed; 
            width: 100%; 
            top: 0; 
            z-index: 9999; 
        }
        .page-heading { 
            background-color: #333; 
            color: white; 
            padding: 60px 0; 
            text-align: center; 
            margin-top: 80px; 
            margin-bottom: 50px; 
        }
        .highlight-box { 
            background-color: #fff; 
            padding: 30px; 
            border-radius: 10px; 
            box-shadow: 0px 6px 18px rgba(0, 0, 0, 0.1); 
            max-width: 600px; 
            margin: auto; 
        }
        .btn-custom { 
            background-color: #6a1b9a; 
            color: white; 
            padding: 10px 20px; 
            border-radius: 5px; 
            text-decoration: none; 
            width: 100%; 
            display: block; 
            text-align: center; 
        }
        .btn-danger { background-color: #d32f2f; color: white; }
        footer { 
            background-color: #333; 
            color: white; 
            text-align: center; 
            padding: 20px 0; 
            margin-top: auto; 
        }
        .form-container { 
            background: white; 
            padding: 20px; 
            border-radius: 10px; 
            box-shadow: 0px 6px 18px rgba(0, 0, 0, 0.1); 
            width: 100%; 
            max-width: 400px; 
            text-align: center; 
        }
        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 80px;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a class="navbar-brand" href="index.php"><h2>Inventario <em>UTN</em></h2></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="container">
