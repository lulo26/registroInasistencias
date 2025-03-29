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
  </h5> 
  <input class="form-control" type="file" id="excel" name="horarioFile" accept=".xlsx">
  </div>

  <div class="mb-3">

</div>

  <div id="alertZone"></div>

  <div id="display"></div>
</div>

<script src="https://unpkg.com/read-excel-file@5.x/bundle/read-excel-file.min.js"></script>
<?php footer_admin($data) ?> <!-- Carga todo el footer -->