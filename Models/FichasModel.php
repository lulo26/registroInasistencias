<?php
class FichasModel extends Mysql {
    public function __construct() {
        parent::__construct();
    }
    public function selectFichas()
    {
        $sql = "SELECT idficha, numero_ficha, numero_ficha, cursos.idcurso AS id_curso, fecha_inicio, fecha_fin, modalidad 
                FROM fichas
                INNER JOIN cursos ON cursos.idcurso = fichas.cursos_idcursos
                ORDER BY idficha ASC";
        $request = $this->select_all($sql);
        return $request;
    }
    public function selectFichaID(int $id)
    {
        $sql = "SELECT idficha, numero_ficha, numero_ficha, cursos.idcurso AS id_curso, fecha_inicio, fecha_fin, modalidad 
                FROM fichas
                INNER JOIN cursos ON cursos.idcurso = fichas.cursos_idcursos WHERE idficha = {$id}";
        $request = $this->select_all($sql);
        return $request;
    }
    public function selectCursos()
    {
        $sql = "SELECT idcurso, nombre_curso, tipo_curso, descripcion_curso
                FROM cursos";
        $request = $this->select_all($sql);
        return $request;
    }
    public function insertarFicha(int $numero_ficha, int $cursos_idcurso, date $fecha_inicio, date $fecha_fin, string $modalidad)
    {
        $return = "";
        $this->numficha = $numero_ficha;
        $this->idCurso = $cursos_idcurso;
        $this->fechaInicio = $fecha_inicio;
        $this->fechaFin = $fecha_fin;
        $this->modalidad = $modalidad;

        $sql = "SELECT * FROM fichas WHERE numero_ficha = '{$this->numficha}'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query = "INSERT INTO fichas (numero_ficha, cursos_idcurso, fecha_inicio, fecha_fin, modalidad) VALUES (?,?,?,?,?)";
            $arrData = array($this->numficha, $this->idCurso, $this->fechaInicio, $this->fechaFin, $this->modalidad);
            $request_insert = $this->insert($query, $arrData);
            $return = $request_insert;
        } else {
            $return = 'exists';
        }
        return $return;
    }
    public function editarFicha(int $numero_ficha, int $cursos_idcurso, date $fecha_inicio, date $fecha_fin, string $modalidad, int $idficha)
    {
        $return = "";
        $this->numficha = $numero_ficha;
        $this->idCurso = $cursos_idcurso;
        $this->fechaInicio = $fecha_inicio;
        $this->fechaFin = $fecha_fin;
        $this->modalidad = $modalidad;
        $this->id = $idficha;

        $sql = "SELECT idficha FROM fichas WHERE idficha = '{$this->id}'";
        $request = $this->select_all($sql);
        if (!empty($request)) {
            $query = "UPDATE fichas SET numero_ficha = ?, cursos_idcurso = ?, fecha_inicio = ?, fecha_fin = ?, modalidad = ? WHERE idficha = ?";
            $arrData = array($this->numficha, $this->idCurso, $this->fechaInicio, $this->fechaFin, $this->modalidad, $this->id);
            $request_insert = $this->insert($query, $arrData);
            $return = $request_insert;
        } else {
            $return = "empty";
        }
        return $return;
    }

    public function eliminarFicha(int $id)
    {
        $return = "";
        $this->id = $id;
        $sql = "SELECT * FROM fichas WHERE idficha = '{$this->id}'";
        $request = $this->select_all($sql);
        if (!empty($request)) {
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
?>
