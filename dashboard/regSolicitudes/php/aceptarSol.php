<?php
session_start();
require_once '../../../conexion.php';

$idSolicitud = filter_input(INPUT_POST, 'id_solicitud', FILTER_VALIDATE_INT);

if ($idSolicitud === false || $idSolicitud === null) {
    echo "ID de solicitud no válido.";
    exit;
}

$sqlAceptarSolicitud = "UPDATE solicitud SET estado_solicitud = 'aceptada' WHERE id_solicitud = ?";
$stmtAceptarSolicitud = $conn->prepare($sqlAceptarSolicitud);
$stmtAceptarSolicitud->bind_param("i", $idSolicitud);

if ($stmtAceptarSolicitud->execute()) {
    echo "Solicitud aceptada.";
} else {
    echo "Error al aceptar la solicitud.";
}

$conn->close();
header("Location: ../detalleSolicitud.php?id=$idSolicitud");
exit;
?>
