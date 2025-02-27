<?php

class Usuarios extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function usuarios()
    {

        $data['page_title'] = "Usuarios";
        $data['page_id_name'] = "usuarios";
        $data['page_functions_js'] = "usuarios/usuarios.js";

        $this->views->getView($this, "usuarios", $data);
    }

    public function getUsuarios()
    {
        $arrData = $this->model->selectUsuarios();

        for ($i = 0; $i < count($arrData); $i++) {
            $btnEdit = "<button type='button' class='btn btn-primary rounded-pill' data-action-type='update' rel='" . $arrData[$i]['idusuario'] . "'>
                            <i class='bi bi-pencil-square'></i>
                        </button>";
            $btnDelete = "<button type='button' class='btn btn-danger rounded-pill' data-action-type='delete' rel='" . $arrData[$i]['idusuario'] . "'>
                            <i class='bi bi-trash-fill'></i>
                          </button>";
            $arrData[$i]['options'] =  $btnDelete . " " . " " . $btnEdit;
        }

        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getRoles()
    {
        $arrData = $this->model->selectRoles();

        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getUsuarioByID($idusuario)
    {
        $intIdUsuario = intval(strClean($idusuario));
        if ($intIdUsuario > 0) {
            $arrData = $this->model->selectUsuarioID($intIdUsuario);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function setUsuarios()
    {
        $numdoc_usuario = strClean($_POST['numdoc_usuario']);
        $nombre_usuario = strClean($_POST['nombre_usuario']);
        $password_usuario = strClean($_POST['password_usuario']);
        $correo_usuario = strClean($_POST['correo_usuario']);
        $telefono_usuario = strClean($_POST['telefono_usuario']);
        $roles_idrol = strClean($_POST['roles_idrol']);
        $codigo_usuario = strClean($_POST['codigo_usuario']);
        $idusuario = strClean($_POST['idusuario']);

        $arrPost = ['numdoc_usuario', 'nombre_usuario', 'password_usuario', 'correo_usuario', 'telefono_usuario', 'roles_idrol', 'codigo_usuario'];

        if (check_post($arrPost)) {
            if ($idusuario == 0 || $idusuario == "") {

                $validarIdentificacion = $this->model->validarIdentificacion($numdoc_usuario);
                $validarCorreo = $this->model->validarEmail($correo_usuario);
                $validarCodigo = $this->model->validarCodigo($codigo_usuario);

                if ($validarIdentificacion == "numdocExiste") {
                    $arrRespuesta = array('status' => false, 'msg' => 'Numero de identificacion ya registrado.');
                } elseif ($validarCorreo == "correoExiste") {
                    $arrRespuesta = array('status' => false, 'msg' => 'Correo ya registrado.');
                } elseif ($validarCodigo == "codigoExiste") {
                    $arrRespuesta = array('status' => false, 'msg' => 'Codigo no valido.');
                } else {
                    $requestModel = $this->model->insertarUsuario($numdoc_usuario, $nombre_usuario, $password_usuario, $correo_usuario, $telefono_usuario, $roles_idrol, $codigo_usuario);
                    if ($requestModel > 0) {
                        $arrRespuesta = array('status' => true, 'msg' => 'Usuario agregado correctamente.');
                    }
                    /* $option = 1; */
                }
            } else {
                $validarCorreoEditar = $this->model->validarEmail($correo_usuario, $idusuario);
                $validarCodigoEditar = $this->model->validarCodigo($codigo_usuario, $idusuario);

                if ($validarCorreoEditar == "correoExiste") {
                    $arrRespuesta = array('status' => false, 'msg' => 'Correo ya registrado.');
                } elseif ($validarCodigoEditar == "codigoExiste") {
                    $arrRespuesta = array('status' => false, 'msg' => 'Codigo no valido.');
                } else {
                    $requestModel = $this->model->editarUsuario($numdoc_usuario, $nombre_usuario, $password_usuario, $correo_usuario, $telefono_usuario, $roles_idrol, $codigo_usuario, $idusuario);
                    $arrRespuesta = array('status' => true, 'msg' => 'Usuario actualizado correctamente.');
                }
                /* $option = 2; */
                /* $validarCorreo = $this->model->validarEmail($correo_usuario);
                if ($validarCorreo === "correoExiste") {
                    $arrRespuesta = array('status' => false, 'msg' => 'Correo ya registrado.');
                } else {
                    $requestModel = $this->model->editarUsuario($numdoc_usuario, $nombre_usuario, $password_usuario, $correo_usuario, $telefono_usuario, $roles_idrol, $codigo_usuario, $idusuario);
                    $option = 2;
                } */
            }
            // echo($option);
            /* if ($requestModel > 0) {
                if ($option === 1) {
                    $arrRespuesta = array('status' => true, 'msg' => 'Usuario agregado correctamente.');
                }
            } elseif ($requestModel === 'exists') {
                $arrRespuesta = array('status' => false, 'msg' => 'Este usuario ya existe.');
            } else {
                $arrRespuesta = array('status' => true, 'msg' => 'Usuario actualizado correctamente.');
            } */
        } else {
            $arrRespuesta = array('status' => false, 'msg' => 'Debe ingresar todos los datos.');
        }

        echo json_encode($arrRespuesta, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminarUsuario()
    {
        if ($_POST) {
            $idusuario = intval($_POST['idusuario']);
            $requestDelete = $this->model->eliminarUsuario($idusuario);
            if ($requestDelete == 'empty') {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el usuario.');
            } else {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el usuario.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            print_r($_POST);
        }
        die();
    }

    /* public function validarIdentificacion()
    {
        if ($_POST) {
            $idusuario = intval($_POST['idusuario']);
            $requestDelete = $this->model->eliminarUsuario($idusuario);
            if ($requestDelete == 'empty') {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el usuario.');
            } else {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el usuario.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            print_r($_POST);
        }
        die();
    } */

    /* public function validarEmail()
    {
        if ($_POST) {
            $idusuario = intval($_POST['idusuario']);
            $requestDelete = $this->model->eliminarUsuario($idusuario);
            if ($requestDelete == 'empty') {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el usuario.');
            } else {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el usuario.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            print_r($_POST);
        }
        die();
    } */
}
