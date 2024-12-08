<?php

class Cursos extends Controllers{
    public function __construct(){
        parent::__construct();
    }

    public function cursos(){

        $data['page_title'] = "Cursos";
        $data['page_id_name'] = "cursos";
        $data['page_functions_js'] = "cursos/cursos.js";

        $this->views->getView($this,"cursos", $data);
    }

    public function getCursos(){
        $arrData = $this->model->selectCursos();

        for ($i=0; $i < count($arrData); $i++) { 
            $btnEdit = "<button type='button' class='btn btn-primary rounded-pill' data-action-type='update' rel='".$arrData[$i]['idcurso']."'>
                    <i class='bi bi-pencil-square'></i>
                </button>";
            $btnDelete = "<button type='button' class='btn btn-danger rounded-pill' data-action-type='delete' rel='".$arrData[$i]['idcurso']."'>
                <i class='bi bi-trash-fill'></i>
                </button>";
            $arrData[$i]['options'] =  $btnDelete . " " . " " . $btnEdit;
                
        }

        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    } 

    public function getCursoByID($idcurso){

        $intIdCurso = intval(strClean($idcurso));

        if($intIdCurso > 0){
    
            $arrData = $this->model->selectCursoID($intIdCurso);
            if(empty($arrData)){
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
            }else{
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function setCursos(){
        $nombreCurso = strClean($_POST['nombreCurso']);
        $tipoCurso = strClean($_POST['tipoCurso']);
        $descripcionCurso = strClean($_POST['descripcionCurso']);
        $idcurso = strClean($_POST['idcurso']);
        
        $arrPost = ['nombreCurso','tipoCurso','descripcionCurso'];
        if (check_post($arrPost)) {
            if ($idcurso == 0 || $idcurso == ""){
                $requestModel = $this->model->insertarCurso($nombreCurso, $tipoCurso, $descripcionCurso);
                $option = 1;
            } else {
                $requestModel = $this->model->editarCurso($nombreCurso, $tipoCurso, $descripcionCurso, $idcurso);
                $option = 2;
                
            }
            if($requestModel > 0) {
                if($option === 1){
                $arrRespuesta = array('status' => true, 'msg' => 'curso agregado correctamente.');
            }
            }elseif ($requestModel === 'exists'){
                $arrRespuesta = array('status' => false, 'msg' => 'Este curso ya existe');
            }
            
            else{
                $arrRespuesta = array('status' => true, 'msg' => 'curso actualizado correctamente.');
                }
        }else{
            $arrRespuesta = array('status' => false, 'msg' => 'Debe ingresar todos los datos');
        }
        echo json_encode($arrRespuesta, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminarCurso(){
        if ($_POST) {
            $idcurso = intval($_POST['idcurso']);
            $requestDelete = $this->model->eliminarCurso($idcurso);
            if($requestDelete == 'empty'){
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el curso.');
            }else{
                $arrResponse = array('status' => true, 'msg' => 'se ha eliminado el curso.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }else{
            print_r($_POST);
        }
        die();
    }
}