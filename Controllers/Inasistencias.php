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

        $idUsuario = 4;
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
    /*

public function updateAprendices()
{
$idAprendiz = strClean($_POST['idaprendiz']);
$numeroDocumentoAprendiz = strClean($_POST['numeroDocumentoAprendiz']);
$nombreAprendiz = strClean($_POST['nombreAprendiz']);
$apellidoAprendiz = strClean($_POST['apellidoAprendiz']);
$codigoAprendiz = strClean($_POST['codigoAprendiz']);
$generoAprendiz = $_POST['generoAprendiz'];

$arrPost = ['idaprendiz', 'numeroDocumentoAprendiz', 'nombreAprendiz', 'apellidoAprendiz', 'generoAprendiz', 'codigoAprendiz'];
if (check_post($arrPost)) {
   $requestModel = $this->model->editarAprendices($idAprendiz, $nombreAprendiz, $apellidoAprendiz, $generoAprendiz, $numeroDocumentoAprendiz, $codigoAprendiz);

   $option = 2;

   if ($requestModel > 0) {
       if ($option === 1) {
           $arrRespuesta = array('status' => true, 'msg' => 'Aprendiz agregado correctamente.');
       }
   } elseif ($requestModel === 'exists') {
       $arrRespuesta = array('status' => false, 'msg' => 'Este aprendiz ya existe');
   } else {
       $arrRespuesta = array('status' => true, 'msg' => 'Aprendiz actualizado correctamente.');
   }
} else {
   $arrRespuesta = array('status' => false, 'msg' => 'Debe ingresar todos los datos');
}
echo json_encode($arrRespuesta, JSON_UNESCAPED_UNICODE);
die();
}/*


public function getAprendiz($idAprendiz)
{

$intIdAprendiz = intval(strClean($id));

if ($intIdAprendiz > 0) {

   $arrData = $this->model->selectMascotaID($idAprendiz);
   if (empty($arrData)) {
       $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
   } else {
       $arrResponse = array('status' => true, 'data' => $arrData);
   }
}

echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
die();
}

public function getAprendizByID($idAprendiz)
{

$intIdAprendiz = intval(strClean($idAprendiz));

if ($intIdAprendiz > 0) {

   $arrData = $this->model->getAprendizPorId($intIdAprendiz);
   if (empty($arrData)) {
       $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
   } else {
       $arrResponse = array('status' => true, 'data' => $arrData);
   }
}

echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
die();
}


public function eliminarAprendiz()
{
if ($_POST) {
   $idAprendiz = intval($_POST['idAprendiz']);
   $requestDelete = $this->model->eliminarAprendiz($idAprendiz);
   if ($requestDelete == 'empty') {
       $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Aprendiz.');
   } else {
       $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el aprendiz.');
   }
   echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
} else {
   print_r($_POST);
}
die();
} */
}
