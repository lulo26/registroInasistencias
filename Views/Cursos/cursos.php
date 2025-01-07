<?php header_admin($data); ?>

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
    <h5 class="card-title">Tabla cursos</h5>
    <table class="table datatable">
      <thead>
        <tr>
          <th>
            <b>I</b>D
          </th>
          <th>Nombre</th>
          <th>Tipo</th>
          <th>Descripción</th>
        </tr>
      </thead>
      <tbody>
        <tr id="tablaCursos"></tr>
      </tbody>
    </table>
  </div>
</div>

<?php footer_admin($data) ?> 
<script src="<?= media() ?>/js/cursos/cursos.js"></script>