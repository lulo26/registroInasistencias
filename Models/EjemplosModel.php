<?php

// la clase se debe llamar exactamente a como se llama el archivo .php del modelo, incluyendo mayusculas
class EjemplosModel extends Mysql{
    public function __construct(){
        parent::__construct();
    }

    //ejemplos:

    // ejemplo select
    public function ejemploSelect(){
        $sql = "SELECT * FROM `table`";
        $request = $this->select_all($sql);
        return $request;
    }

    // ejemplo insertar
    public function ejemploInsertat(int $variable){

        $this->variable = $variable;

        $sql = "INSERT INTO `table` (`data`) VALUES (?)";
        $arrData = array($this->variable);
        return $this->insert($sql, $arrData);
    }

    // ejemplo editar
    public function ejemploEditar(int $id, int $variable){
        $return = "";

        $this->variable = $variable;
        $this->id = $id;

        $sql = "SELECT `iddata` FROM `table` WHERE `iddata` = '{$this->id}'";
        $request = $this->select_all($sql);

        if(!empty($request)){
            $query = "UPDATE `table` SET `data` = ? WHERE `iddata` = ?";
            $arrData = array($this->variable, $this->id);
            $request_insert = $this->insert($query, $arrData);
            $return = $request_insert;
        } else {
            $return = "empty";
        }
        return $return;
    }

    // ejemplo eliminar
    public function ejemploEliminar(int $id){
        $return = "";

        $this->id = $id;

        $sql = "SELECT * FROM `table` WHERE `iddata` = '{$this->id}'";
        $request = $this->select_all($sql);
        if(!empty($request)){
            $query = "DELETE FROM `table` WHERE `iddata` = ?";
            $arrData = array($this->id);
            $request_insert = $this->insert($query, $arrData);
            $return = $request_insert;
        } else {
            $return = "empty";
        }
        return $return;
    }

}

?>