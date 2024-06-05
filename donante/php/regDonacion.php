<?php
// conexion.php
$servername = "localhost";
$username = "root";
$password = "";
$database = "proyecto";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha_recojo = $_POST["fecha"];
    $hora_recojo = $_POST["hora"];
    $estado = "pendiente"; // Por defecto, estado pendiente
    $ubicacion = $conn->real_escape_string($_POST["ubicacion"]);
    $id_donante = $_POST["id_donante"]; // Obtener el id_donante del formulario

    // Insertar datos en la tabla de donaciones
    $sql = "INSERT INTO donacion (fecha_recojo, hora_recojo, estado, id_donante, ubicacion)
            VALUES ('$fecha_recojo', '$hora_recojo', '$estado', '$id_donante', '$ubicacion')";

    if ($conn->query($sql) === TRUE) {
        $id_donacion = $conn->insert_id;

        // Ingreso de los productos en la tabla de productos
        $productos = array();
        $total_productos = isset($_POST["total_productos"]) ? $_POST["total_productos"] : 0; // Verificar si existe el campo total_productos
        for ($i = 1; $i <= $total_productos; $i++) {
            if (isset($_POST["producto_$i"]) && isset($_POST["cantidad_producto_$i"])) { // Verificar si existen los campos para este producto
                $nombre_producto = $conn->real_escape_string($_POST["producto_$i"]);
                $cantidad_producto = $_POST["cantidad_producto_$i"];
                // Agregar el producto a la lista
                $productos[] = "('$nombre_producto', $cantidad_producto, $id_donacion)";
            }
        }

        // Si se han proporcionado productos, insertarlos en la tabla de productos
        if (!empty($productos)) {
            $sql_productos = "INSERT INTO producto (nombre_producto, cantidad, id_donacion)
                              VALUES " . implode(", ", $productos);
            if ($conn->query($sql_productos) === TRUE) {
                echo "Productos registrados exitosamente.";
            } else {
                echo "Error al registrar productos: " . $sql_productos . "<br>" . $conn->error;
            }
        } else {
            echo "No se proporcionaron productos.";
        }
        header('Location: ../catalogo.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>
