<?php
session_start();

require('./fpdf.php');

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

// Crear instancia de FPDF
$pdf = new FPDF();
$pdf->AddPage();

$id_donante = isset($_SESSION['id_donante']) ? $_SESSION['id_donante'] : null;

// Consulta SQL para obtener los datos del donante
$sqlDonante = "SELECT u.nombre, u.apellido, u.ci, u.correo, u.celular
               FROM usuario u
               INNER JOIN donante d ON u.id_usuario = d.id_usuario
               WHERE d.id_donante = $id_donante";

$resultadoDonante = mysqli_query($conn, $sqlDonante);

// Consulta SQL para obtener los datos de la donación
$sqlDonacion = "SELECT fecha_recojo, hora_recojo, ubicacion, estado, id_voluntario, id_inventario,id_donacion
                FROM donacion
                WHERE id_donante = $id_donante";

$resultadoDonacion = mysqli_query($conn, $sqlDonacion);

$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Reporte de Donaciones', 0, 1, 'C');
$pdf->Ln(10);

// Encabezado y datos del donante
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Datos del Donante', 0, 1, 'L');
$pdf->SetFont('Arial', '', 12);

while ($filaDonante = mysqli_fetch_assoc($resultadoDonante)) {
    $pdf->Cell(50, 10, 'Nombre:', 0);
    $pdf->Cell(0, 10, utf8_decode($filaDonante['nombre'] . ' ' . $filaDonante['apellido']), 0, 1);
    $pdf->Cell(50, 10, 'CI:', 0);
    $pdf->Cell(0, 10, utf8_decode($filaDonante['ci']), 0, 1);
    $pdf->Cell(50, 10, 'Correo:', 0);
    $pdf->Cell(0, 10, utf8_decode($filaDonante['correo']), 0, 1);
    $pdf->Cell(50, 10, 'Celular:', 0);
    $pdf->Cell(0, 10, utf8_decode($filaDonante['celular']), 0, 1);
    $pdf->Ln(10);
}

// Mostrar datos de la donación y tabla de productos por cada donación
while ($filaDonacion = mysqli_fetch_assoc($resultadoDonacion)) {
    // Tabla de detalles de la donación
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Detalles de la Donación', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetFillColor(200, 220, 255); // Celeste
    $pdf->Cell(50, 10, 'Fecha de Recojo', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Hora de Recojo', 1, 0, 'C', true);
    $pdf->Cell(50, 10, 'Ubicación', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Estado', 1, 1, 'C', true);
    $pdf->Cell(50, 10, utf8_decode($filaDonacion['fecha_recojo']), 1, 0, 'C');
    $pdf->Cell(40, 10, utf8_decode($filaDonacion['hora_recojo']), 1, 0, 'C');
    $pdf->Cell(50, 10, utf8_decode($filaDonacion['ubicacion']), 1, 0, 'C');
    $pdf->Cell(40, 10, utf8_decode($filaDonacion['estado']), 1, 1, 'C');
    $pdf->Ln(10);

    // Consulta SQL para obtener los productos donados en esta donación
    $id_donacion = $filaDonacion['id_donacion'];
    $sqlProductos = "SELECT nombre_producto, cantidad
                    FROM producto
                    WHERE id_donacion = $id_donacion";
    $resultadoProductos = mysqli_query($conn, $sqlProductos);

    if (mysqli_num_rows($resultadoProductos) > 0) {
        // Tabla de productos donados
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Productos Donados', 0, 1, 'C', true);
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetFillColor(200, 220, 255); // Celeste
        $pdf->Cell(80, 10, 'Nombre Producto', 1, 0, 'C', true);
        $pdf->Cell(40, 10, 'Cantidad', 1, 1, 'C', true);

        while ($filaProducto = mysqli_fetch_assoc($resultadoProductos)) {
            $pdf->Cell(80, 10, utf8_decode($filaProducto['nombre_producto']), 1, 0, 'L');
            $pdf->Cell(40, 10, utf8_decode($filaProducto['cantidad']), 1, 1, 'C');
        }
    }

    // Espacio entre donaciones
    $pdf->Ln(10);
    $pdf->Cell(0, 10, '-------------------------------------------------------------', 0, 1, 'C');
    $pdf->Ln(10);
}

// Salida del PDF
$pdf->Output();
?>
