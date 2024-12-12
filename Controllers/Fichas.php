<?php

class Fichas extends Controllers{
    public function __construct(){
        parent::__construct();
    }

    public function fichas(){

        $data['page_title'] = "fichas";
        $data['page_id_name'] = "fichas";
        $data['page_functions_js'] = "fichas/fichas.js";

        $this->views->getView($this,"fichas", $data);
    }

    public function getFichas(){
        $arrData = $this->model->selectFichas();

        for ($i=0; $i < count($arrData); $i++) { 
            $btnEdit = "<button type='button' class='btn btn-primary rounded-pill' data-action-type='update' rel='".$arrData[$i]['idficha']."'>
                    <i class='bi bi-pencil-square'></i>
                </button>";
            $btnDelete = "<button type='button' class='btn btn-danger rounded-pill' data-action-type='delete' rel='".$arrData[$i]['idficha']."'>
                <i class='bi bi-trash-fill'></i>
                </button>";
            $arrData[$i]['options'] =  $btnDelete . " " . " " . $btnEdit;
                
        }

        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    } 

    public function getFichaByID($idficha){

        $intIdFicha = intval(strClean($idficha));

        if($intIdFicha > 0){
    
            $arrData = $this->model->selectFichaID($intIdFicha);
            if(empty($arrData)){
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
            }else{
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function setFichas(){
        $numFicha = intval($_POST['numFicha']);
        $curso = intval($_POST['curso']);
        $fechaIni = strClean($_POST['fechaIni']);
        $fechaFin = strClean($_POST['fechaFin']);
        $modalidad = strClean($_POST['modalidad']);
        $idficha = strClean($_POST['idficha']);

        $arrPost = ['numFicha','curso','fechaIni', 'fechaFin', 'modalidad'];
        if (check_post($arrPost)) {
            if ($idficha == 0 || $idficha == ""){
                $requestModel = $this->model->insertarFicha($numFicha, $curso, $fechaIni, $fechaFin, $modalidad);
                $option = 1;
            } else {
                $requestModel = $this->model->editarFicha($numFicha, $curso, $fechaIni, $fechaFin, $modalidad, $idficha);
                $option = 2;
                
            }
            if($requestModel > 0) {
                if($option === 1){
                $arrRespuesta = array('status' => true, 'msg' => 'ficha agregada correctamente.');
            }
            }elseif ($requestModel === 'exists'){
                $arrRespuesta = array('status' => false, 'msg' => 'Esta ficha ya existe');
            }
            
            else{
                $arrRespuesta = array('status' => true, 'msg' => 'ficha actualizada correctamente.');
                }
        }else{
            $arrRespuesta = array('status' => false, 'msg' => 'Debe ingresar todos los datos');
        }
        echo json_encode($arrRespuesta, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminarFicha(){
        if ($_POST) {
            $idficha = intval($_POST['idficha']);
            $requestDelete = $this->model->eliminarFicha($idficha);
            if($requestDelete == 'empty'){
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar la ficha.');
            }else{
                $arrResponse = array('status' => true, 'msg' => 'se ha eliminado la ficha.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }else{
            print_r($_POST);
        }
        die();
    }
}