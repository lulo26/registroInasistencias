<?php

class Cursos extends Controllers{
    public function __construct(){
        parent::__construct();
    }

    public function cursos(){

        $data['page_title'] = "cursos";
        $data['page_id_name'] = "cursos";
        $data['page_functions_js'] = "cursos/cursos.js";

        $this->views->getView($this,"cursos", $data);
    }
}