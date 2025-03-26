<?php

class LoginModel extends Mysql{

    private $intIdUsuario;
    private $strUsuario;
    private $strToken;

    public function __construct(){
        parent::__construct();
    }

    public function loginUser(string $usuario, string $password){
        $this->strUsuario = $usuario;
        $this->strPassword = $password;
        $sql = "SELECT idusuario FROM usuarios WHERE
        correo_usuario = '{$this->strUsuario}' AND
        password_usuario = '{$this->strPassword}'";
        
        $request = $this->select($sql);
        return $request;        
    }

}