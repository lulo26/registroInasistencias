<?php

class Aprendices extends Controllers{
    public function __construct(){
        parent::__construct();
    }

    public function aprendices(){

        $data['page_title'] = "aprendices";
        $data['page_id_name'] = "aprendices";
        $data['page_functions_js'] = "aprendices/aprendices.js";

        $this->views->getView($this,"aprendices", $data);
    }
}