<div class="card">
  <div class="card-body">

    <!-- Vertically centered Modal -->
    <div class="modal fade" id="crearUsuarioModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="UsuarioModalLabel">Agregar Usuario</h5>
            <button type="button" class="btn-close bg-white" name="btnEquis" id="btnEquis" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form class="row g-3" id="frmUsuarios">
            <div class="modal-body" style="margin-bottom: -2%;">
              <!-- <span>Todos los campos son obligatorios</span> -->

              <input type="hidden" name="idusuario" id="idusuario" value="0">

              <div class="row">
                <div class="form-group col-6">
                  <label for="nombre_usuario">Nombre</label>
                  <input type="text" class="form-control valid validText" id="nombre_usuario" name="nombre_usuario" autocomplete="off" required="">
                </div>
                <div class="form-group col-6">
                  <label for="numdoc_usuario">Identificacion</label>
                  <input type="number" min="1" class="form-control valid validNumber" id="numdoc_usuario" name="numdoc_usuario" autocomplete="off" required="">
                </div>
              </div>

              <div class="row mt-2">
                <div class="form-group col-6">
                  <label for="correo_usuario">E-mail</label>
                  <input type="email" class="form-control valid validEmail" id="correo_usuario" name="correo_usuario" autocomplete="off" required="">
                </div>
                <div class="form-group col-6">
                  <label for="telefono_usuario">Teléfono</label>
                  <input type="number" min="1" class="form-control valid validNumber" id="telefono_usuario" name="telefono_usuario" autocomplete="off" required="">
                </div>
              </div>
              <!-- </div> -->

              <div class="row mt-2">
                <div class="form-group col-6">
                  <label for="codigo_usuario">Codigo</label>
                  <input type="text" class="form-control valid validText" id="codigo_usuario" name="codigo_usuario" autocomplete="off">
                </div>
                <div class="form-group col-6">
                  <label for="password_usuario">Contraseña</label>
                  <input type="password" class="form-control valid validPassword" id="password_usuario" name="password_usuario" autocomplete="off" required="">
                </div>
              </div>
              <div class="form-group col-12">
                <label for="telefono_usuario">Teléfono</label>
                <input type="number" min="1" class="form-control valid validNumber" id="telefono_usuario" name="telefono_usuario" autocomplete="off" required="">
              </div>
              <!-- </div> -->

              <label for="roles_idrol" class="form-label mt-2">Rol</label>
              <select class="form-select" aria-label="Default select example" name="roles_idrol" id="roles_idrol">
                <!-- Aqui se cargan los roles dinamicamente -->
              </select>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" name="btnCerrar" id="btnCerrar" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div><!-- End Vertically centered Modal-->
  </div>
</div>