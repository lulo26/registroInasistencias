<?php

class Usuarios extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
        }
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
            if ($_SESSION['idUser'] === $arrData[$i]['idusuario'] || $_SESSION['userData']['rol_usuario'] === "COORDINADOR") {
                $btnEdit = "<button type='button' class='btn btn-primary rounded-pill' data-action-type='update' rel='" . $arrData[$i]['idusuario'] . "'>
                                <i class='bi bi-pencil-square'></i>
                            </button>";
            } else {
                $btnEdit = "<button disabled type='button' class='btn btn-primary rounded-pill' data-action-type='update' rel='" . $arrData[$i]['idusuario'] . "'>
                                <i class='bi bi-pencil-square'></i>
                            </button>";
            }
            $btnDelete = "<button disabled type='button' class='btn btn-danger rounded-pill' data-action-type='delete' rel='" . $arrData[$i]['idusuario'] . "'>
                            <i class='bi bi-trash-fill'></i>
                          </button>";
            $arrData[$i]['options'] =  $btnDelete . " " . " " . $btnEdit;
        }

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
        /* $password_usuario = hash('SHA256', strClean($_POST['password_usuario'])); */
        $correo_usuario = strClean($_POST['correo_usuario']);
        $telefono_usuario = strClean($_POST['telefono_usuario']);
        $codigo_usuario = strClean($_POST['codigo_usuario']);
        $rol_usuario = strClean($_POST['rol_usuario']);
        $idusuario = strClean($_POST['idusuario']);

        $arrPost = ['numdoc_usuario', 'nombre_usuario', 'correo_usuario', 'telefono_usuario', 'codigo_usuario', 'rol_usuario'];

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
                } elseif (trim($password_usuario) === "" || empty($password_usuario)) {
                    $arrRespuesta = array('status' => false, 'msg' => 'Por favor, ingrese una contraseña.');
                } else {
                    $password_usuario_hash = hash('SHA256', $password_usuario);
                    $requestModel = $this->model->insertarUsuario(
                        $numdoc_usuario,
                        $nombre_usuario,
                        $password_usuario_hash,
                        $correo_usuario,
                        $telefono_usuario,
                        $codigo_usuario,
                        $rol_usuario
                    );
                    if ($requestModel > 0) {
                        $arrRespuesta = array('status' => true, 'msg' => 'Usuario agregado correctamente.');
                    }
                }
            } else {
                $validarCorreoEditar = $this->model->validarEmail($correo_usuario, $idusuario);
                $validarCodigoEditar = $this->model->validarCodigo($codigo_usuario, $idusuario);

                if ($validarCorreoEditar == "correoExiste") {
                    $arrRespuesta = array('status' => false, 'msg' => 'Correo ya registrado.');
                } elseif ($validarCodigoEditar == "codigoExiste") {
                    $arrRespuesta = array('status' => false, 'msg' => 'Codigo no valido.');
                } else {

                    if (empty($password_usuario)) {
                        $password_usuario = null;
                        // Actualizar sin cambiar contraseña
                        $requestModel = $this->model->editarUsuario(
                            $numdoc_usuario,
                            $nombre_usuario,
                            $password_usuario,
                            $correo_usuario,
                            $telefono_usuario,
                            $codigo_usuario,
                            $rol_usuario,
                            $idusuario
                        );
                    } else {
                        // Hashear la nueva contraseña y actualizarla
                        $password_usuario_hash = hash('SHA256', $password_usuario);
                        $requestModel = $this->model->editarUsuario(
                            $numdoc_usuario,
                            $nombre_usuario,
                            $password_usuario_hash,
                            $correo_usuario,
                            $telefono_usuario,
                            $codigo_usuario,
                            $rol_usuario,
                            $idusuario
                        );
                    }

                    $arrRespuesta = ['status' => true, 'msg' => 'Usuario actualizado correctamente.'];
                }
            }
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
                $arrResponse = array('status' => true, 'msg' => 'Usuario eliminado correctamente.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            print_r($_POST);
        }
        die();
    }
}
