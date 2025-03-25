<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    $_SESSION['mensaje_error'] = "Debes iniciar sesión para acceder a esta página.";
    header("Location: iniciodesesion.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página de Inicio - Inventario Biblioteca UTN">
    <title>Inicio - Inventario UTN</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-host-cloud.css">
    <link rel="stylesheet" href="assets/css/owl.css">

    <style>
        /* Estilos personalizados */
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #74b9ff, #6a1b9a);
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: rgba(51, 51, 51, 0.8);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 9999;
            border: none;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand h2 {
            color: #ffffff;
            font-size: 24px;
        }

        .navbar-nav .nav-link {
            color: #ffffff;
        }

        .navbar-nav .nav-link:hover {
            color: #cccccc;
        }

        .banner {
            text-align: center;
            padding: 80px 20px;
            color: white;
            margin-top: 80px;
        }

        .banner h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .banner p {
            font-size: 1.25rem;
            margin-bottom: 40px;
        }

        .search-bar {
            max-width: 600px;
            margin: 20px auto;
            display: flex;
            gap: 10px;
        }

        .search-bar input {
            flex-grow: 1;
            padding: 15px;
            border-radius: 25px;
            border: 1px solid #ccc;
        }

        .search-bar button {
            padding: 15px 30px;
            border-radius: 25px;
            border: none;
            background-color: #6a1b9a;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .search-bar button:hover {
            background-color: #4a148c;
        }

        .features {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 50px 20px;
        }

        .feature-item {
            flex: 1 1 calc(33% - 40px);
            max-width: 300px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        .feature-item img {
            width: 50px;
            margin-bottom: 15px;
        }

        .feature-item h3 {
            font-size: 20px;
            color: #6a1b9a;
            margin-bottom: 10px;
        }

        .feature-item p {
            color: #666;
            font-size: 16px;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px 0;
        }
    </style>
</head>

<body>
    <!-- Barra de navegación -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a class="navbar-brand" href="#"><h2>Inventario <em>UTN</em></h2></a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="gestion.php">Agregar Material</a></li>
                        <li class="nav-item"><a class="nav-link" href="perfil.php">Tu Perfil</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar Sesión</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>



<!-- Encabezado principal -->
 <!-- Encabezado principal -->
 <div class="banner">
        <h1>Bienvenido al Inventario UTN</h1>
        <p>Gestiona artículos, movimientos y usuarios de forma eficiente y sencilla.</p>
        <div class="search-container">
    <form id="search-form">
        <input type="text" id="search-input" class="search-input" placeholder="Buscar productos...">
        <button type="submit" class="search-button"><i class="fas fa-search"></i></button>
    </form>
</div>

<div id="search-results"></div>

<style>
/* Contenedor del buscador */
.search-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 20px 0;
}

/* Estilo del campo de búsqueda */
.search-input {
    width: 300px;
    padding: 12px;
    border: 2px solid rgba(255, 255, 255, 0.28);
    border-radius: 25px;
    background: transparent;
    color: white;
    font-size: 16px;
    outline: none;
    transition: 0.3s;
}

.search-button {
    background: transparent;
    border: none;
    color: white;
    font-size: 18px;
    margin-left: -40px;
    cursor: pointer;
}

#search-results {
    width: 50%;
    margin: auto;
background:                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         rgba(255, 255, 255, 0.34);
    color: white;
    padding: 15px;
    border-radius: 10px;
    text-align: left;
    display: none;
}

.result-item {
    padding: 10px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.5);
    position: relative;
}

