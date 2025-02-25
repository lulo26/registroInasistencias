<?php
header_admin($data);
getModal('fichasModal', $data);
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
  </div>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Tabla Fichas<button type="button" class="btn btn-primary m-2" id="btnFicha"><i class="bi bi-plus-circle"></i>Añadir Ficha</button></h5>
      <table class="table datatable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Numero de Ficha</th>
            <th>Curso</th>
            <th>Fecha de Inicio</th>
            <th>Fecha de Fin</th>
            <th>Modalidad</th>
          </tr>
        </thead>
        <tbody id="tablaFichas">
          <tr></tr>
        </tbody>
      </table>
    </div>
  </div>
  <?php footer_admin($data) ?>