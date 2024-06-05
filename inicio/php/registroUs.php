<?php
include 'conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $carnet = $_POST['carnet'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $celular = $_POST['celular']; 
    $tipo_usuario = $_POST['tipo_usuario'];

    // Insertar datos en la tabla de usuarios
    $sql_usuario = "INSERT INTO usuario (nombre, apellido, ci , correo, contrasena, celular) VALUES ('$nombre', '$apellido','$carnet', '$correo', '$contrasena', '$celular')";
    
    if ($conn->query($sql_usuario) === TRUE) {
        $id_usuario = $conn->insert_id; 
        
        switch ($tipo_usuario) {
            case "voluntario":
                $horario = $_POST['horario']; 
                $dia_disponible = $_POST['dia_disponible'];
                $sql_rol = "INSERT INTO voluntario (id_usuario, horario, dia_disponible) VALUES ('$id_usuario', '$horario', '$dia_disponible')";
                break;
            case "receptor":
                $tipo = $_POST['tipo']; 
                $sql_rol = "INSERT INTO receptor (id_usuario, tipo) VALUES ('$id_usuario', '$tipo')";
                break;
            case "donante":
                $sql_rol = "INSERT INTO donante (id_usuario) VALUES ('$id_usuario')";
                break;
            default:
                echo "Tipo de usuario no válido";
                break;
        }
        if ($conn->query($sql_rol) === TRUE) {
            header("Location: ../../index.php");
        } else {
            echo "Error al crear el rol: " . $sql_rol . "<br>" . $conn->error;
        }
    } else {
        echo "Error al crear el usuario: " . $sql_usuario . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
