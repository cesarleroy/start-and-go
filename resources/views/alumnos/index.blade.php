
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <h1>Lista de alumnos</h1>

        <table border="1" cellpadding="5">
            <thead>
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

        @include('alumnos.modals.agregar')
        <!--<img src="{{ asset('img/agregar.png') }}" 
        alt="Agregar" 
        style="width: 60px; cursor:pointer;"
         data-bs-toggle="modal"
        data-bs-target="#modalAgregarAlumno">-->

        <img src="{{ asset('img/agregar.png') }}" 
        id="btnAbrirModal"
        style="width: 60px; cursor:pointer;">




<script>
    document.addEventListener("DOMContentLoaded", function () {

        const boton = document.getElementById("btnAbrirModal");
        const modal = document.getElementById("modalAgregarAlumno");
        const cerrar = document.getElementById("btnCancelarModalAgregarAlumno");

        // ABRIR
        boton.addEventListener("click", function () {
            modal.style.display = "block";
        });

        // CERRAR
        cerrar.addEventListener("click", function () {
            modal.style.display = "none";
        });

        // CERRAR haciendo clic fuera del modal
        window.addEventListener("click", function(e) {
            if (e.target === modal) {
                modal.style.display = "none";
            }
        });

    });
</script>

    </body>
</html>


