<div class="card">
            <div class="card-body">

              <!-- Vertically centered Modal -->
              <div class="modal fade" id="crearFichaModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-md">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="FichaModalLabel">Agregar curso</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="row g-3" id="frmFichas">
                    <div class="modal-body">
                    <input type="hidden" name="idcurso" id="idcurso" value="0" >
                    <div class="row"> 
                <div class="col-md-12">
                  <label for="numFicha" class="form-label">Numero de la ficha</label>
                  <input type="number" class="form-control" name="numFicha" id="numFicha">
                </div>
                <div class="col-md-12 mt-3">
                  <label for="tipoCurso" class="form-label">Curso</label>
                  <select class="form-select" aria-label="Default select example" name="tipoCurso" id="tipoCurso">
                    <option selected>Seleccione el curso</option>
                    <option value="tecnico">tecnico</option>
                    <option value="tecnologo">tecnologo</option>
                    <option value="complementario">complementario</option>
                  </select>
                </div>
            </div>
               <div class="col-md-12 mt-3">
                  <label for="fechaIni" class="form-label">Fecha de inicio</label>
                  <input type="date" class="form-control" name="fechaIni" id="fechaIni">
                </div>
                <div class="col-md-12 mt-3">
                  <label for="fechaFin" class="form-label">Fecha de finalización</label>
                  <input type="date" class="form-control" name="fechaFin" id="fechaFin">
               </div>
               <div class="col-md-12 mt-3 mb-4">
                  <label for="tipoCurso" class="form-label">Modalidad</label>
                  <select class="form-select" aria-label="Default select example" name="tipoCurso" id="tipoCurso">
                    <option selected>Seleccione la modalidad</option>
                    <option value="presencial">Presencial</option>
                    <option value="virtual">Virtual</option>
                  </select>
                </div>
                
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                      <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                    </div>
                    </form>
                  </div>
                </div>
              </div><!-- End Vertically centered Modal-->
            </div>
  </div>