<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Alumno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.4);
        }

        .modal-content {
            background: white;
            padding: 20px;
            margin: 10% auto;
            width: 50%;
        }

        .modal-header {
            background-color: #007bff;
            color: white;
        }

        .btn-close {
            cursor: pointer;
        }

        /* Ajusta el tamaño del modal */
        .custom-modal-lg {
            max-width: 80vw;  /* Puedes ajustar este valor según lo necesites */
        }
        
    </style>
</head>
<body>
    <!-- Modal -->
    <div class="modal fade" id="modalAgregarAlumno" tabindex="-1" aria-labelledby="modalAgregarAlumnoLabel" aria-hidden="true">
        <div class="modal-dialog custom-modal-lg">  <!-- Aquí se aplica la clase personalizada -->
            <div class="modal-content contenido">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarAlumnoLabel">Agregar Alumno</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('alumnos.store') }}" method="POST" id="formAgregarAlumno">
                    @csrf
                    <div class="modal-body">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="inputRFC" class="form-label">RFC (mayúsculas)</label>
                                <input type="text" name="rfc" class="form-control" id="inputRFC" required>
                            </div>

                            <div class="col-md-6">
                                <label for="inputNombre" class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control" id="inputNombre" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="inputApP" class="form-label">Apellido Paterno</label>
                                <input type="text" name="apellido_paterno" class="form-control" id="inputApP" required>
                            </div>

                            <div class="col-md-6">
                                <label for="inputApM" class="form-label">Apellido Materno</label>
                                <input type="text" name="apellido_materno" class="form-control" id="inputApM">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="inputFechaNacimiento" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" name="fecha_nacimiento" class="form-control" id="inputFechaNacimiento" required>
                            </div>

                            <div class="col-md-6">
                                <label for="selectPermiso" class="form-label">Permiso</label>
                                <select name="permiso" class="form-control" id="selectPermiso" required>
                                    <option value="A">SI</option>
                                    <option value="B">NO</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="inputCalle" class="form-label">Calle</label>
                                <input type="text" name="calle" class="form-control" id="inputCalle" required>
                            </div>

                            <div class="col-md-6">
                                <label for="inputNumero" class="form-label">Número</label>
                                <input type="text" name="numero" class="form-control" id="inputNumero" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="inputColonia" class="form-label">Colonia</label>
                                <input type="text" name="colonia" class="form-control" id="inputColonia" required>
                            </div>

                            <div class="col-md-6">
                                <label for="inputAlcaldia" class="form-label">Alcaldía</label>
                                <input type="text" name="alcaldia" class="form-control" id="inputAlcaldia" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="inputCorreo" class="form-label">Correo</label>
                                <input type="email" name="correo" class="form-control" id="inputCorreo">
                            </div>

                            <div class="col-md-6">
                                <label for="inputObservaciones" class="form-label">Observaciones</label>
                                <textarea name="observaciones" class="form-control" id="inputObservaciones" rows="2"></textarea>
                            </div>
                        </div>

                    </div> <!-- modal-body -->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
