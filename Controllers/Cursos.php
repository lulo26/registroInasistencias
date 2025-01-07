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


}