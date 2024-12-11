<div class="card">
  <div class="card-body">

    <!-- Vertically centered Modal -->
    <div class="modal fade" id="crearUsuarioModal" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="UsuarioModalLabel">Agregar Usuario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form class="row g-3" id="frmUsuarios">
            <div class="modal-body">
              <span>Todos los campos son obligatorios</span>

              <input type="hidden" name="idusuario" id="idusuario" value="0">


              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="nombre_usuario">Nombre</label>
                  <input type="text" class="form-control valid validText" id="nombre_usuario" name="nombre_usuario" autocomplete="off" required="">
                </div>
                <div class="form-group col-md-6">
                  <label for="numdoc_usuario">Identificacion</label>
                  <input type="number" min="1" class="form-control valid validNumber" id="numdoc_usuario" name="numdoc_usuario" autocomplete="off" required="">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="correo_usuario">E-mail</label>
                  <input type="email" class="form-control valid validEmail" id="correo_usuario" name="correo_usuario" autocomplete="off" required="">
                </div>
                <div class="form-group col-md-6">
                  <label for="telefono_usuario">Teléfono</label>
                  <input type="number" min="1" class="form-control valid validNumber" id="telefono_usuario" name="telefono_usuario" autocomplete="off" required="" onkeypress="return controlTag(event);">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="codigo_usuario">Codigo</label>
                  <input type="text" class="form-control valid validEmail" id="codigo_usuario" name="codigo_usuario" autocomplete="off">
                </div>
                <div class="form-group col-md-6">
                  <label for="password_usuario">Contraseña</label>
                  <input type="password" class="form-control valid validNumber" id="password_usuario" name="password_usuario" autocomplete="off" required="" onkeypress="return controlTag(event);">
                </div>
              </div>

              <!-- Hacer select ROL -->
              <div class="form-row">
                <div class="form-group col-md-12 mt-3"">
                  <label for=" roles_idrol">Rol</label>
                  <input type="number" min="1" class="form-control valid validNumber" id="roles_idrol" name="roles_idrol" autocomplete="off" required="" onkeypress="return controlTag(event);">
                </div>
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