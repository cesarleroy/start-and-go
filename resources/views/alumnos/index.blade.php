@extends('layouts.app')
@section('title', 'Alumnos')
@section('content')
<div class="container-fluid p-4 min-h-[calc(100vh-80px)] relative">

    {{-- ALERTAS --}}
    @if(session('success')) <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div> @endif
    @if($errors->any()) <div class="alert alert-danger alert-dismissible fade show"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div> @endif

    <div class="welcome mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Alumnos</h2>
        </div>

        <div class="card shadow border-0">
            <div class="card-header bg-white py-3">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-2 mb-md-0">
                        <input type="text" id="busquedaTabla" class="form-control" placeholder="Buscar en la tabla...">
                    </div>
                    <div class="col-md-6 text-end">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarAlumno">
                            <i class="fas fa-user-plus me-2"></i> Nuevo Alumno
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0" style="white-space: nowrap;">
                        <thead class="text-white" style="background-color: #0d1b2a;">
                            <tr>
                                <th class="text-center" style="width: 50px;">
                                    <i class="fas fa-check-circle"></i>
                                </th>
                                <th>RFC</th>
                                <th>Nombre</th>
                                <th>Apellido P.</th>
                                <th>Apellido M.</th>
                                <th>Fecha Nac.</th>
                                <th>Calle</th>
                                <th>Número</th>
                                <th>Colonia</th>
                                <th>Alcaldía</th>
                                <th>Permiso</th>
                                <th>Observaciones</th>
                                <th>Correo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($alumnos as $alumno)
                            <tr class="cursor-pointer row-selectable">
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input row-checkbox" 
                                        value="{{ $alumno->rfc }}"
                                        data-rfc="{{ $alumno->rfc }}"
                                        data-nombre="{{ $alumno->nombre }}"
                                        data-apellido_p="{{ $alumno->apellido_p }}"
                                        data-apellido_m="{{ $alumno->apellido_m }}"
                                        data-nombre-completo="{{ $alumno->nombre }} {{ $alumno->apellido_p }} {{ $alumno->apellido_m }}"
                                        data-fecha_nac="{{ $alumno->fecha_nac->format('Y-m-d') }}"
                                        data-calle="{{ $alumno->calle }}"
                                        data-numero="{{ $alumno->numero }}"
                                        data-colonia="{{ $alumno->colonia }}"
                                        data-alcaldia="{{ $alumno->alcaldia }}"
                                        data-permiso="{{ $alumno->permiso }}"
                                        data-observaciones="{{ $alumno->observaciones }}"
                                        data-correo="{{ $alumno->correo }}"
                                    >
                                </td>
                                <td>{{ $alumno->rfc }}</td>
                                <td>{{ $alumno->nombre }}</td>
                                <td>{{ $alumno->apellido_p }}</td>
                                <td>{{ $alumno->apellido_m }}</td>
                                <td>{{ $alumno->fecha_nac->format('Y-m-d') }}</td>
                                <td>{{ $alumno->calle }}</td>
                                <td>{{ $alumno->numero }}</td>
                                <td>{{ $alumno->colonia }}</td>
                                <td>{{ $alumno->alcaldia }}</td>
                                <td>{{ $alumno->permiso }}</td>
                                <td>{{ $alumno->observaciones }}</td>
                                <td>{{ $alumno->correo }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="13" class="text-center py-4 bg-light"><h5 class="text-muted mb-0">No hay alumnos registrados.</h5></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- MENÚ FLOTANTE --}}
    <div id="floating-actions" class="position-fixed bottom-0 end-0 m-4 p-3 bg-[#fff] dark:bg-gray-800 shadow-lg rounded-pill d-none align-items-center gap-3 z-50 border border-gray-200 dark:border-gray-700">
        <span class="fw-bold text-gray-700 dark:text-gray-200 ps-2">Alumno seleccionado</span>
        
        <button id="btn-float-credencial" class="btn btn-info text-white btn-sm rounded-circle shadow-sm" style="width: 40px; height: 40px;" title="Generar Credencial" data-bs-toggle="modal" data-bs-target="#modalCredencial">
            <i class="fas fa-id-card"></i>
        </button>

        <button id="btn-float-edit" class="btn btn-warning text-white btn-sm rounded-circle shadow-sm" style="width: 40px; height: 40px;" title="Editar" data-bs-toggle="modal" data-bs-target="#modalEditarAlumno">
            <i class="fas fa-edit"></i>
        </button>

        <button id="btn-float-delete" class="btn btn-danger btn-sm rounded-circle shadow-sm" style="width: 40px; height: 40px;" title="Eliminar" data-bs-toggle="modal" data-bs-target="#modalConfirmarEliminar">
            <i class="fas fa-trash"></i>
        </button>
    </div>

</div>

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
                    <h5 class="mb-3 font-bold text-gray-800 dark:text-gray-200">¿Estás seguro de eliminar este alumno?</h5>
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

@include('alumnos.modals.credencial')
@include('alumnos.modals.agregar')
@include('alumnos.modals.editar')

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    const floatingActions = document.getElementById('floating-actions');
    
    // Función de selección única
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
            cargarDatosEdicion(selected);
            // Cargar datos Credencial
            cargarDatosCredencial(selected);
            // Cargar datos Eliminar
            document.getElementById('formEliminar').action = `/alumnos/${selected.dataset.rfc}`;
        } else {
            floatingActions.classList.add('d-none');
            floatingActions.classList.remove('d-flex');
        }
    }

    checkboxes.forEach(cb => cb.addEventListener('change', function() { handleSelection(this); }));

    function cargarDatosEdicion(element) {
        document.getElementById('edit_rfc').value           = element.dataset.rfc;
        document.getElementById('edit_nombre').value        = element.dataset.nombre;
        document.getElementById('edit_apellido_p').value    = element.dataset.apellido_p;
        document.getElementById('edit_apellido_m').value    = element.dataset.apellido_m;
        document.getElementById('edit_fecha_nac').value     = element.dataset.fecha_nac;
        document.getElementById('edit_permiso').value       = element.dataset.permiso;
        document.getElementById('edit_calle').value         = element.dataset.calle;
        document.getElementById('edit_numero').value        = element.dataset.numero;
        document.getElementById('edit_colonia').value       = element.dataset.colonia;
        document.getElementById('edit_alcaldia').value      = element.dataset.alcaldia;
        document.getElementById('edit_correo').value        = element.dataset.correo;
        document.getElementById('edit_observaciones').value = element.dataset.observaciones;

        document.getElementById('formEditarAlumno').action = `/alumnos/${element.dataset.rfc}`;
    }

    function cargarDatosCredencial(element) {
        document.getElementById('view_nombre').textContent = element.dataset.nombreCompleto;
        document.getElementById('view_rfc').textContent = element.dataset.rfc;
        document.getElementById('view_permiso').textContent = element.dataset.permiso;
        document.getElementById('input_rfc').value = element.dataset.rfc;
    }

    document.getElementById('busquedaTabla').addEventListener('keyup', function() {
        const value = this.value.toLowerCase();
        document.querySelectorAll('tbody tr').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
        });
    });
});
</script>
@endpush