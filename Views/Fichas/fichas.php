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
          <th>Opciones</th>
        </tr>
      </thead>
      <tbody id="tablaFichas">
      </tbody>
    </table>
  </div>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Tabla Fichas<button type="button" class="btn btn-primary m-2" id="btnFicha"><i class="bi bi-plus-circle"></i> Añadir - Ficha</button></h5>
      <table class="table datatable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Numero de Ficha</th>
            <th>Curso</th>
            <th>Fecha de Inicio</th>
            <th>Fecha de Fin</th>
            <th>Modalidad</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody id="tablaFichas">
          <tr></tr>
        </tbody>
      </table>
    </div>
  </div>
  <!-- Modal para asignar usuarios -->
  <div class="modal fade" id="modalAsignarUsuarios" tabindex="-1" aria-labelledby="modalAsignarUsuariosLabel" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAsignarUsuariosLabel">Asignar Usuarios</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="idFichaAsignacion">
          <div class="row">
            <div class="col-md-6">
              <h6>Instructores</h6>
              <select id="selectInstructores" class="form-select" multiple size="8"></select>
            </div>
            <div class="col-md-6">
              <h6>Aprendices</h6>
              <select id="selectAprendices" class="form-select" size="8"></select>
              <small class="text-muted">* Solo puedes asignar un aprendiz por ficha</small>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" id="btnGuardarAsignaciones">Guardar</button>
        </div>
      </div>
    </div>
  </div>
  <?php footer_admin($data) ?>
