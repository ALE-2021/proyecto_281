<?php
include "modificaEdu.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/educacion.css">
    <title>Contenido Educativo</title>
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
                <h3 class="fw-bold fs-4 mb-3">Contenido educativo</h3>
                <div class="mb-3">
                    <h3 class="fw-bold fs-4 my-3">Agregar contenido educativo</h3>
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="titulo" class="form-label">Título:</label>
                            <input type="text" name="titulo" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="tipo_contenido" class="form-label">Tipo de Contenido:</label>
                            <input type="text" name="tipo_contenido" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="descripcion_edu" class="form-label">Descripción:</label>
                            <textarea name="descripcion_edu" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="fecha_publicacion" class="form-label">Fecha publicación:</label>
                            <input type="date" name="fecha_publicacion" class="form-control">
                        </div>
                        <button type="submit" name="agregar_evento" class="btn btn-primary">Agregar</button>
                    </form>
                </div>
                <h3 class="fw-bold fs-4 my-3">Lista de contenido</h3>
                <div>
                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#modalAgregarEducacion">Agregar Cambios</a>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-striped">
                            <thead>
                                <tr class="highlight">
                                    <th scope="col">#</th>
                                    <th scope="col">Código Educativo</th>
                                    <th scope="col">Titulo</th>
                                    <th scope="col">Tipo de contenido</th>
                                    <th scope="col">Descripcion</th>
                                    <th scope="col">Fecha de publicacion</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recursos_educacion as $contador => $recurso): ?>
                                <tr>
                                    <th scope="row">
                                        <?php echo $contador + 1; ?>
                                    </th>
                                    <td contenteditable="true">
                                        <?php echo $recurso['cod_educacion']; ?>
                                    </td>
                                    <td contenteditable="true">
                                        <?php echo $recurso['titulo']; ?>
                                    </td>
                                    <td contenteditable="true">
                                        <?php echo $recurso['tipo_contenido']; ?>
                                    </td>
                                    <td contenteditable="true">
                                        <?php echo $recurso['descripcion_edu']; ?>
                                    </td>
                                    <td contenteditable="true">
                                        <?php echo $recurso['fecha_publicacion']; ?>
                                    </td>
                                    <td>
                                        <form action="" method="POST">
                                            <input type="hidden" name="id" value="<?php echo $recurso['cod_educacion']; ?>">
                                            <button type="submit" name="eliminar_evento" class="btn btn-danger">Eliminar</button>
                                            <button type="submit" name="actualizar_evento" class="btn btn-primary">Modificar</button>
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



    <script src="https://unpkg.com/vue@2.6.14/dist/vue.js"></script>
    <script src="https://unpkg.com/vue-router@3.5.2/dist/vue-router.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="js/app.js"></script>
</body>

</html>
