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

    public function selectCursoID(int $id){
        $sql = "SELECT * FROM cursos WHERE idcurso = {$id}";
        $request = $this->select_all($sql);
        return $request;
    }

    public function insertarCurso(string $nombre, string $tipo, string $descripcion){
        $return = "";
        $this->nombre = $nombre;
        $this->tipo = $tipo;
        $this->descripcion = $descripcion;

        $sql = "SELECT * FROM cursos WHERE nombre_curso = '{$this->nombre}'";
        $request = $this->select_all($sql);

        if (empty($request)){
            $query = "INSERT INTO cursos (nombre_curso, tipo_curso, descripcion_curso) VALUES (?,?,?)";
            $arrData = array($this->nombre, $this->tipo, $this->descripcion);
            $request_insert = $this->insert($query, $arrData);
            $return = $request_insert;
        } else {
            $return = 'exists';
        }
        return $return;
    }

    public function editarCurso(string $nombre, string $tipo, string $descripcion, int $id){
        $return = "";

        $this->nombre = $nombre;
        $this->tipo = $tipo;
        $this->descripcion = $descripcion;
        $this->id = $id;

        $sql = "SELECT idcurso FROM cursos WHERE idcurso = '{$this->id}'";
        $request = $this->select_all($sql);

        if(!empty($request)){
            $query = "UPDATE cursos SET nombre_curso = ?, tipo_curso = ?, descripcion_curso = ? WHERE idcurso = ?";
            $arrData = array($this->nombre, $this->tipo, $this->descripcion, $this->id);
            $request_insert = $this->insert($query, $arrData);
            $return = $request_insert;
        } else {
            $return = "empty";
        }
        return $return;
    }

    public function eliminarCurso(int $id){
        $return = "";

        $this->id = $id;

        $sql = "SELECT * FROM cursos WHERE idcurso = '{$this->id}'";
        $request = $this->select_all($sql);
        if(!empty($request)){
            $query = "DELETE FROM cursos WHERE idcurso = ?";
            $arrData = array($this->id);
            $request_insert = $this->insert($query, $arrData);
            $return = $request_insert;
        } else {
            $return = "empty";
        }
        return $return;
    }
}