@extends('layouts.app')

@section('content')
<div class="container-fluid p-4 min-h-[calc(100vh-80px)] relative">
    
    {{-- ALERTAS --}}
    @if(session('success')) <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div> @endif
    @if(session('error')) <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div> @endif
    @if($errors->any()) <div class="alert alert-danger alert-dismissible fade show"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div> @endif

    <div class="welcome mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
             <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Pagos</h2>
        </div>

        <div class="card shadow border-0">
            <div class="card-header bg-white py-3">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-2 mb-md-0">
                        <input type="text" id="busquedaTabla" class="form-control" placeholder="Búsqueda general en la tabla...">
                    </div>
                    <div class="col-md-6 text-end">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarPago">
                            <i class="fas fa-dollar-sign me-2"></i> Nuevo Pago
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0" style="width: 100%; white-space: nowrap;">
                        <thead class="text-white" style="background-color: #0d1b2a;">
                            <tr>
                                <th class="text-center" style="width: 50px;">
                                    <i class="fas fa-check-circle"></i> {{-- Icono cambiado para indicar selección única --}}
                                </th>
                                <th>Fecha de Pago</th>
                                <th>RFC Cliente</th>
                                <th>Alumno</th>
                                <th>Tipo Contratación</th>
                                <th>Total</th>
                                <th>Forma de Pago</th>
                                <th>Reembolso</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pagos as $pago)
                            <tr class="cursor-pointer row-selectable">
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input row-checkbox" 
                                        data-rfc="{{ $pago->rfc_cliente }}"
                                        data-fecha="{{ $pago->fecha_pago->format('Y-m-d') }}"
                                        data-tipo="{{ $pago->tipo_contratacion }}"
                                        data-total="{{ $pago->total_pago }}"
                                        data-forma="{{ $pago->forma_pago }}"
                                        data-reembolso="{{ $pago->reembolso }}"
                                    >
                                </td>
                                <td>{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                                <td>{{ $pago->rfc_cliente }}</td>
                                <td>{{ $pago->alumno ? $pago->alumno->nombre_completo : 'No encontrado' }}</td>
                                <td><span class="badge bg-info">{{ $pago->tipo_contratacion }}</span></td>
                                <td class="fw-bold">${{ number_format($pago->total_pago, 2) }}</td>
                                <td>
                                    @php
                                        $colores = ['DEBITO' => 'primary', 'CRÉDITO' => 'warning', 'EFECTIVO' => 'success', 'TRANSFERENCIA' => 'info'];
                                    @endphp
                                    <span class="badge bg-{{ $colores[$pago->forma_pago] ?? 'secondary' }}">{{ $pago->forma_pago }}</span>
                                </td>
                                <td>
                                    @if($pago->reembolso) <span class="badge bg-danger"><i class="fas fa-undo"></i> SÍ</span>
                                    @else <span class="badge bg-secondary">NO</span> @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="text-center py-5 bg-light"><h5 class="text-muted">No hay pagos registrados.</h5></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    {{-- MENÚ FLOTANTE --}}
    <div id="floating-actions" class="position-fixed bottom-0 end-0 m-4 p-3 bg-[#fff] dark:bg-gray-800 shadow-lg rounded-pill d-none align-items-center gap-3 z-50 border border-gray-200 dark:border-gray-700">
        <span class="fw-bold text-gray-700 dark:text-gray-200 ps-2">Registro seleccionado</span>
        
        <button id="btn-float-edit" class="btn btn-warning text-white btn-sm rounded-circle shadow-sm" style="width: 40px; height: 40px;" title="Editar" data-bs-toggle="modal" data-bs-target="#modalModificarPago">
            <i class="fas fa-edit"></i>
        </button>

        {{-- El botón eliminar ahora abre el modal de confirmación --}}
        <button id="btn-float-delete" class="btn btn-danger btn-sm rounded-circle shadow-sm" style="width: 40px; height: 40px;" title="Eliminar" data-bs-toggle="modal" data-bs-target="#modalConfirmarEliminar">
            <i class="fas fa-trash"></i>
        </button>
    </div>

</div>

<!-- Modal Agregar -->
<div class="modal fade" id="modalAgregarPago" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('pagos.store') }}" method="POST">
                @csrf
                <div class="modal-header text-white" style="background-color: #092c4c;">
                    <h5 class="modal-title fw-bold">Registrar Nuevo Pago</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body p-4 bg-[#fff] dark:bg-slate-700">
                    <div class="row g-3">
                        <!-- Alumno -->
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Alumno</label>
                            <select name="rfc_cliente" id="select_alumno_add" class="form-select" required>
                                <option value="" disabled selected>Seleccione un alumno...</option>
                                @foreach($alumnos as $alumno)
                                    <option value="{{ $alumno->rfc }}" data-nombre="{{ $alumno->nombre_completo }}">
                                        {{ $alumno->nombre_completo }} - {{ $alumno->rfc }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Fecha de Pago -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Fecha de Pago</label>
                            <input type="date" name="fecha_pago" class="form-control" required value="{{ date('Y-m-d') }}">
                        </div>

                        <!-- Tipo de Contratación -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tipo de Contratación</label>
                            <select name="tipo_contratacion" id="tipo_contratacion_add" class="form-select" required>
                                <option value="" disabled selected>Seleccione...</option>
                                @foreach($contrataciones as $contratacion)
                                    <option value="{{ $contratacion->tipo_contratacion }}" data-precio="{{ $contratacion->precio }}">
                                        {{ $contratacion->tipo_contratacion }} - ${{ number_format($contratacion->precio, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Total del Pago -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Total del Pago</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="total_pago" id="total_pago_add" class="form-control" required min="0" step="0.01" readonly>
                            </div>
                            <small class="text-black-500 dark:text-[#fff]">Se actualizará automáticamente al seleccionar tipo de contratación</small>
                        </div>

                        <!-- Forma de Pago -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Forma de Pago</label>
                            <select name="forma_pago" class="form-select" required>
                                <option value="" disabled selected>Seleccione...</option>
                                <option value="EFECTIVO">EFECTIVO</option>
                                <option value="DEBITO">DÉBITO</option>
                                <option value="CRÉDITO">CRÉDITO</option>
                                <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                            </select>
                        </div>

                        <!-- Reembolso -->
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="reembolso" id="reembolso_add" value="1">
                                <label class="form-check-label fw-bold" for="reembolso_add">
                                    ¿Es un reembolso?
                                </label>
                            </div>
                        </div>
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

<!-- Modal Modificar -->
<div class="modal fade" id="modalModificarPago" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formEditar" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header text-white" style="background-color: #092c4c;">
                    <h5 class="modal-title fw-bold">Modificar Pago</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body p-4 bg-[#fff] dark:bg-slate-700">
                    <div class="row g-3">
                        <!-- Info del Alumno (solo lectura) -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">RFC Cliente</label>
                            <input type="text" id="edit_rfc_display" class="form-control" readonly disabled>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Fecha de Pago</label>
                            <input type="text" id="edit_fecha_display" class="form-control" readonly disabled>
                        </div>

                        <!-- Tipo de Contratación -->
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Tipo de Contratación</label>
                            <select name="tipo_contratacion" id="edit_tipo" class="form-select" required>
                                @foreach($contrataciones as $contratacion)
                                    <option value="{{ $contratacion->tipo_contratacion }}" data-precio="{{ $contratacion->precio }}">
                                        {{ $contratacion->tipo_contratacion }} - ${{ number_format($contratacion->precio, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Total del Pago -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Total del Pago</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="total_pago" id="edit_total" class="form-control" required min="0" step="0.01" readonly>
                            </div>
                        </div>

                        <!-- Forma de Pago -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Forma de Pago</label>
                            <select name="forma_pago" id="edit_forma" class="form-select" required>
                                <option value="EFECTIVO">EFECTIVO</option>
                                <option value="DEBITO">DÉBITO</option>
                                <option value="CRÉDITO">CRÉDITO</option>
                                <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                            </select>
                        </div>

                        <!-- Reembolso -->
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="reembolso" id="edit_reembolso" value="1">
                                <label class="form-check-label fw-bold" for="edit_reembolso">
                                    ¿Es un reembolso?
                                </label>
                            </div>
                        </div>
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
<div class="modal fade" id="modalConfirmarEliminar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <form id="formEliminar" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-exclamation-triangle me-2"></i> Confirmar Eliminación
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 text-center bg-[#fff] dark:bg-slate-700">
                    <div class="mb-3 text-danger display-4">
                        <i class="fas fa-trash-alt"></i>
                    </div>
                    <h5 class="mb-3 font-bold text-gray-800 dark:text-gray-200">¿Estás seguro de eliminar este pago?</h5>
                    <p class="text-[#000] dark:text-gray-200">Esta acción no se puede deshacer y el registro se borrará permanentemente de la base de datos.</p>
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

        // Auto-llenar precio al seleccionar tipo de contratación (Modal Agregar)
        document.getElementById('tipo_contratacion_add').addEventListener('change', function() {
            const precio = this.options[this.selectedIndex].dataset.precio;
            document.getElementById('total_pago_add').value = precio;
        });

        // Auto-llenar precio al seleccionar tipo de contratación (Modal Editar)
        document.getElementById('edit_tipo').addEventListener('change', function() {
            const precio = this.options[this.selectedIndex].dataset.precio;
            document.getElementById('edit_total').value = precio;
        });
        
        // Función principal para manejar selección
        function handleSelection(checkboxClicked) {
            // 1. Si se marca uno, desmarcar todos los demás (Modo "Radio Button")
            if (checkboxClicked.checked) {
                checkboxes.forEach(cb => {
                    if (cb !== checkboxClicked) cb.checked = false;
                });
            }

            // 2. Verificar si hay alguno seleccionado
            const selected = document.querySelector('.row-checkbox:checked');

            // 3. Mostrar u ocultar menú flotante
            if (selected) {
                floatingActions.classList.remove('d-none');
                floatingActions.classList.add('d-flex');
                
                // Cargar datos al formulario de Editar
                document.getElementById('edit_rfc_display').value = selected.dataset.rfc;
                document.getElementById('edit_fecha_display').value = selected.dataset.fecha;
                document.getElementById('edit_tipo').value = selected.dataset.tipo;
                document.getElementById('edit_total').value = selected.dataset.total;
                document.getElementById('edit_forma').value = selected.dataset.forma;
                document.getElementById('edit_reembolso').checked = selected.dataset.reembolso == '1';
                
                document.getElementById('formEditar').action = `/pagos/${selected.dataset.rfc}/${selected.dataset.fecha}`;

                // Cargar datos al formulario de Eliminar (Modal)
                document.getElementById('formEliminar').action = `/pagos/${selected.dataset.rfc}/${selected.dataset.fecha}`;

            } else {
                floatingActions.classList.add('d-none');
                floatingActions.classList.remove('d-flex');
            }
        }

        // Asignar listeners
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                handleSelection(this);
            });
        });

        // Buscador
        document.getElementById('busquedaTabla').addEventListener('keyup', function() {
            let searchText = this.value.toLowerCase();
            document.querySelectorAll('tbody tr').forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(searchText) ? '' : 'none';
            });
        });
        
        // Calculadora de precios en editar
        document.getElementById('edit_tipo').addEventListener('change', function() {
            const precio = this.options[this.selectedIndex].dataset.precio;
            document.getElementById('edit_total').value = precio;
        });
    });
</script>
@endsection