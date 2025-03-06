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
  </div>
</div>


<?php footer_admin($data) ?> <!-- Carga todo el footer -->