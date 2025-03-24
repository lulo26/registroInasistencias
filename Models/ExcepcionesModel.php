<?php

class ExcepcionesModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function selectUsuarioID(int $id)
    {
        $sql = "SELECT idusuario, numdoc_usuario, nombre_usuario, correo_usuario, telefono_usuario, rol_usuario, codigo_usuario 
                FROM usuarios
                WHERE idusuario = {$id} AND estado_usuario = 'Activo'";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectExcepciones()
    {
        $sql = "SELECT idexcepcion, fecha, motivo_excepcion, usuarios.idusuario, usuarios.nombre_usuario, usuarios.rol_usuario, bloques_idbloque, bloques.hora_bloque, horaEntrada_excepcion, CONCAT(fichas.numero_ficha, ' - ', cursos.nombre_curso) AS ficha
                FROM excepciones
                INNER JOIN usuarios ON usuarios.idusuario = excepciones.usuarios_idusuario
                INNER JOIN bloques ON bloques.idbloque = excepciones.bloques_idbloque
                INNER JOIN fichas ON fichas.idficha = excepciones.fichas_idficha
                INNER JOIN cursos ON cursos.idcurso = fichas.cursos_idcurso";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectExcepInstructor(int $id)
    {
        $sql = "SELECT idexcepcion, fecha, motivo_excepcion, usuarios.nombre_usuario, usuarios.rol_usuario, bloques_idbloque, bloques.hora_bloque, horaEntrada_excepcion, CONCAT(fichas.numero_ficha, ' - ', cursos.nombre_curso) AS ficha
                FROM excepciones
                INNER JOIN usuarios ON usuarios.idusuario = excepciones.usuarios_idusuario
                                    OR usuarios.rol_usuario = 'COORDINADOR'
                INNER JOIN bloques ON bloques.idbloque = excepciones.bloques_idbloque
                INNER JOIN fichas ON fichas.idficha = excepciones.fichas_idficha
                INNER JOIN cursos ON cursos.idcurso = fichas.cursos_idcurso
                WHERE idusuario = {$id}";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectExcepID(int $id)
    {
        $sql = "SELECT idexcepcion, fecha, motivo_excepcion, usuarios_idusuario, bloques_idbloque, horaEntrada_excepcion 
                FROM excepciones
                WHERE idexcepcion = {$id}";
        $request = $this->select_all($sql);
        return $request;
    }

    public function insertarExcepcion(string $fecha, string $motivo, int $idUsuario, int $idBloque, int $idFicha)
    {
        $return = "";

        $this->fecha = $fecha;
        $this->motivo = $motivo;
        $this->idUsuario = $idUsuario;
        $this->idBloque = $idBloque;
        $this->idFicha = $idFicha;

        $query = "INSERT INTO excepciones (fecha, motivo_excepcion, usuarios_idusuario, bloques_idbloque, fichas_idficha) 
                  VALUES (?, ?, ?, ?, ?)";

        $arrData = array($this->fecha, $this->motivo, $this->idUsuario, $this->idBloque, $this->idFicha);
        $request_insert = $this->insert($query, $arrData);
        $return = $request_insert;

        return $return;
    }

    public function editarExcepcion(string $fecha, string $motivo, int $idUsuario, int $idBloque, int $idExcepcion)
    {
        $return = "";

        $this->fecha = $fecha;
        $this->motivo = $motivo;
        $this->idUsuario = $idUsuario;
        $this->idBloque = $idBloque;
        $this->id = $idExcepcion;

        $sql = "SELECT idexcepcion FROM excusas WHERE idexcepcion = '{$this->id}'";
        $request = $this->select_all($sql);

        if (!empty($request)) {
            $query = "UPDATE excepciones 
                      SET fecha_excepcion = ?, motivo_excepcion = ?, usuarios_idusuario = ?, bloques_idbloque = ?
                      WHERE idexcepcion = ?";
            $arrData = array($this->fecha, $this->motivo, $this->idUsuario, $this->idBloque, $this->idExcepcion);
            $request_insert = $this->insert($query, $arrData);
            $return = $request_insert;
        } else {
            $return = "empty";
        }
        return $return;
    }

    public function selectFichasUserID(int $id)
    {
        $sql = "SELECT fichas.idficha, fichas.numero_ficha, cursos.nombre_curso
                FROM fichas
		        INNER JOIN cursos ON cursos.idcurso = fichas.cursos_idcurso
                INNER JOIN fichas_has_usuarios ON fichas_has_usuarios.fichas_idficha = fichas.idficha
                INNER JOIN usuarios ON usuarios.idusuario  = fichas_has_usuarios.usuarios_idusuario
		        WHERE idusuario = {$id}";
        $request = $this->select_all($sql);
        return $request;
    }

    /* Si un instructor va a añadir una excepcion, validar que el dia de la excepcion si le toque a la ficha con ese instructor */
    public function selectFichasDate(int $id, string $fecha)
    {
        $sql = "SELECT fichas.idficha, fichas.numero_ficha, cursos.nombre_curso, horarios.fecha_horario
                FROM fichas
		        INNER JOIN cursos ON cursos.idcurso = fichas.cursos_idcurso
                INNER JOIN fichas_has_usuarios ON fichas_has_usuarios.fichas_idficha = fichas.idficha
                INNER JOIN usuarios ON usuarios.idusuario = fichas_has_usuarios.usuarios_idusuario
                INNER JOIN horarios ON horarios.usuarios_idusuario = usuarios.idusuario
		        WHERE usuarios.idusuario = {$id} AND horarios.fecha_horario = '{$fecha}'";
        $request = $this->select_all($sql);
        return $request;
    }

    /* ------------------------ VALIDACIONES -------------------------- */

    public function validarDiaExcep(int $numdoc)
    /* Si un instructor va a añadir una excepcion, validar que el dia de la excepcion si le toque a la ficha con ese instructor */
    {
        $return = "";

        $this->numdoc = $numdoc;

        $sql = "SELECT numdoc_usuario FROM usuarios WHERE numdoc_usuario = '{$this->numdoc}'";
        $request = $this->select($sql);

        if (empty($request)) {
            $return = "numdocValido";
        } else {
            $return = "numdocExiste";
        }

        return $return;
    }
}
