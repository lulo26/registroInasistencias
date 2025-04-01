<?php

class Home extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
<<<<<<< HEAD
        if(empty($_SESSION['login'])){
            header('Location: ' . base_url().'/login' );
=======
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
>>>>>>> 74c1f7b4aed38f7b588465482cfe895b5712c5f3
        }
    }
    public function home()
    {


        $data['page_title'] = "Página principal";
        $data['page_name'] = "home";
        $data['page_id_name'] = "home";
        $data['page_tag'] = "Pincipal";
        $this->views->getView($this, "home", $data);
    }
}
