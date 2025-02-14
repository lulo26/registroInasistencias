<?php
class RfidModel extends Mysql {
    public function __construct() {
        parent::__construct();

    }
    public function insertarInasistencia($codigo,$fechaHora) {
        
    } 
    public function buscarCodigo(string $codigo){
        $this->codigo=$codigo;
        $sql = "SELECT * FROM aprendices WHERE codigo_aprendiz = '{$this->codigo}'";
        $request = $this->select($sql);
        return $request;
    }

}
?>
