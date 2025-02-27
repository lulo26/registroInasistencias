<?php

// la clase se debe llamar exactamente a como se llama el archivo .php del modelo, incluyendo mayusculas
class InasistenciasModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    //ejemplos:

    // ejemplo select

    public function selectInasistencias()
    {
        $sql = "SELECT * FROM registro_inasistencias";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectFichas()
    {
        $sql = "SELECT * FROM fichas";
        $request = $this->select_all($sql);
        return $request;
    }

    public function insertarInasistencia(string $codigoAprendiz, int $idUsuario, string $numeroFicha)
    {
        $return = "";
        $this->codigo = $codigoAprendiz;
        $this->idUsuario = $idUsuario;
        $this->idFicha = $numeroFicha;

        $sql = "SELECT idaprendiz FROM aprendices WHERE codigo_aprendiz=?";
        $request = $this->efectuarConsulta($sql, [$codigoAprendiz], 's');

        if ($request && count($request) > 0) {

            $result = $request[0];
            $this->idAprendiz = $result['idaprendiz'];
        } else {
            return false;
        }

        $sql = "INSERT INTO inasistencias (aprendices_idusuario, registro_idusuario, estado_inasistencia, retardos_inasistencia) 
                VALUES(?, ?, 'Activo', 'No')";

        $arrData = array($this->idAprendiz, $this->idUsuario);

        return $this->insert($sql, $arrData);
    }


    // ejemplo editar

    /*public function editarAprendices(int $idAprendiz, string $nombreAprendiz, string $apellidoAprendiz, string $generoAprendiz, string $numeroDocumentoAprendiz, string $codigoAprendiz)
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
*/
    // ejemplo eliminar
    public function eliminarInasistencia(int $id)
    {
        $return = "";

        // Asignar el ID al objeto
        $this->id = $id;

        // Verificar si el aprendiz existe
        $sql = "SELECT * FROM aprendices WHERE idAprendiz = '{$this->id}'";
        $request = $this->select_all($sql);

        // Si el aprendiz existe, proceder a eliminarlo
        if (!empty($request)) {
            $query = "DELETE FROM aprendices WHERE idAprendiz = ?";
            $arrData = array($this->id);
            $request_delete = $this->insert($query, $arrData); // Usar un método adecuado como 'delete' si está disponible
            $return = $request_delete;
        } else {
            $return = "empty"; // Si no existe el aprendiz
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
