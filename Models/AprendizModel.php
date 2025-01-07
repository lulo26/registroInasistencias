<?php

// la clase se debe llamar exactamente a como se llama el archivo .php del modelo, incluyendo mayusculas
class AprendizModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    //ejemplos:

    // ejemplo select

    public function selectAprendiz()
    {
        $sql = "SELECT * FROM aprendices";
        $request = $this->select_all($sql);
        return $request;
    }

    // ejemplo insertar
    public function insertarAprendices(string $nombreAprendiz, string $apellidoAprendiz, string $generoAprendiz, string $numeroDocumentoAprendiz)
    {
        $this->nombre = $nombreAprendiz;
        $this->apellido = $apellidoAprendiz;
        $this->genero = $generoAprendiz;
        $this->numeroDocumento = $numeroDocumentoAprendiz;

        $sql = "INSERT INTO aprendices (nombre_aprendiz,apellido_aprendiz,generos_idgenero,numdoc) VALUES (?,?,?,?)";
        $arrData = array($this->nombre, $this->apellido, $this->genero, $this->numeroDocumento);
        return $this->insert($sql, $arrData);
    }

    // ejemplo editar
    public function editarAprendices(int $idAprendiz, string $nombreAprendiz, string $apellidoAprendiz, string $generoAprendiz, string $numeroDocumentoAprendiz)
    {
        $return = "";

        $this->id = $idAprendiz;
        $this->nombre = $nombreAprendiz;
        $this->apellido = $apellidoAprendiz;
        $this->genero = $generoAprendiz;
        $this->numeroDocumento = $numeroDocumentoAprendiz;

        $sql = "SELECT idAprendiz FROM aprendices WHERE idAprendiz = '{$this->id}'";
        $request = $this->select_all($sql);

        if (!empty($request)) {
            $query = "UPDATE aprendices SET nombre_aprendiz = ?, apellido_aprendiz=?, generos_idgenero=?, numdoc=? WHERE idAprendiz = ?";
            $arrData = array($this->nombre, $this->apellido, $this->genero, $this->numeroDocumento, $this->id);
            $request_insert = $this->insert($query, $arrData);
            $return = $request_insert;
        } else {
            $return = "empty";
        }
        return $return;
    }

    // ejemplo eliminar
    public function eliminarAprendiz(int $id)
    {
        $return = "";

        $this->id = $id;

        $sql = "SELECT * FROM aprendices WHERE idAprendiz = '{$this->id}'";
        $request = $this->select_all($sql);
        if (!empty($request)) {
            $query = "DELETE FROM aprendiz WHERE idAprendiz = ?";
            $arrData = array($this->id);
            $request_insert = $this->insert($query, $arrData);
            $return = $request_insert;
        } else {
            $return = "empty";
        }
        return $return;
    }


    public function getAprendizPorId(int $idAprendiz)
    {
        $return = "";

        $this->id = $idAprendiz;

        $sql = "SELECT * FROM aprendices WHERE idaprendiz = '{$this->id}'";
        $request = $this->select_all($sql);
        return $request;
    }
}
