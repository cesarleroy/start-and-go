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
                                <th>Acciones</th>
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
                            <tr>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-warning text-white btn-editar" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalModificarPago"
                                                data-rfc="{{ $pago->rfc_cliente }}"
                                                data-fecha="{{ $pago->fecha_pago->format('Y-m-d') }}"
                                                data-tipo="{{ $pago->tipo_contratacion }}"
                                                data-total="{{ $pago->total_pago }}"
                                                data-forma="{{ $pago->forma_pago }}"
                                                data-reembolso="{{ $pago->reembolso }}">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <form action="{{ route('pagos.destroy', [$pago->rfc_cliente, $pago->fecha_pago->format('Y-m-d')]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este pago?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td>{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                                <td>{{ $pago->rfc_cliente }}</td>
                                <td>
                                    @if($pago->alumno)
                                        {{ $pago->alumno->nombre_completo }}
                                    @else
                                        <span class="text-muted">No encontrado</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $pago->tipo_contratacion }}</span>
                                </td>
                                <td class="fw-bold">${{ number_format($pago->total_pago, 2) }}</td>
                                <td>
                                    @php
                                        $iconos = [
                                            'DEBITO' => 'credit-card',
                                            'CRÉDITO' => 'credit-card',
                                            'EFECTIVO' => 'money-bill-wave',
                                            'TRANSFERENCIA' => 'exchange-alt'
                                        ];
                                        $colores = [
                                            'DEBITO' => 'primary',
                                            'CRÉDITO' => 'warning',
                                            'EFECTIVO' => 'success',
                                            'TRANSFERENCIA' => 'info'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $colores[$pago->forma_pago] ?? 'secondary' }}">
                                        <i class="fas fa-{{ $iconos[$pago->forma_pago] ?? 'question' }}"></i>
                                        {{ $pago->forma_pago }}
                                    </span>
                                </td>
                                <td>
                                    @if($pago->reembolso)
                                        <span class="badge bg-danger">
                                            <i class="fas fa-undo"></i> SÍ
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">NO</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 bg-light">
                                    <h5 class="text-muted">No hay pagos registrados.</h5>
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
<div class="modal fade" id="modalAgregarPago" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('pagos.store') }}" method="POST">
                @csrf
                <div class="modal-header text-white" style="background-color: #092c4c;">
                    <h5 class="modal-title fw-bold">Registrar Nuevo Pago</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body p-4">
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
                                <input type="number" name="total_pago" id="total_pago_add" class="form-control" required min="0" step="0.01">
                            </div>
                            <small class="text-muted">Se actualizará automáticamente al seleccionar tipo de contratación</small>
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

                <div class="modal-footer bg-light">
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
                
                <div class="modal-body p-4">
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
                                <input type="number" name="total_pago" id="edit_total" class="form-control" required min="0" step="0.01">
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

        // Lógica para llenar el Modal de Edición
        const botonesEditar = document.querySelectorAll('.btn-editar');
        botonesEditar.forEach(boton => {
            boton.addEventListener('click', function() {
                const rfc = this.dataset.rfc;
                const fecha = this.dataset.fecha;
                
                // Llenar inputs de solo lectura
                document.getElementById('edit_rfc_display').value = rfc;
                document.getElementById('edit_fecha_display').value = fecha;
                
                // Llenar inputs editables
                document.getElementById('edit_tipo').value = this.dataset.tipo;
                document.getElementById('edit_total').value = this.dataset.total;
                document.getElementById('edit_forma').value = this.dataset.forma;
                document.getElementById('edit_reembolso').checked = this.dataset.reembolso == '1';
                
                // Actualizar action del form
                const form = document.getElementById('formEditar');
                form.action = `/pagos/${rfc}/${fecha}`;
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
</script>
@endsection