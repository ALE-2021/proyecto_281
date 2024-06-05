<?php
session_start(); // Inicia la sesión

// Incluir el archivo de conexión a la base de datos
include '../../conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recuperar el id_receptor de la sesión
    $id_receptor = $_SESSION['id_receptor'];
    $descripcion = $_POST['descripcion'];
    $productos = json_decode($_POST['productos'], true);

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    try {
        // Iniciar la transacción
        $conn->autocommit(false);

        // Insertar en la tabla 'solicitud' con fecha actual y estado 'Pendiente'
        $sql = "INSERT INTO solicitud (fecha_solicitud, estado_solicitud, descripcion_sol, id_receptor) VALUES (CURRENT_DATE, 'Pendiente', ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Error al preparar la consulta: " . $conn->error);
        }
        $stmt->bind_param("si", $descripcion, $id_receptor);
        $stmt->execute();
        
        // Obtener el ID de la solicitud insertada
        $solicitud_id = $conn->insert_id;

        // Insertar en la tabla 'solicitud_productos'
        foreach ($productos as $producto) {
            $nombre_producto = $producto['nombre_producto'];
            $cantidad = $producto['cantidad'];

            // Preparar la consulta SQL para insertar en 'solicitud_productos'
            $sql_productos = "INSERT INTO solicitud_productos (id_solicitud, nombre_producto, cantidad) VALUES (?, ?, ?)";
            $stmt_productos = $conn->prepare($sql_productos);
            $stmt_productos->bind_param("iss", $solicitud_id, $nombre_producto, $cantidad);
            $stmt_productos->execute();
        }

        // Confirmar la transacción
        $conn->commit();
        $conn->autocommit(true);

        header('Location: ../receptor.php');
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    // Cerrar la conexión
    $conn->close();
}
?>