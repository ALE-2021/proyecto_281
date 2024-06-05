<?php
require_once '../../../conexion.php';
if (isset($_POST['id_voluntario']) && isset($_POST['id_solicitud'])) {
    $idVoluntario = $_POST['id_voluntario'];
    $idSolicitud = $_POST['id_solicitud'];
    $sqlEliminarAsignacion = "DELETE FROM entrega WHERE id_voluntario = ? AND id_solicitud = ?";
    $stmtEliminarAsignacion = $conn->prepare($sqlEliminarAsignacion);
    $stmtEliminarAsignacion->bind_param("ii", $idVoluntario, $idSolicitud);

    if ($stmtEliminarAsignacion->execute()) {
        $sqlActualizarEstadoVoluntario = "UPDATE voluntario SET estado_asignacion = 'disponible' WHERE id_voluntario = ?";
        $stmtActualizarEstadoVoluntario = $conn->prepare($sqlActualizarEstadoVoluntario);
        $stmtActualizarEstadoVoluntario->bind_param("i", $idVoluntario);
        $stmtActualizarEstadoVoluntario->execute();
        header("Location: ../detalleSolicitud.php?id=$idSolicitud");
        exit;
    } else {
        echo "Error al cancelar la asignación de voluntario.";
    }
} else {
    echo "Datos incompletos.";
}
?>
