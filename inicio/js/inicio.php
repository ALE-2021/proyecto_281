<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
<script>
    // Función para cerrar el modal activo
    function cerrarModalActivo() {
        $('.modal').modal('hide'); // Cierra todos los modales activos
    }

        // Evento click en el enlace "Regístrate" dentro del modal de inicio de sesión
        $('#registrarseLink').click(function() {
            cerrarModalActivo(); // Cierra el modal activo
        });

        // Evento click en el enlace "Login" dentro del modal de inicio de sesión
        $('#loginLink').click(function() {
            cerrarModalActivo(); // Cierra el modal activo
        });
    </script> 
    <script>
        document.getElementById('tipo_usuario').addEventListener('change', function() {
            var tipoUsuario = this.value;
            if (tipoUsuario === 'voluntario') {
                document.getElementById('voluntario_fields').style.display = 'block';
            } else {
                document.getElementById('voluntario_fields').style.display = 'none';
            }
        });
    </script>

    <!-- Agrega este script en la parte inferior de tu página justo antes del cierre del body -->
    <script>
        // Función para restablecer el valor del desplegable cuando se carga la página
        document.addEventListener('DOMContentLoaded', function() {
            resetDropdown();
        });

        // Función para restablecer el valor del desplegable
        function resetDropdown() {
            document.getElementById("tipo_usuario").value = "";
        }
    </script>

    <script>
    function validarContrasena() {
        var contrasena = document.getElementById("contrasena").value;

        //Que contengan como minimo 8 caracteres
        if (contrasena.length < 8) {
            alert("La contraseña debe tener al menos 8 caracteres.");
            return false;
        }
        // Expresión regular para validar al menos dos letras mayúsculas
        var regexMayusculas = /[A-Z].*[A-Z]/;
        
        // Expresión regular para validar al menos dos símbolos
        var regexSimbolos = /[!@#$%^&*()_+{}\[\]:;<>,.?\/\\~-]/;
        
        // Verificar si la contraseña cumple con las condiciones
        if (!regexMayusculas.test(contrasena) || !regexSimbolos.test(contrasena)) {
            alert("La contraseña debe contener al menos dos letras mayúsculas y dos símbolos.");
            return false;
        }
        return true;
    }
    </script>
    
    <script>
        function mostrarOpciones(tipo) {
            if (tipo === 'voluntario') {
                document.getElementById('voluntario_fields').style.display = 'block';
            } else {
                document.getElementById('voluntario_fields').style.display = 'none';
            }
            document.getElementById('tipo_usuario').value = tipo;
        }
    </script>

    <script>
        function definirRol(tipo) {
            document.getElementById('tipo_usuario').value = tipo;
        }
    </script>