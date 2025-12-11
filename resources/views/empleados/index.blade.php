@extends('layouts.app')

@section('content')
<div class="container-fluid p-4 min-h-[calc(100vh-80px)]">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="welcome mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
             <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Empleados</h2>
        </div>

        <div class="card shadow border-0">
            <div class="card-header bg-white py-3">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-2 mb-md-0">
                        <input type="text" id="busquedaTabla" class="form-control" placeholder="Búsqueda general en la tabla...">
                    </div>
                    <div class="col-md-6 text-end">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarEmpleado">
                            <i class="fas fa-user-plus me-2"></i> Nuevo Empleado
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0" style="width: 100%; white-space: nowrap;">
                        <thead class="text-white" style="background-color: #0d1b2a;"> <tr>
                                <th>Acciones</th>
                                <th>RFC</th>
                                <th>Nombre(s)</th>
                                <th>Apellido P.</th>
                                <th>Apellido M.</th>
                                <th>Puesto</th>
                                <th>Turno</th>
                                <th>Días Descanso</th>
                                <th>Sexo</th>
                                <th>Fecha Nac.</th>
                                <th>Teléfono</th>
                                <th>Calle</th>
                                <th>Número</th>
                                <th>Colonia</th>
                                <th>Alcaldía</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($empleados as $empleado)
                            <tr>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-warning text-white btn-editar-empleado" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalModificarEmpleado"
                                                data-rfc="{{ $empleado->rfc }}"
                                                data-nombre="{{ $empleado->nombre }}"
                                                data-apellido_p="{{ $empleado->apellido_p }}"
                                                data-apellido_m="{{ $empleado->apellido_m }}"
                                                data-puesto="{{ $empleado->puesto }}"
                                                data-turno="{{ $empleado->turno }}"
                                                data-sexo="{{ $empleado->sexo }}"
                                                data-fecha="{{ $empleado->fecha_nac }}"
                                                data-tel="{{ $empleado->tel_personal }}"
                                                data-calle="{{ $empleado->calle }}"
                                                data-numero="{{ $empleado->numero }}"
                                                data-colonia="{{ $empleado->colonia }}"
                                                data-alcaldia="{{ $empleado->alcaldia }}"
                                                data-descansos="{{ $empleado->descansos }}">
                                                <i class="fas fa-edit"></i>
                                        </button>


                                        <form action="{{ route('empleados.destroy', $empleado->rfc) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar a este empleado?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td>{{ $empleado->rfc }}</td>
                                <td>{{ $empleado->nombre }}</td>
                                <td>{{ $empleado->apellido_p }}</td>
                                <td>{{ $empleado->apellido_m }}</td>
                                <td>{{ $empleado->puesto }}</td>
                                <td>{{ $empleado->turno }}</td>
                                <td><small>{{ $empleado->descansos }}</small></td>
                                <td>{{ $empleado->sexo }}</td>
                                <td>{{ $empleado->fecha_nac }}</td>
                                <td>{{ $empleado->tel_personal }}</td>
                                <td>{{ $empleado->calle }}</td>
                                <td>{{ $empleado->numero }}</td>
                                <td>{{ $empleado->colonia }}</td>
                                <td>{{ $empleado->alcaldia }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="15" class="text-center py-5 bg-light">
                                    <h5 class="text-muted">No hay empleados registrados.</h5>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAgregarEmpleado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl"> <div class="modal-content">
            <form action="{{ route('empleados.store') }}" method="POST">
                @csrf
                <div class="modal-header text-white" style="background-color: #092c4c;"> 
                    <h5 class="modal-title fw-bold">Agregar Nuevo Empleado</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">RFC (en mayúsculas)</label>
                            <input type="text" name="rfc" class="form-control" required 
                                   pattern="^[A-ZÑ&]{4}\d{6}[A-Z0-9]{3}$" 
                                   title="Formato de RFC inválido">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nombre(s)</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Apellido Paterno</label>
                            <input type="text" name="apellido_p" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Apellido Materno</label>
                            <input type="text" name="apellido_m" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Puesto</label>
                            <input type="text" name="puesto" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Turno</label>
                            <select name="turno" class="form-select" required>
                                <option value="" disabled selected>Seleccione...</option>
                                <option value="MATUTINO">MATUTINO</option>
                                <option value="VESPERTINO">VESPERTINO</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label d-block fw-bold">Días de descanso</label>
                            <div class="d-flex flex-wrap gap-3 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="descansos[]" value="LUNES" id="dLun">
                                    <label class="form-check-label" for="dLun">Lunes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="descansos[]" value="MARTES" id="dMar">
                                    <label class="form-check-label" for="dMar">Martes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="descansos[]" value="MIERCOLES" id="dMie">
                                    <label class="form-check-label" for="dMie">Miércoles</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="descansos[]" value="JUEVES" id="dJue">
                                    <label class="form-check-label" for="dJue">Jueves</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="descansos[]" value="VIERNES" id="dVie">
                                    <label class="form-check-label" for="dVie">Viernes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="descansos[]" value="SABADO" id="dSab">
                                    <label class="form-check-label" for="dSab">Sábado</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="descansos[]" value="DOMINGO" id="dDom">
                                    <label class="form-check-label" for="dDom">Domingo</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Sexo</label>
                            <select name="sexo" class="form-select" required>
                                <option value="" disabled selected>Seleccione...</option>
                                <option value="MASCULINO">MASCULINO</option>
                                <option value="FEMENINO">FEMENINO</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Fecha de nacimiento</label>
                            <input type="date" name="fecha_nac" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Teléfono personal</label>
                            <input type="text" name="tel" class="form-control" required pattern="^\d{10}$" title="10 dígitos">
                        </div>

                        <div class="col-12 mt-4">
                            <h6 class="fw-bold border-bottom pb-2">Dirección</h6>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label fw-bold">Calle</label>
                            <input type="text" name="calle" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Número</label>
                            <input type="text" name="numero" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Colonia</label>
                            <input type="text" name="colonia" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Alcaldía</label>
                            <input type="text" name="alcaldia" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn text-white" style="background-color: #212529;">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalModificarEmpleado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="formEditar" method="POST">
                @csrf
                @method('PUT') 
                <div class="modal-header text-white" style="background-color: #092c4c;">
                    <h5 class="modal-title fw-bold">Modificar Empleado</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Nombre</label>
                            <input type="text" name="nombre" id="edit_nombre" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Apellido Paterno</label>
                            <input type="text" name="apellido_p" id="edit_ap" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Apellido Materno</label>
                            <input type="text" name="apellido_m" id="edit_am" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Puesto</label>
                            <input type="text" name="puesto" id="edit_puesto" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Turno</label>
                            <select name="turno" id="edit_turno" class="form-select" required>
                                <option value="MATUTINO">MATUTINO</option>
                                <option value="VESPERTINO">VESPERTINO</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                             <label class="form-label fw-bold text-danger">Nota: Vuelve a seleccionar los días de descanso</label>
                             <div class="d-flex flex-wrap gap-3">
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="descansos[]" value="LUNES"><label class="form-check-label">Lunes</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="descansos[]" value="MARTES"><label class="form-check-label">Martes</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="descansos[]" value="MIERCOLES"><label class="form-check-label">Miércoles</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="descansos[]" value="JUEVES"><label class="form-check-label">Jueves</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="descansos[]" value="VIERNES"><label class="form-check-label">Viernes</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="descansos[]" value="SABADO"><label class="form-check-label">Sábado</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="descansos[]" value="DOMINGO"><label class="form-check-label">Domingo</label></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Sexo</label>
                            <select name="sexo" id="edit_sexo" class="form-select" required>
                                <option value="MASCULINO">MASCULINO</option>
                                <option value="FEMENINO">FEMENINO</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Fecha de nacimiento</label>
                            <input type="date" name="fecha_nac" id="edit_fecha" class="form-control" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Teléfono</label>
                            <input type="text" name="tel" id="edit_tel" class="form-control" required>
                        </div>

                        <div class="col-12 mt-4"><h6 class="fw-bold border-bottom pb-2">Dirección</h6></div>

                        <div class="col-md-8"><label class="form-label fw-bold">Calle</label><input type="text" name="calle" id="edit_calle" class="form-control"></div>
                        <div class="col-md-4"><label class="form-label fw-bold">Número</label><input type="text" name="numero" id="edit_numero" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Colonia</label><input type="text" name="colonia" id="edit_colonia" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Alcaldía</label><input type="text" name="alcaldia" id="edit_alcaldia" class="form-control"></div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn text-white" style="background-color: #212529;">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lógica para llenar el Modal de Edición
        const botonesEditar = document.querySelectorAll('.btn-editar');
        botonesEditar.forEach(boton => {
            boton.addEventListener('click', function() {
                // Obtener datos del botón (data-attributes)
                const rfc = this.dataset.rfc;
                
                // Llenar inputs
                document.getElementById('edit_nombre').value = this.dataset.nombre;
                document.getElementById('edit_ap').value = this.dataset.apellido_p;
                document.getElementById('edit_am').value = this.dataset.apellido_m;
                document.getElementById('edit_puesto').value = this.dataset.puesto;
                document.getElementById('edit_turno').value = this.dataset.turno;
                document.getElementById('edit_sexo').value = this.dataset.sexo;
                document.getElementById('edit_fecha').value = this.dataset.fecha;
                document.getElementById('edit_tel').value = this.dataset.tel;
                document.getElementById('edit_calle').value = this.dataset.calle;
                document.getElementById('edit_numero').value = this.dataset.numero;
                document.getElementById('edit_colonia').value = this.dataset.colonia;
                document.getElementById('edit_alcaldia').value = this.dataset.alcaldia;
                
                // Actualizar action del form
                const form = document.getElementById('formEditar');
                form.action = `/empleados/${rfc}`;
            });
        });

        // Buscador básico en tabla
        document.getElementById('busquedaTabla').addEventListener('keyup', function() {
            let searchText = this.value.toLowerCase();
            let tableRows = document.querySelectorAll('tbody tr');
            
            tableRows.forEach(row => {
                let rowText = row.innerText.toLowerCase();
                row.style.display = rowText.includes(searchText) ? '' : 'none';
            });
        });
    });

