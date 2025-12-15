<div class="modal fade" id="modalAgregarAlumno" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <form action="{{ route('alumnos.store') }}" method="POST" id="formAgregarAlumno">
                @csrf

                {{-- HEADER DEL MODAL --}}
                <div class="modal-header text-white" style="background-color: #092c4c;">
                    <h5 class="modal-title fw-bold">Agregar Nuevo Alumno</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                {{-- CONTENIDO --}}
                <div class="modal-body p-4 bg-[#fff] dark:bg-slate-700">

                    <div class="row g-3">

                        {{-- RFC --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">RFC (mayúsculas)</label>
                            <input type="text" name="rfc" class="form-control" required>
                        </div>

                        {{-- Nombre --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nombre(s)</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>

                        {{-- Apellidos --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Apellido Paterno</label>
                            <input type="text" name="apellido_p" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Apellido Materno</label>
                            <input type="text" name="apellido_m" class="form-control">
                        </div>

                        {{-- Fecha de nacimiento --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Fecha de nacimiento</label>
                            <input type="date" name="fecha_nac" class="form-control" required>
                        </div>

                        {{-- Permiso --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Permiso</label>
                            <select name="permiso" class="form-select" required>
                                <option value="" disabled selected>Seleccione...</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>

                        {{-- Dirección --}}
                        <div class="col-12 mt-4">
                            <h6 class="fw-bold border-bottom pb-2">Dirección</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Calle</label>
                            <input type="text" name="calle" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Número</label>
                            <input type="number" name="numero" class="form-control" min="0" max="999" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Colonia</label>
                            <input type="text" name="colonia" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Alcaldía</label>
                            <input type="text" name="alcaldia" class="form-control" required>
                        </div>

                        {{-- Correo y observaciones --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Correo electrónico</label>
                            <input type="email" name="correo" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Observaciones</label>
                            <textarea name="observaciones" class="form-control" rows="2"></textarea>
                        </div>

                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="modal-footer bg-[#fff] dark:bg-[#092c4c]">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn text-white" style="background-color: #212529;">
                        Guardar
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
