<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "proyecto";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
// Procesar formularios si se envían datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["agregar_evento"])) {
        // Obtener los datos del formulario
        $nom_evento = $_POST["nom_evento"];
        $fecha_evento = $_POST["fecha_evento"];
        $hora_evento = $_POST["hora_evento"];
        $descripcion_event = $_POST["descripcion_event"];
        
        // Llamar a la función para agregar el nuevo evento
        agregarEvento($nom_evento, $fecha_evento, $hora_evento, $descripcion_event);
    } elseif (isset($_POST["eliminar_evento"])) {
        // Obtener el ID del evento a eliminar
        $id_evento = $_POST["id_evento"];
        
        // Llamar a la función para eliminar el evento
        eliminarEvento($id_evento);
    } elseif (isset($_POST["actualizar_evento"])) {
        // Obtener los datos del formulario
        $id_evento = $_POST["id_evento"];
        $nom_evento = $_POST["nom_evento"];
        $fecha_evento = $_POST["fecha_evento"];
        $hora_evento = $_POST["hora_evento"];
        $descripcion_event = $_POST["descripcion_event"];
        
        // Llamar a la función para actualizar el evento
        actualizarEvento($id_evento, $nom_evento, $fecha_evento, $hora_evento, $descripcion_event);
    }
}

// Función para obtener todos los eventos
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
//**************EDUCACION***********
// Función para obtener todos los recursos de educación
function obtenerRecursosEducacion() {
    global $conn;
    $recursos = array();
    $sql = "SELECT cod_educacion, titulo, tipo_contenido, descripcion_edu, fecha_publicacion FROM educacion";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Agregar los datos al array $recursos
            $recursos[] = $row;
        }
    }
    return $recursos;
}
// Obtener todos los recursos de educación
$educacion = obtenerRecursosEducacion();

//***********NORMAS************ */
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

// Obtener todas las normas
$normas = obtenerNormas();

// Obtener todos los eventos
$eventos = obtenerEventos();

// Cerrar la conexión a la base de datos
$conn->close();

?>
