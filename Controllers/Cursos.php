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

    public function setCursos(){
        $nombreCurso = strClean($_POST['nombreCurso']);
        $tipoCurso = strClean($_POST['tipoCurso']);
        $descripcionCurso = strClean($_POST['descripcionCurso']);
        $idCurso = strClean($_POST['idCurso'])
        
        $arrPost = ['nombreCurso','tipoCurso','descripcionCurso'];
        // falta cambiar esta información !!!!!!!!!!!!!!!!!!!!!!!!!!!
        if (check_post($arrPost)) {
            if ($idCurso == 0 || $idCurso == ""){
                $requestModel = $this->model->insertarCurso($idCliente, $nombreMascota, $razaMascota, $edadMascota, $comentarioMascota);
                $option = 1;
            } else {
                $requestModel = $this->model->editarCruso($idMascotas ,$idCliente ,$nombreMascota, $razaMascota, $edadMascota, $comentarioMascota);
                $option = 2;
            }
           // echo($option);
            if($requestModel > 0) {
                if($option === 1){
                $arrRespuesta = array('status' => true, 'msg' => 'Datos guardados correctamente.');
            }
            }else{
                $arrRespuesta = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                }
        }else{
            $arrRespuesta = array('status' => false, 'msg' => 'Debe ingresar todos los datos');
        }
        echo json_encode($arrRespuesta, JSON_UNESCAPED_UNICODE);
        die();
    }


}