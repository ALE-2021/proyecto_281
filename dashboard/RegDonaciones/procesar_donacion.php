<?php
require_once '../../conexion.php';

$idDonacion = isset($_GET['id']) ? intval($_GET['id']) : (isset($_POST['id']) ? intval($_POST['id']) : null);

if ($idDonacion === null) {
    echo "No se proporcionó un ID de donación válido.";
    exit;
}

$voluntariosAsignados = false;

$sql = "SELECT d.id_donacion, d.fecha_recojo, d.hora_recojo, d.ubicacion, d.estado, u.nombre AS nombre_donante, u.apellido, u.celular
        FROM donacion d
        JOIN donante don ON d.id_donante = don.id_donante
        JOIN usuario u ON don.id_usuario = u.id_usuario
        WHERE d.id_donacion = $idDonacion";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $donacion = $result->fetch_assoc();
} else {
    echo "No se encontraron detalles para esta donación.";
    exit;
}

$sqlProductos = "SELECT id_producto, nombre_producto, cantidad FROM producto WHERE id_donacion = $idDonacion";
$resultProductos = $conn->query($sqlProductos);

$sqlListaVoluntarios = "SELECT v.id_voluntario, u.nombre, u.apellido, u.celular, v.dia_disponible, v.horario
                        FROM voluntario v
                        JOIN usuario u ON v.id_usuario = u.id_usuario
                        LEFT JOIN asignacion_voluntarios av ON v.id_voluntario = av.id_voluntario
                        WHERE (av.id_voluntario IS NULL OR av.estado = 'rechazado') 
                          AND v.estado_asignacion = 'disponible'";
$resultListaVoluntarios = $conn->query($sqlListaVoluntarios);

$sqlVoluntarios = "SELECT u.nombre, u.apellido, u.celular, v.id_voluntario, av.estado
                   FROM asignacion_voluntarios av
                   JOIN voluntario v ON av.id_voluntario = v.id_voluntario
                   JOIN usuario u ON v.id_usuario = u.id_usuario
                   WHERE av.id_donacion = $idDonacion";
$resultVoluntarios = $conn->query($sqlVoluntarios);

