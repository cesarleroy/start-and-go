@extends('layouts.app')

@section('content')
<div class="container-fluid p-4 min-h-[calc(100vh-80px)] relative">
    
    @if(session('success')) <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div> @endif
    @if($errors->any()) <div class="alert alert-danger alert-dismissible fade show"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div> @endif

    <div class="welcome mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
             <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Empleados</h2>
        </div>

        <div class="card shadow border-0">
            <div class="card-header bg-white py-3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <input type="text" id="busquedaTabla" class="form-control" placeholder="Búsqueda general...">
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
                    <table class="table table-striped table-hover align-middle mb-0" style="white-space: nowrap;">
                        <thead class="text-white" style="background-color: #0d1b2a;"> 
                            <tr>
                                <th class="text-center" style="width: 50px;"><i class="fas fa-check-circle"></i></th>
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
                            <tr class="cursor-pointer row-selectable">
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input row-checkbox"
                                        value="{{ $empleado->rfc }}"
                                        data-rfc="{{ $empleado->rfc }}"
                                        data-nombre="{{ $empleado->nombre }}"
                                        data-apellido_p="{{ $empleado->apellido_p }}"
                                        data-apellido_m="{{ $empleado->apellido_m }}"
                                        data-puesto="{{ $empleado->puesto }}"
                                        data-turno="{{ $empleado->turno }}"
                                        data-sexo="{{ $empleado->sexo }}"
                                        data-fecha="{{ $empleado->fecha_nac->format('Y-m-d') }}"
                                        data-tel="{{ $empleado->tel_personal }}"
                                        data-calle="{{ $empleado->calle }}"
                                        data-numero="{{ $empleado->numero }}"
                                        data-colonia="{{ $empleado->colonia }}"
                                        data-alcaldia="{{ $empleado->alcaldia }}"
                                        data-descansos="{{ $empleado->descansos }}"
                                    >
                                </td>
                                <td>{{ $empleado->rfc }}</td>
                                <td>{{ $empleado->nombre }}</td>
                                <td>{{ $empleado->apellido_p }}</td>
                                <td>{{ $empleado->apellido_m }}</td>
                                <td>{{ $empleado->puesto }}</td>
                                <td>{{ $empleado->turno }}</td>
                                <td><small>{{ $empleado->descansos }}</small></td>
                                <td>{{ $empleado->sexo }}</td>
                                <td>{{ $empleado->fecha_nac->format('Y-m-d') }}</td>
                                <td>{{ $empleado->tel_personal }}</td>
                                <td>{{ $empleado->calle }}</td>
                                <td>{{ $empleado->numero }}</td>
                                <td>{{ $empleado->colonia }}</td>
                                <td>{{ $empleado->alcaldia }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="15" class="text-center py-5 bg-light"><h5 class="text-muted">No hay empleados registrados.</h5></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MENÚ FLOTANTE --}}
<div id="floating-actions" class="position-fixed bottom-0 end-0 m-4 p-3 bg-[#fff] dark:bg-gray-800 shadow-lg rounded-pill d-none align-items-center gap-3 z-50 border border-gray-200 dark:border-gray-700">
    <span class="fw-bold text-gray-700 dark:text-gray-200 ps-2">Empleado seleccionado</span>
    
    <button id="btn-float-edit" class="btn btn-warning text-white btn-sm rounded-circle shadow-sm" style="width: 40px; height: 40px;" title="Editar" data-bs-toggle="modal" data-bs-target="#modalModificarEmpleado">
        <i class="fas fa-edit"></i>
    </button>

    <button id="btn-float-delete" class="btn btn-danger btn-sm rounded-circle shadow-sm" style="width: 40px; height: 40px;" title="Eliminar" data-bs-toggle="modal" data-bs-target="#modalConfirmarEliminar">
        <i class="fas fa-trash"></i>
    </button>
</div>

