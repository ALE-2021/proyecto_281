<?php
session_start();
require_once '../../../conexion.php';

$idSolicitud = filter_input(INPUT_POST, 'id_solicitud', FILTER_VALIDATE_INT);

if ($idSolicitud === false || $idSolicitud === null) {
    echo "ID de solicitud no válido.";
    exit;
}

$productosRegistrados = $_SESSION['productos_registrados'] ?? [];

foreach ($productosRegistrados as $producto) {
    if ($producto['id_solicitud'] == $idSolicitud) {
        $nombreProducto = $producto['nombre_producto'];
        $cantidadSolicitada = $producto['cantidad_solicitada'];


        $sqlActualizarInventario = "UPDATE inventario SET cantidad = cantidad - ? WHERE nombre_prod = ? AND estado = 'disponible'";
        $stmtActualizarInventario = $conn->prepare($sqlActualizarInventario);
        if ($stmtActualizarInventario) {
            $stmtActualizarInventario->bind_param("is", $cantidadSolicitada, $nombreProducto);
            $stmtActualizarInventario->execute();
            $stmtActualizarInventario->close();
        }
    }
}


$sqlCambiarEstado = "UPDATE solicitud SET estado_solicitud = 'entregada' WHERE id_solicitud = ?";
$stmtCambiarEstado = $conn->prepare($sqlCambiarEstado);
if ($stmtCambiarEstado) {
    $stmtCambiarEstado->bind_param("i", $idSolicitud);
    $stmtCambiarEstado->execute();
    $stmtCambiarEstado->close();
}

$conn->close();
unset($_SESSION['productos_registrados']);
header("Location: ../detalleSolicitud.php?id=$idSolicitud");
exit;
?>
