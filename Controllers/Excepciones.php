<?php 

class Excepciones extends Controllers{
    
    public function __construct(){
        parent::__construct();
    }

    public function excepciones(){
        
        $data['page_title'] = "excepciones";
        $data['page_id_name'] = "excepciones";
        $data['page_functions_js'] = "excepciones/excepciones.js";
        $this->views->getView($this,"excepciones", $data); 
    }
}