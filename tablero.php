<?php
require_once 'conexion.php';

// Consulta para obtener todos los usuarios con sus roles, priorizando un rol específico si un usuario pertenece a múltiples roles
$sqlUsuarios = "SELECT u.id_usuario, u.nombre, u.apellido, u.ci, u.correo, u.celular, 
                CASE 
                    WHEN a.id_administrador IS NOT NULL THEN 'Administrador'
                    WHEN v.id_voluntario IS NOT NULL THEN 'Voluntario'
                    WHEN r.id_receptor IS NOT NULL THEN 'Receptor'
                    WHEN d.id_donante IS NOT NULL THEN 'Donante'
                    ELSE 'Usuario'
                END AS rol
                FROM usuario u
                LEFT JOIN administrador a ON u.id_usuario = a.id_usuario
                LEFT JOIN voluntario v ON u.id_usuario = v.id_usuario
                LEFT JOIN receptor r ON u.id_usuario = r.id_usuario
                LEFT JOIN donante d ON u.id_usuario = d.id_usuario
                GROUP BY u.id_usuario
                ORDER BY FIELD(rol, 'Administrador', 'Voluntario', 'Receptor', 'Donante')";

$resultUsuarios = $conn->query($sqlUsuarios);
$usuarios = [];
while ($row = $resultUsuarios->fetch_assoc()) {
    $usuarios[] = $row;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <style>
        nav.navbar {
            background-color: #010b6ad2 !important;
        }
        nav.navbar .navbar-nav .nav-link {
            color: #fff !important;
        }
        .navbar {
            background-color: #101d5d !important;
        }

        .navbar-brand {
            color: #fff;
        }

        .navbar-nav {
            margin-left: auto;
        }

        .navbar-nav .nav-link {
            color: #fff !important;
            font-weight: 600;
            font-size: 16px;
            padding-right: 15px;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link:focus,
        .navbar-nav .nav-link.active {
            color: #ccc !important;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }
        .estado-entregada {
            background-color: #d4edda;
            color: #155724;
        }
        .estado-pendiente {
            background-color: #fff3cd;
            color: #856404;
        }
        .estado-rechazada {
            background-color: #f8d7da;
            color: #721c24;
        }

        .table-responsive {
            margin-top: 20px;
        }

        .form-control {
            margin-bottom: 20px;
        }

        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }

        .table thead th {
            background-color: #010b6ad2;
            color: #fff;
            border: none;
        }

        .table thead th:first-child {
            border-radius: 5px 0 0 5px;
        }

        .table thead th:last-child {
            border-radius: 0 5px 5px 0;
        }

        .table tbody tr {
            border-bottom: 1px solid #ddd;
        }

        .table tbody tr:last-child {
            border-bottom: none;
        }

        .table tbody tr td {
            vertical-align: middle;
        }

        .table tbody tr td:last-child {
            text-align: center;
        }

        .table .btn {
            font-size: 14px;
            padding: 5px 10px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="tablero.php" class="nav-link">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a href="dashboard/php/normas.php" class="nav-link">Normas</a>
                    </li>
                    <li class="nav-item">
                        <a href="dashboard/php/educacion.php" class="nav-link">Educacion</a>
                    </li>
                    <li class="nav-item">
                        <a href="dashboard/php/eventos.php" class="nav-link">Eventos</a>
                    </li>
                    <li class="nav-item">
                        <a href="dashboard/RegDonaciones/donaciond.php" class="nav-link">Registro de Donaciones</a>
                    </li>
                    <li class="nav-item">
                        <a href="dashboard/regSolicitudes/listaSolicitudes.php" class="nav-link">Registro de Solicitudes</a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php" class="nav-link">Salir</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h1>Lista de Usuarios</h1>
        <div class="form-group mb-3">
            <label for="filtroRol">Buscar por Rol:</label>
            <select id="filtroRol" class="form-control">
                <option value="Todos">Todos</option>
                <option value="Administrador">Administrador</option>
                <option value="Voluntario">Voluntario</option>
                <option value="Receptor">Receptor</option>
                <option value="Donante">Donante</option>
            </select>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID Usuario</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>CI</th>
                        <th>Correo</th>
                        <th>Celular</th>
                        <th>Rol</th>
                    </tr>
                </thead>
                <tbody id="tablaUsuarios">
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr class="fila-usuario" data-rol="<?php echo htmlspecialchars($usuario['rol']); ?>">
                            <td><?php echo htmlspecialchars($usuario['id_usuario']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['apellido']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['ci']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['celular']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#filtroRol').change(function(){
                var filtro = $(this).val().toLowerCase();
                if (filtro === "todos") {
                    $('.fila-usuario').show();
                } else {
                    $('.fila-usuario').each(function(){
                        var rol = $(this).data('rol').toLowerCase();
                        if (rol === filtro) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
