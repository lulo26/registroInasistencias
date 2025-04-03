<?php

class LoginModel extends Mysql
{

    private $intIdUsuario;
    private $strUsuario;
    private $strToken;

    public function __construct()
    {
        parent::__construct();
    }

    public function loginUser(string $usuario, string $password)
    {
        $this->strUsuario = $usuario;
        $this->strPassword = $password;/* 
        $sql = "SELECT u.idusuario, u.rol_usuario
                FROM usuarios u
                WHERE u.correo_usuario = '{$this->strUsuario}'
                AND u.password_usuario = '{$this->strPassword}' AND u.estado_usuario = 'Activo'
                UNION
                SELECT a.idaprendiz AS idusuario, 'APRENDIZ' AS rol_usuario
                FROM aprendices a
                WHERE (a.correo_aprendiz = '{$this->strUsuario}' OR a.numdoc_aprendiz = '{$this->strUsuario}')
                AND a.contra_aprendiz = '{$this->strPassword}' AND a.estado_aprendiz = 'Activo'"; */
        $sql = "SELECT u.idusuario, u.roles_usuarios
                FROM usuarios u
                WHERE u.correo_usuario = '{$this->strUsuario}'
                AND u.password_usuario = '{$this->strPassword}'";

        $request = $this->select($sql);
        return $request;
    }

    /* public function sessionLogin(int $idUser){
        $this->intUsuario = $idUser;

        $sql = "SELECT p.id_persona, 
        p.identificacion,
        p.nombres,
        p.apellidos,
        p.email_user,
        p.nit,
        p.razon_social,
        r.id_rol, r.nombre_rol,
        p.status
        FROM personas p
        INNER JOIN roles r
        ON p.rol_id = r.id_rol
        WHERE p.id_persona = {$this->intUsuario}";

        $request = $this->select($sql);
        return $request;
    } */
}