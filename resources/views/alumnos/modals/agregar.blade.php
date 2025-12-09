<!-- Modal Agregar Alumno -->
<div class="modal fade" id="modalAgregarAlumno" tabindex="-1" aria-hidden="true">

  <div class="modal-dialog modal-xl" id="modalAgregarAlumnoDialog">

    <div class="modal-content" id="modalAgregarAlumnoContent">

      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Agregar Alumno</h5>

        <!-- Botón para cerrar el modal -->
        <button type="button" class="btn-close" id="btnCerrarModalAgregarAlumno"></button>
      </div>

      <form action="{{ route('alumnos.store') }}" method="POST" id="formAgregarAlumno">
        @csrf

        <div class="modal-body">

          <!-- RFC + Tipo de Contratación -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label>RFC (mayúsculas)</label>
              <input type="text" name="rfc" class="form-control" id="inputRFC" required>
            </div>

            <div class="col-md-6">
              <label>Tipo de Contratación</label>
              <select name="tipo_contratacion" class="form-control" id="selectTipoContratacion" required>
                <option value="Clase Individual">Clase Individual</option>
                <option value="Paquete">Paquete</option>
              </select>
            </div>
          </div>

          <!-- Nombre -->
          <div class="row mb-3">
            <div class="col-md-4">
              <label>Nombre</label>
              <input type="text" name="nombre" class="form-control" id="inputNombre" required>
            </div>

            <div class="col-md-4">
              <label>Apellido Paterno</label>
              <input type="text" name="apellido_paterno" class="form-control" id="inputApP" required>
            </div>

            <div class="col-md-4">
              <label>Apellido Materno</label>
              <input type="text" name="apellido_materno" class="form-control" id="inputApM">
            </div>
          </div>

          <!-- Fecha Nacimiento + Permiso -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label>Fecha de Nacimiento</label>
              <input type="date" name="fecha_nacimiento" class="form-control" id="inputFechaNacimiento" required>
            </div>

            <div class="col-md-6">
              <label>Permiso</label>
              <select name="permiso" class="form-control" id="selectPermiso" required>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
              </select>
            </div>
          </div>

          <hr>

          <!-- Dirección -->
          <div class="row mb-3">
            <div class="col-md-4">
              <label>Calle</label>
              <input type="text" name="calle" class="form-control" id="inputCalle" required>
            </div>

            <div class="col-md-2">
              <label>Número</label>
              <input type="text" name="numero" class="form-control" id="inputNumero" required>
            </div>

            <div class="col-md-4">
              <label>Colonia</label>
              <input type="text" name="colonia" class="form-control" id="inputColonia" required>
            </div>

            <div class="col-md-2">
              <label>Alcaldía</label>
              <input type="text" name="alcaldia" class="form-control" id="inputAlcaldia" required>
            </div>
          </div>

          <!-- Pago -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label>Fecha de Pago</label>
              <input type="date" name="fecha_pago" class="form-control" id="inputFechaPago">
            </div>

            <div class="col-md-6">
              <label>Total Pago</label>
              <input type="number" name="total_pago" class="form-control" id="inputTotalPago" placeholder="Ej. 1500">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label>Forma de Pago</label>
              <select name="forma_pago" class="form-control" id="selectFormaPago">
                <option value="Efectivo">Efectivo</option>
                <option value="Tarjeta">Tarjeta</option>
                <option value="Transferencia">Transferencia</option>
              </select>
            </div>

            <div class="col-md-6">
              <label>Reembolso (1=Sí, 0=No)</label>
              <input type="number" name="reembolso" class="form-control" id="inputReembolso" min="0" max="1">
            </div>
          </div>

          <!-- Correo -->
          <div class="mb-3">
            <label>Correo</label>
            <input type="email" name="correo" class="form-control" id="inputCorreo">
          </div>

          <!-- Observaciones -->
          <div class="mb-3">
            <label>Observaciones</label>
            <textarea name="observaciones" class="form-control" id="inputObservaciones" rows="2"></textarea>
          </div>

        </div> <!-- modal-body -->

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="btnCancelarModalAgregarAlumno">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>

      </form>
    </div>
  </div>
</div>