document.addEventListener('DOMContentLoaded', function () {

    const botonesEditar = document.querySelectorAll('.btn-editar-alumno');

    botonesEditar.forEach(boton => {
        boton.addEventListener('click', function () {

            // Llenar inputs
            document.getElementById('edit_rfc').value           = this.dataset.rfc;
            document.getElementById('edit_nombre').value        = this.dataset.nombre;
            document.getElementById('edit_apellido_p').value    = this.dataset.apellido_p;
            document.getElementById('edit_apellido_m').value    = this.dataset.apellido_m;
            document.getElementById('edit_fecha_nac').value     = this.dataset.fecha_nac;
            document.getElementById('edit_permiso').value       = this.dataset.permiso;
            document.getElementById('edit_calle').value         = this.dataset.calle;
            document.getElementById('edit_numero').value        = this.dataset.numero;
            document.getElementById('edit_colonia').value       = this.dataset.colonia;
            document.getElementById('edit_alcaldia').value      = this.dataset.alcaldia;
            document.getElementById('edit_correo').value        = this.dataset.correo;
            document.getElementById('edit_observaciones').value = this.dataset.observaciones;

            // Actualizar la acción del formulario
            const form = document.getElementById('formEditarAlumno');
            form.action = `/alumnos/${this.dataset.rfc}`;
        });
    });

});
</script>

@endsection