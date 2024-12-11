<?php
header_admin($data);
getModal('usuariosModal', $data);
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

  <button id="btnInsertarUsuario"></button>

  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Tabla usuarios</h5>
      <table class="table datatable">
        <thead>
          <tr>
            <th>
              <b>I</b>D
            </th>
            <th>Documento</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Telefono</th>
            <th>Rol</th>
            <th>Codigo</th>
            <th>Opciones</th>
          </tr>
        </thead>
        <tbody id="tablaUsuarios">
          <tr></tr>
        </tbody>
      </table>
    </div>
  </div>

  <?php footer_admin($data) ?>
  <script src="<?= media() ?>/js/usuarios/usuarios.js"></script>