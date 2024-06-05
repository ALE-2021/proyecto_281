<?php
require_once '../../../conexion.php';

// Obtener el id_voluntario desde el formulario
$idVoluntario = filter_input(INPUT_POST, 'id_voluntario', FILTER_VALIDATE_INT);

// Obtener el id_receptor desde el formulario
$idReceptor = filter_input(INPUT_POST, 'id_receptor', FILTER_VALIDATE_INT);

// Verificar si se proporcionaron valores válidos
if ($idVoluntario === false || $idVoluntario === null || $idReceptor === false || $idReceptor === null) {
    echo "ID de voluntario o ID de receptor no válidos.";
    exit;
}

// Consultar la id_solicitud asociada al id_receptor
$sqlSolicitudReceptor = "SELECT id_solicitud FROM solicitud WHERE id_receptor = ?";
$stmtSolicitudReceptor = $conn->prepare($sqlSolicitudReceptor);
$stmtSolicitudReceptor->bind_param("i", $idReceptor);
$stmtSolicitudReceptor->execute();
$resultSolicitudReceptor = $stmtSolicitudReceptor->get_result();

// Verificar si se encontró una solicitud para el receptor dado
if ($resultSolicitudReceptor->num_rows > 0) {
    // Obtener la primera fila (asumiendo que solo hay una solicitud por receptor)
    $row = $resultSolicitudReceptor->fetch_assoc();
    $idSolicitud = $row['id_solicitud'];

    // Lógica para asignar el voluntario a la solicitud mediante la tabla entrega
    $sqlAsignarVoluntario = "INSERT INTO entrega (id_voluntario, id_receptor, estado_entrega, fecha_entrega) 
                             VALUES (?, ?, 'pendiente', NOW())";
    $stmtAsignarVoluntario = $conn->prepare($sqlAsignarVoluntario);
    $stmtAsignarVoluntario->bind_param("ii", $idVoluntario, $idReceptor);

    // Ejecutar la consulta de asignación de voluntarios
    if ($stmtAsignarVoluntario->execute()) {
        // Actualizar el estado de asignación del voluntario si es necesario
        $sqlActualizarEstadoVoluntario = "UPDATE voluntario SET estado_asignacion = 'asignado' WHERE id_voluntario = ?";
        $stmtActualizarEstadoVoluntario = $conn->prepare($sqlActualizarEstadoVoluntario);
        $stmtActualizarEstadoVoluntario->bind_param("i", $idVoluntario);
        $stmtActualizarEstadoVoluntario->execute();

        header("Location: detalleSolicitud.php?id=$idSolicitud");
        exit;
    } else {
        echo "Error al asignar voluntario: " . $stmtAsignarVoluntario->error;
    }
} else {
    echo "No se encontró ninguna solicitud para el receptor dado.";
}

$conn->close();
?>





