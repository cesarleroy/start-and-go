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

    {{-- ERRORES DE VALIDACIÓN --}}
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


    {{-- TÍTULO Y ACCIONES --}}
    <div class="welcome mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Alumnos</h2>
        </div>

        {{-- CARD PRINCIPAL --}}
        <div class="card shadow border-0">
            
            {{-- HEADER DEL CARD (buscador + botón) --}}
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

            {{-- TABLA --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0" style="white-space: nowrap;">
                        <thead class="text-white" style="background-color: #0d1b2a;">
                            <tr>
                                {{-- Si después deseas acciones, aquí las agregas --}}
                                <th>ID</th>
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
                            @forelse ($alumnos as $alumno)
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


{{-- MODAL DE AGREGAR --}}
@include('alumnos.modals.agregar')

@endsection


{{-- SCRIPTS PARA BUSCADOR --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Buscador en tabla
    document.getElementById('busquedaTabla').addEventListener('keyup', function() {
        let text = this.value.toLowerCase();
        let rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(text) ? '' : 'none';
        });
    });

});
</script>
@endpush
