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
       dep($respuesta);
       
    }
}
?>
<!--  if($_POST){
            $arrCheck = array('TxtRfid');
            if(check_post($arrCheck)){
                
            }
        } -->