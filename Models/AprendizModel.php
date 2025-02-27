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
        $sql = "SELECT * FROM aprendices where estado_aprendiz=1";
        $request = $this->select_all($sql);
        return $request;
    }

    // ejemplo insertar
    public function insertarAprendices(string $nombreAprendiz, string $apellidoAprendiz, string $generoAprendiz, string $numeroDocumentoAprendiz, string $codigoAprendiz, string $usuarioAprendiz, string $passAprendiz)
    {
        $this->nombre = $nombreAprendiz;
        $this->apellido = $apellidoAprendiz;
        $this->codigo = $codigoAprendiz;
        $this->genero = $generoAprendiz;
        $this->numeroDocumento = $numeroDocumentoAprendiz;
        $this->usuario = $usuarioAprendiz;
        $this->pass = $passAprendiz;

        $sql = "INSERT INTO aprendices (aprendices.nombre_aprendiz,aprendices.apellido_aprendiz,aprendices.generos_idgenero,aprendices.numdoc,aprendices.estado_aprendiz,aprendices.codigo_aprendiz,aprendices.usuario_aprendiz,aprendices.contra_aprendiz) 
        VALUES (?,?,?,?,1,?,?,?)";
        $arrData = array($this->nombre, $this->apellido, $this->genero, $this->numeroDocumento, $this->codigo, $this->usuario, $this->pass);
        return $this->insert($sql, $arrData);
    }

    // ejemplo editar
    public function editarAprendices(int $idAprendiz, string $nombreAprendiz, string $apellidoAprendiz, string $generoAprendiz, string $numeroDocumentoAprendiz, string $codigoAprendiz)
    {
        $return = "";

        $this->id = $idAprendiz;
        $this->nombre = $nombreAprendiz;
        $this->apellido = $apellidoAprendiz;
        $this->codigo = $codigoAprendiz;
        $this->genero = $generoAprendiz;
        $this->numeroDocumento = $numeroDocumentoAprendiz;

        $sql = "SELECT idAprendiz FROM aprendices WHERE idAprendiz = '{$this->id}'";
        $request = $this->select_all($sql);

        if (!empty($request)) {
            $query = "UPDATE aprendices SET nombre_aprendiz = ?, apellido_aprendiz=?, generos_idgenero=?, numdoc=?, codigo_aprendiz=? WHERE idAprendiz = ?";
            $arrData = array($this->nombre, $this->apellido, $this->genero, $this->numeroDocumento, $this->codigo, $this->id);
            $request_insert = $this->update($query, $arrData);
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

        $sql = "SELECT * FROM aprendices WHERE idaprendiz ='{$this->id}'";
        $request = $this->select_all($sql);

        if (!empty($request)) {
            $query = "UPDATE aprendices SET estado_aprendiz = ? WHERE idaprendiz = ?";
            $arrData = [2, $this->id];
            $request_update = $this->update($query, $arrData);
            $return = $request_update;
        } else {
            $return = "empty";
        }

        if ($request_update) {
            $return = [
                "status" => true,
                "msg" => "Aprendiz eliminado correctamente."
            ];
        } else {
            $return = [
                "status" => false,
                "msg" => "Hubo un problema al eliminar al aprendiz."
            ];
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
