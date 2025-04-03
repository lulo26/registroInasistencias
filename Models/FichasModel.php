<?php

class FichasModel extends Mysql{
    public function __construct(){
        parent::__construct();
    }

    public function selectFichas()
    {
        $sql = "SELECT idficha, numero_ficha, numero_ficha, cursos.nombre_curso AS id_curso, fecha_inicio, fecha_fin, modalidad FROM fichas INNER JOIN cursos ON cursos.idcurso = fichas.cursos_idcurso ORDER BY idficha ASC";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectFichaID(int $id)
    {
        $sql = "SELECT idficha, numero_ficha, numero_ficha, cursos.idcurso AS id_curso, fecha_inicio, fecha_fin, modalidad FROM fichas INNER JOIN cursos ON cursos.idcurso = fichas.cursos_idcurso WHERE idficha = {$id}";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectCursos()
    {
        $sql = "SELECT idcurso, nombre_curso, tipo_curso, descripcion_curso FROM cursos";
        $request = $this->select_all($sql);
        return $request;
    }

    public function insertarFicha(int $numero_ficha, int $cursos_idcurso, string $fecha_inicio, string $fecha_fin, string $modalidad) {
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

    public function editarFicha(int $numero_ficha, int $cursos_idcurso, string $fecha_inicio, string $fecha_fin, string $modalidad, int $idficha)
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
        $arrData = array(
            $this->numficha, 
            $this->idCurso, 
            $this->fechaInicio, 
            $this->fechaFin, 
            $this->modalidad, 
            $this->id
        );
        $request_update = $this->update($query, $arrData);
        $return = $request_update;
    } else {
        $return = "empty";
    }
    return $return;
}

    public function validarNumeroFicha(int $numficha)
    {
        $return = "";
        $this->numficha = $numficha;
        $sql = "SELECT numero_ficha FROM fichas WHERE numero_ficha = '{$this->numficha}'";
        $request = $this->select($sql);
        if (empty($request)) {
            $return = "numfichaValido";
        } else {
            $return = "numfichaExiste";
        }
        return $return;
    }
    // ASIGNACION DE USUARIOS
    public function getUsuariosPorRol(string $rol) {
        $sql = "SELECT idusuario, nombre_usuario, numdoc_usuarios 
                FROM usuarios 
                WHERE roles_usuarios = '{$rol}' 
                ORDER BY nombre_usuario ASC";
        return $this->select_all($sql);
    }
    
    public function getUsuariosAsignados(int $idficha) {
        $sql = "SELECT usuarios_idusuario FROM fichas_has_usuarios 
                WHERE fichas_idficha = {$idficha}";
        return $this->select_all($sql);
    }
    
    public function asignarUsuarioFicha(int $idficha, int $idusuario) {
        $query = "INSERT INTO fichas_has_usuarios (fichas_idficha, usuarios_idusuario) VALUES (?,?)";
        $arrData = array($idficha, $idusuario);
        return $this->insert($query, $arrData);
    }
    
    public function eliminarAsignacionFicha(int $idficha, int $idusuario) {
        $query = "DELETE FROM fichas_has_usuarios 
                  WHERE fichas_idficha = ? AND usuarios_idusuario = ?";
        $arrData = array($idficha, $idusuario);
        return $this->delete($query, $arrData);
    }
    
    public function verificarAprendizEnFicha(int $idusuario) {
        $sql = "SELECT COUNT(*) as total FROM fichas_has_usuarios fhu
                INNER JOIN usuarios u ON fhu.usuarios_idusuario = u.idusuario
                WHERE u.idusuario = {$idusuario} AND u.roles_usuarios = 'aprendiz'";
        $result = $this->select($sql);
        return $result['total'] > 0;
    }
}
?>
