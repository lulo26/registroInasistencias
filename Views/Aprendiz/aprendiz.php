<?php header_admin($data);
getModal('aprendizModal', $data);
//require_once '../../Views/Aprendiz/aprendiz.php'
?>


<main id="main" class="main">

  <div class="pagetitle">
    <h1><?= $data['page_title'] ?></h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home">home</a></li>
        <li class="breadcrumb-item"><?= $data['page_title'] ?></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <div class="row mt-3">
    <div class="row-3">
      <button type="button" id="btnCrearAprendiz" class="btn btn-primary">Crear Aprendiz</button>
    </div>
  </div>
  <div class="row mt-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Tabla Aprendices</h5>
        <table class="table datatable" id="tablaAprendiz" name="tablaAprendiz">
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
    </div>
  </div>
  </nav>
  </div>


  <!-- End Page Title -->
  <?php footer_admin($data) ?>
  <script src="<?= media() ?>/js/aprendiz/aprendiz.js"></script>