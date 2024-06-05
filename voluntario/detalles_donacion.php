<?php
require_once '../conexion.php';

if (isset($_GET['id_donacion'])) {
    $id_donacion = $_GET['id_donacion'];

    // Obtener detalles de la donación
    $sql_donacion = "SELECT * FROM donacion WHERE id_donacion = ?";
    $stmt_donacion = $conn->prepare($sql_donacion);
    $stmt_donacion->bind_param("i", $id_donacion);
    $stmt_donacion->execute();
    $result_donacion = $stmt_donacion->get_result();
    $donacion = $result_donacion->fetch_assoc();

    // Obtener productos de la donación
    $sql_productos = "SELECT * FROM producto WHERE id_donacion = ?";
    $stmt_productos = $conn->prepare($sql_productos);
    $stmt_productos->bind_param("i", $id_donacion);
    $stmt_productos->execute();
    $result_productos = $stmt_productos->get_result();

    // Calcular el total de productos
    $total_productos = 0;
    while ($producto = $result_productos->fetch_assoc()) {
        $total_productos += $producto['cantidad'];
    }

    // Mostrar detalles de la donación
    echo "<div class='container'>";
    echo "<h3>Detalles de la Donación</h3>";
    echo "<p>ID Donación: " . htmlspecialchars($donacion['id_donacion']) . "</p>";
    echo "<p>Fecha de Recolección: " . htmlspecialchars($donacion['fecha_recojo']) . "</p>";
    echo "<p>Hora de Recolección: " . htmlspecialchars($donacion['hora_recojo']) . "</p>";
    echo "<p>Ubicación: " . htmlspecialchars($donacion['ubicacion']) . "</p>";
    echo "<h4>Productos:</h4>";
    echo "<ul class='list-group'>";
    $result_productos->data_seek(0); // Volver al inicio de los resultados de productos
    while ($producto = $result_productos->fetch_assoc()) {
        echo "<li class='list-group-item'>" . htmlspecialchars($producto['nombre_producto']) . " - Cantidad: " . htmlspecialchars($producto['cantidad']) . "</li>";
    }
    echo "</ul>";
    echo "<p><strong>Total de Productos:</strong> " . htmlspecialchars($total_productos) . "</p>";
    echo "</div>";
} else {
    echo "<p>No se encontró la donación.</p>";
}

$conn->close();
?>
