<?php
session_start();
require_once '../../conexion.php';
$idSolicitud = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($idSolicitud === false || $idSolicitud === null) {
    echo "ID de solicitud no válido.";
    exit;
}
$sqlDetalleSolicitud = "SELECT s.id_solicitud, s.fecha_solicitud, s.estado_solicitud, s.descripcion_sol,
                               r.id_receptor, u.nombre, u.apellido, u.ci, u.correo, u.celular
                        FROM solicitud s
                        JOIN receptor r ON s.id_receptor = r.id_receptor
                        JOIN usuario u ON r.id_usuario = u.id_usuario
                        WHERE s.id_solicitud = ?";
$stmtDetalleSolicitud = $conn->prepare($sqlDetalleSolicitud);
$stmtDetalleSolicitud->bind_param("i", $idSolicitud);
$stmtDetalleSolicitud->execute();
$resultDetalleSolicitud = $stmtDetalleSolicitud->get_result();
if ($detalleSolicitud = $resultDetalleSolicitud->fetch_assoc()) {
    $idReceptor = $detalleSolicitud['id_receptor'];

    $sqlListaVoluntarios = "SELECT v.id_voluntario, u.nombre, u.apellido, u.celular, v.dia_disponible, v.horario
                            FROM usuario u
                            JOIN voluntario v ON u.id_usuario = v.id_usuario
                            WHERE v.estado_asignacion = 'disponible'";
    $resultListaVoluntarios = $conn->query($sqlListaVoluntarios);

    $sqlVoluntariosAsignados = "SELECT v.id_voluntario, u.nombre, u.apellido, u.celular, v.dia_disponible, v.horario
                                FROM usuario u
                                JOIN voluntario v ON u.id_usuario = v.id_usuario
                                JOIN entrega e ON v.id_voluntario = e.id_voluntario
                                WHERE e.id_solicitud = ?";
    $stmtVoluntariosAsignados = $conn->prepare($sqlVoluntariosAsignados);
    $stmtVoluntariosAsignados->bind_param("i", $idSolicitud);
    $stmtVoluntariosAsignados->execute();
    $resultVoluntariosAsignados = $stmtVoluntariosAsignados->get_result();

    $sqlProductosSolicitados = "SELECT sp.nombre_producto, sp.cantidad, 
                                        i.cantidad AS cantidad_inventario, 
                                        CASE WHEN i.cantidad >= sp.cantidad THEN 'Disponible' ELSE 'No disponible' END AS estado_inventario
                                FROM solicitud_productos sp
                                LEFT JOIN inventario i ON sp.nombre_producto = i.nombre_prod AND i.estado = 'disponible'
                                WHERE sp.id_solicitud = ?";
    $stmtProductosSolicitados = $conn->prepare($sqlProductosSolicitados);
    $stmtProductosSolicitados->bind_param("i", $idSolicitud);
    $stmtProductosSolicitados->execute();
    $resultProductosSolicitados = $stmtProductosSolicitados->get_result();

    $productosRegistrados = $_SESSION['productos_registrados'] ?? [];
    $conn->close();
} else {
    echo "Solicitud no encontrada.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
    <title>Detalle de Solicitud</title>
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

    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.min.js"></script>
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
                        <a href="../../index.php" class="nav-link">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a href="listaSolicitudes.php" class="nav-link">Atras</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container mt-4">
        <h1 class="mb-4">Detalle de Solicitud</h1>

        <div class="row">
            
            <!-- Información del Receptor -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        Información del Receptor
                    </div>
                    <div class="card-body">
                        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($detalleSolicitud['nombre']); ?></p>
                        <p><strong>Apellido:</strong> <?php echo htmlspecialchars($detalleSolicitud['apellido']); ?></p>
                        <p><strong>CI:</strong> <?php echo htmlspecialchars($detalleSolicitud['ci']); ?></p>
                        <p><strong>Correo:</strong> <?php echo htmlspecialchars($detalleSolicitud['correo']); ?></p>
                        <p><strong>Celular:</strong> <?php echo htmlspecialchars($detalleSolicitud['celular']); ?></p>
                    </div>
                </div>
            </div>
            <!-- Información de la Solicitud -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        Información de la Solicitud
                    </div>
                    <div class="card-body">
                        <p><strong>ID Solicitud:</strong> <?php echo htmlspecialchars($detalleSolicitud['id_solicitud']); ?></p>
                        <p><strong>Fecha de Solicitud:</strong> <?php echo htmlspecialchars($detalleSolicitud['fecha_solicitud']); ?></p>
                        <p><strong>Estado:</strong> <?php echo htmlspecialchars($detalleSolicitud['estado_solicitud']); ?></p>
                        <p><strong>Descripción:</strong> <?php echo htmlspecialchars($detalleSolicitud['descripcion_sol']); ?></p>
                        <p><strong>Voluntarios Asignados:</strong> <?php echo $resultVoluntariosAsignados->num_rows; ?></p>
                    </div>
                </div>
            </div>

            
        </div>

        <!-- Detalles de los productos solicitados -->
        <div class="card mb-4">
            <div class="card-header">
                Detalles de los Productos Solicitados
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre del Producto</th>
                            <th>Cantidad Solicitada</th>
                            <th>Disponibilidad en Inventario</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($producto = $resultProductosSolicitados->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                                <td><?php echo htmlspecialchars($producto['cantidad']); ?></td>
                                <td><?php echo htmlspecialchars($producto['estado_inventario']); ?></td>
                                <td>
                                    <?php
                                    $registrado = false;
                                    foreach ($productosRegistrados as $productoRegistrado) {
                                        if ($productoRegistrado['nombre_producto'] == $producto['nombre_producto']) {
                                            $registrado = true;
                                            break;
                                        }
                                    }
                                    ?>
                                    <?php if ($registrado): ?>
                                        <button class="btn btn-secondary" disabled>Registrado</button>
                                    <?php else: ?>
                                        <form method="POST" action="php/registrarProd.php">
                                            <input type="hidden" name="id_solicitud" value="<?php echo $idSolicitud; ?>">
                                            <input type="hidden" name="nombre_producto" value="<?php echo htmlspecialchars($producto['nombre_producto']); ?>">
                                            <input type="hidden" name="cantidad_solicitada" value="<?php echo htmlspecialchars($producto['cantidad']); ?>">
                                            <input type="hidden" name="cantidad_disponible" value="<?php echo htmlspecialchars($producto['cantidad_inventario']); ?>">
                                            <button type="submit" name="donar_producto" class="btn btn-success">Registrar</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Productos registrados -->
        <div class="card mb-4">
            <div class="card-header">
                Productos Registrados
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre del Producto</th>
                            <th>Cantidad Solicitada</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productosRegistrados as $productoRegistrado): ?>
                            <?php if ($productoRegistrado['id_solicitud'] == $idSolicitud): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($productoRegistrado['nombre_producto']); ?></td>
                                    <td><?php echo htmlspecialchars($productoRegistrado['cantidad_solicitada']); ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mb-4">
            <form method="POST" action="php/aceptarSol.php" class="d-inline">
                <input type="hidden" name="id_solicitud" value="<?php echo $idSolicitud; ?>">
                <button type="submit" name="aceptar_solicitud" class="btn btn-primary">Aceptar Solicitud</button>
            </form>
            <?php
            $entregaRegistrada = $detalleSolicitud['estado_solicitud'] === 'entregada';
            ?>
            <form method="POST" action="php/registrarEntrega.php" class="d-inline">
                <input type="hidden" name="id_solicitud" value="<?php echo $idSolicitud; ?>">
                <button type="submit" name="registrar_entrega" class="btn <?php echo $entregaRegistrada ? 'btn-secondary' : 'btn-success'; ?>" <?php echo $entregaRegistrada ? 'disabled' : ''; ?>>
                    <?php echo $entregaRegistrada ? 'Entrega ya registrada' : 'Registrar Entrega'; ?>
                </button>
            </form>
        </div>

        <!-- Voluntarios Asignados -->
        <div class="card mb-4">
            <div class="card-header">
                Voluntarios Asignados
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Celular</th>
                            <th>Día Disponible</th>
                            <th>Hora</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($voluntarioAsignado = $resultVoluntariosAsignados->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($voluntarioAsignado['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($voluntarioAsignado['apellido']); ?></td>
                                <td><?php echo isset($voluntarioAsignado['celular']) ? htmlspecialchars($voluntarioAsignado['celular']) : 'N/A'; ?></td>
                                <td><?php echo htmlspecialchars($voluntarioAsignado['dia_disponible']); ?></td>
                                <td><?php echo htmlspecialchars($voluntarioAsignado['horario']); ?></td>
                                <td>
                                    <form method="POST" action="php/cancelarAsig.php">
                                        <input type="hidden" name="id_voluntario" value="<?php echo htmlspecialchars($voluntarioAsignado['id_voluntario']); ?>">
                                        <input type="hidden" name="id_solicitud" value="<?php echo $idSolicitud; ?>">
                                        <button type="submit" name="cancelar_asignacion" class="btn btn-danger">Cancelar Asignación</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header">
                Asignar Voluntarios
            </div>
            <div class="card-body">
                <form method="POST" action="php/asignarVol.php">
                    <input type="hidden" name="id_solicitud" value="<?php echo $idSolicitud; ?>">
                    <input type="hidden" name="id_receptor" value="<?php echo $idReceptor; ?>">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Celular</th>
                                <th>Día Disponible</th>
                                <th>Hora</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($voluntario = $resultListaVoluntarios->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($voluntario['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($voluntario['apellido']); ?></td>
                                    <td><?php echo isset($voluntario['celular']) ? htmlspecialchars($voluntario['celular']) : 'N/A'; ?></td>
                                    <td><?php echo htmlspecialchars($voluntario['dia_disponible']); ?></td>
                                    <td><?php echo htmlspecialchars($voluntario['horario']); ?></td>
                                    <td>
                                        <input type="hidden" name="id_voluntario" value="<?php echo htmlspecialchars($voluntario['id_voluntario']); ?>">
                                        <button type="submit" name="asignar_voluntario" class="btn btn-success">Asignar</button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>

        <a href="listaSolicitudes.php" class="btn btn-primary mb-4">Volver a la Lista de Solicitudes</a>
    </div>
</body>
</html>
