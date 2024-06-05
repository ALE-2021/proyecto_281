<?php
require_once '../../conexion.php';
$sqlSolicitudes = "SELECT s.id_solicitud, s.fecha_solicitud, s.estado_solicitud, s.descripcion_sol, u.nombre, u.apellido
                   FROM solicitud s
                   JOIN receptor r ON s.id_receptor = r.id_receptor
                   JOIN usuario u ON r.id_usuario = u.id_usuario";
$resultSolicitudes = $conn->query($sqlSolicitudes);

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
    <title>Lista de Solicitudes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <style>
        nav.navbar {
            background-color: #010b6ad2 !important;
        }
        nav.navbar .navbar-nav .nav-link {
            color: #fff !important;
        }
        .navbar {
        background-color: #101d5d !important;
        }

        .navbar-brand {
            color: #fff;
        }

        .navbar-nav {
            margin-left: auto;
        }

        .navbar-nav .nav-link {
            color: #fff !important;
            font-weight: 600;
            font-size: 16px;
            padding-right: 15px;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link:focus,
        .navbar-nav .nav-link.active {
            color: #ccc !important;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }
        .estado-entregada {
            background-color: #d4edda;
            color: #155724;
        }
        .estado-pendiente {
            background-color: #fff3cd;
            color: #856404;
        }
        .estado-rechazada {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="../../tablero.php" class="nav-link">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a href="../php/normas.php" class="nav-link">Normas</a>
                    </li>
                    <li class="nav-item">
                        <a href="../php/educacion.php" class="nav-link">Educacion</a>
                    </li>
                    <li class="nav-item">
                        <a href="../php/eventos.php" class="nav-link">Eventos</a>
                    </li>
                    <li class="nav-item">
                        <a href="../RegDonaciones/donaciond.php" class="nav-link">Registro de Donaciones</a>
                    </li>
                    <li class="nav-item">
                        <a href="listaSolicitudes.php" class="nav-link">Registro de Solicitudes</a>
                    </li>
                    <li class="nav-item">
                        <a href="../../index.php" class="nav-link">Salir</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h1>Lista de Solicitudes</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Solicitud</th>
                    <th>Fecha de Solicitud</th>
                    <th>Estado</th>
                    <th>Descripción</th>
                    <th>Nombre del Receptor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($solicitud = $resultSolicitudes->fetch_assoc()): ?>
                    <tr class="<?php echo 'estado-' . strtolower($solicitud['estado_solicitud']); ?>">
                        <td><?php echo htmlspecialchars($solicitud['id_solicitud']); ?></td>
                        <td><?php echo htmlspecialchars($solicitud['fecha_solicitud']); ?></td>
                        <td><?php echo htmlspecialchars($solicitud['estado_solicitud']); ?></td>
                        <td><?php echo htmlspecialchars($solicitud['descripcion_sol']); ?></td>
                        <td><?php echo htmlspecialchars($solicitud['nombre'] . ' ' . $solicitud['apellido']); ?></td>
                        <td>
                            <a href="detalleSolicitud.php?id=<?php echo htmlspecialchars($solicitud['id_solicitud']); ?>" class="btn btn-primary">Detalles</a>
                            <?php if ($solicitud['estado_solicitud'] === 'pendiente'): ?>
                                <a href="listaSolicitudes.php?id=<?php echo htmlspecialchars($solicitud['id_solicitud']); ?>&estado=aceptada" class="btn btn-success">Aceptar</a>
                                <a href="listaSolicitudes.php?id=<?php echo htmlspecialchars($solicitud['id_solicitud']); ?>&estado=rechazada" class="btn btn-danger">Rechazar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
