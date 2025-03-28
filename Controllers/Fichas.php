<?php
class Fichas extends Controllers{
    public function __construct(){
        parent::__construct();
    }

    public function fichas()
    {
        $data['page_title'] = "Fichas";
        $data['page_name'] = "fichas";
        $data['page_id_name'] = "fichas";
        $data['page_functions_js'] = "fichas/fichas.js";
        $this->views->getView($this,"fichas",$data);
    }

    public function getFichas()
    {
        $arrData = $this->model->selectFichas();
        for ($i = 0; $i < count($arrData); $i++) {
            $btnEdit = "<button type='button' class='btn btn-primary rounded-pill' data-action-type='update' rel='" . $arrData[$i]['idficha']."'><i class='bi bi-pencil-square'></i></button>";
            $btnDelete = "<button type='button' class='btn btn-danger rounded-pill' data-action-type='delete' rel='" . $arrData[$i]['idficha']."'><i class='bi bi-trash-fill'></i></button>";
            $arrData[$i]['options'] =  $btnDelete . " " . " " . $btnEdit;
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getCursos()
    {
        $arrData = $this->model->selectCursos();
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getFichaByID($idficha)
    {
        $intIdFicha = intval(strClean($idficha));
        if ($intIdFicha > 0) {
            $arrData=$this->model->selectFichaID($intIdFicha);
            if (empty($arrData)) {
                $arrResponse=array('status'=>false,'msg'=>'informacion no encontrada');
            } else {
                $arrResponse=array('status'=>true,'data'=>$arrData);
            }
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminarFicha()
    {
        if ($_POST) {
            $idficha = intval($_POST['idficha']);
            $requestDelete = $this->model->eliminarFicha($idficha);
            if ($requestDelete == 'empty') {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar la ficha.');
            } else {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la ficha.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            print_r($_POST);
        }
        die();
    }

    public function setFichas() {
        $numero_ficha = strClean($_POST['numero_ficha']);
        $cursos_idcurso = strClean($_POST['cursos_idcurso']);
        $fecha_inicio = strClean($_POST['fecha_inicio']);
        $fecha_fin = strClean($_POST['fecha_fin']);
        $modalidad = strClean($_POST['modalidad']);
        $idficha = strClean($_POST['idficha']);

        $arrPost = ['numero_ficha', 'cursos_idcurso', 'fecha_inicio', 'fecha_fin', 'modalidad'];
        if (check_post($arrPost)) {
            if ($idficha == 0 || $idficha == "") {
                $validarFicha = $this->model->validarNumeroFicha($numero_ficha);
                if ($validarFicha == "numfichaExiste") {
                    $arrRespuesta = array('status' => false, 'msg' => 'La ficha ya está registrada.');
                } else {
                    $requestModel = $this->model->insertarFicha($numero_ficha, $cursos_idcurso, $fecha_inicio, $fecha_fin, $modalidad);
                    if ($requestModel > 0) {
                        $arrRespuesta = array('status' => true, 'msg' => '¡Ficha agregada correctamente!.');
                    }
                }
            } else {
                $requestModel = $this->model->editarFicha($numero_ficha, $cursos_idcurso, $fecha_inicio, $fecha_fin, $modalidad, $idficha);
                $arrRespuesta = array('status' => true, 'msg' => 'Ficha actualizada correctamente.');
            }
        } else {
            $arrRespuesta = array('status' => false, 'msg' => 'Debe ingresar todos los datos.');
        }
        echo json_encode($arrRespuesta, JSON_UNESCAPED_UNICODE);
        die();
    }
}
?>