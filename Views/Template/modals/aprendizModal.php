<!-- Modal Crear/Actualizar -->
<div class="modal fade" id="crearAprendizModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">

            <!-- Encabezado azul -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold text-center " id="crearAprendizModalLabel">Crear Usuario</h5>
            </div>

            <!-- Cuerpo del modal -->
            <div class="modal-body">
                <form id="frmAprendiz" name="frmAprendiz">
                    <input type="hidden" id="idAprendiz" name="idAprendiz" value="0">

                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-10">

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="numeroDocumentoAprendiz">Identificación <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="numeroDocumentoAprendiz"
                                                name="numeroDocumentoAprendiz" autocomplete="off" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="nombreAprendiz">Nombres del aprendiz <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="nombreAprendiz"
                                                name="nombreAprendiz" autocomplete="off" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="apellidoAprendiz">Apellidos del aprendiz <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="apellidoAprendiz"
                                                name="apellidoAprendiz" autocomplete="off" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="usuarioAprendiz">Nombre de usuario <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="usuarioAprendiz"
                                                name="usuarioAprendiz" autocomplete="off" required>
                                        </div>

                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="contraAprendiz">Contraseña <span
                                                    class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="contraAprendiz"
                                                name="contraAprendiz" autocomplete="off" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="codigoAprendiz">Código del aprendiz <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="codigoAprendiz"
                                                name="codigoAprendiz" autocomplete="off" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="generoAprendiz">Género <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control" id="generoAprendiz" name="generoAprendiz"
                                                required>
                                                <option value="">Seleccione un género</option>
                                                <option value="Masculino">Masculino</option>
                                                <option value="Femenino">Femenino</option>
                                                <option value="Otros">Otros...</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
            </div>

            <!-- Footer con botones -->
            <div class="modal-footer d-flex justify-content-between">

                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
            </form>

        </div>
    </div>
</div>

<!-- Modal para Actualizar Aprendiz -->
<div class="modal fade" id="actualizarAprendizModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">

            <!-- Encabezado azul -->
            <div class="modal-header bg-primary text-white position-relative">
                <h5 class="modal-title font-weight-bold text-center w-100" id="actualizarAprendizModalLabel">Actualizar
                    Aprendiz</h5>
            </div>

            <!-- Cuerpo del modal -->
            <div class="modal-body">
                <form id="frmActualizarAprendiz" name="frmActualizarAprendiz">
                    <input type="hidden" id="idAprendiz1" name="idAprendiz1">

                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-10">

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="numeroDocumentoAprendiz1">Identificación <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="numeroDocumentoAprendiz1"
                                                name="numeroDocumentoAprendiz1" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="nombreAprendiz1">Nombres del aprendiz <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="nombreAprendiz1"
                                                name="nombreAprendiz1" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="apellidoAprendiz1">Apellidos del aprendiz <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="apellidoAprendiz1"
                                                name="apellidoAprendiz1" required>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="codigoAprendiz1">Código del aprendiz <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="codigoAprendiz1"
                                                name="codigoAprendiz1" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="generoAprendiz1">Género <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control" id="generoAprendiz1" name="generoAprendiz1"
                                                required>
                                                <option value="">Seleccione un género</option>
                                                <option value="Masculino">Masculino</option>
                                                <option value="Femenino">Femenino</option>
                                                <option value="Otros">Otros...</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Footer con botones -->
                    <div class="modal-footer d-flex justify-content-between">

                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



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