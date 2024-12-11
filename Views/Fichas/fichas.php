<?php header_admin($data); 
getModal('fichasModal', $data);
?>

<main id="main" class="main">

<div class="pagetitle">
  <h1><?= $data['page_title']?></h1>
  <nav>
  <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?=base_url()?>/home">home</a></li>
          <li class="breadcrumb-item"><?= $data['page_title']?></li>
        </ol>
  </nav>
</div><!-- End Page Title -->
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Tabla <?= $data['page_title']?> 
      <button type="button" class="btn btn-primary m-3" id="btnFicha">
      <i class="bi bi-plus-circle"></i> Agregar ficha
    </button>
  </h5> 
    <table class="table mt-2">
      <thead>
        <tr>
          <th>
            <b>I</b>D
          </th>
          <th>Numero de ficha</th>
          <th>Curso</th>
          <th>Fecha de inicio</th>
          <th>Fecha de fin</th>
          <th>Modalidad</th>
        </tr>
      </thead>
      <tbody id="tablaFichas">
      </tbody>
    </table>
  </div>
</div>

<?php footer_admin($data) ?> 