<?php
session_start(); // Inicia la sesión

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de Receptor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/receptor.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="logo">
                    <h1><i class="fa-solid fa-leaf"></i></h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <nav class="nav">
                        <ul>
                            <li><a href="../index.php">Inicio</a></li>
                            <li><a href="">Generar Informe</a></li>
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
                        <div class="name">Realiza tus solicitudes</div>
                        <div class="des">Ayudar al que lo necesita no solo es parte del deber, sino de la felicidad</div>
                    </div>
                </div>      
            </div>
        </div>
    </section>

    <section id="solicitud">
        <div class="container">
            <h2>Realizar Solicitud</h2>
            <form action="php/registraSolicitud.php" method="POST" id="solicitudForm">
            <input type="hidden" name="id_receptor" value="<?php echo isset($_SESSION['id_receptor']) ? $_SESSION['id_receptor'] : ''; ?>">
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="producto">Producto Solicitado:</label>
                        <select class="form-control" id="producto" name="producto">
                            <option value="">Selecciona un producto</option>
                            <optgroup label="Granos y Cereales">
                                <option value="Arroz">Arroz</option>
                                <option value="Avena">Avena</option>
                                <option value="Frijoles">Frijoles</option>
                                <option value="Quinua">Quinua</option>
                                <option value="Lentejas">Lentejas</option>
                            </optgroup>
                            <optgroup label="Productos enlatados">
                                <option value="Atun">Atún</option>
                                <option value="Sardinas">Sardinas</option>
                                <option value="Verduras_enlatadas">Verduras Enlatadas</option>
                                <option value="frutas_enlatadas">Frutas enlatadas</option> 
                            </optgroup>
                            <optgroup label="Aceites y grasas">
                                <option value="aceite_vegetal">Aceite vegetal</option>
                                <option value="aceite_oliva">Aceite de oliva</option>
                                <option value="mantequilla">Mantequilla</option>
                            </optgroup>
                            <optgroup label="Productos lacteos">
                                <option value="leche">Leche</option>
                                <option value="queso">Queso</option>
                                <option value="yogur">Yogur</option>
                            </optgroup>
                            <optgroup label="Frutas y verduras">
                                <option value="zanahoria">Zanahoria</option>
                                <option value="cebollas">Cebollas</option>
                                <option value="tomates">Tomates</option>
                                <option value="manzanas">Manzanas</option>
                                <option value="platano">Platano</option>
                                <option value="mandarina">Mandarinas</option>
                                <option value="naranja">Naranjas</option>
                            </optgroup>
                            <optgroup label="Productos de panaderia">
                                <option value="harina">Harina</option>
                                <option value="azucar">Azucar</option>
                                <option value="pastas">Pastas</option>
                                <option value="galletas">Galletas</option>
                            </optgroup>
                            <optgroup label="Carnes y proteina">
                                <option value="carne_enlatada">Carne enlatada</option>
                                <option value="salchicha_enlatada">salchicha enlatada</option>
                                <option value="jamon_enlatado">Jamon enlatado</option>
                                <option value="pollo_enlatado">Pollo</option>
                                <option value="carne_seca">Carne seca</option>
                            </optgroup>
                            <optgroup label="Articulos de uso personal">
                                <option value="camisetas">Camisetas</option>
                                <option value="pantalones">Pantalones</option>
                                <option value="abrigos">Abrigos</option>
                                <option value="zapatos">Zapatos</option>
                            </optgroup>
                            <optgroup label="Articulos de higiene personal">
                                <option value="jabon">Jabon</option>
                                <option value="champu">Champu</option>
                                <option value="pasta_dental">Pasta de dientes</option>
                            </optgroup>
                            <optgroup label="Articulos de cuidado infantil">
                                <option value="panales">Pañales</option>
                                <option value="formula">Formula infantil</option>
                                <option value="toallitas_humedas">Toallitas humedas</option>
                                <option value="ropa_bebe">Ropa de bebe</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="cantidad">Cantidad:</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad">
                    </div>
                    <div class="form-group col-md-2">
                        <button type="button" class="btn btn-primary" id="agregarLista">Agregar a la Lista</button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="listaProductos">Lista de Productos Solicitados:</label>
                    <table class="table" id="listaProductos">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <input type="hidden" id="productos" name="productos">
                <button type="submit" class="btn btn-primary">Enviar Solicitud</button>
            </form>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const agregarBtn = document.getElementById('agregarLista');
            const listaProductos = document.getElementById('listaProductos').querySelector('tbody');
            const productosInput = document.getElementById('productos');
            let productos = [];

            agregarBtn.addEventListener('click', function() {
                const productoSeleccionado = document.getElementById('producto').value;
                const cantidadSeleccionada = document.getElementById('cantidad').value;

                if (productoSeleccionado && cantidadSeleccionada) {
                    if (!productos.some(producto => producto.nombre_producto === productoSeleccionado)) {
                        const productoObj = { nombre_producto: productoSeleccionado, cantidad: cantidadSeleccionada };
                        productos.push(productoObj);

                        const fila = document.createElement('tr');
                        fila.innerHTML = `
                            <td>${productoSeleccionado}</td>
                            <td>${cantidadSeleccionada}</td>
                            <td><button type="button" class="btn btn-danger btn-sm eliminar-producto">Eliminar</button></td>
                        `;
                        listaProductos.appendChild(fila);
                        document.getElementById('producto').value = '';
                        document.getElementById('cantidad').value = '';

                        actualizarProductosInput();
                    } else {
                        alert('El producto ya ha sido agregado a la lista.');
                    }
                }
            });
            function actualizarProductosInput() {
                productosInput.value = JSON.stringify(productos);
            }
            listaProductos.addEventListener('click', function(event) {
                if (event.target.classList.contains('eliminar-producto')) {
                    const fila = event.target.closest('tr');
                    const productoEliminado = fila.querySelector('td:first-child').textContent;
                    productos = productos.filter(producto => producto.nombre_producto !== productoEliminado);
                    fila.remove();
                    actualizarProductosInput();
                }
            });
            document.getElementById('solicitudForm').addEventListener('submit', function(event) {
                if (productos.length === 0) {
                    alert('Debe agregar al menos un producto a la lista.');
                    event.preventDefault();
                }
            });
        });

    </script>
</body>
</html>
