<?php
class Rfid extends Controllers{
    public function __construct(){
        parent::__construct();
    }
    public function rfid() {
        $data['page_title'] = "CodigoRfid";
        $data['page_id_name'] = "CodigoRfid";
        $data['page_functions_js'] = "aprendices/CodigoRfid.js";

        $this->views->getView($this,"rfid", $data); 
    }
    public function buscarCodigo($codigo){
       $srtCodigo = strClean($codigo);
       $respuesta = $this->model->buscarCodigo($srtCodigo);
       
       if (!empty($respuesta)) {
        $arrResponse = array('estado'=>true,'data'=>$srtCodigo);
       } else {
        $arrResponse = array('estado'=>false,'mensaje'=>"no se encontro el codigo: ".$srtCodigo);
       }
       echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    }
}
?>
<!--  if($_POST){
            $arrCheck = array('TxtRfid');
            if(check_post($arrCheck)){
                
            }
        } -->