<?php
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
if (!$stmtDetalleSolicitud) {
    echo "Error en la preparación de la consulta: " . $conn->error;
    exit;
}
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
    if (!$resultListaVoluntarios) {
        echo "Error en la consulta de voluntarios disponibles: " . $conn->error;
        exit;
    }


    $sqlVoluntariosAsignados = "SELECT v.id_voluntario, u.nombre, u.apellido, u.celular, v.dia_disponible, v.horario
                                FROM usuario u
                                JOIN voluntario v ON u.id_usuario = v.id_usuario
                                JOIN entrega e ON v.id_voluntario = e.id_voluntario
                                WHERE e.id_solicitud = ?";
    $stmtVoluntariosAsignados = $conn->prepare($sqlVoluntariosAsignados);
    if (!$stmtVoluntariosAsignados) {
        echo "Error en la preparación de la consulta: " . $conn->error;
        exit;
    }
    $stmtVoluntariosAsignados->bind_param("i", $idSolicitud);
    $stmtVoluntariosAsignados->execute();
    $resultVoluntariosAsignados = $stmtVoluntariosAsignados->get_result();


    $sqlProductosSolicitados = "SELECT nombre_producto, cantidad
                                FROM solicitud_productos
                                WHERE id_solicitud = ?";
    $stmtProductosSolicitados = $conn->prepare($sqlProductosSolicitados);
    if (!$stmtProductosSolicitados) {
        echo "Error en la preparación de la consulta: " . $conn->error;
        exit;
    }
    $stmtProductosSolicitados->bind_param("i", $idSolicitud);
    $stmtProductosSolicitados->execute();
    $resultProductosSolicitados = $stmtProductosSolicitados->get_result();


    $todosProductosDisponibles = true;
    while ($productoSolicitado = $resultProductosSolicitados->fetch_assoc()) {
        $nombreProducto = $productoSolicitado['nombre_producto'];
        $cantidadSolicitada = $productoSolicitado['cantidad'];

        // Consulta para verificar el inventario
        $sqlInventario = "SELECT cantidad FROM inventario WHERE nombre_prod = ? AND estado = 'disponible'";
        $stmtInventario = $conn->prepare($sqlInventario);
        if (!$stmtInventario) {
            echo "Error en la preparación de la consulta: " . $conn->error;
            exit;
        }
        $stmtInventario->bind_param("s", $nombreProducto);
        $stmtInventario->execute();
        $resultInventario = $stmtInventario->get_result();

        if ($resultInventario->num_rows === 0) {
            $todosProductosDisponibles = false;
            break;
        }

        $inventario = $resultInventario->fetch_assoc();
        if ($inventario['cantidad'] < $cantidadSolicitada) {
            $todosProductosDisponibles = false;
            break; 
        }
    }


    if ($todosProductosDisponibles) {
        $sqlActualizarEstadoSolicitud = "UPDATE solicitud SET estado_solicitud = 'aceptada' WHERE id_solicitud = ?";
        $stmtActualizarEstadoSolicitud = $conn->prepare($sqlActualizarEstadoSolicitud);
        if (!$stmtActualizarEstadoSolicitud) {
            echo "Error en la preparación de la consulta: " . $conn->error;
            exit;
        }
        $stmtActualizarEstadoSolicitud->bind_param("i", $idSolicitud);
        $stmtActualizarEstadoSolicitud->execute();
    }

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Detalle de Solicitud</h1>
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
    <h2>Detalles de los Productos Solicitados</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nombre del Producto</th>
                <th>Cantidad Solicitada</th>
                <th>Estado en el Inventario</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($producto = $resultProductosSolicitados->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                    <td><?php echo htmlspecialchars($producto['cantidad']); ?></td>
                    <td>
                        <?php if ($todosProductosDisponibles): ?>
                            <span class="text-success">Disponible</span>
                        <?php else: ?>
                            <span class="text-danger">No Disponible</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h2>Voluntarios Asignados</h2>
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
                        <form method="POST" action="cancelarAsignacion.php">
                            <input type="hidden" name="id_voluntario" value="<?php echo htmlspecialchars($voluntarioAsignado['id_voluntario']); ?>">
                            <input type="hidden" name="id_solicitud" value="<?php echo $idSolicitud; ?>">
                            <button type="submit" name="cancelar_asignacion" class="btn btn-danger">Cancelar Asignación</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h2>Asignar Voluntarios</h2>
    <form method="POST" action="asignarVoluntarios.php">
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

    <a href="listaSolicitudes.php" class="btn btn-primary mt-4">Volver a la Lista de Solicitudes</a>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

</body>
</html>



<?php
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

    $todosProductosDisponibles = true; 
    while ($producto = $resultProductosSolicitados->fetch_assoc()) {
        if ($producto['estado_inventario'] !== 'Disponible') {
            $todosProductosDisponibles = false;
            break; 
        }
    }
    

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Detalle de Solicitud</h1>
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
        <h2>Detalles de los Productos Solicitados</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nombre del Producto</th>
                    <th>Cantidad</th>
                    <th>Disponibilidad en Inventario</th> 
                </tr>
            </thead>
            <tbody>
                <?php while ($producto = $resultProductosSolicitados->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                        <td><?php echo htmlspecialchars($producto['cantidad']); ?></td>
                        <td><?php echo htmlspecialchars($producto['estado_inventario']); ?></td> 
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php if ($todosProductosDisponibles): ?>
            <form method="POST" action="aceptarSol.php">
                <input type="hidden" name="id_solicitud" value="<?php echo $idSolicitud; ?>">
                <button type="submit" name="aceptar_solicitud" class="btn btn-primary">Aceptar Solicitud</button>
            </form>
        <?php endif; ?>

        <?php if ($todosProductosDisponibles): ?>
            <form method="POST" action="registraSol.php">
                <input type="hidden" name="id_solicitud" value="<?php echo $idSolicitud; ?>">
                <button type="submit" name="registrar_solicitud" class="btn btn-success">Registrar Solicitud</button>
            </form>
        <?php endif; ?>


        <!-- Voluntarios Asignados -->
        <h2>Voluntarios Asignados</h2>
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
                            <form method="POST" action="cancelarAsignacion.php">
                                <input type="hidden" name="id_voluntario" value="<?php echo htmlspecialchars($voluntarioAsignado['id_voluntario']); ?>">
                                <input type="hidden" name="id_solicitud" value="<?php echo $idSolicitud; ?>">
                                <button type="submit" name="cancelar_asignacion" class="btn btn-danger" formaction="php/cancelarAsig.php">Cancelar Asignación</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Asignar Voluntarios -->
        <h2>Asignar Voluntarios</h2>
        <form method="POST" action="asignarVol.php">
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

        <a href="listaSolicitudes.php" class="btn btn-primary mt-4">Volver a la Lista de Solicitudes</a>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>


