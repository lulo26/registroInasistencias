<?php

class UsuariosModel extends Mysql{
    public function __construct(){
        parent::__construct();
    }

    public function selectUsuarios(){
        $sql = "SELECT * FROM usuarios";
        $request = $this->select_all($sql);
        return $request;
    }
    
    public function insertUsuarios(string $nombre_usuario, string $password, string $correo, string $numero){

        $this->nombre_usuario = $nombre_usuario;
        $this->nombre_usuario = $nombre_usuario;
        $this->nombre_usuario = $nombre_usuario;
        $this->nombre_usuario = $nombre_usuario;
        $this->nombre_usuario = $nombre_usuario;

        $sql = "INSERT INTO usuarios (nombre_usuario) VALUES (?)";
        $arrData = array($this->nombre_usuario);
        return $this->insert($sql, $arrData);
    }

    public function editUsuarios(int $id, string $nombre, string $password, string $correo, string $numero, int $idRol){
        $return = "";

        $this->nombre = $nombre;
        $this->password = $password;
        $this->correo = $correo;
        $this->numero = $numero;
        $this->idRol = $idRol;
        $this->id = $id;

        $sql = "SELECT idusuario FROM usuarios WHERE idusuario = '{$this->id}'";
        $request = $this->select_all($sql);

        if(!empty($request)){
            $query = "UPDATE usuarios SET nombre_usuario = ?, password_usuario = ?, correo_usuario = ?, numero_usuario = ?, roles_idrol = ?  
                      WHERE idusuario = ?";
            $arrData = array($this->nombre, $this->password, $this->correo, $this->numero, $this->idRol, $this->id);
            $request_insert = $this->insert($query, $arrData);
            $return = $request_insert;
        } else {
            $return = "empty";
        }
        return $return;
    }

    public function deleteUsuarios(int $id){
        $return = "";

        $this->id = $id;

        $sql = "SELECT * FROM usuarios WHERE idusuario = '{$this->id}'";
        $request = $this->select_all($sql);
        if(!empty($request)){
            $query = "DELETE FROM usuarios WHERE idusuario = ?";
            $arrData = array($this->id);
            $request_insert = $this->insert($query, $arrData);
            $return = $request_insert;
        } else {
            $return = "empty";
        }
        return $return;
    }
}