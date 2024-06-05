<?php include 'proceso.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/detalle.css">
    <title>Donaciones Pendientes</title>
    <style>
        nav.navbar {
            background-color: #010b6ad2 !important;
        }
        nav.navbar .navbar-nav .nav-link {
            color: #fff !important;
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
                        <a href="../../tablero.php" class="nav-link">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a href="../php/normas.php" class="nav-link">Normas</a>
                    </li>
                    <li class="nav-item">
                        <a href="../php/educacion.php" class="nav-link">Educación</a>
                    </li>
                    <li class="nav-item">
                        <a href="../php/eventos.php" class="nav-link">Eventos</a>
                    </li>
                    <li class="nav-item">
                        <a href="../RegDonaciones/donaciond.php" class="nav-link">Registro de Donaciones</a>
                    </li>
                    <li class="nav-item">
                        <a href="../regSolicitudes/listaSolicitudes.php" class="nav-link">Registro de Solicitudes</a>
                    </li>
                    <li class="nav-item">
                        <a href="../../index.php" class="nav-link">Salir</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="content px-3 py-4">
        <div class="container-fluid">
            <h1 class="fw-bold fs-4 mb-3">Registro de Donaciones</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Donación</th>
                        <th>Fecha de Recolección</th>
                        <th>Hora de Recolección</th>
                        <th>Ubicación</th>
                        <th>Cantidad de Productos</th>
                        <th>Estado</th>
                        <th>Voluntarios Asignados</th> 
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($donaciones)): ?>
                        <?php foreach ($donaciones as $donacion): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($donacion['id_donacion']); ?></td>
                            <td><?php echo htmlspecialchars($donacion['fecha_recoleccion']); ?></td>
                            <td><?php echo htmlspecialchars($donacion['hora_recoleccion']); ?></td>
                            <td><?php echo htmlspecialchars($donacion['ubicacion']); ?></td>
                            <td><?php echo htmlspecialchars($donacion['cantidad_productos']); ?></td>
                            <td><?php echo htmlspecialchars($donacion['estado']); ?></td>
                            <td><?php echo htmlspecialchars($donacion['voluntarios_asignados']); ?></td>
                            <td>
                            <?php if ($donacion['estado'] === 'registrada'): ?>
                                <button class="btn btn-primary">Donación Registrada</button>
                            <?php elseif ($donacion['voluntarios_asignados'] > 0): ?>
                                <button class="btn btn-success">Asignado</button>
                            <?php else: ?>
                                <button class="btn btn-danger">No Asignados</button>
                            <?php endif; ?>
                            </td>
                            <td>
                                <a href="detalleDonacion.php?id=<?php echo htmlspecialchars($donacion['id_donacion']); ?>" class="btn btn-info">Ver Detalles</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">No hay donaciones pendientes.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div id="main-content">
            </div>
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
