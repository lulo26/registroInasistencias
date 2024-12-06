<?php

class Usuarios extends Controllers{
    public function __construct(){
        parent::__construct();
    }

    public function usuarios(){

        $data['page_title'] = "Usuarios";
        $data['page_id_name'] = "usuarios";
        $data['page_functions_js'] = "usuarios/usuarios.js";

        $this->views->getView($this,"usuarios", $data);
    }

    public function getUsuarios(){
        $arrData = $this->model->selectUsuarios();

        for ($i=0; $i < count($arrData); $i++) { 
            $btnEdit = "<button type='button' class='btn btn-primary rounded-pill' data-action-type='update' rel='".$arrData[$i]['idusuario']."'>
                            <i class='bi bi-pencil-square'></i>
                        </button>";
            $btnDelete = "<button type='button' class='btn btn-danger rounded-pill' data-action-type='delete' rel='".$arrData[$i]['idusuario']."'>
                            <i class='bi bi-trash-fill'></i>
                          </button>";
            $arrData[$i]['options'] =  $btnDelete . " " . " " . $btnEdit;
        }

        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    } 

    public function setUsuarios(){
        
    } 
}