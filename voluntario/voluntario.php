<?php
session_start(); 

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario']; 

require_once '../conexion.php';

$sql_voluntario = "SELECT id_voluntario FROM voluntario WHERE id_usuario = ?";
$stmt_voluntario = $conn->prepare($sql_voluntario);
$stmt_voluntario->bind_param("i", $id_usuario);
$stmt_voluntario->execute();
$result_voluntario = $stmt_voluntario->get_result();

if ($result_voluntario->num_rows > 0) {
    $row_voluntario = $result_voluntario->fetch_assoc();
    $id_voluntario = $row_voluntario['id_voluntario'];
} else {
    header("Location: login.php");
    exit();
}

$sql = "SELECT av.id_asignacion, d.id_donacion, d.fecha_recojo, d.hora_recojo, d.ubicacion, SUM(p.cantidad) AS total_productos, av.estado
        FROM asignacion_voluntarios av
        JOIN donacion d ON av.id_donacion = d.id_donacion
        JOIN producto p ON d.id_donacion = p.id_donacion
        WHERE av.id_voluntario = ?
        GROUP BY d.id_donacion";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_voluntario);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Voluntario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/voluntario.css">
    <style>
                .logo i {
            font-size: 40px; 
            color: #fff; 
        }
        header .nav ul {
            display: flex;
            justify-content: flex-end;
            list-style: none;
            padding: 0;
        }
        header .nav ul li {
            margin-left: 20px;
        }
        header .nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            transition: color 0.3s;
        }
        header .nav ul li a:hover {
            color: #ccc;
        }
        header {
            background-color: rgba(26, 38, 107, 0.9);
            position: fixed;
            width: 100%;
            z-index: 100;
            top: 0;
            padding: 10px;
        }
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            background-color: #fff;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
            background-color: #2241a7;
            color: #fff;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .table-hover tbody tr:hover {
            color: #212529;
            background-color: rgba(0, 0, 0, 0.075);
        }
        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
            color: #fff;
        }
        .btn-info:hover {
            background-color: #138496;
            border-color: #117a8b;
            color: #fff;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            color: #fff;
        }
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
            color: #fff;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
            color: #fff;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="logo">
                        <h1><i class="fas fa-leaf"></i></h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <nav class="nav">
                        <ul>
                            <li><a href="../index.php">Inicio</a></li>
                            <li><a href="">Perfil</a></li>
                            <li><a href="" target="_blank">Generar Informe</a></li>
                            <li><a href="../index.php">Salir</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <section id="inicio">
        <div class="container">
            <div class="slide">
                <div class="item" style="background-image: url(imagenes/donador1.jpg);">
                    <div class="content">
                        <h1>Bienvenido</h1>
                        <div class="name">Con tu ayuda hacemos un mundo mejor</div>
                        <div class="des">Se tu el cambio que quieres ver en el mundo</div>
                    </div>
                </div>      
            </div>
        </div>
    </section>

    <section id="inicio">
        <div class="container">
            <h1>Asignacion de tareasa los voluntarios</h1>
            <h4>Atareas de entrega y recojo asignadas</h4>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID Donación</th>
                        <th>Fecha de Recolección</th>
                        <th>Hora de Recolección</th>
                        <th>Ubicación</th>
                        <th>Total de Productos</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($resultado && $resultado->num_rows > 0) { 
                        while ($fila = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($fila['id_donacion']) . "</td>";
                            echo "<td>" . htmlspecialchars($fila['fecha_recojo']) . "</td>";
                            echo "<td>" . htmlspecialchars($fila['hora_recojo']) . "</td>";
                            echo "<td>" . htmlspecialchars($fila['ubicacion']) . "</td>";
                            echo "<td>" . htmlspecialchars($fila['total_productos']) . "</td>";
                            echo "<td>" . htmlspecialchars($fila['estado']) . "</td>";
                            echo "<td>";
                            echo "<button class='btn btn-info' onclick='verDetalles(" . $fila['id_donacion'] . ")'>Ver más detalles</button> ";
                            if ($fila['estado'] == 'pendiente') {
                                echo "<button class='btn btn-success' onclick='aceptar(" . $fila['id_asignacion'] . ")'>Aceptar</button> ";
                                echo "<button class='btn btn-danger' onclick='rechazar(" . $fila['id_asignacion'] . ")'>Rechazar</button>";
                            } else {
                                echo "N/A";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No se han encontrado donaciones asignadas para este voluntario.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>

    <div class="modal fade" id="detallesModal" tabindex="-1" aria-labelledby="detallesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detallesModalLabel">Detalles de la Donación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="detallesModalBody">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    function verDetalles(id_donacion) {
        fetch('detalles_donacion.php?id_donacion=' + id_donacion)
        .then(response => response.text())
        .then(data => {
            document.getElementById('detallesModalBody').innerHTML = data;
            $('#detallesModal').modal('show');
        })
        .catch(error => {
            console.error('Error al obtener los detalles de la donación:', error);
        });
    }
    
    function aceptar(id_asignacion) {
        fetch('actualizar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                id_asignacion: id_asignacion,
                estado: 'asignado'
            }),
        })
        .then(response => {
            if (response.ok) {
                console.log("Asignación " + id_asignacion + " aceptada.");
                location.reload();
            } else {
                console.error('Error al aceptar la asignación.');
            }
        })
        .catch(error => {
            console.error('Error de red:', error);
        });
    }

    function rechazar(id_asignacion) {
        fetch('actualizar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                id_asignacion: id_asignacion,
                estado: 'disponible'
            }),
        })
        .then(response => {
            if (response.ok) {
                console.log("Asignación " + id_asignacion + " rechazada.");
                location.reload();
            } else {
                console.error('Error al rechazar la asignación.');
            }
        })
        .catch(error => {
            console.error('Error de red:', error);
        });
    }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
