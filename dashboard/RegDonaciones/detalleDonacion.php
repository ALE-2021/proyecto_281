<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
    <title>Datos de la Donación</title>
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

    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Información de la Donación</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="donaciond.php">Atras</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../index.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <?php require 'procesar_donacion.php'; ?>
        <h1>Detalles de la Donación</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Información de la Donación</h5>
                <p class="card-text"><strong>Nombre del Donante:</strong> <?php echo htmlspecialchars($donacion['nombre_donante'] . ' ' . $donacion['apellido']); ?></p>
                <p class="card-text"><strong>Celular del Donante:</strong> <?php echo htmlspecialchars($donacion['celular']); ?></p>
                <p class="card-text"><strong>Fecha de Recojo:</strong> <?php echo htmlspecialchars($donacion['fecha_recojo']); ?></p>
                <p class="card-text"><strong>Hora de Recojo:</strong> <?php echo htmlspecialchars($donacion['hora_recojo']); ?></p>
                <p class="card-text"><strong>Ubicación:</strong> <?php echo htmlspecialchars($donacion['ubicacion']); ?></p>
                <p class="card-text"><strong>Estado:</strong> <?php echo htmlspecialchars($donacion['estado']); ?></p>
            </div>
        </div>

        <h2 class="mt-4">Productos</h2>
        <form method="POST" action="procesar_donacion.php">
            <input type="hidden" name="id" value="<?php echo $idDonacion; ?>">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre del Producto</th>
                        <th>Cantidad</th>
                        <th>Actualizar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($producto = $resultProductos->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <input type="text" name="nombre_producto[]" value="<?php echo htmlspecialchars($producto['nombre_producto']); ?>" class="form-control">
                            </td>
                            <td>
                                <input type="number" name="cantidad_producto[]" value="<?php echo htmlspecialchars($producto['cantidad']); ?>" class="form-control">
                            </td>
                            <td>
                                <input type="hidden" name="id_producto" value="<?php echo htmlspecialchars($producto['id_producto']); ?>">
                                <button type="submit" name="actualizar_producto" class="btn btn-primary">Actualizar</button>
                            </td>
                            <td>
                                <input type="hidden" name="id_producto" value="<?php echo htmlspecialchars($producto['id_producto']); ?>">
                                <button type="submit" name="eliminar_producto" class="btn btn-danger">Eliminar</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <button type="submit" name="agregar_todos_inventario" class="btn btn-success mt-2">Agregar Todos al Inventario</button>
        </form>

        <h2 class="mt-4">Agregar Producto</h2>
        <form method="POST" action="procesar_donacion.php">
            <input type="hidden" name="id" value="<?php echo $idDonacion; ?>">
            <div class="mb-3">
                <label for="nuevo_nombre_producto" class="form-label">Nombre del Producto</label>
                <input type="text" name="nuevo_nombre_producto" id="nuevo_nombre_producto" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="nueva_cantidad_producto" class="form-label">Cantidad</label>
                <input type="number" name="nueva_cantidad_producto" id="nueva_cantidad_producto" class="form-control" required>
            </div>
            <button type="submit" name="agregar_producto" class="btn btn-primary">Agregar Producto</button>
        </form>

        <h2 class="mt-4">Voluntarios Asignados</h2>
        <?php if ($voluntariosAsignados): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Celular</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($voluntario = $resultVoluntarios->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($voluntario['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($voluntario['apellido']); ?></td>
                            <td><?php echo htmlspecialchars($voluntario['celular']); ?></td>
                            <td><?php echo htmlspecialchars($voluntario['estado']); ?></td>
                            <td>
                                <form method="POST" action="procesar_donacion.php">
                                    <input type="hidden" name="id" value="<?php echo $idDonacion; ?>">
                                    <input type="hidden" name="cancelar_asignacion" value="<?php echo htmlspecialchars($voluntario['id_voluntario']); ?>">
                                    <button type="submit" name="cancelar_voluntario" class="btn btn-danger">Cancelar Asignación</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay voluntarios asignados a esta donación.</p>
        <?php endif; ?>

        <h2>Asignar Voluntarios</h2>
        <form method="POST" action="procesar_donacion.php">
            <input type="hidden" name="id" value="<?php echo $idDonacion; ?>">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Celular</th>
                        <th>Día Disponible</th>
                        <th>Hora</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($voluntario = $resultListaVoluntarios->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($voluntario['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($voluntario['apellido']); ?></td>
                            <td><?php echo isset($voluntario['celular']) ? htmlspecialchars($voluntario['celular']) : 'N/A'; ?></td>
                            <td><?php echo htmlspecialchars($voluntario['dia_disponible']); ?></td>
                            <td><?php echo htmlspecialchars($voluntario['horario']); ?></td>
                            <td>
                                <input type="hidden" name="id" value="<?php echo $idDonacion; ?>">
                                <input type="hidden" name="id_voluntario" value="<?php echo htmlspecialchars($voluntario['id_voluntario']); ?>">
                                <button type="submit" name="asignar_voluntarios" class="btn btn-success">Asignar</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.min.js"></script>
</body>
</html>
