<?php

class Reporte extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function reporte()
    {

        $data['page_title'] = "reporte";
        $data['page_id_name'] = "reporte";
        $data['page_functions_js'] = "reportes/reportes.js";

        $this->views->getView($this, "reportes", $data);
    }

    public function getAprendices()
    {
        $arrData = $this->model->getAprendices();

        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getFichas()
    {
        $arrData = $this->model->getFichas();

        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function getAsistenciasForAprendiz()
    {

        if (isset($_GET['idAprendiz'], $_GET['fechaInicio'], $_GET['fechaFin'])) {

            $idAprendiz = intval($_GET['idAprendiz']);
            $inicio = $_GET['fechaInicio'];
            $fin = $_GET['fechaFin'];

            $arrData = $this->model->selectForAprendiz($inicio, $fin, $idAprendiz);

            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        } else {

            echo json_encode(["error" => "Faltan parámetros"], JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function getAsistenciasForFicha()
    {

        if (isset($_GET['idFicha'], $_GET['fechaInicio'], $_GET['fechaFin'])) {

            $idFicha = intval($_GET['idFicha']);
            $inicio = $_GET['fechaInicio'];
            $fin = $_GET['fechaFin'];

            $arrData = $this->model->selectForFicha($inicio, $fin, $idFicha);

            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        } else {

            echo json_encode(["error" => "Faltan parámetros"], JSON_UNESCAPED_UNICODE);
        }
        die();
    }


}
?>