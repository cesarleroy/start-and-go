@extends('layouts.app')
@section('title', 'Agenda')
@section('content')
<div class="container-fluid p-4 min-h-[calc(100vh-80px)] relative">
    
    {{-- ALERTAS --}}
    @if(session('success')) <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div> @endif
    @if($errors->any()) <div class="alert alert-danger alert-dismissible fade show"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div> @endif

    <div class="welcome mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
             <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Agenda</h2>
        </div>

        <div class="card shadow border-0">
            <div class="card-header bg-white py-3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <input type="text" id="busquedaTabla" class="form-control" placeholder="Buscar en la tabla...">
                    </div>
                    <div class="col-md-6 text-end">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarAgenda">
                            <i class="fas fa-calendar-plus me-2"></i> Nueva Cita
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0" style="width: 100%; white-space: nowrap;">
                        <thead class="text-white" style="background-color: #0d1b2a;">
                            <tr>
                                <th class="text-center" style="width: 50px;"><i class="fas fa-check-circle"></i></th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Empleado</th>
                                <th>Alumno</th>
                                <th>Actividad</th>
                                <th>KM Recorridos</th>
                                <th>Examen Teórico</th>
                                <th>Examen Práctico</th>
                                <th>Notas</th>
                                <th>Resultado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($agendas as $agenda)
                            <tr class="cursor-pointer row-selectable">
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input row-checkbox"
                                        value="{{ $agenda->id }}"
                                        data-id="{{ $agenda->id }}"
                                        data-rfc_emp="{{ $agenda->rfc_emp }}"
                                        data-fecha="{{ optional($agenda->fecha)->format('Y-m-d') }}"
                                        data-hora="{{ $agenda->hora }}"
                                        data-rfc_cliente="{{ $agenda->rfc_cliente }}"
                                        data-fecha_pago="{{ optional($agenda->fecha_pago)->format('Y-m-d') }}"
                                        data-actividad="{{ $agenda->actividad }}"
                                        data-km="{{ $agenda->km_recorridos }}"
                                        data-exam_teo="{{ $agenda->exam_teo }}"
                                        data-exam_prac="{{ $agenda->exam_prac }}"
                                        data-notas="{{ $agenda->notas }}"
                                        data-resultado="{{ $agenda->notas_resultado }}"
                                    >
                                </td>
                                <td>{{ $agenda->fecha->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($agenda->hora)->format('H:i') }}</td>
                                <td>{{ $agenda->empleado ? $agenda->empleado->nombre_completo : 'No asignado' }}</td>
                                <td>{{ $agenda->alumno ? $agenda->alumno->nombre_completo : 'No asignado' }}</td>
                                <td>
                                    <span class="badge {{ $agenda->actividad == 'EXAMEN' ? 'bg-danger' : 'bg-primary' }}">{{ $agenda->actividad }}</span>
                                </td>
                                <td>{{ $agenda->km_recorridos ?? '-' }}</td>
                                <td>{{ $agenda->exam_teo ?? '-' }}</td>
                                <td>{{ $agenda->exam_prac ?? '-' }}</td>
                                <td><small>{{ $agenda->notas ?? '-' }}</small></td>
                                <td><small>{{ $agenda->notas_resultado ?? '-' }}</small></td>
                            </tr>
                            @empty
                            <tr><td colspan="11" class="text-center py-5 bg-light"><h5 class="text-muted">No hay citas registradas.</h5></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    {{-- MENÚ FLOTANTE --}}
    <div id="floating-actions" class="position-fixed bottom-0 end-0 m-4 p-3 bg-[#fff] dark:bg-gray-800 shadow-lg rounded-pill d-none align-items-center gap-3 z-50 border border-gray-200 dark:border-gray-700">
        <span class="fw-bold text-gray-700 dark:text-gray-200 ps-2">Cita seleccionada</span>
        <button id="btn-float-edit" class="btn btn-warning text-white btn-sm rounded-circle shadow-sm" style="width: 40px; height: 40px;" title="Editar" data-bs-toggle="modal" data-bs-target="#modalModificarAgenda">
            <i class="fas fa-edit"></i>
        </button>
        <button id="btn-float-delete" class="btn btn-danger btn-sm rounded-circle shadow-sm" style="width: 40px; height: 40px;" title="Eliminar" data-bs-toggle="modal" data-bs-target="#modalConfirmarEliminar">
            <i class="fas fa-trash"></i>
        </button>
    </div>

</div>

