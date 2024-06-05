<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Website</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .card {
            margin-bottom: 20px;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card img {
            height: 200px;
            object-fit: cover;
        }
        .navbar-brand {
            color: #fff !important;
        }
        .navbar-nav .nav-link {
            color: #fff !important;
        }
        .header {
            background-color: #101d5d;
            padding: 10px 0;
        }
        .header .nav ul {
            display: flex;
            justify-content: space-around;
            list-style: none;
            padding: 0;
        }
        .header .nav ul li {
            margin: 0 10px;
        }
        .header .nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
    <link rel="stylesheet" href="css/donador.css">
</head>
<body>
    <header class="header">
        <div class="logo">
        </div>
        <nav class="nav">
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="perfil.php">Perfil</a></li>
                <li><a href="fpdf/PruebaV.php" target="_blank">Generar Reporte</a></li>
                <li><a href="../index.php">Salir</a></li>
            </ul>
        </nav>
    </header>
    <section id="inicio">
        <div class="container">
            <div class="slide">
                <div class="item" style="background-image: url(imagenes/donador2.jpg);">
                    <div class="content">
                        <h1>Bienvenido</h1>
                        <div class="name">Realiza tus donaciones</div>
                        <div class="des">Tu aporte es muy importante para cada formar un mundo mejor</div>
                        <button class="prev">Anterior</button>
                        <button class="next">Siguiente</button>
                    </div>
                </div>         
            </div>
        </div>
    </section>

    <div class="container mt-4">
        <button class="btn btn-primary btn-lg" onclick="mostrarCarrito()">Ver Carrito</button>
    </div>

    <h1>Catalogo de Productos</h1>
    <div class="container">
        <section class="descripcion">
        <h2 class="mt-5 mb-4">Granos y Cereales</h2>
        <div class="row">
            <!-- Tarjeta Arroz -->
            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/arroz.jpg" class="card-img-top" alt="Arroz">
                    <div class="card-body">
                        <h5 class="card-title">Arroz</h5>
                        <form id="form-arroz">
                            <div class="form-group">
                                <label for="peso-arroz">Peso por unidad (kg):</label>
                                <input type="number" class="form-control" id="peso-arroz" min="0" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label for="cantidad-arroz">Cantidad de bolsas:</label>
                                <input type="number" class="form-control" id="cantidad-arroz" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Arroz', document.getElementById('peso-arroz').value, document.getElementById('cantidad-arroz').value)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Fin Tarjeta Arroz -->

            <!-- Tarjeta Avena -->
            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/avena.jpeg" class="card-img-top" alt="Avena">
                    <div class="card-body">
                        <h5 class="card-title">Avena</h5>
                        <form id="form-avena">
                            <div class="form-group">
                                <label for="peso-avena">Peso por unidad (kg):</label>
                                <input type="number" class="form-control" id="peso-avena" min="0" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label for="cantidad-avena">Cantidad de bolsas:</label>
                                <input type="number" class="form-control" id="cantidad-avena" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Avena', document.getElementById('peso-avena').value, document.getElementById('cantidad-avena').value)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Fin Tarjeta Avena -->

            <!-- Tarjeta Frijoles -->
            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/frijoles.jpeg" class="card-img-top" alt="Frijoles">
                    <div class="card-body">
                        <h5 class="card-title">Frijoles</h5>
                        <form id="form-frijoles">
                            <div class="form-group">
                                <label for="peso-frijoles">Peso por unidad (kg):</label>
                                <input type="number" class="form-control" id="peso-frijoles" min="0" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label for="cantidad-frijoles">Cantidad en bolsas:</label>
                                <input type="number" class="form-control" id="cantidad-frijoles" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Frijoles', document.getElementById('peso-frijoles').value, document.getElementById('cantidad-frijoles').value)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Fin Tarjeta Frijoles -->
            <!-- Tarjeta Quinua -->
            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/quinua.jpeg" class="card-img-top" alt="Quinua">
                    <div class="card-body">
                        <h5 class="card-title">Quinua</h5>
                        <form id="form-quinua">
                            <div class="form-group">
                                <label for="peso-quinua">Peso por unidad (kg):</label>
                                <input type="number" class="form-control" id="peso-quinua" min="0" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label for="cantidad-quinua">Cantidad de bolsas:</label>
                                <input type="number" class="form-control" id="cantidad-quinua" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Quinua', document.getElementById('peso-quinua').value, document.getElementById('cantidad-quinua').value)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Fin Tarjeta Quinua -->
            <!-- Tarjeta lentejas -->
            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/lenteja.jpeg" class="card-img-top" alt="lentejas">
                    <div class="card-body">
                        <h5 class="card-title">Lentejas</h5>
                        <div class="form-group">
                            <label for="peso-lentejas">Peso por unidad (kg):</label>
                            <input type="number" class="form-control" id="peso-lentejas" min="0" step="0.01" required>
                        </div>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-lentejas">Cantidad en bolsas:</label>
                                <input type="number" class="form-control" id="cantidad-lentejas" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Lentejas', document.getElementById('peso-lentejas').value, document.getElementById('cantidad-lentejas').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Fin Tarjeta lentejas -->
            
        </div>

        <!-- LISTADO DE PRODUCTOS ENLATADOS -->
        <h2 class="mt-5 mb-4">Productos enlatados </h2>
        <div class="row">

            <!-- Tarjeta Atun -->
            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/atun.jpg" class="card-img-top" alt="atun">
                    <div class="card-body">
                        <h5 class="card-title">Atun</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-atun">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-atun" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Atun',undefined, document.getElementById('cantidad-atun').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Fin Tarjeta Arroz -->

            <!-- Tarjeta Sardinas -->
            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/sardina.jpeg" class="card-img-top" alt="sardina">
                    <div class="card-body">
                        <h5 class="card-title">Sardinas</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-sardina">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-sardina" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Sardinas', undefined, document.getElementById('cantidad-sardina').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Fin Tarjeta Sardina -->

            <!-- Tarjeta Verduras enlatadas -->
            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/verduras.jpg" class="card-img-top" alt="verduras">
                    <div class="card-body">
                        <h5 class="card-title">Verduras enlatadas</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-verdurasE">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-verdurasE" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Verduras enlatadas', undefined,document.getElementById('cantidad-verdurasE').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Tarjeta frutas enlatadas -->
            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/FRUTAS.jpeg" class="card-img-top" alt="frutas">
                    <div class="card-body">
                        <h5 class="card-title">Frutas enlatadas</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-frutaE">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-frutaE" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Frutas enlatadas', undefined,document.getElementById('cantidad-frutaE').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Fin Tarjeta frutas enlatadas -->    
        </div>

        <!-- LISTADO DE ACEITES Y GRASAS -->   
        <h2 class="mt-5 mb-4">Aceites y grasas </h2>
        <div class="row">

            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/aceite.jpeg" class="card-img-top" alt="aceite">
                    <div class="card-body">
                        <h5 class="card-title">Aceite vegetal</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-aceiteV">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-aceiteV" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Aceite vegetal', undefined,document.getElementById('cantidad-aceiteV').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/oliva.jpeg" class="card-img-top" alt="oliva">
                    <div class="card-body">
                        <h5 class="card-title">Aceite de oliva</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-aceiteO">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-aceiteO" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Aceite  de oliva', undefined,document.getElementById('cantidad-aceiteO').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/mantequilla.jpeg" class="card-img-top" alt="mantequilla">
                    <div class="card-body">
                        <h5 class="card-title">Mantequilla</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-mantequilla">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-mantequilla" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Mantequilla', undefined,document.getElementById('cantidad-mantequilla').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>
               
        </div>
        <!-- LISTADO DE PRODUCTOS LACTEOS -->   
        <h2 class="mt-5 mb-4">Productos lácteos </h2>
        <div class="row">

            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/leche.jpeg" class="card-img-top" alt="leche">
                    <div class="card-body">
                        <h5 class="card-title">Leche</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-leche">Cantidad en unidades:</label>
                                <input type="number" class="form-control" id="cantidad-leche" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Leche', undefined,document.getElementById('cantidad-leche').value,this)">Agregar al Carrito</button>
                        
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/queso.jpeg" class="card-img-top" alt="queso">
                    <div class="card-body">
                        <h5 class="card-title">Queso</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-queso">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-queso" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Queso', undefined,document.getElementById('cantidad-queso').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/yogur.jpg" class="card-img-top" alt="yogur">
                    <div class="card-body">
                        <h5 class="card-title">Yogur</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-yogur">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-yogur" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Yogur', undefined,document.getElementById('cantidad-yogur').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>
               
        </div>
        <!-- LISTADO DE PRODUCTOS FRUTAS Y VERDURAS -->   
        <h2 class="mt-5 mb-4">Frutas y verduras </h2>
        <div class="row">

            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/zanahoria.jpg" class="card-img-top" alt="zanahoria">
                    <div class="card-body">
                        <h5 class="card-title">Zanahoria</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-zanahoria">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-zanahoria" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Zahanoria', undefined,document.getElementById('cantidad-zanahoria').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/cebolla.jpg" class="card-img-top" alt="cebolla">
                    <div class="card-body">
                        <h5 class="card-title">Cebollas</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-cebolla">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-cebolla" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Cebolla', undefined,document.getElementById('cantidad-cebolla').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/tomate.jpeg" class="card-img-top" alt="tomate">
                    <div class="card-body">
                        <h5 class="card-title">Tomates</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-tomates">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-tomates" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Tomates', undefined,document.getElementById('cantidad-tomates').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/manzana.jpg" class="card-img-top" alt="manzanas">
                    <div class="card-body">
                        <h5 class="card-title">Manzanas</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-manzanas">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-manzanas" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Manzanas', undefined,document.getElementById('cantidad-manzanas').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/platano.jpg" class="card-img-top" alt="platanos">
                    <div class="card-body">
                        <h5 class="card-title">Platano</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-platanos">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-platanos" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Platanos', undefined,document.getElementById('cantidad-platanos').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/mandarina.jpeg" class="card-img-top" alt="mandarinas">
                    <div class="card-body">
                        <h5 class="card-title">Mandarinas</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-mandarinas">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-mandarinas" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Platanos', undefined,document.getElementById('cantidad-mandarinas').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/naranja.jpg" class="card-img-top" alt="naranjas">
                    <div class="card-body">
                        <h5 class="card-title">Naranjas</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-naranjas">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-naranjas" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Naranjas', undefined,document.getElementById('cantidad-naranjas').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- LISTADO DE PRODUCTOS HARINAS -->   
        <h2 class="mt-5 mb-4">Productos de panaderia </h2>
        <div class="row">

            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/harina.jpg" class="card-img-top" alt="harina">
                    <div class="card-body">
                        <h5 class="card-title">Harina</h5>
                        <div class="form-group">
                            <label for="peso-avena">Peso por unidad (kg):</label>
                            <input type="number" class="form-control" id="peso-avena" min="0" step="0.01" required>
                        </div>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-harina">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-harina" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Harina', document.getElementById('peso-harina').value, document.getElementById('cantidad-harina').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/azucar.jpg" class="card-img-top" alt="azucar">
                    <div class="card-body">
                        <h5 class="card-title">Azucar</h5>
                        <div class="form-group">
                            <label for="peso-avena">Peso por unidad (kg):</label>
                            <input type="number" class="form-control" id="peso-azucar" min="0" step="0.01" required>
                        </div>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-avena">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-azucar" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Azucar', document.getElementById('peso-azucar').value, document.getElementById('cantidad-azucar').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/pastas.jpg" class="card-img-top" alt="pastas">
                    <div class="card-body">
                        <h5 class="card-title">Pastas</h5>
                        <div class="form-group">
                            <label for="peso-pastas">Peso por unidad (kg):</label>
                            <input type="number" class="form-control" id="peso-pastas" min="0" step="0.01" required>
                        </div>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-frijoles">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-frijoles" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Pastas', document.getElementById('peso-pastas').value, document.getElementById('cantidad-pastas').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/galletas.jpg" class="card-img-top" alt="galletas">
                    <div class="card-body">
                        <h5 class="card-title">Galletas</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-galletas">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-gelletas" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Galletas', document.getElementById('peso-galletas').value, document.getElementById('cantidad-galletas').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- LISTADO DE PRODUCTOS CARNES -->   
        <h2 class="mt-5 mb-4">Carnes y proteínas </h2>
        <div class="row">

            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/carne.jpg" class="card-img-top" alt="carne">
                    <div class="card-body">
                        <h5 class="card-title">Carne enlatada</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-carneE">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-carneE" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Carne enlatada', undefined, document.getElementById('cantidad-carnE').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/salchicha.jpeg" class="card-img-top" alt="salchicha">
                    <div class="card-body">
                        <h5 class="card-title">Salchicha enlatada</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-salchichaE">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-salchichaE" min="0" required>
                            </div>
                            <button type="button" class="btn btn-primary" onclick="agregarAlCarrito('Salchicha', undefined, document.getElementById('cantidad-salchichaE').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/jamon.jpg" class="card-img-top" alt="jamon">
                    <div class="card-body">
                        <h5 class="card-title">Jamón enlatado</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-jamonE">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-jamonE" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Jamon', undefined, document.getElementById('cantidad-jamonE').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/pollo.jpg" class="card-img-top" alt="pollo">
                    <div class="card-body">
                        <h5 class="card-title">Pollo enlatado</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-pollo">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-pollo" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Pollo', undefined, document.getElementById('cantidad-pollo').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/seca.jpg" class="card-img-top" alt="seca">
                    <div class="card-body">
                        <h5 class="card-title">Carne seca</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-carneS">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-carneS" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Carne Seca', undefined, document.getElementById('cantidad-carneS').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>
               
        </div>
        <!-- LISTADO DE PRODUCTOS DE OTROS PRODUCTOS -->   
        <h2 class="mt-5 mb-4">Articulos de uso personal </h2>
        <h3 class="mt-5 mb-4">Ropa </h3>
        <div class="row">

            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/camisetas.png" class="card-img-top" alt="camisetas">
                    <div class="card-body">
                        <h5 class="card-title">Camisetas</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-camisetas">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-camisetas" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Camisetas', undefined, document.getElementById('cantidad-camisetas').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/pantaloones.png" class="card-img-top" alt="pantalones">
                    <div class="card-body">
                        <h5 class="card-title">Pantalones</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-pantalones">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-pantalones" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Pantalones', undefined, document.getElementById('cantidad-pantalones').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/arbigo.png" class="card-img-top" alt="abrigo">
                    <div class="card-body">
                        <h5 class="card-title">Abrigos</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-abrigos">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-abrigos" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Abrigos', undefined, document.getElementById('cantidad-abrigos').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/zapato.png" class="card-img-top" alt="zapatos">
                    <div class="card-body">
                        <h5 class="card-title">Zapatos</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-zapatos">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-zapatos" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Zapatos', undefined, document.getElementById('cantidad-zapatos').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>   
        </div>

        <h3 class="mt-5 mb-4">Articulos de higiene personal </h3>
        <div class="row">

            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/jabon.png" class="card-img-top" alt="jabon">
                    <div class="card-body">
                        <h5 class="card-title">Jabón</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-jabon">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-jabon" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Jabón', undefined, document.getElementById('cantidad-jabon').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/champu.jpg" class="card-img-top" alt="champu">
                    <div class="card-body">
                        <h5 class="card-title">Champú</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-champu">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-champu" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Champú', undefined, document.getElementById('cantidad-champu').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <img src="imagenes/pastad.png" class="card-img-top" alt="pastad">
                    <div class="card-body">
                        <h5 class="card-title">Pasta de dientes</h5>
                        <form>
                            <div class="form-group">
                                <label for="cantidad-pastaD">Cantidad en unidad:</label>
                                <input type="number" class="form-control" id="cantidad-pastaD" min="0" required>
                            </div>
                            <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Pasta dental', undefined, document.getElementById('cantidad-pastaD').value,this)">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="mt-5 mb-4">Productos de cuidado infantil </h3>
        <div class="row">

                <div class="col-md-3">
                    <div class="card">
                        <img src="imagenes/panales.png" class="card-img-top" alt="panales">
                        <div class="card-body">
                            <h5 class="card-title">Pañales</h5>
                            <form>
                                <div class="form-group">
                                    <label for="cantidad-panales">Cantidad en unidad:</label>
                                    <input type="number" class="form-control" id="cantidad-panales" min="0" required>
                                </div>
                                <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Pañales', undefined, document.getElementById('cantidad-panales').value,this)">Agregar al Carrito</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <img src="imagenes/formula.png" class="card-img-top" alt="formula">
                        <div class="card-body">
                            <h5 class="card-title">Fórmula infantil</h5>
                            <form>
                                <div class="form-group">
                                    <label for="cantidad-formula">Cantidad en unidad:</label>
                                    <input type="number" class="form-control" id="cantidad-formula" min="0" required>
                                </div>
                                <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Fórmula', undefined, document.getElementById('cantidad-formula').value,this)">Agregar al Carrito</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <img src="imagenes/toallitas.png" class="card-img-top" alt="toallitas">
                        <div class="card-body">
                            <h5 class="card-title">Toallitas húmedas:</h5>
                            <form>
                                <div class="form-group">
                                    <label for="cantidad-toallitas">Cantidad en unidad:</label>
                                    <input type="number" class="form-control" id="cantidad-toallitas" min="0" required>
                                </div>
                                <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Toallitas humedas', undefined, document.getElementById('cantidad-toallitas').value,this)">Agregar al Carrito</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <img src="imagenes/bebe.jpg" class="card-img-top" alt="bebe">
                        <div class="card-body">
                            <h5 class="card-title">Ropa de bebé:</h5>
                            <form>
                                <div class="form-group">
                                    <label for="cantidad-ropa">Cantidad en unidad:</label>
                                    <input type="number" class="form-control" id="cantidad-ropa" min="0" required>
                                </div>
                                <button type="button" class="btn btn-success btn-lg" onclick="agregarAlCarrito('Ropa para bebe', undefined, document.getElementById('cantidad-ropa').value,this)">Agregar al Carrito</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        </section>
    </div>

    <script>
        function agregarAlCarrito(nombre, peso, cantidad) {
            var formData = new FormData();
            formData.append('producto', nombre);
            
            // Verificar si el campo de peso está presente y no está vacío
            if (document.getElementById('peso-' + nombre.toLowerCase()) !== null && peso !== '') {
                formData.append('peso', peso);
            } else {
                formData.append('peso', '-'); // Enviar un guion si el campo de peso no está presente o está vacío
            }
            
            formData.append('cantidad', cantidad);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'carrito.php', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    console.log('Producto agregado al carrito:', nombre);
                    alert('Producto agregado al carrito: ' + nombre);
                } else {
                    alert('Error al agregar producto al carrito');
                }
            };
            xhr.send(formData);
        }

        function mostrarCarrito() {
            window.location.href = 'carrito.php';
        }

        function buscarCategoria() {
            var input, filter, cards, cardContainer, title, i;
            input = document.getElementById("buscarCategoria");
            filter = input.value.toLowerCase();
            cardContainer = document.getElementsByClassName("descripcion")[0];
            cards = cardContainer.getElementsByClassName("col-md-3");
            for (i = 0; i < cards.length; i++) {
                title = cards[i].getElementsByClassName("card-title")[0];
                if (title.innerHTML.toLowerCase().indexOf(filter) > -1) {
                    cards[i].style.display = "";
                } else {
                    cards[i].style.display = "none";
                }
            }
        }
    </script>
    

</body>
</html>
