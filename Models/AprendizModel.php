<?php

class AprendizModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function selectAprendiz()
    {
        $sql = "SELECT * FROM aprendices WHERE estado_aprendiz = 1";
        $request = $this->select_all($sql);
        return $request;
    }

    public function insertarAprendices(
        string $nombreAprendiz,
        string $apellidoAprendiz,
        string $generoAprendiz,
        string $numeroDocumentoAprendiz,
        string $codigoAprendiz,
        string $usuarioAprendiz,
        string $passAprendiz
    ) {
        $this->nombre = $nombreAprendiz;
        $this->apellido = $apellidoAprendiz;
        $this->codigo = $codigoAprendiz;
        $this->genero = $generoAprendiz;
        $this->numeroDocumento = $numeroDocumentoAprendiz;
        $this->usuario = $usuarioAprendiz;
        $this->pass = $passAprendiz;

        // Validación de duplicados
        $sql = "SELECT * FROM aprendices 
                WHERE numdoc = ? OR codigo_aprendiz = ? OR usuario_aprendiz = ?";
        $arrCheck = array($this->numeroDocumento, $this->codigo, $this->usuario);
        $request_check = $this->select_all2($sql, $arrCheck);

        if (!empty($request_check)) {
            foreach ($request_check as $fila) {
                if ($fila['numdoc'] === $this->numeroDocumento) {
                    return "documento_existente";
                }
                if ($fila['codigo_aprendiz'] === $this->codigo) {
                    return "codigo_existente";
                }
                if ($fila['usuario_aprendiz'] === $this->usuario) {
                    return "usuario_existente";
                }
            }
        }

        // Inserción
        $sql = "INSERT INTO aprendices 
                (nombre_aprendiz, apellido_aprendiz, generos_idgenero, numdoc, estado_aprendiz, codigo_aprendiz, usuario_aprendiz, contra_aprendiz) 
                VALUES (?, ?, ?, ?, 1, ?, ?, ?)";
        $arrData = array(
            $this->nombre,
            $this->apellido,
            $this->genero,
            $this->numeroDocumento,
            $this->codigo,
            $this->usuario,
            $this->pass
        );

        return $this->insert($sql, $arrData);
    }

    public function editarAprendices(
        int $idAprendiz,
        string $nombreAprendiz,
        string $apellidoAprendiz,
        string $generoAprendiz,
        string $numeroDocumentoAprendiz,
        string $codigoAprendiz
    ) {
        $this->id = $idAprendiz;
        $this->nombre = $nombreAprendiz;
        $this->apellido = $apellidoAprendiz;
        $this->codigo = $codigoAprendiz;
        $this->genero = $generoAprendiz;
        $this->numeroDocumento = $numeroDocumentoAprendiz;

        $sql = "SELECT idAprendiz FROM aprendices WHERE idAprendiz = ?";
        $request = $this->select_all2($sql, [$this->id]);

        if (!empty($request)) {
            $query = "UPDATE aprendices 
                      SET nombre_aprendiz = ?, apellido_aprendiz = ?, generos_idgenero = ?, numdoc = ?, codigo_aprendiz = ? 
                      WHERE idAprendiz = ?";
            $arrData = array(
                $this->nombre,
                $this->apellido,
                $this->genero,
                $this->numeroDocumento,
                $this->codigo,
                $this->id
            );
            $request_insert = $this->update($query, $arrData);
            return $request_insert;
        } else {
            return "empty";
        }
    }

    public function eliminarAprendiz(int $id)
    {
        $this->id = $id;

        $sql = "SELECT * FROM aprendices WHERE idaprendiz = ?";
        $request = $this->select_all2($sql, [$this->id]);

        if (!empty($request)) {
            $query = "UPDATE aprendices SET estado_aprendiz = ? WHERE idaprendiz = ?";
            $arrData = [2, $this->id];
            $request_update = $this->update($query, $arrData);

            if ($request_update) {
                return [
                    "status" => true,
                    "msg" => "Aprendiz eliminado correctamente."
                ];
            } else {
                return [
                    "status" => false,
                    "msg" => "Hubo un problema al eliminar al aprendiz."
                ];
            }
        } else {
            return "empty";
        }
    }

    public function getAprendizPorId(int $idAprendiz)
    {
        $sql = "SELECT * FROM aprendices WHERE idaprendiz = ?";
        $request = $this->select_all2($sql, [$idAprendiz]);
        return $request;
    }

    public function existeDocumento($documento)
    {
        $sql = "SELECT idAprendiz FROM aprendices WHERE numdoc = ? AND estado_aprendiz = 1";
        return !empty($this->select_all2($sql, [$documento]));
    }

    public function existeCodigo($codigo)
    {
        $sql = "SELECT idAprendiz FROM aprendices WHERE codigo_aprendiz = ? AND estado_aprendiz = 1";
        return !empty($this->select_all2($sql, [$codigo]));
    }

    public function existeUsuario($usuario)
    {
        $sql = "SELECT idAprendiz FROM aprendices WHERE usuario_aprendiz = ? AND estado_aprendiz = 1";
        return !empty($this->select_all2($sql, [$usuario]));
    }
}
