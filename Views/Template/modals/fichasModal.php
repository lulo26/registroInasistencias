<div class="card">
  <div class="card-body">
    <div class="modal fade" id="crearFichaModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="FichaModalLabel">Agregar Ficha</h5>
            <button type="button" class="btn-close bg-white" name="btnCerrar2" id="btnCerrar2" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form class="row g-3" id="frmFichas">
            <div class="modal-body" style="margin-bottom: -2%;">
              <input type="hidden" name="idficha" id="idficha" value="0">
              <!-- Fila para Ficha y Curso -->
              <div class="row">
                <div class="form-group col-6">
                  <label for="numero_ficha">Ficha</label>
                  <input type="text" class="form-control valid validText" id="numero_ficha" name="numero_ficha" autocomplete="off" required>
                </div>
                <div class="form-group col-6">
                  <label for="cursos_idcurso" class="form-label mt-1">Curso</label>
                  <select class="form-select" aria-label="Default select example" name="cursos_idcurso" id="cursos_idcurso" required>
                    <option value="">Seleccione un curso</option>
                  </select>
                </div>
              </div>
              <!-- Fila para Fecha de Inicio y Fecha de Fin -->
              <div class="row mt-2">
                <div class="form-group col-6">
                  <label for="fecha_inicio">Fecha de inicio</label>
                  <input type="date" class="form-control valid validNumber" id="fecha_inicio" name="fecha_inicio" autocomplete="off" required>
                </div>
                <div class="form-group col-6">
                  <label for="fecha_fin">Fecha de Fin</label>
                  <input type="date" class="form-control valid validNumber" id="fecha_fin" name="fecha_fin" autocomplete="off" required>
                </div>
              </div>
              <!-- Fila para Modalidad -->
              <div class="row mt-2">
                <div class="form-group col-12">
                  <label for="modalidad">Modalidad</label>
                  <input type="text" class="form-control valid validText" id="modalidad" name="modalidad" autocomplete="off" required>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" name="btnCerrar" id="btnCerrar" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>