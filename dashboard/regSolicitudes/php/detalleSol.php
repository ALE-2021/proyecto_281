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

    $conn->close();
} else {
    echo "Solicitud no encontrada.";
    exit;
}

?>
