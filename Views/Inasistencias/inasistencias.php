<?php header_admin($data); ?>

<main id="main" class="main">

  <div class="pagetitle">

    <div class="container" id="container" name="container"
      style="text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh;">


      <div class="container1" id="container1" style="display: none;" name="container1">

        <div class="row mt-7">
          <img src="assets/img/rfid.PNG" alt="" style="opacity: 0.1; width: 700px; height: auto;">
        </div>
        <h1 style="font-size: 200%; ">Acerque su dispositivo al RFID</h1>

        <form id="frmInasistencia" name="frmInasistencia">
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Codigo del aprendiz</label>
            <input type="text" class="form-control" id="codigoInasistencia" name="codigoInasistencia"
              aria-describedby="emailHelp">

            <input type="hidden" class="form-control" id="numeroFicha" name="numeroFicha" aria-describedby="emailHelp">
          </div>
          <!--<button type="submit" class="btn btn-primary">Insertar</button> -->
        </form>

      </div>

      <div class="container2" id="container2" name="container2" style="display: block;">
        <div class="row" id="card" name="card">
          <!--Card-->

        </div>
      </div>

      <div id="alerta" style="display: none; padding: 10px; margin-top: 10px; border-radius: 5px;"></div>

    </div>


  </div>

  <!-- End Page Title -->
  <?php footer_admin($data) ?>
  <script src="<?= media() ?>/js/inasistencias/inasistencias.js"></script>

</main>