<div class="card">
  <div class="card-body">

    <!-- Vertically centered Modal -->
    <div class="modal fade" id="subirExcusaModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
      <div class="modal-dialog modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="ExcusaModalLabel">Adjuntar Excusa</h5>
            <button type="button" class="btn-close bg-white" name="btnEquis" id="btnEquis" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form class="row g-3" id="frmExcusas" enctype="multipart/form-data">
            <div class="modal-body" style="margin-bottom: -2%;">
              <!-- <span>Todos los campos son obligatorios</span> -->

              <input type="hidden" name="idexcusa" id="idexcusa" value="0">
              <input type="hidden" name="idAprendiz" id="idAprendiz" value="0">
              <input type="hidden" name="idInasistencia" id="idInasistencia" value="0">

              <div class="row">
                <div class="form-group">
                  <label class="form-label ms-1" for="excusa">Excusa:</label>
                  <input class="form-control" type="file" name="excusa" id="excusa" accept="application/pdf" required>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" name="btnCerrar" id="btnCerrar" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
          </form>
        </div>
      </div>
    </div><!-- End Vertically centered Modal-->
  </div>
</div>