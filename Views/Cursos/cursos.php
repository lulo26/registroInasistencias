<?php header_admin($data); 
getModal('cursosModal',$data);
?>

<!-- Fatal error: Uncaught Error: Failed opening required 
 'Views/Template/Modals/crearCursoModal.php' (include_path='C:\xampp\php\PEAR') 
 in C:\xampp\htdocs\registroInasistencias\Helpers\Helpers.php:59 Stack trace: #0 
 C:\xampp\htdocs\registroInasistencias\Views\Cursos\cursos.php(2): getModal('crearCursoModal', Array) 
 #1 C:\xampp\htdocs\registroInasistencias\Libraries\Core\Views.php(11): require_once('C:\\xampp\\htdocs...') 
 #2 C:\xampp\htdocs\registroInasistencias\Controllers\Cursos.php(14): Views->getView('Cursos', 'Views/Cursos/cu...', Array) 
 #3 C:\xampp\htdocs\registroInasistencias\Libraries\Core\Load.php(9): Cursos->cursos('') #4 C:\xampp\htdocs\registroInasistencias\index.php(29): 
 require_once('C:\\xampp\\htdocs...') #5 {main} thrown in C:\xampp\htdocs\registroInasistencias\Helpers\Helpers.php on line 59--->

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
    <h5 class="card-title">Tabla cursos 
      <button type="button" class="btn btn-primary m-3" id="btnCurso">
      <i class="bi bi-plus-circle"></i> Agregar curso
    </button>
  </h5> 
    <table class="table mt-2">
      <thead>
        <tr>
          <th>
            <b>I</b>D
          </th>
          <th>Nombre</th>
          <th>Tipo</th>
          <th>Descripción</th>
          <th>Opciones</th>
        </tr>
      </thead>
      <tbody id="tablaCursos">
      </tbody>
    </table>
  </div>
</div>

<?php footer_admin($data) ?> 