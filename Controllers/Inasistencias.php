<?php

class Inasistencias extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function inasistencias()
    {

        $data['page_title'] = "inasistencias";
        $data['page_id_name'] = "inasistencias";
        $data['page_functions_js'] = "inasistencias/inasistencias.js";

        $this->views->getView($this, "inasistencias", $data);
    }

    public function getInasistencias()
    {
        $arrData = $this->model->selectInasistencias();

        for ($i = 0; $i < count($arrData); $i++) {
            $btnEdit = "<button type='button' class='btn btn-primary rounded-pill' data-action-type='update' rel='" . $arrData[$i]['idregistro'] . "'>
                    <i class='bi bi-pencil-square'></i>
                </button>";
            $btnDelete = "<button type='button' class='btn btn-danger rounded-pill' data-action-type='delete' rel='" . $arrData[$i]['idregistro'] . "'>
                <i class='bi bi-trash-fill'></i>
                </button>";
            $arrData[$i]['actions'] = $btnDelete . " " . " " . $btnEdit;
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getFichas()
    {
        $arrData = $this->model->selectFichas();

        for ($i = 0; $i < count($arrData); $i++) {
            $btnEdit = "<button type='button' class='btn btn-primary rounded-pill' data-action-type='update' rel='" . $arrData[$i]['idficha'] . "'>
                    <i class='bi bi-pencil-square'></i>
                </button>";
            $btnDelete = "<button type='button' class='btn btn-danger rounded-pill' data-action-type='delete' rel='" . $arrData[$i]['idficha'] . "'>
                <i class='bi bi-trash-fill'></i>
                </button>";
            $arrData[$i]['actions'] = $btnDelete . " " . " " . $btnEdit;
        }

        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }



    public function setInasistencias()
    {

        $idUsuario = 5;
        $codigoInasistencia = strClean($_POST['codigoInasistencia']);
        $numeroFicha = strClean($_POST['numeroFicha']);

        $arrPost = ['codigoInasistencia', 'numeroFicha'];

        if (check_post($arrPost)) {
            $requestModel = $this->model->insertarInasistencia($codigoInasistencia, $idUsuario, $numeroFicha);

            if ($requestModel === false) {
                $arrRespuesta = ['status' => false, 'msg' => 'El aprendiz no fue encontrado.'];
            } elseif ($requestModel > 0) {
                $arrRespuesta = ['status' => true, 'msg' => 'Asistencia agregada correctamente.'];
            } else {
                $arrRespuesta = ['status' => false, 'msg' => 'Error al registrar la inasistencia.'];
            }
        } else {
            $arrRespuesta = ['status' => false, 'msg' => 'Debe ingresar todos los datos'];
        }

        echo json_encode($arrRespuesta, JSON_UNESCAPED_UNICODE);
        die();
    }

}
