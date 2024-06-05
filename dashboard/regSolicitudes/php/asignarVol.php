<?php
require_once '../../../conexion.php';

$idSolicitud = filter_input(INPUT_POST, 'id_solicitud', FILTER_VALIDATE_INT);
$idVoluntario = filter_input(INPUT_POST, 'id_voluntario', FILTER_VALIDATE_INT);
$idReceptor = filter_input(INPUT_POST, 'id_receptor', FILTER_VALIDATE_INT);

if ($idSolicitud === false || $idSolicitud === null || $idVoluntario === false || $idVoluntario === null || $idReceptor === false || $idReceptor === null) {
    echo "ID de solicitud, ID de voluntario o ID de receptor no válidos.";
    exit;
}
$sqlAsignarVoluntario = "INSERT INTO entrega (id_voluntario, id_solicitud, estado_entrega, fecha_entrega) 
                         VALUES (?, ?, 'pendiente', NOW())";
$stmtAsignarVoluntario = $conn->prepare($sqlAsignarVoluntario);
$stmtAsignarVoluntario->bind_param("ii", $idVoluntario, $idSolicitud);

if (!$stmtAsignarVoluntario->execute()) {
    echo "Error al asignar voluntario: " . $stmtAsignarVoluntario->error;
    exit;
}

$sqlActualizarEstadoVoluntario = "UPDATE voluntario SET estado_asignacion = 'asignado' WHERE id_voluntario = ?";
$stmtActualizarEstadoVoluntario = $conn->prepare($sqlActualizarEstadoVoluntario);
$stmtActualizarEstadoVoluntario->bind_param("i", $idVoluntario);

if (!$stmtActualizarEstadoVoluntario->execute()) {
    echo "Error al actualizar el estado del voluntario: " . $stmtActualizarEstadoVoluntario->error;
    exit;
}

header("Location: ../detalleSolicitud.php?id=$idSolicitud");
exit;

$conn->close();
?>
