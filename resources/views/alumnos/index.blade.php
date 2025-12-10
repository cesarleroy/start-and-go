<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <!-- Agrega el siguiente link en el head de tu archivo app.blade.php -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
            *{
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

        </style>
    </head>
    <body>
        <h1 class="titulo">Lista de alumnos</h1> <br><br>

        <table border="1" cellpadding="5" class="table table-bordered table-striped contenido">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>RFC</th>
                    <th>Nombre</th>
                    <th>Apellido_p</th>
                    <th>Apellido_m</th>
                    <th>Fecha_Nacimiento</th>
                    <th>Calle</th>
                    <th>Numero</th>
                    <th>Colonia</th>
                    <th>Alcaldia</th>
                    <th>Permiso</th>
                    <th>Observaciones</th>
                    <th>Correo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alumnos as $alumno)
                <tr>
                    <td>{{ $alumno->id }}</td>
                    <td>{{ $alumno->rfc }}</td>
                    <td>{{ $alumno->nombre }}</td>
                    <td>{{ $alumno->apellido_p }}</td>
                    <td>{{ $alumno->apellido_m }}</td>
                    <td>{{ $alumno->fecha_nac }}</td>
                    <td>{{ $alumno->calle }}</td>
                    <td>{{ $alumno->numero }}</td>
                    <td>{{ $alumno->colonia }}</td>
                    <td>{{ $alumno->alcaldia }}</td>
                    <td>{{ $alumno->permiso }}</td>
                    <td>{{ $alumno->observaciones }}</td>
                    <td>{{ $alumno->correo }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Incluye el modal de agregar alumno -->
        @include('alumnos.modals.agregar')

        <!-- Imagen para modal -->
        <img src="{{ asset('img/agregar.png') }}" id="btnAbrirModal" style="width: 60px; cursor:pointer;">

        <!-- Scripts para el modal -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Obtener el botón y el modal
                const botonAbrirModal = document.getElementById("btnAbrirModal");
                const modalAgregarAlumno = new bootstrap.Modal(document.getElementById('modalAgregarAlumno'), {});

                // Abrir el modal al hacer clic en la imagen
                botonAbrirModal.addEventListener("click", function () {
                    modalAgregarAlumno.show(); // Abre el modal
                });

                // Cerrar el modal al hacer clic en el botón de cerrar
                const botonCerrarModal = document.getElementById("btnCancelarModalAgregarAlumno");
                botonCerrarModal.addEventListener("click", function () {
                    modalAgregarAlumno.hide(); // Cierra el modal
                });
            });
        </script>

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <!-- Scripts de Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
    </body>
</html>
