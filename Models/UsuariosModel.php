<?php

class UsuariosModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function selectUsuarios()
    {
        $sql = "SELECT idusuario, numdoc_usuario, nombre_usuario, correo_usuario, telefono_usuario, codigo_usuario, rol_usuario
                FROM usuarios
                WHERE estado_usuario = 'Activo'
                ORDER BY idusuario ASC";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectUsuarioID(int $id)
    {
        $sql = "SELECT idusuario, numdoc_usuario, nombre_usuario, correo_usuario, telefono_usuario, codigo_usuario, password_usuario, rol_usuario
                FROM usuarios 
                WHERE idusuario = {$id} AND estado_usuario = 'Activo'";
        $request = $this->select_all($sql);
        return $request;
    }

    public function insertarUsuario(string $numdoc_usuario, string $nombre_usuario, string $password_usuario, string $correo_usuario, string $telefono_usuario, string $codigo_usuario, string $rol_usuario)
    {
        $return = "";

        $this->numdoc = $numdoc_usuario;
        $this->nombre = $nombre_usuario;
        $this->password = $password_usuario;
        $this->correo = $correo_usuario;
        $this->telefono = $telefono_usuario;
        $this->codigo = $codigo_usuario;
        $this->rol = $rol_usuario;

        $query = "INSERT INTO usuarios (numdoc_usuario, nombre_usuario, password_usuario, correo_usuario, telefono_usuario, codigo_usuario, rol_usuario, estado_usuario) 
                  VALUES (?,?,?,?,?,?,?, 'Activo')";
        $arrData = array($this->numdoc, $this->nombre, $this->password, $this->correo, $this->telefono, $this->codigo, $this->rol);
        $request_insert = $this->insert($query, $arrData);
        $return = $request_insert;

        return $return;
    }

    public function editarUsuario(string $numdoc_usuario, string $nombre_usuario, string $password_usuario = null, string $correo_usuario, string $telefono_usuario, string $codigo_usuario, string $rol_usuario, int $idusuario)
    {
        $return = "";

        $this->numdoc = $numdoc_usuario;
        $this->nombre = $nombre_usuario;
        $this->password = $password_usuario;
        $this->correo = $correo_usuario;
        $this->telefono = $telefono_usuario;
        $this->codigo = $codigo_usuario;
        $this->rol = $rol_usuario;
        $this->id = $idusuario;

        $sql = "SELECT idusuario FROM usuarios WHERE idusuario = '{$this->id}' AND estado_usuario = 'Activo'";
        $request = $this->select_all($sql);

        if (!empty($request)) {
            if (empty($this->password)) {
                $query = "UPDATE usuarios SET numdoc_usuario = ?, nombre_usuario = ?, correo_usuario = ?, telefono_usuario = ?, codigo_usuario = ?, rol_usuario = ? 
                          WHERE idusuario = ?";
                $arrData = array($this->numdoc, $this->nombre, $this->correo, $this->telefono, $this->codigo, $this->rol, $this->id);
            } else {
                $query = "UPDATE usuarios SET numdoc_usuario = ?, nombre_usuario = ?, password_usuario = ?, correo_usuario = ?, telefono_usuario = ?, codigo_usuario = ?, rol_usuario = ? 
                          WHERE idusuario = ?";
                $arrData = array($this->numdoc, $this->nombre, $this->password, $this->correo, $this->telefono, $this->codigo, $this->rol, $this->id);
            }

            $request_insert = $this->insert($query, $arrData);
            $return = $request_insert;
        } else {
            $return = "empty";
        }
        return $return;
    }

    public function eliminarUsuario(int $id)
    {
        $return = "";

        $this->id = $id;

        $sql = "SELECT * FROM usuarios WHERE idusuario = '{$this->id}'";
        $request = $this->select_all($sql);
        if (!empty($request)) {
            $query = "UPDATE usuarios SET estado_usuario = 'Inactivo'
                      WHERE idusuario = ?";
            $arrData = array($this->id);
            $request_insert = $this->insert($query, $arrData);
            $return = $request_insert;
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

        $sql = "SELECT numdoc_usuario FROM usuarios WHERE numdoc_usuario = '{$this->numdoc}' AND estado_usuario = 'Activo'";
        $request = $this->select($sql);

        if (empty($request)) {
            $return = "numdocValido";
        } else {
            $return = "numdocExiste";
        }

        return $return;
    }

    public function validarEmail(string $correo, int $id = null)
    {
        $return = "";

        $this->correo = $correo;
        $this->id = $id;

        if ($id !== null) {
            $sql = "SELECT correo_usuario FROM usuarios WHERE correo_usuario = '{$this->correo}' AND idusuario != '{$id}' AND estado_usuario = 'Activo'";
        } else {
            $sql = "SELECT correo_usuario FROM usuarios WHERE correo_usuario = '{$this->correo}' AND estado_usuario = 'Activo'";
        }

        $request = $this->select($sql);

        if (empty($request)) {
            $return = "correoValido";
        } else {
            $return = "correoExiste";
        }

        return $return;
    }

    public function validarCodigo(string $codigo, int $id = null)
    {
        $return = "";

        $this->codigo = $codigo;
        $this->id = $id;

        if ($id !== null) {
            $sql = "SELECT codigo_usuario FROM usuarios WHERE codigo_usuario = '{$this->codigo}' AND idusuario != '{$id}' AND estado_usuario = 'Activo'";
        } else {
            $sql = "SELECT codigo_usuario FROM usuarios WHERE codigo_usuario = '{$this->codigo}' AND estado_usuario = 'Activo'";
        }

        $request = $this->select($sql);

        if (empty($request)) {
            $return = "codigoValido";
        } else {
            $return = "codigoExiste";
        }

        return $return;
    }
}
