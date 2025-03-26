<?php 

class Horarios extends Controllers{
    public function __construct(){
        parent::__construct();
        session_start();
        if(empty($_SESSION['login'])){
            header('Location: ' . base_url().'/login' );
        }
    }
    public function horarios(){


        $data['page_title'] = "Horarios";
        $data['page_name'] = "horarios";
        $data['page_id_name'] = "horarios";
        $data['page_functions_js'] = "horarios/horarios.js";
        $this->views->getView($this,"Horarios", $data);
    }

    public function getHorarios(){
        $arrData = $this->model->selectHorarios();

        for ($i=0; $i < count($arrData); $i++) { 
            $btnEdit = "<button type='button' class='btn btn-primary rounded-pill' data-action-type='update' rel='".$arrData[$i]['idHorario']."'>
                    <i class='bi bi-pencil-square'></i>
                </button>";
            $btnDelete = "<button type='button' class='btn btn-danger rounded-pill' data-action-type='delete' rel='".$arrData[$i]['idHorario']."'>
                <i class='bi bi-trash-fill'></i>
                </button>";
            $arrData[$i]['options'] =  $btnDelete . " " . " " . $btnEdit;
                
        }

        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    } 

    public function getHorarioByID($idHorario){

        $intIdHorario = intval(strClean($idHorario));

        if($intIdHorario > 0){
    
            $arrData = $this->model->selectHorarioID($intIdHorario);
            if(empty($arrData)){
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
            }else{
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function setHorarios(){
        if ($_POST) {
            $statusLectura = true;
            $arrStatus = array();
            $insert = 0;
            $ficha  = intval(strClean($_POST['ficha']));

            $fichaEncontrada = $this->model->selectFicha($ficha);

            if (!empty($fichaEncontrada)) {

                for ($i=0; $i < count($_POST['fecha']); $i++) { 
    
                    $fecha = strClean($_POST['fecha'][$i]);
                    $horaInicio = intval(strClean($_POST['fechaIni'][$i]));
                    $horaFin = intval(strClean($_POST['fechaFin'][$i]));
                    $instructor = strClean($_POST['usuario'][$i]);
    
                    if (
                        check_post_var($fecha) && 
                        check_post_var($horaInicio) &&
                        check_post_var($horaFin) &&
                        check_post_var($instructor)) {

                        $arrFecha = explode('/', $fecha);
    
                        if(count($arrFecha) === 3) {
                            

                            $strFechaFormateada = $arrFecha[2]."/".$arrFecha[1]."/".$arrFecha[0];

                            $horaInicioFormateada = mktime($horaInicio,0,0);
                            $horaFinFormateada = mktime($horaFin,0,0);
                    
                            $horaInicioConvertida = date('H:i:s', $horaInicioFormateada);
                            $horaFinConvertida = date('H:i:s', $horaFinFormateada);
        
                            $horariosRegistrados = $this->model->selectHorarios($ficha, $strFechaFormateada, $horaInicioConvertida);
    
                            if (empty($horariosRegistrados)) {
                                    
                                $idInstructor = $this->model->selectInstructorByName($instructor);
    
                                if (!empty($idInstructor)) {
                                    $idInstructor = $idInstructor['idUsuarios'];
                                    $insert = $this->model->insertHorario($ficha, $strFechaFormateada, $horaInicioConvertida, $horaFinConvertida, $idInstructor);
        
                                    if (intval($insert) > 0) {
                                        $arrStatusMessage = array('index' => $i, 'status' => true, 'msg' => 'Registro insertado exitosamente');
                                        array_push($arrStatus,$arrStatusMessage);
                                    }else if($insert == 'exist'){
                                        $arrStatusMessage = array('index' => $i, 'status' => false, 'msg' => 'El registro ya existe');
                                        array_push($arrStatus,$arrStatusMessage);
                                    }else{
                                        $arrStatusMessage = array('index' => $i, 'status' => false, 'msg' => 'No se pudo insertar el registro');
                                        array_push($arrStatus,$arrStatusMessage);
                                    }
                                }else{
                                    $arrStatusMessage = array('index' => $i, 'status' => false, 'msg' => 'No se encontró el nombre del instructor');
                                    array_push($arrStatus,$arrStatusMessage);
                                }
                            }else{
                                $arrStatusMessage = array('index' => $i, 'status' => false, 'msg' => 'Ya existe un registro con la misma fecha y hora');
                                array_push($arrStatus,$arrStatusMessage);
                            }      
                        }else{
                            $arrStatusMessage = array('index' => $i, 'status' => false, 'msg' => 'La fecha contiene un formato inválido');
                            array_push($arrStatus,$arrStatusMessage);
                        }
    
                    }else{
                        $statusLectura = false;
                        break;
                    }
                }

                if (!empty($arrStatus)){
                    $arrResponse = array('statusCode' => 1, 'msg' => 'algunos registros no se insertaron correctamente: ', 'log' => $arrStatus);
                }else if($statusLectura){
                    $arrResponse = array('statusCode' => 0, 'msg' => 'registros del horario insertados correctamente');
                }else{
                    $arrResponse = array('statusCode' => 2, 'msg' => 'Uno o varios campos estan vacios o contienen datos inválidos');
                }

            }else{
                $arrResponse = array('statusCode' => 3, 'msg' => 'Se debe insertar una ficha valida');
            }



            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }

    public function eliminarHorario(){
        if ($_POST) {
            
            $requestDelete = $this->model->eliminarHorario($idHorario);
            if($requestDelete == 'empty'){
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el horario.');
            }else{$idficha = intval($_POST['idHorario']);
                $arrResponse = array('status' => true, 'msg' => 'se ha eliminado el horario.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }else{
            print_r($_POST);
        }
        die();
    }
}
