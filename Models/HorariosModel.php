<?php 

class HorariosModel extends Mysql{
    public function __construct(){
        parent::__construct();
    }

    public function selectHorarios(int $ficha, string $fecha, string $horaInicio){
        $this->intFicha = $ficha;
        $this->strFecha = $fecha;
        $this->strHoraInicio = $horaInicio;
        $sql = "SELECT * FROM horarios WHERE fecha_horario = '{$this->strFecha}' AND fecha_inicio = '{$this->strHoraInicio}' AND ficha = {$this->intFicha}";
        $request = $this->select_all($sql);
        return $request;
    } 

    public function selectHorarioID(int $id){
        $sql = "SELECT idhorario, fichas_idficha, usuarios_idusuario, fecha_horario, fecha_inicio, fecha_fin FROM horarios INNER JOIN usuarios ON idusuario = usuarios_idusuario WHERE idhorario = {$id}";
        $request = $this->select_all($sql);
        return $request;
    }

    public function insertarHorario(int $ficha, int $usuario, string $fechaIni, string $fechaFin, string $fecha){

        $this->ficha = $ficha;
        $this->usuario = $usuario;
        $this->fechaIni = $fechaIni;
        $this->fechaFin = $fechaFin;
        $this->fecha = $fecha;

        $sql = "INSERT INTO horarios (fichas_idficha, usuarios_idusuario, fecha_inicio, fecha_fin, fecha_horario) VALUES (?,?,?,?,?)";
        $arrData = array($this->ficha, $this->usuario, $this->fechaIni, $this->fechaFin, $this->fecha);
        return $this->insert($sql, $arrData);
    }

    public function editarHorario(int $ficha, int $usuario, string $fechaIni, string $fechaFin, string $fecha, int $id){
        $return = "";

        $this->ficha = $ficha;
        $this->usuario = $usuario;
        $this->fechaIni = $fechaIni;
        $this->fechaFin = $fechaFin;
        $this->fecha = $fecha;
        $this->id = $id;

        $sql = "SELECT idhorario FROM horarios WHERE idhorario = '{$this->id}'";
        $request = $this->select_all($sql);

        if(!empty($request)){
            $query = "UPDATE horarios SET fichas_idficha = ?, usuarios_idusuario = ?, fecha_inicio = ?, fecha_fin = ?, fecha_horario = ?  WHERE idhorario = ?";
            $arrData = array($this->ficha, $this->usuario, $this->fechaIni, $this->fechaFin, $this->fecha, $this->id);
            $request_insert = $this->insert($query, $arrData);
            $return = $request_insert;
        } else {
            $return = "empty";
        }
        return $return;
    }

    public function eliminarHorario(int $id){
        $return = "";

        $this->id = $id;

        $sql = "SELECT * FROM horarios WHERE idhorario = '{$this->id}'";
        $request = $this->select_all($sql);
        if(!empty($request)){
            $query = "DELETE FROM horarios WHERE idhorario = ?";
            $arrData = array($this->id);
            $request_insert = $this->insert($query, $arrData);
            $return = $request_insert;
        } else {
            $return = "empty";
        }
        return $return;
    }

    public function selectFicha(int $ficha){
        $this->intFicha = $ficha;

        $sql = "SELECT * FROM fichas WHERE numero_ficha = {$this->intFicha}";
        $request = $this->select($sql);
        return $request;
    }

    public function selectInstructorByName($nombreInstructor){
        $this->nombreInstructor = $nombreInstructor;
        $this->arrNombreCompleto = explode(' ', $this->nombreInstructor);
        $this->nombre = $this->arrNombreCompleto[0];
        $this->lastElement = count($this->arrNombreCompleto)-1;
        $this->apellido = $this->arrNombreCompleto[$this->lastElement];

        $sql = "SELECT idusuario FROM usuarios WHERE nombre_usuario like '{$this->nombre}%' AND apellido_usuario like '%{$this->apellido}' AND roles_idrol = 2;";
        $request = $this->select($sql);
        return $request;
    }
}