<?php
header_admin($data);
getModal('subirExcusaModal', $data);
getModal('rechazarExcusaModal', $data);
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

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Inasistencias
                <!-- <button type="button" class="btn btn-primary m-3" id="btnUsuario">
                    <i class="bi bi-plus-circle"></i> Agregar usuario
                </button> -->
            </h5>
            <table class="table datatable">
                <thead>
                    <tr>
                        <th># Inasistencia</th>
                        <!-- <th>Aprendiz</th> -->
                        <th>Fecha</th>
                        <th>Instructor</th>
                        <th>Excusa</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody id="tablaInasistencias">
                    <tr></tr>
                </tbody>
            </table>

            <table class="table datatable">
                <thead>
                    <tr>
                        <th>Inasistencia</th>
                        <th>Aprendiz</th>
                        <th>Programa</th>
                        <th>Ficha</th>
                        <th>Fecha Excusa</th>
                        <th>Excusa</th>
                        <th>Aprobar/Rechazar</th>
                    </tr>
                </thead>
                <tbody id="tablaExcusas">
                    <tr></tr>
                </tbody>
            </table>

        </div>
    </div>

    <?php footer_admin($data) ?>