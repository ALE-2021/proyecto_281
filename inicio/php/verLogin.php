<?php

session_start(); 
include 'conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT u.id_usuario, u.nombre, u.apellido, d.id_donante, r.id_receptor,
                   CASE WHEN v.id_voluntario IS NOT NULL THEN 'voluntario'
                        WHEN a.id_administrador IS NOT NULL THEN 'administrador'
                        WHEN d.id_donante IS NOT NULL THEN 'donante'
                        WHEN r.id_receptor IS NOT NULL THEN 'receptor'
                        ELSE 'otro' END AS rol
            FROM usuario u
            LEFT JOIN voluntario v ON u.id_usuario = v.id_usuario
            LEFT JOIN administrador a ON u.id_usuario = a.id_usuario
            LEFT JOIN donante d ON u.id_usuario = d.id_usuario
            LEFT JOIN receptor r ON u.id_usuario = r.id_usuario
            WHERE u.correo = '$correo' AND u.contrasena = '$contrasena'";
    
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['id_usuario'] = $row['id_usuario'];
        $_SESSION['nombre'] = $row['nombre'];
        $_SESSION['apellido'] = $row['apellido'];

        $rol = $row['rol'];

        $id_receptor = isset($row['id_receptor']) ? $row['id_receptor'] : null;

        switch ($rol) {
            case 'administrador':
                echo "Reconocido como administrador";
                header("Location: ../../tablero.php"); // Redirigir al panel de administrador
                exit;
            case 'voluntario':
                echo "Reconocido como voluntario";
                header("Location: ../../voluntario/voluntario.php"); // Redirigir al panel de voluntario
                exit;
            case 'donante':
                echo "Reconocido como donante";
                $_SESSION['id_donante'] = $row['id_donante'];
                header("Location: ../../donante/catalogo.php"); // Redirigir al panel de donante
                exit;   
            case 'receptor':
                echo "Reconocido como receptor";
                if (!is_null($id_receptor)) {
                    $_SESSION['id_receptor'] = $id_receptor;
                    header("Location: ../../receptor/receptor.php"); // Redirigir al panel de receptor
                    exit;
                } else {
                    echo "Error: id_receptor no está definido o es NULL";
                }
            default:
                echo "Error: Rol no reconocido";
                break;
        }
    } else {
        echo '<script>alert("Correo o contraseña incorrecta");</script>';
    }
}
?>
