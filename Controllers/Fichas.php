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
}