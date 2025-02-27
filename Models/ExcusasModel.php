<?php

class ExcusasModel extends Mysql
{
    /* private $numdoc;
    private $nombre;
    private $password;
    private $correo;
    private $telefono;
    private $idRol;
    private $codigo;
    private $idusuario;
    private $id;
    private $fileName;
    private $filePath;
 */
    public function __construct()
    {
        parent::__construct();
    }

    public function insertarExcusa(string $fileName, string $filePath, int $idAprendiz, int $idInasistencia)
    {
        $return = "";

        $this->fileName = $fileName;
        $this->filePath = $filePath;
        $this->idAprendiz = $idAprendiz;
        $this->idInasistencia = $idInasistencia;

        /* $sql = "SELECT * FROM excusas WHERE nombre_usuario = '{$this->nombre}'";
        $request = $this->select_all($sql); */

        /* if (empty($request)) { */
        /* $query = "INSERT INTO excusas (filename_excusa, filepath_excusa, aprendices_idusuario, registro_inasistencias_idregistro, estado_excusa) 
        VALUES (?, ?, ?, ?, 'Por revisar')"; */
        $query = "INSERT INTO excusas (filename_excusa, filepath_excusa, aprendices_idusuario, registro_inasistencias_idregistro, estado_excusa) 
                  VALUES (?, ?, ?, ?, 'Por revisar')";
        /* $arrData = array($this->fileName, $this->filePath, $this->idAprendiz, $this->idInasistencia);
         */
        $arrData = array($this->fileName, $this->filePath, $this->idAprendiz, $this->idInasistencia);
        $request_insert = $this->insert($query, $arrData);
        $return = $request_insert;
        /* } else { 
        $return = 'exists';
        } */
        return $return;
    }

    public function getFilePath(int $id)
    {
        $sql = "SELECT filepath_excusa FROM excusas WHERE idexcusa = {$id}";
        $request = $this->select_all($sql);

        return $request;
    }

    public function selectInasistencias(int $id) /* selectInasistenciasAprendiz */
    {
        $sql = "SELECT idregistro, nombre_usuario, registro_idusuario, fecha_inasistencia, nombre_aprendiz, aprendices_idusuario, estado_inasistencia
                FROM registro_inasistencias
                JOIN usuarios ON usuarios.idusuario = registro_inasistencias.registro_idusuario
                JOIN aprendices ON aprendices.idaprendiz = registro_inasistencias.aprendices_idusuario
                WHERE aprendices.idaprendiz = {$id}
                ORDER BY fecha_inasistencia DESC";
        /* $sql = "SELECT idregistro, nombre_usuario, fecha_inasistencia, nombre_aprendiz, estado_excusa, estado_inasistencia, idexcusa
                FROM registro_inasistencias
                JOIN usuarios ON usuarios.idusuario = registro_inasistencias.registro_idusuario
                JOIN aprendices ON aprendices.idaprendiz = registro_inasistencias.aprendices_idusuario 
                JOIN excusas ON excusas.registro_inasistencias_idregistro = registro_inasistencias.idregistro";
         */
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectExcusasAprendiz(int $id)
    {
        /* CONVERTIR ESTA FUNCION A "selectInasistenciaId" Y AÑADIR EL WHERE EN LA CONSULTA*/
        /* $sql = "SELECT idregistro, aprendices_idusuario, fecha_inasistencia, registro_idusuario, estado_inasistencia
                FROM registro_inasistencias"; */
        $sql = "SELECT idregistro, nombre_usuario, registro_idusuario, fecha_inasistencia, nombre_aprendiz, registro_inasistencias.aprendices_idusuario, estado_excusa, estado_inasistencia, motivo_rechazo, idexcusa
                FROM registro_inasistencias
                JOIN usuarios ON usuarios.idusuario = registro_inasistencias.registro_idusuario
                JOIN aprendices ON aprendices.idaprendiz = registro_inasistencias.aprendices_idusuario 
                JOIN excusas ON excusas.registro_inasistencias_idregistro = registro_inasistencias.idregistro
                WHERE aprendices.idaprendiz = {$id}
                ORDER BY fecha_inasistencia DESC";
        $request = $this->select_all($sql);
        return $request;
    }

    /* -------------------------------------------------- */
    /* -------------------------------------------------- */
    /* -------------------------------------------------- */

    public function selectExcusaID(int $id)
    {
        $sql = "SELECT idexcusa, aprendices_idusuario, registro_inasistencias_idregistro
                FROM excusas
                WHERE idexcusa = {$id}";
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

    public function editarExcusa(string $fileName, string $filePath, int $idExcusa)
    {
        $return = "";

        $this->fileName = $fileName;
        $this->filePath = $filePath;
        $this->id = $idExcusa;

        $sql = "SELECT idexcusa FROM excusas WHERE idexcusa = '{$this->id}'";
        $request = $this->select_all($sql);

        if (!empty($request)) {
            $query = "UPDATE excusas SET filename_excusa = ?, filepath_excusa = ?, estado_excusa = 'Por revisar' WHERE idexcusa = ?";
            $arrData = array($this->fileName, $this->filePath, $this->id);
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

    public function rechazarExcusa(int $idexcusa, string $motivo_rechazo)
    {
        $return = "";

        $this->id = $idexcusa;
        $this->motivo = $motivo_rechazo;

        $sql = "SELECT idexcusa FROM excusas WHERE idexcusa = '{$this->id}'";
        $request = $this->select_all($sql);

        if (!empty($request)) {
            $query = "UPDATE excusas SET estado_excusa = 'Rechazada', motivo_rechazo = ? WHERE idexcusa = ?";
            $arrData = array($this->motivo, $this->id);
            $request_insert = $this->insert($query, $arrData);
            /* $return = $request_insert; */
            $return = "Rechazada";
        } else {
            $return = "empty";
        }
        return $return;
    }

    /* ------------------------ VALIDACIONES -------------------------- */

    /* VALIDAR QUE, AL EDITAR LA EXCUSA NO SE PUEDA SUBIR LA MISMA */
    public function validarExcusa(int $numdoc)
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


    public function selectMotivoRechazo(int $id)
    {
        $sql = "SELECT motivo_rechazo
                FROM excusas
                WHERE excusas.idexcusa = {$id}";
        $request = $this->select_all($sql);
        return $request;
    }
}
