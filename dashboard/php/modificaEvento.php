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
    if (isset($_POST["agregar_eventos"])) {
        $nom_evento = $_POST["nom_evento"];
        $fecha_evento = $_POST["fecha_evento"];
        $hora_evento = $_POST["hora_evento"];
        $descripcion_event = $_POST["descripcion_event"];
        
        agregarEvento($nom_evento, $fecha_evento, $hora_evento, $descripcion_event);
    } elseif (isset($_POST["eliminar_eventos"])) {
        $id_evento = $_POST["id_evento"];
        
        eliminarEvento($id_evento);
    } elseif (isset($_POST["actualizar_eventos"])) {
        $id_evento = $_POST["id_evento"];
        $nom_evento = $_POST["nom_evento"];
        $fecha_evento = $_POST["fecha_evento"];
        $hora_evento = $_POST["hora_evento"];
        $descripcion_event = $_POST["descripcion_event"];
        
        actualizarEvento($id_evento, $nom_evento, $fecha_evento, $hora_evento, $descripcion_event);
    }
}

function agregarEvento($nom_evento, $fecha_evento, $hora_evento, $descripcion_event) {
    global $conn;
    $sql = "INSERT INTO eventos (nom_evento, fecha_evento, hora_evento, descripcion_event) VALUES ('$nom_evento', '$fecha_evento', '$hora_evento', '$descripcion_event')";
    

    if ($conn->query($sql) === TRUE) {
        echo "Evento agregado exitosamente";
    } else {
        echo "Error al agregar evento: " . $conn->error;
    }
}


function obtenerEventos() {
    global $conn;
    $eventos = array();
    $sql = "SELECT * FROM eventos";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $eventos[] = $row;
        }
    }
    return $eventos;
}




function eliminarEvento($id_evento) {
    global $conn;
    

    $sql = "DELETE FROM eventos WHERE cod_evento = $id_evento";

    if ($conn->query($sql) === TRUE) {
        echo "Evento eliminado exitosamente";
    } else {
        echo "Error al eliminar evento: " . $conn->error;
    }
}



function actualizarEvento($id_evento, $nom_evento, $fecha_evento, $hora_evento, $descripcion_event) {
    global $conn;
    
    $sql = "UPDATE eventos SET nom_evento = '$nom_evento', fecha_evento = '$fecha_evento', hora_evento = '$hora_evento', descripcion_event = '$descripcion_event' WHERE cod_evento = $id_evento";
    

    if ($conn->query($sql) === TRUE) {
        echo "Evento actualizado exitosamente";
    } else {
        echo "Error al actualizar evento: " . $conn->error;
    }
}

$eventos = obtenerEventos();

$conn->close();
?>