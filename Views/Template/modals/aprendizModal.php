<!-- Modal Crear/Actualizar -->
<div class="modal fade" id="crearAprendizModal" name="crearAprendizModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-light">
                <h5 class="modal-title font-weight-bold" id="crearAprendizModalLabel">Crear Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmAprendiz" name="frmAprendiz">
                    <input type="hidden" id="idAprendiz" name="idAprendiz" value="0">
                    <div class="alert alert-info text-center">
                        <strong>Importante:</strong> Todos los campos son obligatorios.
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 mx-auto">
                                <div class="form-group text-center">
                                    <label for="numeroDocumentoAprendiz">Identificación <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="numeroDocumentoAprendiz"
                                        name="numeroDocumentoAprendiz" autocomplete="off" required>
                                </div>
                                <div class="form-group text-center">
                                    <label for="nombreAprendiz">Nombres del aprendiz <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nombreAprendiz" name="nombreAprendiz"
                                        autocomplete="off" required>
                                </div>
                                <div class="form-group text-center">
                                    <label for="apellidoAprendiz">Apellidos del aprendiz <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="apellidoAprendiz"
                                        name="apellidoAprendiz" autocomplete="off" required>
                                </div>
                                <div class="form-group text-center">
                                    <label for="usuarioAprendiz">Nombre de usuario <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="usuarioAprendiz" name="usuarioAprendiz"
                                        autocomplete="off" required>
                                </div>
                                <div class="form-group text-center">
                                    <label for="contraAprendiz">Contraseña <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="contraAprendiz"
                                        name="contraAprendiz" autocomplete="off" required>
                                </div>
                                <div class="form-group text-center">
                                    <label for="codigoAprendiz">Código del aprendiz <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="codigoAprendiz" name="codigoAprendiz"
                                        autocomplete="off" required>
                                </div>
                                <div class="form-group text-center">
                                    <label for="generoAprendiz">Género <span class="text-danger">*</span></label>
                                    <select class="form-control" id="generoAprendiz" name="generoAprendiz" required>
                                        <option value="">Seleccione un género</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                        <option value="Otros">Otros..</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" id="btnCancelarModal" class="btn btn-secondary">Cancelar</button>

                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
            </form>
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