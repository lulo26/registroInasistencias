<?php 

class Horarios extends Controllers{
    public function __construct(){
        parent::__construct();
        session_start();
        if(empty($_SESSION['login'])){
            header('Location: ' . base_url().'/login' );
        }
    }
    public function horarios(){


        $data['page_title'] = "Horarios";
        $data['page_name'] = "horarios";
        $data['page_id_name'] = "horarios";
        $data['page_functions_js'] = "horarios/horarios.js";
        $this->views->getView($this,"Horarios", $data);
    }
}
