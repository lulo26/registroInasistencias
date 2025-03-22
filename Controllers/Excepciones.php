<?php

class Excepciones extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
        }
    }

    public function excepciones()
    {
        $data['page_title'] = "Excepciones";
        $data['page_id_name'] = "excepciones";
        $data['page_functions_js'] = "excepciones/excepciones.js";

        $this->views->getView($this, "excepciones", $data);
    }

    public function getUsuarioByID()
    {
        if ($_SESSION['idUser']) {
            $idusuario = $_SESSION['idUser'];
            $arrData = $this->model->selectUsuarioID($idusuario);

            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'No se encontraron datos.');
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getFichasByUserID()
    {
        if ($_SESSION['idUser']) {
            $idUsuario = $_SESSION['idUser'];
            $arrData = $this->model->selectFichasUserID($idUsuario);

            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'No se encontraron datos.');
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getFichasByDate($fecha)
    {
        if ($_SESSION['idUser']) {
            $idUsuario = $_SESSION['idUser'];
            $arrData = $this->model->selectFichasDate($idUsuario, $fecha);

            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'No se encontraron datos.');
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getExcepciones()
    {
        $arrData = $this->model->selectExcepciones();

        for ($i = 0; $i < count($arrData); $i++) {
            if ($_SESSION['idUser'] === $arrData[$i]['idusuario']) {
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

    public function getExcepcionByID($idExcepcion)
    {
        $intIdExcep = intval(strClean($idExcepcion));
        if ($intIdExcep > 0) {
            $arrData = $this->model->selectExcepID($intIdExcep);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getExcepByInstructor() {}

    public function setExcepciones()
    {
        $fecha = strClean($_POST['fecha']);
        $motivo_excepcion = strClean($_POST['motivo_excepcion']);
        $usuarios_idusuario = strClean($_POST['usuarios_idusuario']);
        $bloques_idbloque = strClean($_POST['bloques_idbloque']);/* 
        $horaEntrada_excepcion = strClean($_POST['horaEntrada_excepcion']); */

        $arrPost = ['fecha', 'motivo_excepcion', 'usuarios_idusuario', 'bloques_idbloque'];

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
                    $requestModel = $this->model->insertarUsuario($numdoc_usuario, $nombre_usuario, $password_usuario, $correo_usuario, $telefono_usuario, $codigo_usuario, $rol_usuario);
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
                    $requestModel = $this->model->editarUsuario($numdoc_usuario, $nombre_usuario, $password_usuario, $correo_usuario, $telefono_usuario, $codigo_usuario, $rol_usuario, $idusuario);
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
}
