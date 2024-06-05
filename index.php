<?php include 'inicio/php/inicio.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="inicio/css/estilo1.css">
    <link rel="stylesheet" href="inicio/css/estRegistro.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"/> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
    <!--Inicio y login-->
    <section id="inicio">
        <div class="contenido">
            <header>
                <div class="contenido-header">
                    <h1><i class="fa-solid fa-leaf"></i></h1>
                    <nav id="nav" class="">
                        <ul id="links">
                            <li><a href="#inicio">INICIO</a></li>
                            <li><a href="#normas">NORMAS</a></li>
                            <li><a href="#educacion">EDUCACIÓN</a></li>
                            <li><a href="#eventos">EVENTOS</a></li>
                            <li><a id="loginBtn" href="#" data-toggle="modal" data-target="#loginModal">REGISTRARSE</a></li>
                        </ul>
                    </nav> 
                </div>
            </header>
            <div class="presentacion">
                <p class="bienvenidos"><span id="donar">donar</span> <span id="compartir">compartir</span> <span id="cuidar">cuidar</span> </p>
                <P class="descripcion">En FoodLink, creemos en el poder de la comida para unir comunidades, nutrir esperanzas y cambiar vidas. Nuestra misión es simple: conectar a aquellos con alimentos para compartir con aquellos que los necesitan. Juntos,
                    podemos transformar la generosidad en acción y hacer una diferencia tangible en la lucha contra el hambre. Únete a nosotros en este viaje de compasión, solidaridad y cambio positivo. ¡Cada contribución cuenta en nuestro esfuerzo por construir un mundo más alimentado y más unido para todos!"</P>
                <a href="#" data-toggle="modal" data-target="#loginModal">Iniciar sesion o registrarse</a>
            </div>
        </div>
    </section>
    

    <!------Pagina Modal para el login------>

    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Iniciar Sesión</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="inicio/imagenes/incioSes.jpg" class="img-fluid" alt="Imagen de inicio de sesión">
                        </div>
                        <div class="col-md-6">
                            <form action="inicio/php/verLogin.php" method="POST" class="formulario__login">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Correo Electrónico" name="correo">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Contraseña" name="contrasena">
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                            </form>
                            <hr>
                            <p class="text-center">¿No tienes una cuenta? <a href="#" id="registrarseLink" data-toggle="modal" data-target="#registroModal">Regístrate</a></p>
                            <?php include 'inicio/php/recuContrasena.php'; ?>
                            <p class="text-center"><a href="#" id="olvidarContrasenaLink" data-toggle="modal" data-target="#olvidarContrasenaModal">¿Olvidaste tu contraseña?</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de registro -->
<div class="modal fade" id="registroModal" tabindex="-1" role="dialog" aria-labelledby="registroModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registroModalLabel">Registrarse</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="inicio/php/registroUs.php" method="POST" class="formulario__registro" onsubmit="return validarContrasena()">
                    <div class="row mb-4">
                        <div class="col-md-12 text-center">
                            <h4>Selecciona tu tipo de usuario</h4>
                            <div class="btn-group" role="group" aria-label="Tipo de Usuario">
                                <button type="button" class="btn btn-primary" onclick="mostrarOpciones('voluntario')">Voluntario</button>
                                <button type="button" class="btn btn-primary" onclick="mostrarOpciones('donante')">Donante</button>
                                <button type="button" class="btn btn-primary" onclick="mostrarOpciones('receptor')">Receptor</button>
                            </div>
                            <input type="hidden" name="tipo_usuario" id="tipo_usuario" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Nombre" name="nombre" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Apellido" name="apellido" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Carnet" name="carnet" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Correo Electrónico" name="correo" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Contraseña" name="contrasena" id="contrasena" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="telefono o celular" name="celular" id="celular" required>
                    </div>
                    <div id="voluntario_fields" style="display: none;">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Día disponible" name="dia_disponible">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Horario" name="horario">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
                </form>
            </div>
            <div class="modal-footer">
                <p class="text-center">¿Ya te registraste? <a href="#" id="loginLink" data-toggle="modal" data-target="#loginModal">Iniciar Sesión</a></p>
            </div>
        </div>
    </div>
</div>




    <!--SECCION DE CONTENIDO NORMAS-->
    
    <section id="normas">
        <div class="fot1">
            <img src="inicio/imagenes/img2.jpg" alt="">
        </div>
        <div id="contenido">
            <div class="slider">
                <?php foreach ($normas as $index => $normas): ?>
                    <div class="normas" style="<?php echo $index == 0 ? 'display:block;' : 'display:none;'; ?>">
                        <p class="tituloNorma">Normas</p>
                        <h2><?php echo $normas['titulo'];?></h2>
                        <h3>Actividad: <?php echo $normas['nro_norma'];?></h3>
                        <p><?php echo $normas['descripcion_norma'];?></p>
                        <h3>Fecha publicacion: <?php echo $normas['tipo_norma'];?></h3>
                        <a href="#">Descargar</a>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="flechas">
                <i class="fa-solid fa-chevron-left" onclick="cambiarNorma(-1)"></i>
                <i class="fa-solid fa-chevron-right" onclick="cambiarNorma(1)"></i>
            </div>
        </div>
    </section>

    <!--SECCION DE CONTENIDO EDUCACION-->

    <section id="educacion">
        <div class="fot1">
            <img src="inicio/imagenes/normas.jpg" alt="">
        </div>
        <div id="contenido_edu">
            <div class="slider">
                <?php foreach ($educacion as $index => $educacionItem): ?>
                    <div class="educacion" style="<?php echo $index == 0 ? 'display:block;' : 'display:none;'; ?>">
                        <p class="tituloEdu">Centro de Conscientizacion y educacion</p>
                        <h2><?php echo $educacionItem['titulo'];?></h2>
                        <h3>Actividad: <?php echo $educacionItem['tipo_contenido'];?></h3>
                        <p><?php echo $educacionItem['descripcion_edu'];?></p>
                        <h3>Fecha publicacion: <?php echo $educacionItem['fecha_publicacion'];?></h3>
                        <a href="#">Descargar</a>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="flechas-edu">
                <i class="fa-solid fa-chevron-left" onclick="cambiarEdu(-1)"></i>
                <i class="fa-solid fa-chevron-right" onclick="cambiarEdu(1)"></i>
            </div>
  
        </div>
    </section>
    
    <!--Seccion de eventos-->
    <section id="eventos">
    <h3 class="TituloEventos">Eventos</h3>
    <div class="fila">
        <?php $contador = 0; ?>
        <?php foreach ($eventos as $evento): ?>
            <div class="columna">
                <div class="evento">
                    <span class="icono"><i class="fa-solid fa-shop"></i></span>
                    <h4>Tipo: <?php echo $evento['nom_evento'];?></h4>
                    <hr>
                    <ul class="eventos-tag">
                        <li>Fecha: <?php echo $evento["fecha_evento"];?> </li>
                        <li>Hora: <?php echo $evento['hora_evento']; ?></li>
                    </ul>
                    <p>Descripción: <?php echo $evento['descripcion_event']; ?></p>
                </div>
            </div>
            <?php $contador++; ?>
            <?php if ($contador % 3 == 0): ?>
                </div><div class="fila">
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    </section>
    
    
</body>
    <?php include 'inicio/js/inicio.php'; ?>
    <script src="inicio/js/scrpitt.js"></script> 
</html>

