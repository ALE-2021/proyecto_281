<?php
session_start(); // Iniciar o reanudar la sesión

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['producto']) && isset($_POST['peso']) && isset($_POST['cantidad'])) {
    $producto = $_POST['producto'];
    $peso = $_POST['peso'];
    $cantidad = $_POST['cantidad'];

    // Crear o actualizar 
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    }

    // Agregar el producto al carrito
    $_SESSION['carrito'][] = array(
        'producto' => $producto,
        'peso' => $peso,
        'cantidad' => $cantidad
    );
}

// Eliminar un producto del carrito
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar']) && isset($_POST['indice'])) {
    $indice = $_POST['indice'];
    if (isset($_SESSION['carrito'][$indice])) {
        unset($_SESSION['carrito'][$indice]);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ubicacion']) && isset($_POST['fecha']) && isset($_POST['hora'])) {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "proyecto";

    $conn = new mysqli($servername, $username, $password, $database);


    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $conn->begin_transaction();

    try {
        $ubicacion = $conn->real_escape_string($_POST['ubicacion']);
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];
        $estado = "pendiente";

        $sql_donacion = "INSERT INTO donacion (fecha_recojo, hora_recojo, estado, ubicacion)
                         VALUES ('$fecha', '$hora', '$estado', '$ubicacion')";
        $conn->query($sql_donacion);
        $id_donacion = $conn->insert_id;

        // Obtener el id del donante desde la sesión
        $id_donante = isset($_SESSION['id_donante']) ? $_SESSION['id_donante'] : null;

        foreach ($_SESSION['carrito'] as $producto) {
            $nombre_producto = $conn->real_escape_string($producto['producto']);
            $cantidad_producto = $producto['cantidad'];

            $sql_producto = "INSERT INTO producto (nombre_producto, cantidad, id_donacion)
                             VALUES ('$nombre_producto', $cantidad_producto, $id_donacion)";
            $conn->query($sql_producto);
        }

        // Relacionar la donación con el donante en la tabla donante
        $sql_relacion_donante = "UPDATE donacion SET id_donante = $id_donante WHERE id_donacion = $id_donacion";
        $conn->query($sql_relacion_donante);

        // Confirmar la transacción
        $conn->commit();

        // Limpiar el carrito
        unset($_SESSION['carrito']);

        header('Location: catalogo.php');
    } catch (Exception $e) {
        // Si hay un error, revertir la transacción
        $conn->rollback();
        echo "Error al registrar la donación: " . $e->getMessage();
    }

    // Cerrar la conexión
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Donación</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            text-align: center;
        }

        th {
            background-color: #343a40;
            color: #ffffff;
        }

        .btn-danger {
            background-color: #28a745; /* Color verde */
            border-color: #28a745; /* Borde verde */
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Registro de Donación</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Reporte</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="catalogo.php">Atras</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="jumbotron" style="padding: 20px;">
            <h1 class="display-5" style="font-size: 2rem;">Bienvenido al Carrito de Donación</h1>
            <p class="lead" style="font-size: 1rem;">Aquí puedes registrar tus donaciones y gestionar tus productos.</p>
            <hr class="my-2" style="margin-top: 10px; margin-bottom: 10px;">
            <p style="font-size: 0.9rem;">Comience agregando productos al carrito y complete el formulario para registrar su donación.</p>
        </div>

        <div class="text-left mb-2">
            <a href="fpdf/PruebaV.php" target="_blank" class="btn btn-primary">
                <i class="fas fa-file-pdf mr-2"></i>Generar Reporte
            </a>
        </div>

    </div>


    <div class="container mt-5">
        <h2>Productos en el Carrito</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Peso (kg)</th>
                    <th>Cantidad</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])): ?>
                    <?php foreach($_SESSION['carrito'] as $indice => $producto): ?>
                        <tr>
                            <td><?= $producto['producto'] ?></td>
                            <td><?= $producto['peso'] ?></td>
                            <td><?= $producto['cantidad'] ?></td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="indice" value="<?= $indice ?>">
                                    <button type="submit" name="eliminar" class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No hay productos en el carrito.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="container mt-5">
        <h2>Registrar Donación</h2>
        <form method="POST">
            <div class="form-group">
                <label for="ubicacion">Ubicación de entrega:</label>
                <input type="text" id="ubicacion" name="ubicacion" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="fecha">Fecha de entrega:</label>
                <input type="date" id="fecha" name="fecha" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="hora">Hora de entrega:</label>
                <input type="time" id="hora" name="hora" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrar Donación</button>
            <!-- Campo oculto para el id_donante -->
            <input type="hidden" name="id_donante" value="<?php echo isset($_SESSION['id_donante']) ? $_SESSION['id_donante'] : ''; ?>">
        </form>
    </div>
</body>
</html>