{{-- MODAL AGREGAR --}}
<div class="modal fade" id="modalAgregarAgenda" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('agenda.store') }}" method="POST">
                @csrf
                <div class="modal-header text-white" style="background-color: #092c4c;">
                    <h5 class="modal-title fw-bold">Agregar Nueva Cita</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 bg-[#fff] dark:bg-slate-700">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label fw-bold">Empleado</label><select name="rfc_emp" class="form-select" required>@foreach($empleados as $emp)<option value="{{ $emp->rfc }}">{{ $emp->nombre_completo }}</option>@endforeach</select></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Alumno</label><select name="rfc_cliente" class="form-select" required>@foreach($alumnos as $alumno)<option value="{{ $alumno->rfc }}">{{ $alumno->nombre_completo }}</option>@endforeach</select></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Fecha</label><input type="date" name="fecha" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Hora</label><input type="time" name="hora" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Fecha Pago</label><input type="date" name="fecha_pago" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Actividad</label><select name="actividad" class="form-select" required><option value="LECCIÓN">LECCIÓN</option><option value="EXAMEN">EXAMEN</option></select></div>
                        <div class="col-md-4"><label class="form-label fw-bold">KM Recorridos</label><input type="number" name="km_recorridos" class="form-control"></div>
                        <div class="col-md-4"><label class="form-label fw-bold">Examen Teórico</label><input type="number" name="exam_teo" class="form-control" max="100"></div>
                        <div class="col-md-4"><label class="form-label fw-bold">Examen Práctico</label><input type="number" name="exam_prac" class="form-control" max="100"></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Notas</label><textarea name="notas" class="form-control"></textarea></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Notas Resultado</label><textarea name="notas_resultado" class="form-control"></textarea></div>
                    </div>
                </div>
                <div class="modal-footer bg-[#fff] dark:bg-[#092c4c]">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn text-white" style="background-color: #212529;">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL MODIFICAR --}}
<div class="modal fade" id="modalModificarAgenda" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="formEditar" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header text-white" style="background-color: #092c4c;">
                    <h5 class="modal-title fw-bold">Modificar Cita</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 bg-[#fff] dark:bg-slate-700">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label fw-bold">Empleado</label><select name="rfc_emp" id="edit_rfc_emp" class="form-select" required>@foreach($empleados as $emp)<option value="{{ $emp->rfc }}">{{ $emp->nombre_completo }}</option>@endforeach</select></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Alumno</label><select name="rfc_cliente" id="edit_rfc_cliente" class="form-select" required>@foreach($alumnos as $alumno)<option value="{{ $alumno->rfc }}">{{ $alumno->nombre_completo }}</option>@endforeach</select></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Fecha</label><input type="date" name="fecha" id="edit_fecha" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Hora</label><input type="time" name="hora" id="edit_hora" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Fecha Pago</label><input type="date" name="fecha_pago" id="edit_fecha_pago" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Actividad</label><select name="actividad" id="edit_actividad" class="form-select" required><option value="LECCIÓN">LECCIÓN</option><option value="EXAMEN">EXAMEN</option></select></div>
                        <div class="col-md-4"><label class="form-label fw-bold">KM Recorridos</label><input type="number" name="km_recorridos" id="edit_km" class="form-control"></div>
                        <div class="col-md-4"><label class="form-label fw-bold">Examen Teórico</label><input type="number" name="exam_teo" id="edit_exam_teo" class="form-control" max="100"></div>
                        <div class="col-md-4"><label class="form-label fw-bold">Examen Práctico</label><input type="number" name="exam_prac" id="edit_exam_prac" class="form-control" max="100"></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Notas</label><textarea name="notas" id="edit_notas" class="form-control"></textarea></div>
                        <div class="col-md-6"><label class="form-label fw-bold">Notas Resultado</label><textarea name="notas_resultado" id="edit_resultado" class="form-control"></textarea></div>
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
                    <h5 class="mb-3 font-bold text-gray-800 dark:text-gray-200">¿Estás seguro de eliminar esta cita?</h5>
                    <p class="text-[#000] dark:text-gray-200">Esta acción borrará la cita de la agenda de forma permanente.</p>
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
                
                const el = selected;
                document.getElementById('edit_rfc_emp').value = el.dataset.rfc_emp;
                document.getElementById('edit_rfc_cliente').value = el.dataset.rfc_cliente;
                document.getElementById('edit_fecha').value = el.dataset.fecha;
                document.getElementById('edit_hora').value = el.dataset.hora;
                document.getElementById('edit_fecha_pago').value = el.dataset.fecha_pago;
                document.getElementById('edit_actividad').value = el.dataset.actividad;
                document.getElementById('edit_km').value = el.dataset.km;
                document.getElementById('edit_exam_teo').value = el.dataset.exam_teo;
                document.getElementById('edit_exam_prac').value = el.dataset.exam_prac;
                document.getElementById('edit_notas').value = el.dataset.notas;
                document.getElementById('edit_resultado').value = el.dataset.resultado;

                document.getElementById('formEditar').action = `/agenda/${el.dataset.id}`;
                document.getElementById('formEliminar').action = `/agenda/${el.dataset.id}`;

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