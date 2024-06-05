<?php
require_once '../../conexion.php';

$sql = "
    SELECT 
        d.id_donacion,
        d.fecha_recojo AS fecha_recoleccion, 
        d.hora_recojo AS hora_recoleccion, 
        d.ubicacion, 
        SUM(p.cantidad) AS cantidad_productos, 
        d.estado,
        (SELECT COUNT(av.id_voluntario) 
         FROM asignacion_voluntarios av 
         JOIN voluntario v ON av.id_voluntario = v.id_voluntario 
         WHERE av.id_donacion = d.id_donacion AND v.estado_asignacion = 'asignado') AS voluntarios_asignados
    FROM 
        donacion d 
    JOIN 
        producto p 
    ON 
        d.id_donacion = p.id_donacion 
    GROUP BY 
        d.id_donacion, d.fecha_recojo, d.hora_recojo, d.ubicacion, d.estado
";

$result = $conn->query($sql);

if (!$result) {
    die('Error en la consulta: ' . $conn->error);
}

$donaciones = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $donaciones[] = $row;
    }
} else {
    echo 'No se encontraron donaciones pendientes.';
}

$conn->close();
?>