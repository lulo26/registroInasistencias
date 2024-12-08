<div class="card">
            <div class="card-body">

              <!-- Vertically centered Modal -->
              <div class="modal fade" id="crearCursoModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="CursoModalLabel">Agregar curso</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="row g-3" id="frmCursos">
                    <div class="modal-body">
                    <input type="hidden" name="idcurso" id="idcurso" value="0" >
                <div class="col-md-12">
                  <label for="nombreCurso" class="form-label">Nombre del curso</label>
                  <input type="text" class="form-control" name="nombreCurso" id="nombreCurso">
                </div>
                <div class="col-md-12 mt-3">
                  <label for="tipoCurso" class="form-label">Tipo de curso</label>
                  <select class="form-select" aria-label="Default select example" name="tipoCurso" id="tipoCurso">
                    <option selected>Seleccione el tipo de curso</option>
                    <option value="tecnico">tecnico</option>
                    <option value="tecnologo">tecnologo</option>
                    <option value="complementario">complementario</option>
                  </select>
                </div>
                <div class="col-md-12 mt-3">
                <label for="descripcionCurso" class="form-label">descripción</label>
                    <textarea class="form-control" style="height: 100px" name="descripcionCurso" id="descripcionCurso"></textarea>
                  </div>
              
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                      <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                    </form>
                  </div>
                </div>
              </div><!-- End Vertically centered Modal-->
            </div>
  </div>
