<?php
class FichasModel extends Mysql {
    public function __construct() {
        parent::__construct();
    }
    public function selectFichas()
    {
        $sql = "SELECT idficha, numero_ficha, numero_ficha, cursos.nombre_curso AS id_curso, fecha_inicio, fecha_fin, modalidad  FROM fichas INNER JOIN cursos ON cursos.idcurso = fichas.cursos_idcurso ORDER BY idficha ASC";
        $request = $this->select_all($sql);
        return $request;
    }
    public function selectFichaID(int $id)
    {
        $sql = "SELECT idficha, numero_ficha, numero_ficha, cursos.idcurso AS id_curso, fecha_inicio, fecha_fin, modalidad  FROM fichas INNER JOIN cursos ON cursos.idcurso = fichas.cursos_idcurso WHERE idficha = {$id}";
        $request = $this->select_all($sql);
        return $request;
    }
    public function selectCursos()
    {
        $sql = "SELECT idcurso, nombre_curso, tipo_curso, descripcion_curso FROM cursos";
        $request = $this->select_all($sql);
        return $request;
    }
    public function insertarFicha(int $numero_ficha, int $cursos_idcurso, date $fecha_inicio, date $fecha_fin, string $modalidad, array $usuarios = []) {
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

            // Si se insertó la ficha, asociamos los usuarios
            if ($request_insert > 0 && !empty($usuarios)) {
                $idficha = $request_insert;
                foreach ($usuarios as $usuario_id) {
                    $query_relacion = "INSERT INTO fichas_has_usuarios (fichas_idficha, usuarios_idusuario) VALUES (?, ?)";
                    $arrData_relacion = array($idficha, $usuario_id);
                    $this->insert($query_relacion, $arrData_relacion);
                }
            }

            $return = $request_insert;
        } else {
            $return = 'exists';
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
    public function selectUsuariosByFicha(int $idficha) {
        $sql = "SELECT usuarios_idusuario FROM fichas_has_usuarios WHERE fichas_idficha = {$idficha}";
        $request = $this->select_all($sql);
        return $request;
    }

    // Método para obtener todos los usuarios disponibles
    public function selectUsuarios() {
        $sql = "SELECT idusuario, nombre_usuario FROM usuarios";
        $request = $this->select_all($sql);
        return $request;
    }

}
?>
