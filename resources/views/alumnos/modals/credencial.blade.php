<div class="modal fade" id="modalCredencial" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-id-card me-2"></i> Generar Credencial
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            
            <form action="{{ route('alumnos.credencial') }}" method="POST" enctype="multipart/form-data" target="_blank">
                @csrf
                <div class="modal-body p-4 bg-[#fff] dark:bg-slate-700">
                    
                    <div class="alert alert-light border text-center mb-4">
                        <h5 class="fw-bold text-dark mb-1" id="view_nombre">Nombre del Alumno</h5>
                        <div class="text-muted small">RFC: <span id="view_rfc"></span></div>
                        <div class="badge bg-secondary mt-2">Permiso: <span id="view_permiso"></span></div>
                    </div>

                    <input type="hidden" name="rfc" id="input_rfc">

                    <div class="mb-3">
                        <label for="foto" class="form-label fw-bold">Fotografía del Alumno</label>
                        <input type="file" class="form-control" name="foto" accept="image/jpeg,image/png,image/jpg">
                        <div class="form-text dark:text-[#fff]">
                            <i class="fas fa-info-circle"></i> Sube una foto para que aparezca en la credencial. Si no subes ninguna, se usará la anterior o una genérica.
                        </div>
                    </div>

                </div>
                <div class="modal-footer bg-[#fff] dark:bg-slate-500">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info text-white fw-bold">
                        <i class="fas fa-file-pdf me-2"></i> Generar PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>