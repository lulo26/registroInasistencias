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


}
?>