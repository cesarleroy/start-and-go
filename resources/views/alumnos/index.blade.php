@extends('layouts.app')

@section('content')
<div class="container-fluid p-4 min-h-[calc(100vh-80px)]">

    {{-- ALERTAS --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ERRORES --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    {{-- TÍTULO --}}
    <div class="welcome mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Alumnos</h2>
        </div>

        {{-- CARD PRINCIPAL --}}
        <div class="card shadow border-0">
            
            {{-- HEADER --}}
            <div class="card-header bg-white py-3">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-2 mb-md-0">
                        <input 
                            type="text" 
                            id="busquedaTabla" 
                            class="form-control" 
                            placeholder="Buscar en la tabla..."
                        >
                    </div>

                    <div class="col-md-6 text-end">
                        <button 
                            type="button" 
                            class="btn btn-success" 
                            data-bs-toggle="modal" 
                            data-bs-target="#modalAgregarAlumno"
                        >
                            <i class="fas fa-user-plus me-2"></i> Nuevo Alumno
                        </button>
                    </div>
                </div>
            </div>

            {{-- TABLA --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table 
                        class="table table-striped table-hover align-middle mb-0" 
                        style="white-space: nowrap;"
                    >
                        <thead class="text-white" style="background-color: #0d1b2a;">
                            <tr>
                                <th>Acciones</th>
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
                            <tr>
                                <td>
                                    <div class="d-flex gap-2">

                                        {{-- EDITAR --}}
                                        <button class="btn btn-sm btn-warning text-white d-flex align-items-center justify-content-center btn-editar-alumno" style="width: 30px; height: 30px;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditarAlumno"
                                                data-rfc="{{ $alumno->rfc }}"
                                                data-nombre="{{ $alumno->nombre }}"
                                                data-apellido_p="{{ $alumno->apellido_p }}"
                                                data-apellido_m="{{ $alumno->apellido_m }}"
                                                data-fecha_nac="{{ $alumno->fecha_nac }}"
                                                data-calle="{{ $alumno->calle }}"
                                                data-numero="{{ $alumno->numero }}"
                                                data-colonia="{{ $alumno->colonia }}"
                                                data-alcaldia="{{ $alumno->alcaldia }}"
                                                data-permiso="{{ $alumno->permiso }}"
                                                data-observaciones="{{ $alumno->observaciones }}"
                                                data-correo="{{ $alumno->correo }}">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        {{-- BOTÓN ELIMINAR --}}
                                        <form action="{{ route('alumnos.destroy', $alumno->rfc) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger d-flex align-items-center justify-content-center"
                                                    style="width: 30px; height: 30px;"
                                                    onclick="return confirm('¿Deseas eliminar este alumno?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
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
                            @empty
                            <tr>
                                <td colspan="13" class="text-center py-4 bg-light">
                                    <h5 class="text-muted mb-0">No hay alumnos registrados.</h5>
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

{{-- MODAL AGREGAR --}}
@include('alumnos.modals.agregar')
@include('alumnos.modals.editar')

@endsection


{{-- BUSCADOR --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    console.log("JS de alumnos cargado correctamente");

    // ================================
    //  BUSCADOR
    // ================================
    const input = document.getElementById('busquedaTabla');

    input.addEventListener('keyup', function() {
        const value = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
        });
    });

    // ================================
    //  MODAL DE EDITAR ALUMNO
    // ================================
    const botonesEditar = document.querySelectorAll('.btn-editar-alumno');

    botonesEditar.forEach(boton => {
        boton.addEventListener('click', function () {

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
@endpush


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

