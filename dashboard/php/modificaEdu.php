<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "proyecto";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["agregar_evento"])) {
        $titulo = $_POST["titulo"];
        $tipo_contenido = $_POST["tipo_contenido"];
        $descripcion_edu = $_POST["descripcion_edu"];
        $fecha_publicacion = $_POST["fecha_publicacion"];
        echo agregarRecursoEducacion($titulo, $tipo_contenido, $descripcion_edu, $fecha_publicacion);
    } elseif (isset($_POST["eliminar_evento"])) {
        $id = $_POST["id"];
        echo eliminarRecursoEducacion($id);
    } elseif (isset($_POST["actualizar_evento"])) {
        $id = $_POST["id"];
        $titulo = $_POST["titulo"];
        $tipo_contenido = $_POST["tipo_contenido"];
        $descripcion_edu = $_POST["descripcion_edu"];
        $fecha_publicacion = $_POST["fecha_publicacion"];
        echo actualizarRecursoEducacion($id, $titulo, $tipo_contenido, $descripcion_edu, $fecha_publicacion);
    }
}

function obtenerRecursosEducacion() {
    global $conn;
    $recursos = array();
    $sql = "SELECT cod_educacion, titulo, tipo_contenido, descripcion_edu, fecha_publicacion FROM educacion";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $recursos[] = $row;
        }
    }
    return $recursos;
}

function agregarRecursoEducacion($titulo, $tipo_contenido, $descripcion_edu, $fecha_publicacion) {
    global $conn;
    $sql = "INSERT INTO educacion (titulo, tipo_contenido, descripcion_edu, fecha_publicacion) VALUES ('$titulo', '$tipo_contenido', '$descripcion_edu', '$fecha_publicacion')";
    if ($conn->query($sql) === TRUE) {
        return "Nuevo recurso de educación agregado correctamente";
    } else {
        return "Error al agregar el recurso de educación: " . $conn->error;
    }
}

function eliminarRecursoEducacion($id) {
    global $conn;
    $sql = "DELETE FROM educacion WHERE cod_educacion = $id";
    if ($conn->query($sql) === TRUE) {
        return "Recurso de educación eliminado correctamente";
    } else {
        return "Error al eliminar el recurso de educación: " . $conn->error;
    }
}

function actualizarRecursoEducacion($id, $titulo, $tipo_contenido, $descripcion_edu, $fecha_publicacion) {
    global $conn;
    $sql = "UPDATE educacion SET titulo = '$titulo', tipo_contenido = '$tipo_contenido', descripcion_edu = '$descripcion_edu', fecha_publicacion = '$fecha_publicacion' WHERE cod_educacion = $id";
    if ($conn->query($sql) === TRUE) {
        return "Recurso de educación actualizado correctamente";
    } else {
        return "Error al actualizar el recurso de educación: " . $conn->error;
    }
}

$recursos_educacion = obtenerRecursosEducacion();
$conn->close();
?>