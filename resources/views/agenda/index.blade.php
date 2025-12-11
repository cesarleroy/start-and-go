@extends('layouts.app')

@section('content')
<div class="container-fluid p-4 min-h-[calc(100vh-80px)]">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

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

    <div class="welcome mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
             <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Agenda</h2>
        </div>

        <div class="card shadow border-0">
            <div class="card-header bg-white py-3">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-2 mb-md-0">
                        <input type="text" id="busquedaTabla" class="form-control" placeholder="Búsqueda general en la tabla...">
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
                                <th>Acciones</th>
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
                            <tr>
                                <td>
                                  <div class="d-flex gap-2">
                                      <button class="btn btn-sm btn-warning text-white btn-editar" 
                                              data-bs-toggle="modal" 
                                              data-bs-target="#modalModificarAgenda"
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
                                              data-resultado="{{ $agenda->notas_resultado }}">
                                          <i class="fas fa-edit"></i>
                                      </button>

                                      <form action="{{ route('agenda.destroy', $agenda->id) }}" method="POST" class="d-inline">
                                          @csrf
                                          @method('DELETE')
                                          <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta cita?')">
                                              <i class="fas fa-trash"></i>
                                          </button>
                                      </form>
                                  </div>
                              </td>

                                <td>{{ $agenda->fecha->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($agenda->hora)->format('H:i') }}</td>
                                <td>
                                    @if($agenda->empleado)
                                        {{ $agenda->empleado->nombre_completo }}
                                    @else
                                        <span class="text-muted">No asignado</span>
                                    @endif
                                </td>
                                <td>
                                    @if($agenda->alumno)
                                        {{ $agenda->alumno->nombre_completo }}
                                    @else
                                        <span class="text-muted">No asignado</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $agenda->actividad == 'EXAMEN' ? 'bg-danger' : 'bg-primary' }}">
                                        {{ $agenda->actividad }}
                                    </span>
                                </td>
                                <td>{{ $agenda->km_recorridos ?? '-' }}</td>
                                <td>{{ $agenda->exam_teo ?? '-' }}</td>
                                <td>{{ $agenda->exam_prac ?? '-' }}</td>
                                <td><small>{{ $agenda->notas ?? '-' }}</small></td>
                                <td><small>{{ $agenda->notas_resultado ?? '-' }}</small></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="text-center py-5 bg-light">
                                    <h5 class="text-muted">No hay citas registradas.</h5>
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

