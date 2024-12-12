<?php

class FichasModel extends Mysql{
    public function __construct(){
        parent::__construct();
    }

    public function selectFichas(){
        $sql = "SELECT idficha, numero_ficha, cursos_idcurso, fecha_inicio, fecha_fin, modalidad, nombre_curso FROM fichas INNER JOIN cursos ON idcurso = cursos_idcurso";
        $request = $this->select_all($sql);
        return $request;
    } 

    public function selectFichaID(int $id){
        $sql = "SELECT idficha, numero_ficha, cursos_idcurso, fecha_inicio, fecha_fin, modalidad, nombre_curso FROM fichas INNER JOIN cursos ON idcurso = cursos_idcurso WHERE idficha = {$id}";
        $request = $this->select_all($sql);
        return $request;
    }

    public function insertarFicha(int $ficha, int $idCurso, string $fechaIni, string $fechaFin, string $modalidad){

        $this->ficha = $ficha;
        $this->idCurso = $idCurso;
        $this->fechaIni = $fechaIni;
        $this->fechaFin = $fechaFin;
        $this->modalidad = $modalidad;

        $sql = "INSERT INTO fichas (numero_ficha, cursos_idcurso, fecha_inicio, fecha_fin, modalidad) VALUES (?,?,?,?,?)";
        $arrData = array($this->ficha, $this->idCurso, $this->fechaIni, $this->fechaFin, $this->modalidad);
        return $this->insert($sql, $arrData);
    }

    public function editarFicha(int $ficha, int $idCurso, string $fechaIni, string $fechaFin, string $modalidad, int $id){
        $return = "";

        $this->ficha = $ficha;
        $this->idCurso = $idCurso;
        $this->fechaIni = $fechaIni;
        $this->fechaFin = $fechaFin;
        $this->modalidad = $modalidad;
        $this->id = $id;

        $sql = "SELECT idficha FROM fichas WHERE idficha = '{$this->id}'";
        $request = $this->select_all($sql);

        if(!empty($request)){
            $query = "UPDATE fichas SET numero_ficha = ?, cursos_idcurso = ?, fecha_inicio = ?, fecha_fin = ?, modalidad = ?  WHERE idficha = ?";
            $arrData = array($this->ficha, $this->idCurso, $this->fechaIni, $this->fechaFin, $this->modalidad, $this->id);
            $request_insert = $this->insert($query, $arrData);
            $return = $request_insert;
        } else {
            $return = "empty";
        }
        return $return;
    }

    public function eliminarFicha(int $id){
        $return = "";

        $this->id = $id;

        $sql = "SELECT * FROM fichas WHERE idficha = '{$this->id}'";
        $request = $this->select_all($sql);
        if(!empty($request)){
            $query = "DELETE FROM fichas WHERE idficha = ?";
            $arrData = array($this->id);
            $request_insert = $this->insert($query, $arrData);
            $return = $request_insert;
        } else {
            $return = "empty";
        }
        return $return;
    }
}