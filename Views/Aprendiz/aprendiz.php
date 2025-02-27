<?php header_admin($data);
getModal('aprendizModal', $data);
//require_once '../../Views/Aprendiz/aprendiz.php'
?>


<main id="main" class="main">

  <div class="pagetitle">
    <h1>Aprendices</h1>
    <nav>
      <div class="row mt-3">
        <div class="row-3">
          <button type="button" id="btnCrearAprendiz" class="btn btn-primary">Crear Aprendiz</button>
        </div>
      </div>

      <div class="row mt-3">
        <table class="table" id="tablaAprendiz" name="tablaAprendiz">
          <thead>
            <tr>
              <th scope="col">Id</th>
              <th scope="col">Numero documento</th>
              <th scope="col">Nombre</th>
              <th scope="col">Apellido</th>
              <th scope="col">genero</th>
              <th scope="col">Acciones</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </nav>
  </div>


  <!-- End Page Title -->
  <?php footer_admin($data) ?>
  <script src="<?= media() ?>/js/aprendiz/aprendiz.js"></script>