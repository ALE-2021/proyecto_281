<?php include 'modificaEvento.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/evento.css">
    <title>Eventos</title>
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
                        <a href="normas.php" class="nav-link">Normas</a>
                    </li>
                    <li class="nav-item">
                        <a href="educacion.php" class="nav-link">Educación</a>
                    </li>
                    <li class="nav-item">
                        <a href="eventos.php" class="nav-link">Eventos</a>
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
            <div class="mb-3">
                <h3 class="fw-bold fs-4 mb-3">Eventos</h3>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="card border-0">
                            <div class="card-body py-4">
                                <canvas id="eventChart" width="400" height="400"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card border-0">
                            <div class="card-body py-4">
                                <form action="" method="POST">
                                    <div class="mb-3">
                                        <label for="nom_evento" class="form-label">Título del evento:</label>
                                        <input type="text" name="nom_evento" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="fecha_evento" class="form-label">Fecha del evento:</label>
                                        <input type="date" name="fecha_evento" class="form-control" required></input>
                                    </div>
                                    <div class="mb-3">
                                        <label for="hora_evento" class="form-label">Hora:</label>
                                        <input type="time" name="hora_evento" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="descripcion_event" class="form-label">Descripcion del evento:</label>
                                        <input name="descripcion_event" class="form-control" required>
                                    </div>
                                    <button type="submit" name="agregar_eventos" class="btn btn-primary">Agregar Evento</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <h3 class="fw-bold fs-4 my-3">Lista de eventos</h3>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-striped">
                            <thead>
                                <tr class="highlight">
                                    <th scope="col">#</th>
                                    <th scope="col">Código Evento</th>
                                    <th scope="col">Nombre del evento</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Hora</th>
                                    <th scope="col">Descripcion</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($eventos as $contador => $evento): ?>
                                <tr>
                                    <th scope="row"><?php echo $contador + 1; ?></th>
                                    <td contenteditable="true"><?php echo $evento['cod_evento']; ?></td>
                                    <td contenteditable="true"><?php echo $evento['nom_evento']; ?></td>
                                    <td contenteditable="true"><?php echo $evento['fecha_evento']; ?></td>
                                    <td contenteditable="true"><?php echo $evento['hora_evento']; ?></td>
                                    <td contenteditable="true"><?php echo $evento['descripcion_event']; ?></td>
                                    <td>
                                        <form action="" method="POST">
                                            <input type="hidden" name="id_evento" value="<?php echo $evento['cod_evento']; ?>">
                                            <button type="submit" name="eliminar_eventos" class="btn btn-danger">Eliminar</button>
                                            <button type="submit" name="actualizar_eventos" class="btn btn-primary">Modificar</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

   
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var eventosRegistrados = 30;
        var eventosRestantes = 100 - eventosRegistrados;
        var ctx = document.getElementById('eventChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Eventos Registrados', 'Eventos Restantes'],
                datasets: [{
                    label: 'Eventos',
                    data: [eventosRegistrados, eventosRestantes],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
            }
        });
    </script>


</body>

</html>
