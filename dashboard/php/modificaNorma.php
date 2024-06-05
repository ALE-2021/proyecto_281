<?php

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "proyecto";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["agregar_norma"])) {
        $nro_norma = $_POST["nro_norma"];
        $titulo = $_POST["titulo"];
        $descripcion_norma = $_POST["descripcion_norma"];
        $tipo_norma = $_POST["tipo_norma"];
        echo agregarNorma($nro_norma, $titulo, $descripcion_norma, $tipo_norma);
    } elseif (isset($_POST["eliminar_norma"])) {
        $id = $_POST["id"];
        echo eliminarNorma($id);
    } elseif (isset($_POST["actualizar_norma"])) {
        $id = $_POST["id"];
        $nro_norma = $_POST["nro_norma"];
        $titulo = $_POST["titulo"];
        $descripcion_norma = $_POST["descripcion_norma"];
        $tipo_norma = $_POST["tipo_norma"];
        echo actualizarNorma($id, $nro_norma, $titulo, $descripcion_norma, $tipo_norma);
    }
}

function eliminarNorma($id) {
    global $conn;
    $sql = "DELETE FROM normas WHERE id_norma = $id";
    if ($conn->query($sql) === TRUE) {
    } else {
        return "Error al eliminar la norma: " . $conn->error;
    }
}

function obtenerNormas() {
    global $conn;
    $normas = array();
    $sql = "SELECT id_norma, nro_norma, titulo, descripcion_norma, tipo_norma FROM normas";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $normas[] = $row;
        }
    }
    return $normas;
}


function agregarNorma($nro_norma, $titulo, $descripcion_norma, $tipo_norma) {
    global $conn;
    $sql = "INSERT INTO normas (nro_norma, titulo, descripcion_norma, tipo_norma) VALUES ('$nro_norma', '$titulo', '$descripcion_norma', '$tipo_norma')";
    if ($conn->query($sql) === TRUE) {
        return "Nueva norma agregada correctamente";
    } else {
        return "Error al agregar la norma: " . $conn->error;
    }
}



function actualizarNorma($id, $nro_norma, $titulo, $descripcion_norma, $tipo_norma) {
    global $conn;
    $sql = "UPDATE normas SET nro_norma = '$nro_norma', titulo = '$titulo', descripcion_norma = '$descripcion_norma', tipo_norma = '$tipo_norma' WHERE id_norma = $id";
    if ($conn->query($sql) === TRUE) {
        return "Norma actualizada correctamente";
    } else {
        return "Error al actualizar la norma: " . $conn->error;
    }
}

$normas = obtenerNormas();

$conn->close();
?>
