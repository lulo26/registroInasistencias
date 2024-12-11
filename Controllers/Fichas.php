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

    

}