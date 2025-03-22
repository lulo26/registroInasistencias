<div class="card">
    <div class="card-body">

        <!-- Vertically centered Modal -->
        <div class="modal fade" id="crearExcepModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="ExcepModalLabel">Nueva Excepción</h5>
                        <button type="button" class="btn-close bg-white" name="btnEquis" id="btnEquis" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="row g-3" id="frmExcepciones">
                        <div class="modal-body" style="margin-bottom: -2%;">
                            <!-- <span>Todos los campos son obligatorios</span> -->

                            <input type="hidden" name="idexcepcion" id="idexcepcion" value="0">

                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="fecha_excep">Fecha</label>
                                    <input type="date" min="<?php echo date('Y-m-d'); ?>" class="form-control valid validDate" id="fecha_excep" name="fecha_excep" autocomplete="off" required="">
                                </div>
                                <div class="form-group col-6">
                                    <label for="numdoc_usuario">Ficha</label>
                                    <input type="number" min="1" class="form-control valid validNumber" id="numdoc_usuario" name="numdoc_usuario" autocomplete="off" required="">
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="form-group">
                                    <label for="motivo_excep">Motivo</label>
                                    <textarea class="form-control valid validText" rows="2" name="motivo_excep" id="motivo_excep"></textarea>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="form-group">
                                    <label for="rol_usuario">Bloque</label>
                                    <select class="form-select" aria-label="Default select example" name="rol_usuario" id="rol_usuario">
                                        <option disabled selected>Selecciona un bloque</option>
                                        <option value="INSTRUCTOR">3 horas</option>
                                        <option value="COORDINADOR">6 horas</option>
                                    </select>
                                </div>
                            </div>

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