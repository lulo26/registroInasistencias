<!-- Carga todo el header, la variable $data viene desde el controlador -->
<?php header_admin($data); 
getModal('horariosModal', $data);?> 

<main id="main" class="main">

<div class="pagetitle">
  <h1>Horarios</h1>
  <nav>
  </nav>
</div><!-- End Page Title -->

<div class="card">
  <div class="card-body">
    <h5 class="card-title"><?= $data['page_title']?> 
      <button type="button" class="btn btn-primary m-3" id="btnHorario">
      <i class="bi bi-plus-circle"></i> Agregar horario
    </button>
  </h5> 
  <input class="form-control" type="file" id="excel" name="horarioFile" accept=".xlsx">
  </div>

  <div id="alertZone"></div>

  <div id="display"></div>
</div>

<script src="https://unpkg.com/read-excel-file@5.x/bundle/read-excel-file.min.js"></script>
<?php footer_admin($data) ?> <!-- Carga todo el footer -->