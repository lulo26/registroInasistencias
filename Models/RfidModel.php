<?php
class RfidModel extends Mysql {
    public function __construct() {
        parent::__construct();

    }
/*     public function insertarCodigo($codigo,$fechaHora) {
        $sql = "INSERT INTO rgistros_rfid (codigoRfid, fechaRfid) VALUES (:codigo, :fechaHora)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->bindParam(':fechaHora', $fechaHora);
        return $stmt->execute();
    } */
    public function buscarCodigo(string $codigo){
        $this->codigo=$codigo;
        $sql = "SELECT codigoRfid FROM rgistros_rfid WHERE id = '{$this->codigo}'";
        $request = $this->select($sql);
        return $request;
    }
}
?>
