<?php

class Excusas extends Controllers
{
    private $targetDir = __DIR__ . "/../pdf/";

    /* private $model;
    private $views; */

    public function __construct()
    {
        parent::__construct();
    }


    public function getInasistencias1()
    {
        $arrInasistencias = $this->model->selectInasistencias();
        $arrResponse = $arrInasistencias;

        for ($i = 0; $i < count($arrInasistencias); $i++) {

            if ($arrInasistencias[$i]['estado_inasistencia'] === "Sin excusa") {
                $arrResponse[$i]['idexcusa'] = 0;
                $arrResponse[$i]['estado_excusa'] = "Sin excusa";
            } elseif ($arrInasistencias[$i]['estado_inasistencia'] === "Con excusa") {

                $arrExcusas = $this->model->selectExcusasAprendiz();

                $arrResponse[$i]['idexcusa'] = $arrExcusas[$i]['idexcusa'];
                $arrResponse[$i]['estado_excusa'] = $arrExcusas[$i]['estado_excusa'];
            }

            if ($arrResponse[$i]['estado_excusa'] === "Sin excusa") {
                $estadoExcusa = "<span class='badge rounded-pill text-bg-secondary'>" . $arrResponse[$i]['estado_excusa'] . "</span>";
            } elseif ($arrResponse[$i]['estado_excusa'] === "Enviada" || $arrResponse[$i]['estado_excusa'] === "Por revisar") {
                $estadoExcusa = "<span class='badge rounded-pill text-bg-info'>" . $arrResponse[$i]['estado_excusa'] . "</span>";
            } elseif ($arrResponse[$i]['estado_excusa'] === "Aprobada") {
                $estadoExcusa = "<span class='badge rounded-pill text-bg-success'>" . $arrResponse[$i]['estado_excusa'] . "</span>";
            } elseif ($arrResponse[$i]['estado_excusa'] === "Rechazada") {
                $estadoExcusa = "<span class='badge rounded-pill text-bg-danger'>" . $arrResponse[$i]['estado_excusa'] . "</span>";
            }

            if ($arrResponse[$i]['estado_inasistencia'] === "Con excusa") {
                if ($arrResponse[$i]['estado_excusa'] === "Aprobada") {
                    $btnEdit = "<button disabled type='button' class='btn btn-outline-primary rounded-pill' data-action-type='update' rel='" . $arrResponse[$i]['idregistro'] . "'>
                                    <i class='bi bi-pencil-square'></i>
                                </button>";
                    $arrResponse[$i]['options'] =  $btnEdit;
                } else {
                    $btnEdit = "<button type='button' class='btn btn-outline-primary rounded-pill' data-action-type='update' rel='" . $arrResponse[$i]['idregistro'] . "'>
                                <i class='bi bi-pencil-square'></i>
                            </button>";
                    /* $btnDelete = "<button type='button' class='btn btn-outline-danger rounded-pill' data-action-type='delete' rel='" . $arrResponse[$i]['idregistro'] . "'>
                                <i class='bi bi-trash-fill'></i>
                            </button>"; */
                    /* $arrResponse[$i]['options'] =  $btnEdit . " " . " " . $btnDelete; */
                    $arrResponse[$i]['options'] =  $btnEdit;
                }
            } else if ($arrResponse[$i]['estado_inasistencia'] === "Sin excusa") {
                $btnAdjuntar = "<button type='button' class='btn btn-outline-primary rounded-pill' data-action-type='adjuntar' rel='" . $arrResponse[$i]['idregistro'] . "'>
                                <i class='bi bi-paperclip'></i>
                            </button>";
                $arrResponse[$i]['options'] =  $btnAdjuntar;
            }

            $arrResponse[$i]['estado_excusa'] = $estadoExcusa;
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function excusas()
    {
        $data['page_title'] = "Excusas";
        $data['page_id_name'] = "excusas";
        $data['page_functions_js'] = "excusas/excusas.js";

        $this->views->getView($this, "excusas", $data);
    }

    public function getInasistencias()
    {
        $arrData = $this->model->selectInasistencias();

        for ($i = 0; $i < count($arrData); $i++) {

            if ($arrData[$i]['estado_inasistencia'] === "Sin excusa") {
            }

            if ($arrData[$i]['estado_excusa'] === "Sin excusa") {
                $estadoExcusa = "<span class='badge rounded-pill text-bg-secondary'>" . $arrData[$i]['estado_excusa'] . "</span>";
            } elseif ($arrData[$i]['estado_excusa'] === "Enviada" || $arrData[$i]['estado_excusa'] === "Por revisar") {
                $estadoExcusa = "<span class='badge rounded-pill text-bg-info'>" . $arrData[$i]['estado_excusa'] . "</span>";
            } elseif ($arrData[$i]['estado_excusa'] === "Aprobada") {
                $estadoExcusa = "<span class='badge rounded-pill text-bg-success'>" . $arrData[$i]['estado_excusa'] . "</span>";
            } elseif ($arrData[$i]['estado_excusa'] === "Rechazada") {
                $estadoExcusa = "<span class='badge rounded-pill text-bg-danger'>" . $arrData[$i]['estado_excusa'] . "</span>";
            }

            if ($arrData[$i]['estado_inasistencia'] === "Con excusa") {
                if ($arrData[$i]['estado_excusa'] === "Aprobada") {
                    $btnEdit = "<button disabled type='button' class='btn btn-outline-primary rounded-pill' data-action-type='update' rel='" . $arrData[$i]['idregistro'] . "'>
                                    <i class='bi bi-pencil-square'></i>
                                </button>";
                    $arrData[$i]['options'] =  $btnEdit;
                } else {
                    $btnEdit = "<button type='button' class='btn btn-outline-primary rounded-pill' data-action-type='update' rel='" . $arrData[$i]['idregistro'] . "'>
                                <i class='bi bi-pencil-square'></i>
                            </button>";
                    /* $btnDelete = "<button type='button' class='btn btn-outline-danger rounded-pill' data-action-type='delete' rel='" . $arrData[$i]['idregistro'] . "'>
                                <i class='bi bi-trash-fill'></i>
                            </button>"; */
                    /* $arrData[$i]['options'] =  $btnEdit . " " . " " . $btnDelete; */
                    $arrData[$i]['options'] =  $btnEdit;
                }
            } else if ($arrData[$i]['estado_inasistencia'] === "Sin excusa") {
                $btnAdjuntar = "<button type='button' class='btn btn-outline-primary rounded-pill' data-action-type='adjuntar' rel='" . $arrData[$i]['idregistro'] . "'>
                                <i class='bi bi-paperclip'></i>
                            </button>";
                $arrData[$i]['options'] =  $btnAdjuntar;
            }

            $arrData[$i]['estado_excusa'] = $estadoExcusa;
        }

        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    /* ------------------------------------------------- */
    /* ------------------------------------------------- */
    /* ------------------------------------------------- */

    public function getExcusas()
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

    public function getExcusasPorInstructor($idinstructor)
    {
        $intIdInstructor = intval(strClean($idinstructor));
        if ($intIdInstructor > 0) {
            $arrData = $this->model->selectExcusasInstructor($intIdInstructor);
            if (empty($arrData)) {
                $arrData = array('status' => false, 'msg' => 'Datos no encontrados');
            } else {
                /* $arrResponse = array('status' => true, 'data' => $arrData); */

                /* Decision: si hay excusa, mostrarla en la tabla */

                for ($i = 0; $i < count($arrData); $i++) {

                    if ($arrData[$i]['estado_excusa'] === "Sin excusa") {
                        $estadoExcusa = "<span class='badge rounded-pill text-bg-secondary'>" . $arrData[$i]['estado_excusa'] . "</span>";
                    } elseif ($arrData[$i]['estado_excusa'] === "Enviada" || $arrData[$i]['estado_excusa'] === "Por revisar") {
                        $estadoExcusa = "<span class='badge rounded-pill text-bg-info'>" . $arrData[$i]['estado_excusa'] . "</span>";
                    } elseif ($arrData[$i]['estado_excusa'] === "Aprobada") {
                        $estadoExcusa = "<span class='badge rounded-pill text-bg-success'>" . $arrData[$i]['estado_excusa'] . "</span>";
                    } elseif ($arrData[$i]['estado_excusa'] === "Rechazada") {
                        $estadoExcusa = "<span class='badge rounded-pill text-bg-danger'>" . $arrData[$i]['estado_excusa'] . "</span>";
                    }
                    $arrData[$i]['estado_excusa'] = $estadoExcusa;

                    $btnDescargar = "<button type='button' class='btn btn-outline-primary rounded-pill' data-action-type='descargar' rel='" . $arrData[$i]['idexcusa'] . "'>
                            <i class='bi bi-file-earmark-text'></i>
                        </button>";
                    $arrData[$i]['excusa'] = $btnDescargar;

                    $btnAprobar = "<button type='button' class='btn btn-outline-success rounded-pill' data-action-type='aprobar' rel='" . $arrData[$i]['idexcusa'] . "'>
                            <i class='bi bi-check-circle'></i>
                        </button>";

                    $btnRechazar = "<button type='button' class='btn btn-outline-danger rounded-pill' data-action-type='rechazar' rel='" . $arrData[$i]['idexcusa'] . "'>
                            <i class='bi bi-x-circle'></i>
                          </button>";
                    $arrData[$i]['options'] =  $btnAprobar . " " . " " . $btnRechazar;
                }
            }
        }

        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    /* ------------------------------------------------- */

    /* public function getUsuarioByID($idusuario)
    {
        $intIdUsuario = intval(strClean($idusuario));
        if ($intIdUsuario > 0) {
            $arrData = $this->model->selectUsuarioID($intIdUsuario);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    } */


    public function setExcusas()
    {
        $file = ($_FILES['excusa']);
        $fileName = basename($file["name"]);
        $idExcusa = strClean($_POST['idexcusa']);
        $idAprendiz = strClean($_POST['idAprendiz']);
        $idInasistencia = strClean($_POST['idInasistencia']);

        $targetFile = $this->targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $arrPost = ['idexcusa', 'idAprendiz', 'idInasistencia'];

        // Verificar si el archivo es un PDF
        if ($fileType != "pdf") {
            $arrRespuesta = array('status' => false, 'msg' => 'Solo se permiten archivos PDF.');
        }
        // Verificar si el archivo ya existe
        elseif (file_exists($targetFile)) {
            $arrRespuesta = array('status' => false, 'msg' => 'El archivo ya existe.');
        } elseif (check_post($arrPost)) {
            if ($idExcusa == 0 || $idExcusa == "") {

                // Intentar mover el archivo al directorio de destino
                if (move_uploaded_file($file["tmp_name"], $targetFile)) {
                    $requestModel = $this->model->insertarExcusa($fileName, $targetFile, $idAprendiz, $idInasistencia);
                    if ($requestModel > 0) {
                        $arrRespuesta = array('status' => true, 'msg' => 'Excusa enviada correctamente.');
                    }
                } else {
                    $arrRespuesta = array('status' => false, 'msg' => 'Error al mover el archivo: ' . print_r(error_get_last(), true));
                }
            } else {
                $requestModel = $this->model->editarExcusa($fileName, $targetFile, $idExcusa);
                $arrRespuesta = array('status' => true, 'msg' => 'Excusa actualizada correctamente.');
            }
            // echo($option);
        } else {
            $arrRespuesta = array('status' => false, 'msg' => 'Faltan datos en el POST.');
        }

        /* $targetFile = $this->targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Verificar si el archivo es un PDF
        if ($fileType != "pdf") {
            $arrRespuesta = array('status' => false, 'msg' => 'Solo se permiten archivos PDF.');
        }

        // Verificar si el archivo ya existe
        if (file_exists($targetFile)) {
            $arrRespuesta = array('status' => false, 'msg' => 'El archivo ya existe.');
        }

        // Intentar mover el archivo al directorio de destino
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            $this->model->insertarExcusa($fileName, $targetFile);
            $arrRespuesta = array('status' => true, 'msg' => 'Excusa enviada correctamente.');
        } else {
            $arrRespuesta = array('status' => false, 'msg' => 'Error al mover el archivo: ' . print_r(error_get_last(), true));
        } */

        echo json_encode($arrRespuesta, JSON_UNESCAPED_UNICODE);
        die();
    }

    /* public function deleteExcusa()
    {
        if ($_POST) {
            $idExcusa = intval($_POST['idExcusa']);
            $request = $this->model->deleteExcusa($idExcusa);
            if ($request == 'empty') {
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

    public function aprobarExcusa()
    {
        if ($_POST) {
            $idexcusa = intval($_POST['idexcusa']);
            $request = $this->model->aprobarExcusa($idexcusa);
            if ($request == 'empty') {
                $arrResponse = array('status' => false, 'msg' => 'Error al aprobar la excusa.');
            } elseif ($request == 'Aprobada') {
                $arrResponse = array('status' => true, 'msg' => 'Excusa aprobada correctamente.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            print_r($_POST);
        }
        die();
    }

    public function rechazarExcusa()
    {
        if ($_POST) {
            $idexcusa = intval($_POST['idexcusa']);
            $request = $this->model->aprobarExcusa($idexcusa);
            if ($request == 'empty') {
                $arrResponse = array('status' => false, 'msg' => 'Error al aprobar la excusa.');
            } elseif ($request == 'Rechazada') {
                $arrResponse = array('status' => true, 'msg' => 'Excusa rechazada correctamente.');
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

    public function mostrarExcusaVistaPrevia()
    {
        // Comprobar si se ha pasado un id en la URL
        if (isset($_GET['idexcusa'])) {
            $id = $_GET['idexcusa'];

            // Instanciar la clase y obtener la ruta del archivo
            /* $fileDownload = new descarga(); */
            $filepath = $this->model->getFilePath($id);

            // Verificar si el archivo existe
            if ($filepath && file_exists($filepath)) {
                // Forzar la visualización del archivo en el navegador
                header('Content-Type: application/pdf');
                header('Content-Disposition: inline; filename="' . basename($filepath) . '"');
                header('Content-Length: ' . filesize($filepath));
                readfile($filepath);
                exit;
            } else {
                echo "El archivo no existe.";
            }
        } else {
            echo "ID de archivo no proporcionado.";
        }
    }

    public function mostrarExcusaDescargaDirecta()
    {
        // Comprobar si se ha pasado un id en la URL
        if (isset($_GET['idexcusa'])) {
            $id = $_GET['idexcusa'];

            // Instanciar la clase y obtener la ruta del archivo
            /* $fileDownload = new descarga(); */
            $response = $this->model->getFilePath($id);

            // Verificar si el archivo existe
            if (!empty($response) && isset($response[0]['filepath_excusa'])) {
                $filepath = $response[0]['filepath_excusa'];

                // Verificar si el archivo existe
                if (file_exists($filepath)) {
                    /* echo "Descargar";
                    die(); */
                    // Forzar la descarga del archivo
                    header('Content-Type: application/pdf');
                    header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
                    header('Content-Length: ' . filesize($filepath));
                    readfile($filepath);
                    exit;
                } else {
                    echo "El archivo no existe.";
                }
            } else {
                echo "No se encontró la ruta del archivo.";
            }
        } else {
            echo "ID de archivo no proporcionado.";
        }
    }
}