if ($resultVoluntarios && $resultVoluntarios->num_rows > 0) {
    $voluntariosAsignados = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['asignar_voluntarios'])) {
        $idVoluntario = intval($_POST['id_voluntario']);
        $sqlAsignar = "INSERT INTO asignacion_voluntarios (id_voluntario, id_donacion, estado, fecha_asignacion) 
                       VALUES ($idVoluntario, $idDonacion, 'pendiente', NOW())";
        if ($conn->query($sqlAsignar) === TRUE) {
            $sqlActualizarEstado = "UPDATE voluntario SET estado_asignacion = 'asignado' WHERE id_voluntario = $idVoluntario";
            if ($conn->query($sqlActualizarEstado) === TRUE) {
                header("Location: detalleDonacion.php?id=$idDonacion");
                exit;
            } else {
                echo "Error al actualizar el estado de asignación del voluntario: " . $conn->error;
            }
        } else {
            echo "Error al asignar voluntario: " . $conn->error;
        }
    }

    if (isset($_POST['cancelar_voluntario'])) {
        $idVoluntarioCancelar = intval($_POST['cancelar_asignacion']);
        $sqlCancelar = "DELETE FROM asignacion_voluntarios WHERE id_voluntario = $idVoluntarioCancelar AND id_donacion = $idDonacion";
        if ($conn->query($sqlCancelar) === TRUE) {
            $sqlActualizarEstadoCancelar = "UPDATE voluntario SET estado_asignacion = 'disponible' WHERE id_voluntario = $idVoluntarioCancelar";
            if ($conn->query($sqlActualizarEstadoCancelar) === TRUE) {
                header("Location: detalleDonacion.php?id=$idDonacion");
                exit;
            } else {
                echo "Error al actualizar el estado de asignación del voluntario: " . $conn->error;
            }
        } else {
            echo "Error al cancelar asignación de voluntario: " . $conn->error;
        }
    }

    if (isset($_POST['agregar_producto'])) {
        $nombreProducto = $_POST['nuevo_nombre_producto'];
        $cantidadProducto = $_POST['nueva_cantidad_producto'];
        $sqlInsertarProducto = "INSERT INTO producto (nombre_producto, cantidad, id_donacion) 
                                VALUES ('$nombreProducto', $cantidadProducto, $idDonacion)";
        if ($conn->query($sqlInsertarProducto) === TRUE) {
            $sqlInsertarInventario = "INSERT INTO inventario (cantidad, nombre_prod, ubi_almacen, estado) 
                                      VALUES ($cantidadProducto, '$nombreProducto', 'Almacen', 'Disponible')";
            if ($conn->query($sqlInsertarInventario) === TRUE) {
                header("Location: detalleDonacion.php?id=$idDonacion");
                exit;
            } else {
                echo "Error al agregar el producto al inventario: " . $conn->error;
            }
        } else {
            echo "Error al agregar el producto: " . $conn->error;
        }
    }

    if (isset($_POST['actualizar_producto'])) {
        $idProducto = $_POST['id_producto'];
        $nombreProducto = $_POST['nombre_producto'];
        $cantidadProducto = $_POST['cantidad_producto'];
        $sqlActualizarProducto = "UPDATE producto SET nombre_producto = '$nombreProducto', cantidad = $cantidadProducto WHERE id_producto = $idProducto";
        if ($conn->query($sqlActualizarProducto) === TRUE) {
            $sqlActualizarInventario = "UPDATE inventario SET cantidad = $cantidadProducto WHERE nombre_prod = '$nombreProducto'";
            if ($conn->query($sqlActualizarInventario) === TRUE) {
                header("Location: detalleDonacion.php?id=$idDonacion");
                exit;
            } else {
                echo "Error al actualizar el producto en el inventario: " . $conn->error;
            }
        } else {
            echo "Error al actualizar el producto: " . $conn->error;
        }
    }

    if (isset($_POST['eliminar_producto'])) {
        $idProducto = $_POST['id_producto'];
        $sqlEliminarProducto = "DELETE FROM producto WHERE id_producto = $idProducto";
        if ($conn->query($sqlEliminarProducto) === TRUE) {
            header("Location: detalleDonacion.php?id=$idDonacion");
            exit;
        } else {
            echo "Error al eliminar el producto: " . $conn->error;
        }
    }

    if (isset($_POST['agregar_todos_inventario'])) {
        $nombresProductos = $_POST['nombre_producto'];
        $cantidadesProductos = $_POST['cantidad_producto'];
        foreach ($nombresProductos as $index => $nombreProducto) {
            $cantidadProducto = $cantidadesProductos[$index];
            $sqlComprobarProducto = "SELECT cantidad FROM inventario WHERE nombre_prod = '$nombreProducto'";
            $resultComprobarProducto = $conn->query($sqlComprobarProducto);

            if ($resultComprobarProducto && $resultComprobarProducto->num_rows > 0) {
                $inventario = $resultComprobarProducto->fetch_assoc();
                $nuevaCantidad = $inventario['cantidad'] + $cantidadProducto;
                $sqlActualizarInventario = "UPDATE inventario SET cantidad = $nuevaCantidad WHERE nombre_prod = '$nombreProducto'";
                $conn->query($sqlActualizarInventario);
            } else {
                $sqlInsertarInventario = "INSERT INTO inventario (nombre_prod, cantidad, ubi_almacen, estado)
                                          VALUES ('$nombreProducto', $cantidadProducto, 'Almacen', 'Disponible')";
                $conn->query($sqlInsertarInventario);
            }
        }

        header("Location: detalleDonacion.php?id=$idDonacion");
        exit;
    }
}

$conn->close();
?>
