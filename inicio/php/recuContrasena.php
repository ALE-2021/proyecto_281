<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <!-- Modal Recuperar Contraseña -->
    <div class="modal fade" id="olvidarContrasenaModal" tabindex="-1" role="dialog" aria-labelledby="recuperarContrasenaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="olvidarContrasenaModal">Recuperar Contraseña</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="php/recuperarContrasena.php" method="POST">
            <div class="form-group">
                <label for="correoRecuperar">Correo Electrónico:</label>
                <input type="email" class="form-control" id="correoRecuperar" name="correoRecuperar" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Recuperar Contraseña</button>
            </form>
        </div>
        </div>
    </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-pzjw8f+vbBCRBfXJFcCB2AyH2+pYaaJTMf2spiVNAWTfBvXa+matISKVC6D5IgvJ" crossorigin="anonymous"></script>
</body>
</html>