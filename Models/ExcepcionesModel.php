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

    public function selectExcepciones()
    {
        $sql = "SELECT idregistro, nombre_usuario, registro_idusuario, fecha_inasistencia, nombre_aprendiz, aprendices_idusuario, estado_inasistencia
                FROM inasistencias
                JOIN usuarios ON usuarios.idusuario = inasistencias.registro_idusuario
                JOIN aprendices ON aprendices.idaprendiz = inasistencias.aprendices_idusuario";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectExcepID(int $id)
    {
        $sql = "SELECT idexcusa, aprendices_idusuario, registro_inasistencias_idregistro
                FROM excusas
                WHERE idexcusa = {$id}";
        $request = $this->select_all($sql);
        return $request;
    }

    public function insertarExcepcion(string $fileName, string $filePath, int $idAprendiz, int $idInasistencia)
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

    public function editarExcepcion(string $fileName, string $filePath, int $idExcusa)
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

    /* ------------------------ VALIDACIONES -------------------------- */

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
}
