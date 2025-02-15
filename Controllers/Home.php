<?php 

class Home extends Controllers{
    public function __construct(){
        parent::__construct();
        session_start();
        if(empty($_SESSION['login'])){
            header('Location: ' . base_url().'/login' );
        }
    }
    public function home(){


        $data['page_title'] = "Página principal";
        $data['page_name'] = "home";
        $data['page_id_name'] = "home";
        $data['page_tag'] = "Pincipal";
        $this->views->getView($this,"home", $data);
    }
}
