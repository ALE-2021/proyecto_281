<?php
session_start();
require_once '../../../conexion.php';

$idSolicitud = filter_input(INPUT_POST, 'id_solicitud', FILTER_VALIDATE_INT);
$nombreProducto = filter_input(INPUT_POST, 'nombre_producto', FILTER_SANITIZE_STRING);
$cantidadSolicitada = filter_input(INPUT_POST, 'cantidad_solicitada', FILTER_VALIDATE_INT);
$cantidadDisponible = filter_input(INPUT_POST, 'cantidad_disponible', FILTER_VALIDATE_INT);

if ($idSolicitud === false || $idSolicitud === null || !$nombreProducto || $cantidadSolicitada === false) {
    echo "Datos no válidos.";
    exit;
}

if (!isset($_SESSION['productos_registrados'])) {
    $_SESSION['productos_registrados'] = [];
}

$_SESSION['productos_registrados'][] = [
    'id_solicitud' => $idSolicitud,
    'nombre_producto' => $nombreProducto,
    'cantidad_solicitada' => $cantidadSolicitada,
    'cantidad_disponible' => $cantidadDisponible,
];

header("Location: ../detalleSolicitud.php?id=$idSolicitud");
exit;
?>
