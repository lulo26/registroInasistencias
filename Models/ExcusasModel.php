<?php

class ExcusasModel extends Mysql
{
    /* -------------------------------------------------- */

    public function __construct()
    {
        parent::__construct();
    }

    public function saveFilePathToDatabase(string $fileName, string $filePath)
    {
        $return = "";

        $this->fileName = $fileName;
        $this->filePath = $filePath;



        /* $sql = "SELECT * FROM usuarios WHERE nombre_usuario = '{$this->nombre}'";
        $request = $this->select_all($sql); */

        /* if (empty($request)) { */
        $query = "INSERT INTO excusas (filename_excusa, filepath_excusa, aprendices_idusuario, registro_inasistencias_idregistro, estado_excusa) 
                  VALUES (?, ?, 1, 1, 'Por revisar')";
        $arrData = array($this->fileName, $this->filePath);
        $request_insert = $this->insert($query, $arrData);
        $return = $request_insert;
        /* } else { 
        $return = 'exists';
        } */
        return $return;
    }

    /* ACTUALIZAR ESTADO DE LA TABLA INASISTENCIA: DE Sin excusa a Con excusa */
    public function updateEstadoInasistencia()
    {
        $query = "UPDATE registro_inasistencias SET estado_inasistencia = 'Con excusa' WHERE idregistro = ?";
    }

    public function getFilePath(int $id)
    {
        $sql = "SELECT filepath_excusa FROM excusas WHERE idexcusa = {$id}";
        $request = $this->select_all($sql);

        return $request;
    }

    /* public function insertarExcusa(string $numdoc_usuario, string $nombre_usuario, string $password_usuario, string $correo_usuario, string $telefono_usuario, int $roles_idrol, string $codigo_usuario)
    {
        $return = "";

        $this->numdoc = $numdoc_usuario;
        $this->nombre = $nombre_usuario;
        $this->password = $password_usuario;
        $this->correo = $correo_usuario;
        $this->telefono = $telefono_usuario;
        $this->idRol = $roles_idrol;
        $this->codigo = $codigo_usuario;

        $sql = "SELECT * FROM usuarios WHERE nombre_usuario = '{$this->nombre}'";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $query = "INSERT INTO usuarios (numdoc_usuario, nombre_usuario, password_usuario, correo_usuario, telefono_usuario, roles_idrol, codigo_usuario) VALUES (?,?,?,?,?,?,?)";
            $arrData = array($this->numdoc, $this->nombre, $this->password, $this->correo, $this->telefono, $this->idRol, $this->codigo);
            $request_insert = $this->insert($query, $arrData);
            $return = $request_insert;
        } else {
            $return = 'exists';
        }
        return $return;
    } */

    /* -------------------------------------------------- */
    /* -------------------------------------------------- */
    /* -------------------------------------------------- */

