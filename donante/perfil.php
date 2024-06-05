<?php
session_start();
include '../conexion.php';

// Verifica si se inicio sesion
if (!isset($_SESSION['id_donante'])) {
    header("Location: inicip.php");
    exit;
}
//obtner la informacionde usuario
function obtenerInformacionUsuario($conn, $id_donante) {
    $informacion_usuario = array();

    // consulta
    $sql = "SELECT nombre, apellido, ci, correo, celular 
            FROM usuario u 
            INNER JOIN donante d ON u.id_usuario = d.id_usuario 
            WHERE d.id_donante = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $id_donante);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $informacion_usuario = $result->fetch_assoc();
    }

    $stmt->close();

    return $informacion_usuario;
}

// Obtener el ID del donante de la sesión
$id_donante = $_SESSION['id_donante'];
$informacion_usuario = obtenerInformacionUsuario($conn, $id_donante);

// Mostrar la información del usuario
$nombre = $informacion_usuario['nombre'] ?? '';
$apellido = $informacion_usuario['apellido'] ?? '';
$ci = $informacion_usuario['ci'] ?? '';
$correo = $informacion_usuario['correo'] ?? '';
$celular = $informacion_usuario['celular'] ?? '';

// Manejar el envío del formulario de actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos enviados por el formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $ci = $_POST['ci'];
    $correo = $_POST['correo'];
    $celular = $_POST['celular'];

    // Actualizar la información del usuario en la base de datos
    $sql = "UPDATE usuario u
            INNER JOIN donante d ON u.id_usuario = d.id_usuario
            SET u.nombre = ?, u.apellido = ?, u.ci = ?, u.correo = ?, u.celular = ?
            WHERE d.id_donante = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $nombre, $apellido, $ci, $correo, $celular, $id_donante);
    $stmt->execute();

    // Redirigir a la página de perfil después de la actualización
    header("Location: perfil.php");
    exit;
}

// Cerrar la conexión
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Perfil</title>
    <!-- Enlace a Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        form {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
        }
        label {
            font-weight: bold;
        }
        .btn-update {
            display: block;
            width: 100%;
            margin-top: 20px;
        }
        @media (max-width: 576px) {
            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <!-- Cabecera responsiva -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Logo</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="catalogo.php">Atras</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <h1>Actualizar Perfil</h1>
        <form method="post">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($informacion_usuario['nombre']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido:</label>
                <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo htmlspecialchars($informacion_usuario['apellido']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="ci" class="form-label">CI:</label>
                <input type="text" class="form-control" id="ci" name="ci" value="<?php echo htmlspecialchars($informacion_usuario['ci']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo:</label>
                <input type="email" class="form-control" id="correo" name="correo" value="<?php echo htmlspecialchars($informacion_usuario['correo']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="celular" class="form-label">Celular:</label>
                <input type="text" class="form-control" id="celular" name="celular" value="<?php echo htmlspecialchars($informacion_usuario['celular']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
