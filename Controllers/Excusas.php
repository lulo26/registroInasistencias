<?php

class Excusas extends Controllers
{
    private $targetDir = __DIR__ . "/../pdf/";

    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
        }
    }

    public function excusas()
    {
        $data['page_title'] = "Excusas";
        $data['page_id_name'] = "excusas";
        $data['page_functions_js'] = "excusas/excusas.js";

        $this->views->getView($this, "excusas", $data);
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

    public function getInasistencias() /* getInasByAprendiz */
    {
        $id = 1;

        $arrInasistencias = $this->model->selectInasistencias($id);
        $arrExcusas = $this->model->selectExcusasAprendiz($id);
        $arrResponse = $arrInasistencias;

        /* for ($j = 0; $j < count($arrExcusas); $j++) {
        } */

        for ($i = 0; $i < count($arrInasistencias); $i++) {
            if ($arrInasistencias[$i]['estado_inasistencia'] === "Sin excusa") {

                $limite = 6;
                $fechaInasistencia = new DateTime($arrInasistencias[$i]['fecha_inasistencia']);
                $fechaActual = new DateTime(date('Y-m-d H:i:s'));
                $diasPlazo = $fechaInasistencia->diff($fechaActual);
                $dif = (int)$diasPlazo->days;

                if ($dif >= $limite) {
                    $estadoExcusa = "<span class='badge rounded-pill text-bg-secondary'>Sin excusa</span>";
                    $arrResponse[$i]['estado_excusa'] = $estadoExcusa;
                    $mensaje = "<div class='alert alert-danger' role='alert'>
                              ¡Superaste el limite de dias para enviar una excusa!
                            </div>";
                    $arrResponse[$i]['options'] =  $mensaje;
                } else {
                    $arrResponse[$i]['idexcusa'] = 0;

                    $estadoExcusa = "<span class='badge rounded-pill text-bg-secondary'>Sin excusa</span>";
                    $arrResponse[$i]['estado_excusa'] = $estadoExcusa;

                    $btnAdjuntar = "<button type='button' class='btn btn-outline-primary rounded-pill' data-action-type='adjuntar' rel='" . $arrResponse[$i]['idregistro'] . "'>
                                        <i class='bi bi-paperclip'></i>
                                    </button>";
                    $arrResponse[$i]['options'] =  $btnAdjuntar;
                }
            } elseif ($arrInasistencias[$i]['estado_inasistencia'] === "Con excusa") {

                for ($j = 0; $j < count($arrExcusas); $j++) {
                    if ($arrResponse[$i]['idregistro'] === $arrExcusas[$j]['idregistro']) {
                        $arrResponse[$i]['idexcusa'] = $arrExcusas[$j]['idexcusa'];
                        $arrResponse[$i]['estado_excusa'] = $arrExcusas[$j]['estado_excusa'];
                        break;
                    }
                }
                /* foreach ($arrExcusas as $excusa) {
                    if ($arrResponse[$i]['idregistro'] === $excusa['idregistro']) {
                        # code...
                    }
               } */

                /* if ($arrResponse[$i]['idregistro'] === $arrExcusas[$i]['idregistro']) {

                    $arrResponse[$i]['idexcusa'] = $arrExcusas[$i]['idexcusa'];
                    $arrResponse[$i]['estado_excusa'] = $arrExcusas[$i]['estado_excusa']; */

                if ($arrResponse[$i]['estado_excusa'] === "Enviada" || $arrResponse[$i]['estado_excusa'] === "Por revisar") {

                    $estadoExcusa = "<span class='badge rounded-pill text-bg-info'>" . $arrResponse[$i]['estado_excusa'] . "</span>";

                    $btnEdit = "<button type='button' class='btn btn-outline-primary rounded-pill' data-action-type='update' rel='" . $arrResponse[$i]['idexcusa'] . "'>
                                        <i class='bi bi-pencil-square'></i>
                                    </button>";
                    $arrResponse[$i]['options'] =  $btnEdit;
                } elseif ($arrResponse[$i]['estado_excusa'] === "Aprobada") {
                    /*  $btnEdit = "<button disabled type='button' class='btn btn-outline-primary rounded-pill' data-action-type='update' rel='" . $arrResponse[$i]['idexcusa'] . "'>
                                            <i class='bi bi-pencil-square'></i>
                                        </button>";
                        $arrResponse[$i]['options'] =  $btnEdit; */

                    $estadoExcusa = "<span class='badge rounded-pill text-bg-success'>" . $arrResponse[$i]['estado_excusa'] . "</span>";

                    $mensaje = "<div class='alert alert-success' role='alert'>
                                ¡Tu excusa fue aprobada!
                                </div>";
                    $arrResponse[$i]['options'] =  $mensaje;
                } elseif ($arrResponse[$i]['estado_excusa'] === "Rechazada") {

                    /* $btnEdit = "<button type='button' class='btn btn-outline-primary rounded-pill' data-action-type='update' rel='" . $arrResponse[$i]['idexcusa'] . "'>
                                        <i class='bi bi-pencil-square'></i>
                                    </button>";
                        $arrResponse[$i]['options'] =  $btnEdit; */

                    $estadoExcusa = "<span class='badge rounded-pill text-bg-danger'>" . $arrResponse[$i]['estado_excusa'] . "</span>";

                    $mensaje = "<div class='alert alert-danger' role='alert'>
                                ¡Tu excusa fue rechazada! <a href='#' class='alert-link' id='verMotivo' data-action-type='verMotivo' data-idexcusa=" . $arrResponse[$i]['idexcusa'] . ">Ver motivo.</a>
                                </div>";
                    /* $arrResponse[$i]['motivo'] =  $arrResponse[$i]['motivo_rechazo']; */
                    $arrResponse[$i]['options'] =  $mensaje;
                }
                $arrResponse[$i]['estado_excusa'] = $estadoExcusa;
                /* } */

                /*  $arrResponse[$i]['idexcusa'] = $arrExcusas[$i]['idexcusa'];
                $arrResponse[$i]['estado_excusa'] = $arrExcusas[$i]['estado_excusa']; */
            }
        }

        /* 
$datetime1 = new DateTime($arrInasistencias[$i]['fecha_inasistencia']);
$hoy = date('Y-m-d H:i:s')
$datetime2 = new DateTime($hoy);
$interval = $datetime1->diff($datetime2);
echo $interval->format('%R%a días'); */

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    /* public function getInasistencias()
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
            $arrResponse[$i]['estado_excusa'] = $estadoExcusa;

            if ($arrResponse[$i]['estado_inasistencia'] === "Con excusa") {
                if ($arrResponse[$i]['estado_excusa'] === "Aprobada") {
                    $btnEdit = "<button disabled type='button' class='btn btn-outline-primary rounded-pill' data-action-type='update' rel='" . $arrResponse[$i]['idexcusa'] . "'>
                                    <i class='bi bi-pencil-square'></i>
                                </button>";
                    $arrResponse[$i]['options'] =  $btnEdit;
                } else {
                    $btnEdit = "<button type='button' class='btn btn-outline-primary rounded-pill' data-action-type='update' rel='" . $arrResponse[$i]['idexcusa'] . "'>
                                <i class='bi bi-pencil-square'></i>
                            </button>";
                    $arrResponse[$i]['options'] =  $btnEdit;
                }
            } else if ($arrResponse[$i]['estado_inasistencia'] === "Sin excusa") {
                $btnAdjuntar = "<button type='button' class='btn btn-outline-primary rounded-pill' data-action-type='adjuntar' rel='" . $arrResponse[$i]['idregistro'] . "'>
                                <i class='bi bi-paperclip'></i>
                            </button>";
                $arrResponse[$i]['options'] =  $btnAdjuntar;
            }
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    } */

    public function getExcusaByID($idexcusa)
    {
        $intIdExcusa = intval(strClean($idexcusa));

        if ($intIdExcusa > 0) {
            $arrData = $this->model->selectExcusaID($intIdExcusa);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getExcusasPorInstructor($idinstructor) /* getExcusasByInstructor */
    {
        $intIdInstructor = intval(strClean($idinstructor));
        if ($intIdInstructor > 0) {
            $arrData = $this->model->selectExcusasInstructor($intIdInstructor);
            if (empty($arrData)) {
                $mensaje = "<div class='alert alert-success' role='alert'>
                          ¡No hay excusas por revisar!
                        </div>";
                $arrData = array('msg' => $mensaje);
                $arrResponse = array('status' => false, 'data' => $arrData);
            } else {
                /* Decision: si hay excusa, mostrarla en la tabla */

                for ($i = 0; $i < count($arrData); $i++) {

                    if ($arrData[$i]['estado_excusa'] === "Por revisar") {
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

                    /* if ($arrData[$i]['estado_excusa'] === "Sin excusa") {
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
                    $arrData[$i]['options'] =  $btnAprobar . " " . " " . $btnRechazar;*/
                }
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function setExcusas()
    {
        $file = ($_FILES['excusa']);
        $fileName = basename($file["name"]);
        $idExcusa = strClean($_POST['idexcusa']);
        $idAprendiz = strClean($_POST['idAprendiz']);
        $idInasistencia = strClean($_POST['idInasistencia']);

        $targetFile = $this->targetDir . uniqid() . $fileName;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        /* $arrPost = ['idexcusa', 'idAprendiz', 'idInasistencia']; */

        // Verificar si el archivo es un PDF
        if ($fileType != "pdf") {
            $arrRespuesta = array('status' => false, 'msg' => 'Solo se permiten archivos PDF.');
        }
        // Verificar si el archivo ya existe
        elseif (file_exists($targetFile)) {
            $arrRespuesta = array('status' => false, 'msg' => 'El archivo ya existe.');
        } elseif ($idExcusa == 0 || $idExcusa == "") {

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

            // Intentar mover el archivo al directorio de destino
            if (move_uploaded_file($file["tmp_name"], $targetFile)) {

                $requestModel = $this->model->editarExcusa($fileName, $targetFile, $idExcusa);
                $arrRespuesta = array('status' => true, 'msg' => 'Excusa actualizada correctamente.');
            } else {
                $arrRespuesta = array('status' => false, 'msg' => 'Error al mover el archivo: ' . print_r(error_get_last(), true));
            }
        }

        echo json_encode($arrRespuesta, JSON_UNESCAPED_UNICODE);
        die();
    }

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
            $motivo = strClean($_POST['motivo_rechazo']);
            $request = $this->model->rechazarExcusa($idexcusa, $motivo);
            if ($request == 'empty') {
                $arrResponse = array('status' => false, 'msg' => 'Error al rechazar la excusa.');
            } elseif ($request == 'Rechazada') {
                $arrResponse = array('status' => true, 'msg' => 'Excusa rechazada correctamente.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            print_r($_POST);
        }
        die();
    }

    public function descargarExcusa()
    {
        if (isset($_GET['idexcusa'])) {
            $id = $_GET['idexcusa'];

            $response = $this->model->getFilePath($id);

            // Verificar si el archivo existe
            if (!empty($response) && isset($response[0]['filepath_excusa'])) {
                $filepath = $response[0]['filepath_excusa'];

                // Verificar si el archivo existe
                if ($filepath && file_exists($filepath)) {
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

    public function getMotivoRechazo($idexcusa)
    {
        $intIdExcusa = intval(strClean($idexcusa));

        if ($intIdExcusa > 0) {
            $arrData = $this->model->selectMotivoRechazo($intIdExcusa);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
}