.result-item button {
    width: 100%;
    padding: 5px;
    margin-top: 5px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

/* Estilos específicos para los botones */
.result-item .edit-button {
    background: blue;
    color: white;
}

.result-item .delete-button {
    background: red;
    color: white;
}
</style>

<script>
document.getElementById('search-input').addEventListener('input', function() {
    let query = this.value;

    if (query.length < 2) {
        document.getElementById('search-results').style.display = "none";
        return;
    }

    fetch('buscar_articulos.php?query=' + query)
        .then(response => response.json())
        .then(data => {
            let html = "";
            if (data.length > 0) {
                data.forEach(articulo => {
                    html += `<div class="result-item">
                                <strong>${articulo.nombre_articulo}</strong> <br>
                                ${articulo.descripcion} <br>
                                <b>Unidad:</b> ${articulo.unidad_medida} <br>
                                <b>Stock Actual:</b> ${articulo.stock_actual}
                                <button class="delete-button" onclick="eliminarProducto(${articulo.id_articulo})">Eliminar</button>
                                <button class="edit-button" onclick="editarProducto(${articulo.id_articulo})">Editar</button>
                             </div>`;
                });
            } else {
                html = "<p>No se encontraron productos.</p>";
            }

            document.getElementById('search-results').innerHTML = html;
            document.getElementById('search-results').style.display = "block";
        })
        .catch(error => console.error('Error:', error));
});


// Eliminar producto
function eliminarProducto(id) {
    if (confirm("¿Estás seguro de que quieres eliminar este producto?")) {
        let formData = new FormData();
        formData.append('id', id);

        fetch('eliminar_articulo.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload();
        })
        .catch(error => console.error('Error:', error));
    }
}

// Editar producto
function editarProducto(id) {
    window.location.href = `editar_articulo.php?id=${id}`;
}
</script>
            
            
               </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
   

    <!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Herramientas</title>
  <style>
    /* Contenedor que agrupa las características */
    .features-container {
      display: flex;
      justify-content: space-between; /* Espacio entre las tarjetas */
      gap: 20px; /* Espacio entre los elementos */
      flex-wrap: wrap; /* Para que los elementos se ajusten en pantallas pequeñas */
    }

    /* Estilo de cada tarjeta */
    .feature-item {
      width: 30%; /* Ajusta el tamaño de cada tarjeta (ajustable) */
      box-sizing: border-box;
      text-align: center;
    }

    .feature-item img {
      width: 100%; /* Hace que la imagen ocupe todo el ancho del contenedor */
      height: auto;
    }

    .feature-item button {
      margin-top: 10px;
    }
  </style>
</head>
<body>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tu Página</title>
  <style>
    .features-container {
      display: flex;
      justify-content: center;
      gap: 20px; /* Reduce el espacio entre los cuadros */
      padding: 20px;
    }

    .feature-item {
      background: #f8f8f8; /* Fondo para destacar */
      padding: 15px;
      border-radius: 10px;
      text-align: center;
      box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
      width: 250px; /* Ajusta el tamaño */
    }

    .feature-item img {
      width: 100%;
      border-radius: 5px;
    }

    button {
      background: #007bff;
      color: white;
      border: none;
      padding: 10px;
      border-radius: 5px;
      cursor: pointer;
    }

    button:hover {
      background: #0056b3;
    }
  </style>
</head>
<body>

  <!-- Contenedor principal de las características -->
  <div class="features-container">
    <div class="feature-item">
      <img src="assets/images/herramientas.jpg" alt="Gestión de Artículos">
      <h3>Préstamo de herramientas</h3>
      <p>Formulario de prestamo de herramientas.</p>
      <a href="prestamo.php">
        <button>Prestar herramienta</button>
      </a>
    </div>

    <div class="feature-item">
      <img src="assets/images/devolucion.jpg" alt="Control de Movimientos">
      <h3>Devolución de herramientas</h3>
      <p>Formulario de devolucion de prestamos.</p>
      <a href="buscar_prestamo.php">
        <button>Entrega de herramienta</button>
      </a>
    </div>

  </div>

</body>
</html>


    <!-- Pie de página -->
    <footer>
        <p>&copy; 2025 Inventario UTN. Todos los derechos reservados.</p>
    </footer>
</body>

</html>
