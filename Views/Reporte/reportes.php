<?php header_admin($data); ?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1><?= $data['page_title'] ?></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>/home">Home</a></li>
                <li class="breadcrumb-item"><?= $data['page_title'] ?></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="row mt-3">
        <div class="col-3 text-right">
            <h5>Aprendiz</h5>
            <input type="text" id="inputAprendiz" class="form-control" placeholder="Seleccione el aprendiz"
                list="listAprendices">
            <datalist id="listAprendices"></datalist>
        </div>
        <div class="col-3 text-right">
            <h5>Mes</h5>
            <select class="form-select" id="selectMes" aria-label="Default select example" required>
                <option value="" selected>Seleccione el mes</option>
                <option value=01>Enero</option>
                <option value=02>Febrero</option>
                <option value=03>Marzo</option>
                <option value=04>Abril</option>
                <option value=05>Mayo</option>
                <option value=06>Junio</option>
                <option value=07>Julio</option>
                <option value=08>Agosto</option>
                <option value=09>Septiembre</option>
                <option value=10>Octubre</option>
                <option value=11>Noviembre</option>
                <option value=12>Diciembre</option>
            </select>
        </div>
        <div class="col-3 text-right">
            <h5>Ficha</h5>
            <select class="form-select" id="selectFicha2" aria-label="Default select example" required>
                <option value="" selected>Seleccione la ficha</option>
                <div class="selectFicha" id="selectFicha"></div>

            </select>
        </div>
        <div class="col-3 text-right">
            <button type="button" id="btnBuscar" class="btn btn-primary"><i class="bi bi-search"></i></button>
        </div>
    </div>


    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Lista de Aprendices</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tablaReportes">
                            <thead class="thead-light">
                                <tr id="cabeceraTabla">
                                </tr>
                            </thead>
                            <tbody id="tablaReportesBody">

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<?php footer_admin($data) ?>
<script src="<?= media() ?>/js/reportes/reportes.js"></script>