<div class="modal fade" id="modalEditarAlumno" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <form id="formEditarAlumno" method="POST">
                @csrf
                @method('PUT')

                {{-- HEADER --}}
                <div class="modal-header text-white" style="background-color: #092c4c;">
                    <h5 class="modal-title fw-bold">Modificar Alumno</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                {{-- CONTENIDo --}}
                <div class="modal-body p-4">
                    <div class="row g-3">

                        {{-- RFC (solo lectura) --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">RFC</label>
                            <input type="text" class="form-control" id="edit_rfc" name="rfc" readonly>
                        </div>

                        {{-- Nombre --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nombre(s)</label>
                            <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
                        </div>

                        {{-- Apellidos --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Apellido Paterno</label>
                            <input type="text" class="form-control" id="edit_apellido_p" name="apellido_p" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Apellido Materno</label>
                            <input type="text" class="form-control" id="edit_apellido_m" name="apellido_m">
                        </div>

                        {{-- Fecha nacimiento --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Fecha de nacimiento</label>
                            <input type="date" class="form-control" id="edit_fecha_nac" name="fecha_nac" required>
                        </div>

                        {{-- Permiso --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Permiso</label>
                            <select class="form-select" id="edit_permiso" name="permiso" required>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>

                        {{-- Sección dirección --}}
                        <div class="col-12 mt-4">
                            <h6 class="fw-bold border-bottom pb-2">Dirección</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Calle</label>
                            <input type="text" class="form-control" id="edit_calle" name="calle" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Número</label>
                            <input type="number" class="form-control" id="edit_numero" name="numero" min="0" max="999" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Colonia</label>
                            <input type="text" class="form-control" id="edit_colonia" name="colonia" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Alcaldía</label>
                            <input type="text" class="form-control" id="edit_alcaldia" name="alcaldia" required>
                        </div>

                        {{-- Correo y observaciones --}}
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Correo electrónico</label>
                            <input type="email" class="form-control" id="edit_correo" name="correo" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Observaciones</label>
                            <textarea class="form-control" id="edit_observaciones" name="observaciones" rows="2"></textarea>
                        </div>
                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn text-white" style="background-color: #212529;">
                        Actualizar
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