    public function selectInasistencias()
    {
        /* $sql = "SELECT idregistro, aprendices_idusuario, fecha_inasistencia, registro_idusuario, estado_inasistencia
                FROM registro_inasistencias"; */
        $sql = "SELECT idregistro, nombre_usuario, fecha_inasistencia, nombre_aprendiz, estado_excusa, estado_inasistencia
                FROM registro_inasistencias
                JOIN usuarios ON usuarios.idusuario = registro_inasistencias.registro_idusuario
                JOIN aprendices ON aprendices.idaprendiz = registro_inasistencias.aprendices_idusuario 
                JOIN excusas ON excusas.registro_inasistencias_idregistro = registro_inasistencias.idregistro";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectInasAprendizID()
    {
        /* $sql = "SELECT idregistro, aprendices_idusuario, fecha_inasistencia, registro_idusuario, estado_inasistencia
                FROM registro_inasistencias"; */
        /*  $sql = "SELECT idregistro, nombre_usuario, fecha_inasistencia, nombre_aprendiz, estado_excusa, estado_inasistencia
                FROM registro_inasistencias
                JOIN usuarios ON usuarios.idusuario = registro_inasistencias.registro_idusuario
                JOIN aprendices ON aprendices.idaprendiz = registro_inasistencias.aprendices_idusuario 
                JOIN excusas ON excusas.registro_inasistencias_idregistro = registro_inasistencias.idregistro";
        $request = $this->select_all($sql);
        return $request; */
    }

    public function selectInasInstructorID()
    {
        /* $sql = "SELECT idregistro, aprendices_idusuario, fecha_inasistencia, registro_idusuario, estado_inasistencia
                FROM registro_inasistencias"; */
        /* $sql = "SELECT idregistro, nombre_usuario, fecha_inasistencia, nombre_aprendiz, estado_excusa, estado_inasistencia
                FROM registro_inasistencias
                JOIN usuarios ON usuarios.idusuario = registro_inasistencias.registro_idusuario
                JOIN aprendices ON aprendices.idaprendiz = registro_inasistencias.aprendices_idusuario 
                JOIN excusas ON excusas.registro_inasistencias_idregistro = registro_inasistencias.idregistro";
        $request = $this->select_all($sql);
        return $request; */
    }

    /* -------------------------------------------------- */
    /* -------------------------------------------------- */
    /* -------------------------------------------------- */


    public function selectExcusas()
    {
        $sql = "SELECT idusuario, numdoc_usuario, nombre_usuario, correo_usuario, telefono_usuario, roles.nombre_rol AS nombre_rol, codigo_usuario 
                FROM usuarios
                INNER JOIN roles ON roles.idrol = usuarios.roles_idrol
                ORDER BY idusuario ASC";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectExcusaID(int $id)
    {
        $sql = "SELECT idusuario, numdoc_usuario, nombre_usuario, correo_usuario, telefono_usuario, roles.nombre_rol AS nombre_rol, roles.idrol, codigo_usuario 
                FROM usuarios
                INNER JOIN roles ON roles.idrol = usuarios.roles_idrol WHERE idusuario = {$id}";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectExcusasInstructor(int $id)
    {
        $sql = "SELECT idexcusa, fecha_excusa, nombre_aprendiz, nombre_curso, numero_ficha, fecha_inasistencia, estado_excusa, filepath_excusa 
                FROM excusas 
                JOIN registro_inasistencias ON registro_inasistencias.idregistro = excusas.registro_inasistencias_idregistro 
                JOIN usuarios ON usuarios.idusuario = registro_inasistencias.registro_idusuario 
                JOIN aprendices ON aprendices.idaprendiz = registro_inasistencias.aprendices_idusuario
                JOIN horarios ON horarios.usuarios_idusuario = usuarios.idusuario
                JOIN fichas ON fichas.idficha =    fichas_idficha
                JOIN cursos ON cursos.idcurso = fichas.cursos_idcurso
                WHERE excusas.estado_excusa = 'Por revisar' AND usuarios.idusuario = {$id}
                ORDER BY registro_inasistencias.fecha_inasistencia ASC";
        $request = $this->select_all($sql);
        return $request;
    }

    public function editarExcusa(string $numdoc_usuario, string $nombre_usuario, string $password_usuario, string $correo_usuario, string $telefono_usuario, int $roles_idrol, string $codigo_usuario, int $idusuario)
    {
        $return = "";

        $this->numdoc = $numdoc_usuario;
        $this->nombre = $nombre_usuario;
        $this->password = $password_usuario;
        $this->correo = $correo_usuario;
        $this->telefono = $telefono_usuario;
        $this->idRol = $roles_idrol;
        $this->codigo = $codigo_usuario;
        $this->id = $idusuario;

        $sql = "SELECT idusuario FROM usuarios WHERE idusuario = '{$this->id}'";
        $request = $this->select_all($sql);

        if (!empty($request)) {
            $query = "UPDATE usuarios SET numdoc_usuario = ?, nombre_usuario = ?, password_usuario = ?, correo_usuario = ?, telefono_usuario = ?, roles_idrol = ?, codigo_usuario = ? WHERE idusuario = ?";
            $arrData = array($this->numdoc, $this->nombre, $this->password, $this->correo, $this->telefono, $this->idRol, $this->codigo, $this->id);
            $request_insert = $this->insert($query, $arrData);
            $return = $request_insert;
        } else {
            $return = "empty";
        }
        return $return;
    }

    public function eliminarExcusa(int $id)
    {
        $return = "";

        $this->id = $id;

        $sql = "SELECT * FROM usuarios WHERE idusuario = '{$this->id}'";
        $request = $this->select_all($sql);
        if (!empty($request)) {
            $query = "DELETE FROM usuarios WHERE idusuario = ?";
            $arrData = array($this->id);
            $request_insert = $this->insert($query, $arrData);
            $return = $request_insert;
        } else {
            $return = "empty";
        }
        return $return;
    }

    public function aprobarExcusa(int $idexcusa)
    {
        $return = "";

        $this->id = $idexcusa;

        $sql = "SELECT idexcusa FROM excusas WHERE idexcusa = '{$this->id}'";
        $request = $this->select_all($sql);

        if (!empty($request)) {
            $query = "UPDATE excusas SET estado_excusa = 'Aprobada' WHERE idexcusa = ?";
            $arrData = array($this->id);
            $request_insert = $this->insert($query, $arrData);
            /* $return = $request_insert; */
            $return = "Aprobada";
        } else {
            $return = "empty";
        }
        return $return;
    }

    public function rechazarExcusa(int $idexcusa)
    {
        $return = "";

        $this->id = $idexcusa;

        $sql = "SELECT idexcusa FROM excusas WHERE idexcusa = '{$this->id}'";
        $request = $this->select_all($sql);

        if (!empty($request)) {
            $query = "UPDATE excusas SET estado_excusa = 'Rechazada' WHERE idexcusa = ?";
            $arrData = array($this->id);
            $request_insert = $this->insert($query, $arrData);
            /* $return = $request_insert; */
            $return = "Rechazada";
        } else {
            $return = "empty";
        }
        return $return;
    }

    /* ------------------------ VALIDACIONES -------------------------- */

    public function validarIdentificacion(int $numdoc)
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
