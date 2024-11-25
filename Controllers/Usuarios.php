<?php

class Usuarios extends Controllers{
    public function __construct(){
        parent::__construct();
    }

    public function usuarios(){

        $data['page_title'] = "usuarios";
        $data['page_id_name'] = "usuarios";
        $data['page_functions_js'] = "usuarios/usuarios.js";

        $this->views->getView($this,"usuarios", $data);
    }
}