<!-- Modal Agregar -->
<div class="modal fade" id="modalAgregarAgenda" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('agenda.store') }}" method="POST">
                @csrf
                <div class="modal-header text-white" style="background-color: #092c4c;">
                    <h5 class="modal-title fw-bold">Agregar Nueva Cita</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Empleado -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Empleado (Instructor)</label>
                            <select name="rfc_emp" class="form-select" required>
                                <option value="" disabled selected>Seleccione un empleado...</option>
                                @foreach($empleados as $emp)
                                    <option value="{{ $emp->rfc }}">
                                        {{ $emp->nombre_completo }} - {{ $emp->rfc }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Alumno -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Alumno</label>
                            <select name="rfc_cliente" id="select_alumno" class="form-select" required>
                                <option value="" disabled selected>Seleccione un alumno...</option>
                                @foreach($alumnos as $alumno)
                                    <option value="{{ $alumno->rfc }}">
                                        {{ $alumno->nombre_completo }} - {{ $alumno->rfc }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Fecha -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Fecha de la Cita</label>
                            <input type="date" name="fecha" class="form-control" required>
                        </div>

                        <!-- Hora -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Hora</label>
                            <input type="time" name="hora" class="form-control" required>
                        </div>

                        <!-- Fecha Pago -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Fecha de Pago</label>
                            <input type="date" name="fecha_pago" class="form-control" required>
                        </div>

                        <!-- Actividad -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Actividad</label>
                            <select name="actividad" class="form-select" required>
                                <option value="" disabled selected>Seleccione...</option>
                                <option value="LECCIÓN">LECCIÓN</option>
                                <option value="EXAMEN">EXAMEN</option>
                            </select>
                        </div>

                        <!-- KM Recorridos -->
                        <div class="col-md-4">
                            <label class="form-label fw-bold">KM Recorridos</label>
                            <input type="number" name="km_recorridos" class="form-control" min="0">
                        </div>

                        <!-- Examen Teórico -->
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Examen Teórico (0-100)</label>
                            <input type="number" name="exam_teo" class="form-control" min="0" max="100">
                        </div>

                        <!-- Examen Práctico -->
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Examen Práctico (0-100)</label>
                            <input type="number" name="exam_prac" class="form-control" min="0" max="100">
                        </div>

                        <!-- Notas -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Notas</label>
                            <textarea name="notas" class="form-control" rows="2" maxlength="50"></textarea>
                        </div>

                        <!-- Notas Resultado -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Notas de Resultado</label>
                            <textarea name="notas_resultado" class="form-control" rows="2" maxlength="50"></textarea>
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

<!-- Modal Modificar -->
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
                
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Empleado -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Empleado (Instructor)</label>
                            <select name="rfc_emp" id="edit_rfc_emp" class="form-select" required>
                                <option value="">Seleccione...</option>
                                @foreach($empleados as $emp)
                                    <option value="{{ $emp->rfc }}">
                                        {{ $emp->nombre_completo }} - {{ $emp->rfc }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Alumno -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Alumno</label>
                            <select name="rfc_cliente" id="edit_rfc_cliente" class="form-select" required>
                                <option value="">Seleccione...</option>
                                @foreach($alumnos as $alumno)
                                    <option value="{{ $alumno->rfc }}">
                                        {{ $alumno->nombre_completo }} - {{ $alumno->rfc }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Fecha -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Fecha de la Cita</label>
                            <input type="date" name="fecha" id="edit_fecha" class="form-control" required>
                        </div>

                        <!-- Hora -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Hora</label>
                            <input type="time" name="hora" id="edit_hora" class="form-control" required>
                        </div>

                        <!-- Fecha Pago -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Fecha de Pago</label>
                            <input type="date" name="fecha_pago" id="edit_fecha_pago" class="form-control" required>
                        </div>

                        <!-- Actividad -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Actividad</label>
                            <select name="actividad" id="edit_actividad" class="form-select" required>
                                <option value="LECCIÓN">LECCIÓN</option>
                                <option value="EXAMEN">EXAMEN</option>
                            </select>
                        </div>

                        <!-- KM Recorridos -->
                        <div class="col-md-4">
                            <label class="form-label fw-bold">KM Recorridos</label>
                            <input type="number" name="km_recorridos" id="edit_km" class="form-control" min="0">
                        </div>

                        <!-- Examen Teórico -->
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Examen Teórico</label>
                            <input type="number" name="exam_teo" id="edit_exam_teo" class="form-control" min="0" max="100">
                        </div>

                        <!-- Examen Práctico -->
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Examen Práctico</label>
                            <input type="number" name="exam_prac" id="edit_exam_prac" class="form-control" min="0" max="100">
                        </div>

                        <!-- Notas -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Notas</label>
                            <textarea name="notas" id="edit_notas" class="form-control" rows="2" maxlength="50"></textarea>
                        </div>

                        <!-- Notas Resultado -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Notas de Resultado</label>
                            <textarea name="notas_resultado" id="edit_resultado" class="form-control" rows="2" maxlength="50"></textarea>
                        </div>
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
        // Lógica para el botón Editar
        const botonesEditar = document.querySelectorAll('.btn-editar');
        
        botonesEditar.forEach(boton => {
            boton.addEventListener('click', function() {
                // 1. Obtener el ID del botón
                const id = this.dataset.id; 

                // 2. Llenar los campos del modal
                document.getElementById('edit_rfc_emp').value = this.dataset.rfc_emp;
                document.getElementById('edit_rfc_cliente').value = this.dataset.rfc_cliente;
                document.getElementById('edit_fecha').value = this.dataset.fecha;
                document.getElementById('edit_hora').value = this.dataset.hora;
                document.getElementById('edit_fecha_pago').value = this.dataset.fecha_pago;
                document.getElementById('edit_actividad').value = this.dataset.actividad;
                document.getElementById('edit_km').value = this.dataset.km || '';
                document.getElementById('edit_exam_teo').value = this.dataset.exam_teo || '';
                document.getElementById('edit_exam_prac').value = this.dataset.exam_prac || '';
                document.getElementById('edit_notas').value = this.dataset.notas || '';
                document.getElementById('edit_resultado').value = this.dataset.resultado || '';

                const form = document.getElementById('formEditar');
                form.action = `/agenda/${id}`; 
            });
        });

        // Buscador básico (se queda igual)
        document.getElementById('busquedaTabla').addEventListener('keyup', function() {
            let searchText = this.value.toLowerCase();
            let tableRows = document.querySelectorAll('tbody tr');
            
            tableRows.forEach(row => {
                let rowText = row.innerText.toLowerCase();
                row.style.display = rowText.includes(searchText) ? '' : 'none';
            });
        });
    });
</script>
@endsection