{{-- MODAL AGREGAR --}}
<div class="modal fade" id="modalAgregarEmpleado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl"> 
        <div class="modal-content">
            <form action="{{ route('empleados.store') }}" method="POST">
                @csrf
                <div class="modal-header text-white" style="background-color: #092c4c;"> 
                    <h5 class="modal-title fw-bold">Agregar Nuevo Empleado</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                
                {{-- Fondo body ajustado --}}
                <div class="modal-body p-4 bg-[#fff] dark:bg-slate-700">
                    <div class="row g-3">
                        {{-- Mantener tus inputs originales, solo cuida que el texto sea legible --}}
                         <div class="col-md-6"><label class="form-label fw-bold">RFC</label><input type="text" name="rfc" class="form-control" required pattern="^[A-ZÑ&]{4}\d{6}[A-Z0-9]{3}$"></div>
                         <div class="col-md-6"><label class="form-label fw-bold">Nombre</label><input type="text" name="nombre" class="form-control" required></div>
                         <div class="col-md-6"><label class="form-label fw-bold">Apellido P.</label><input type="text" name="apellido_p" class="form-control" required></div>
                         <div class="col-md-6"><label class="form-label fw-bold">Apellido M.</label><input type="text" name="apellido_m" class="form-control"></div>
                         
                         <div class="col-md-6"><label class="form-label fw-bold">Puesto</label>
                            <select name="puesto" class="form-select" required>
                                <option value="ADMIN">ADMIN</option><option value="RECEPCIONISTA">RECEPCIONISTA</option><option value="INSTRUCTOR">INSTRUCTOR</option><option value="LIMPIEZA">LIMPIEZA</option>
                            </select>
                        </div>
                        <div class="col-md-6"><label class="form-label fw-bold">Turno</label>
                            <select name="turno" class="form-select" required><option value="MATUTINO">MATUTINO</option><option value="VESPERTINO">VESPERTINO</option></select>
                        </div>

                        {{-- Días de descanso --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Días de descanso</label>
                            <div class="d-flex flex-wrap gap-2 mt-2">
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="descansos[]" value="LUNES"><label class="form-check-label">Lun</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="descansos[]" value="MARTES"><label class="form-check-label">Mar</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="descansos[]" value="MIERCOLES"><label class="form-check-label">Mié</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="descansos[]" value="JUEVES"><label class="form-check-label">Jue</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="descansos[]" value="VIERNES"><label class="form-check-label">Vie</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="descansos[]" value="SABADO"><label class="form-check-label">Sáb</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="descansos[]" value="DOMINGO"><label class="form-check-label">Dom</label></div>
                            </div>
                        </div>

                        <div class="col-md-6"><label class="form-label fw-bold">Sexo</label><select name="sexo" class="form-select" required><option value="MASCULINO">MASCULINO</option><option value="FEMENINO">FEMENINO</option></select></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Fecha Nac.</label><input type="date" name="fecha_nac" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Teléfono</label><input type="text" name="tel" class="form-control" required></div>
                        <div class="col-12"><h6 class="fw-bold border-bottom pb-2">Dirección</h6></div>
                        <div class="col-md-8"><label class="form-label fw-bold">Calle</label><input type="text" name="calle" class="form-control" required></div>
                        <div class="col-md-4"><label class="form-label fw-bold">Número</label><input type="number" name="numero" class="form-control" min="1" max="999" required></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Colonia</label><input type="text" name="colonia" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Alcaldía</label><input type="text" name="alcaldia" class="form-control" required></div>
                    </div>
                </div>

                {{-- Fondo footer ajustado --}}
                <div class="modal-footer bg-[#fff] dark:bg-[#092c4c]">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn text-white" style="background-color: #212529;">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDITAR --}}
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
                
                <div class="modal-body p-4 bg-[#fff] dark:bg-slate-700">
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label fw-bold">Nombre</label><input type="text" name="nombre" id="edit_nombre" class="form-control" required></div>
                        <div class="col-md-4"><label class="form-label fw-bold">Apellido P.</label><input type="text" name="apellido_p" id="edit_ap" class="form-control" required></div>
                        <div class="col-md-4"><label class="form-label fw-bold">Apellido M.</label><input type="text" name="apellido_m" id="edit_am" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Puesto</label><select name="puesto" id="edit_puesto" class="form-control" required><option value="ADMIN">ADMIN</option><option value="RECEPCIONISTA">RECEPCIONISTA</option><option value="INSTRUCTOR">INSTRUCTOR</option><option value="LIMPIEZA">LIMPIEZA</option></select></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Turno</label><select name="turno" id="edit_turno" class="form-select" required><option value="MATUTINO">MATUTINO</option><option value="VESPERTINO">VESPERTINO</option></select></div>

                        <div class="col-md-12">
                             <div class="d-flex flex-wrap gap-2">
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="descansos[]" value="LUNES"><label class="form-check-label">Lun</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="descansos[]" value="MARTES"><label class="form-check-label">Mar</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="descansos[]" value="MIERCOLES"><label class="form-check-label">Mié</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="descansos[]" value="JUEVES"><label class="form-check-label">Jue</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="descansos[]" value="VIERNES"><label class="form-check-label">Vie</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="descansos[]" value="SABADO"><label class="form-check-label">Sáb</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="descansos[]" value="DOMINGO"><label class="form-check-label">Dom</label></div>
                            </div>
                        </div>

                        <div class="col-md-6"><label class="form-label fw-bold">Sexo</label><select name="sexo" id="edit_sexo" class="form-select" required><option value="MASCULINO">MASCULINO</option><option value="FEMENINO">FEMENINO</option></select></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Fecha Nac.</label><input type="date" name="fecha_nac" id="edit_fecha" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Teléfono</label><input type="text" name="tel" id="edit_tel" class="form-control" required></div>
                        <div class="col-12"><h6 class="fw-bold border-bottom pb-2">Dirección</h6></div>
                        <div class="col-md-8"><label class="form-label fw-bold">Calle</label><input type="text" name="calle" id="edit_calle" class="form-control" required></div>
                        <div class="col-md-4"><label class="form-label fw-bold">Número</label><input type="number" name="numero" id="edit_numero" class="form-control" min="1" max="999" required></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Colonia</label><input type="text" name="colonia" id="edit_colonia" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Alcaldía</label><input type="text" name="alcaldia" id="edit_alcaldia" class="form-control" required></div>
                    </div>
                </div>

                <div class="modal-footer bg-[#fff] dark:bg-[#092c4c]">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn text-white" style="background-color: #212529;">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL CONFIRMAR ELIMINAR --}}
<div class="modal fade" id="modalConfirmarEliminar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <form id="formEliminar" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold"><i class="fas fa-exclamation-triangle me-2"></i> Confirmar Eliminación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 text-center bg-[#fff] dark:bg-slate-700">
                    <div class="mb-3 text-danger display-4"><i class="fas fa-trash-alt"></i></div>
                    <h5 class="mb-3 font-bold text-gray-800 dark:text-gray-200">¿Estás seguro de eliminar este empleado?</h5>
                    <p class="text-[#000] dark:text-gray-200">Esta acción no se puede deshacer.</p>
                </div>
                <div class="modal-footer bg-[#fff] dark:bg-slate-500 justify-content-center">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger px-4">Sí, Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        const floatingActions = document.getElementById('floating-actions');
        
        function handleSelection(checkboxClicked) {
            if (checkboxClicked.checked) {
                checkboxes.forEach(cb => {
                    if (cb !== checkboxClicked) cb.checked = false;
                });
            }

            const selected = document.querySelector('.row-checkbox:checked');

            if (selected) {
                floatingActions.classList.remove('d-none');
                floatingActions.classList.add('d-flex');
                
                // Cargar datos Editar
                const el = selected;
                document.getElementById('edit_nombre').value = el.dataset.nombre;
                document.getElementById('edit_ap').value = el.dataset.apellido_p;
                document.getElementById('edit_am').value = el.dataset.apellido_m;
                document.getElementById('edit_puesto').value = el.dataset.puesto;
                document.getElementById('edit_turno').value = el.dataset.turno;
                document.getElementById('edit_sexo').value = el.dataset.sexo;
                document.getElementById('edit_fecha').value = el.dataset.fecha;
                document.getElementById('edit_tel').value = el.dataset.tel;
                document.getElementById('edit_calle').value = el.dataset.calle;
                document.getElementById('edit_numero').value = el.dataset.numero;
                document.getElementById('edit_colonia').value = el.dataset.colonia;
                document.getElementById('edit_alcaldia').value = el.dataset.alcaldia;
                
                // Checkbox descansos
                const descansosArr = el.dataset.descansos.split(','); 
                document.querySelectorAll('#modalModificarEmpleado input[name="descansos[]"]').forEach(chk => chk.checked = false);
                descansosArr.forEach(dia => {
                    let chk = document.querySelector(`#modalModificarEmpleado input[name="descansos[]"][value="${dia.trim()}"]`);
                    if(chk) chk.checked = true;
                });

                document.getElementById('formEditar').action = `/empleados/${el.dataset.rfc}`;
                document.getElementById('formEliminar').action = `/empleados/${el.dataset.rfc}`;

            } else {
                floatingActions.classList.add('d-none');
                floatingActions.classList.remove('d-flex');
            }
        }

        checkboxes.forEach(cb => cb.addEventListener('change', function() { handleSelection(this); }));

        document.getElementById('busquedaTabla').addEventListener('keyup', function() {
            let searchText = this.value.toLowerCase();
            document.querySelectorAll('tbody tr').forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(searchText) ? '' : 'none';
            });
        });
    });
</script>
@endsection