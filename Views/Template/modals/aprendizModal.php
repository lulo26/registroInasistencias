<!-- Modal Crear/Actualizar -->
<div class="modal fade" id="crearAprendizModal" name="crearAprendizModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" name="crearAprendizModalLabel" id="crearAprendizModalLabel">Crear Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- aquí va el contenido del modal -->
                <form id="frmAprendiz" name="frmAprendiz">
                    <input type="hidden" id="idAprendiz" name="idAprendiz" value="0">
                    <span>Todos los campos son obligatorios</span>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="txtIdentificacion">Identificacion</label>
                            <input type="number" class="form-control valid validNumber" id="numeroDocumentoAprendiz" name="numeroDocumentoAprendiz" autocomplete="off" required="">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="txtNombres">Nombres del aprendiz</label>
                            <input type="text" class="form-control valid validText" id="nombreAprendiz" name="nombreAprendiz" autocomplete="off" required="">

                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtApellidos">Apellidos del aprendiz</label>
                            <input type="text" class="form-control valid validText" id="apellidoAprendiz" name="apellidoAprendiz" autocomplete="off" required="">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="txtApellidos">Genero</label>
                            <input type="text" class="form-control valid validText" id="generoAprendiz" name="generoAprendiz" autocomplete="off" required="">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal VER USUARIOS --><!-- 
<div class="modal fade" id="verUsuarioModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearRolModalLabel">Informacion del Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <table class="table table-bordered" width="100%" cellspacing="0">
                    <tbody>

                        <tr>
                            <th>Identificacion</th>
                            <td id="celIdentificacion"></td>
                        </tr>

                        <tr>
                            <th>Nombres:</th>
                            <td id="celNombre"></td>
                        </tr>

                        <tr>
                            <th>Apellidos:</th>
                            <td id="celApellido"></td>
                        </tr>

                        <tr>
                            <th>Teléfono:</th>
                            <td id="celTelefono"></td>
                        </tr>

                        <tr>
                            <th>Email (Usuario):</th>
                            <td id="celEmail"></td>
                        </tr>

                        <tr>
                            <th>Tipo Usuario:</th>
                            <td id="celTipoUsuario"></td>
                        </tr>

                        <tr>
                            <th>Estado:</th>
                            <td id="celEstado"></td>
                        </tr>

                        <tr>
                            <th>Fecha registro:</th>
                            <td id="celFechaRegistro"></td>
                        </tr>

                    </tbody>
                </table>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>

            </div>
        </div>
    </div>
</div> -->