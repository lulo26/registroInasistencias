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
                                    <label for="fichas_idficha">Ficha</label>
                                    <select class="form-select" aria-label="Default select example" name="fichas_idficha" id="fichas_idficha">
                                        <!-- Aqui se cargan las fichas dinamicamente -->
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <!-- <div class="form-group">
                                    <label for="motivo_excep">Motivo</label>
                                    <textarea class="form-control valid validText" rows="2" name="motivo_excep" id="motivo_excep" required></textarea>
                                </div> -->
                                <div class="form-group">
                                    <label for="select_motivo">Motivo</label>
                                    <select class="form-select" aria-label="Default select example" name="select_motivo" id="select_motivo">
                                        <option disabled selected>Seleccione un motivo</option>
                                        <option value="Entrada tarde">Entrada tarde</option>
                                        <option value="Salida temprano">Salida temprano</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="form-group" id="div_otro_motivo">
                                    <!-- <label for="otro_motivo">Motivo</label> -->
                                    <textarea class="form-control valid validText" rows="2" name="otro_motivo" id="otro_motivo" placeholder="Motivo de la excepción"></textarea>
                                </div>
                                <div class="form-group" id="div_hora_entrada">
                                    <label for="hora_entrada">Hora de entrada</label>
                                    <input type="time" class="form-control valid validTime" id="hora_entrada" name="hora_entrada" autocomplete="off">
                                </div>
                                <div class="form-group" id="div_hora_salida">
                                    <label for="hora_salida">Hora de salida</label>
                                    <input type="time" class="form-control valid validTime" id="hora_salida" name="hora_salida" autocomplete="off">
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="form-group">
                                    <label for="bloques_idbloque">Bloque</label>
                                    <select class="form-select" aria-label="Default select example" name="bloques_idbloque" id="bloques_idbloque">
                                        <option disabled selected>Seleccione un bloque</option>
                                        <option value="3">3 horas</option>
                                        <option value="3">6 horas</option>
                                    </select>
                                </div>
                            </div>

                            <!-- <label for="roles_idrol" class="form-label mt-2">Rol</label>
                            <select class="form-select" aria-label="Default select example" name="roles_idrol" id="roles_idrol">
                                Aqui se cargan los roles dinamicamente 
                            </select> -->

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