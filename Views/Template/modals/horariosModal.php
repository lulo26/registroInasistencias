<div class="card">
            <div class="card-body">

              <!-- Vertically centered Modal -->
              <div class="modal fade" id="horarioModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="horarioModalLabel">Agregar horario</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="row g-3" id="frmHorario">
                    <div class="modal-body">
                    <div class="col-md-12">
                  <label for="numFicha" class="form-label">Numero de la ficha</label>
                  <input type="number" class="form-control" name="numFicha" id="numFicha">
                </div>
                <div class="col-md-12 mt-3">
                  <label for="horarioFile" class="form-label">Subir horario</label>
                  <!-- <input class="form-control" type="file" id="horarioFile" name="horarioFile" accept=".xlsx"> -->
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