<?php include 'modificaNorma.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normas.css">
    <title>Document</title>
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
            <h3 class="fw-bold fs-4 mb-3">Contenido Normas</h3>
            <div class="mb-3">
                <h3 class="fw-bold fs-4 my-3">Agregar contenido de normas</h3>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="nro_norma" class="form-label">Numero de norma:</label>
                        <input type="text" name="nro_norma" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="titulo" class="form-label">Titulo:</label>
                        <input type="text" name="titulo" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="descripcion_norma" class="form-label">Descripcion norma:</label>
                        <textarea name="descripcion_norma" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tipo_norma" class="form-label">Tipo de Norma:</label>
                        <input name="tipo_norma" class="form-control">
                    </div>
                    <button type="submit" name="agregar_norma" class="btn btn-primary">Agregar</button>
                </form>
            </div>
            <h3 class="fw-bold fs-4 my-3">Lista de contenido</h3>
            <div>
                <button type="button" class="btn btn-danger" onclick="eliminarFila(this)">Aplicar cambios</button>
                <button type="button" class="btn btn-danger" onclick="eliminarFila(this)">Agregar Eventos</button>
            </div>
            <div class="row">
                <div class="col-12">
                    <table class="table table-striped">
                        <thead>
                            <tr class="highlight">
                                <th scope="col">#</th>
                                <th scope="col">ID Norma</th>
                                <th scope="col">Numero de norma</th>
                                <th scope="col">Titulo</th>
                                <th scope="col">Descripcion norma</th>
                                <th scope="col">Tipo de norma</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($normas as $contador => $norma): ?>
                                <tr>
                                    <th scope="row"><?php echo $contador + 1; ?></th>
                                    <td contenteditable="true"><?php echo isset($norma['id_norma']) ? $norma['id_norma'] : ''; ?></td>
                                    <td contenteditable="true"><?php echo isset($norma['nro_norma']) ? $norma['nro_norma'] : ''; ?></td>
                                    <td contenteditable="true"><?php echo isset($norma['titulo']) ? $norma['titulo'] : ''; ?></td>
                                    <td contenteditable="true"><?php echo isset($norma['descripcion_norma']) ? $norma['descripcion_norma'] : ''; ?></td>
                                    <td contenteditable="true"><?php echo isset($norma['tipo_norma']) ? $norma['tipo_norma'] : ''; ?></td>
                                    <td>
                                        <form action="" method="POST">
                                            <input type="hidden" name="id" value="<?php echo isset($norma['id_norma']) ? $norma['id_norma'] : ''; ?>">
                                            <button type="submit" name="eliminar_norma" class="btn btn-danger">Eliminar</button>
                                            <button type="submit" name="actualizar_norma" class="btn btn-primary">Modificar</button>
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
