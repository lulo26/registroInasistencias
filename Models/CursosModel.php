<?php

class CursosModel extends Mysql{
    public function __construct(){
        parent::__construct();
    }

    public function selectCursos(){
        $sql = "SELECT * FROM cursos";
        $request = $this->select_all($sql);
        return $request;
    }
}