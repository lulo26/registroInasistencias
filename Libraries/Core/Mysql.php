<?php

<<<<<<< HEAD
<<<<<<< HEAD
class Mysql extends Conexion
{
=======
class Mysql extends Conexion{
>>>>>>> 670947a49ff133b601f3e0132ad63ddec737f499
=======
class Mysql extends Conexion
{
>>>>>>> 11f7576d73de982abc352ce3b69677d31486c7b1
    private $conexion;
    private $strquery;
    private $arrValues;

<<<<<<< HEAD
<<<<<<< HEAD
    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->conect();
    }

    public function insert(string $query, array $arrValues)
    {
=======
    function __construct(){
=======
    function __construct()
    {
>>>>>>> 11f7576d73de982abc352ce3b69677d31486c7b1
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->conect();
    }

<<<<<<< HEAD
    public function insert(string $query, array $arrValues){
>>>>>>> 670947a49ff133b601f3e0132ad63ddec737f499
=======
    public function insert(string $query, array $arrValues)
    {
>>>>>>> 11f7576d73de982abc352ce3b69677d31486c7b1
        $this->strquery = $query;
        $this->arrValues = $arrValues;

        $insert = $this->conexion->prepare($this->strquery);
        $resInsert = $insert->execute($this->arrValues);
<<<<<<< HEAD
<<<<<<< HEAD
        if ($resInsert) {
            $lastInsert = $this->conexion->lastInsertId();
        } else {
=======
        if($resInsert){
            $lastInsert = $this->conexion->lastInsertId();
        }else{
>>>>>>> 670947a49ff133b601f3e0132ad63ddec737f499
=======
        if ($resInsert) {
            $lastInsert = $this->conexion->lastInsertId();
        } else {
>>>>>>> 11f7576d73de982abc352ce3b69677d31486c7b1
            $lastInsert = 0;
        }

        return $lastInsert;
    }
<<<<<<< HEAD
<<<<<<< HEAD
    public function select(string $query)
    {
=======
    public function select(string $query){
>>>>>>> 670947a49ff133b601f3e0132ad63ddec737f499
=======

    public function select(string $query)
    {
>>>>>>> 11f7576d73de982abc352ce3b69677d31486c7b1
        $this->strquery = $query;
        $result = $this->conexion->prepare($this->strquery);
        $result->execute();
        $data = $result->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

<<<<<<< HEAD
<<<<<<< HEAD
    public function select_all(string $query)
    {
=======
    public function select_all(string $query){
>>>>>>> 670947a49ff133b601f3e0132ad63ddec737f499
=======
    public function select_all(string $query)
    {
>>>>>>> 11f7576d73de982abc352ce3b69677d31486c7b1
        $this->strquery = $query;
        $result = $this->conexion->prepare($this->strquery);
        $result->execute();
        $data = $result->fetchall(PDO::FETCH_ASSOC);
        return $data;
    }

<<<<<<< HEAD
<<<<<<< HEAD
    public function update(string $query, array $arrValues)
    {
=======
    public function update(string $query, array $arrValues){
>>>>>>> 670947a49ff133b601f3e0132ad63ddec737f499
=======
    public function update(string $query, array $arrValues)
    {
>>>>>>> 11f7576d73de982abc352ce3b69677d31486c7b1
        $this->strquery = $query;
        $this->arrValues = $arrValues;
        $update = $this->conexion->prepare($this->strquery);
        $resExecute = $update->execute($this->arrValues);
        return $resExecute;
    }
<<<<<<< HEAD
    public function efectuarConsulta($consulta, $parametros = [], $tipos = '')
    {
        try {
            $stmt = $this->conexion->prepare($consulta);
            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $this->conexion->error);
            }
            if ($parametros) {
                $stmt->bind_param($tipos, ...$parametros);
            }
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado) {
                $stmt->close();
                return $resultado;
            } else {
                $stmt->close();
                return $this->conexion->affected_rows; // Para consultas que no devuelven un
                //conjunto de resultados
            }
        } catch (Exception $e) {
            die("Excepción capturada: " . $e->getMessage());
        }
    }


    public function delete(string $query)
    {
=======

<<<<<<< HEAD
    public function delete(string $query){
>>>>>>> 670947a49ff133b601f3e0132ad63ddec737f499
=======
    public function delete(string $query)
    {
>>>>>>> 11f7576d73de982abc352ce3b69677d31486c7b1
        $this->strquery = $query;
        $result = $this->conexion->prepare($this->strquery);
        $del = $result->execute();
        return $del;
    }
<<<<<<< HEAD
<<<<<<< HEAD
}
=======
}
>>>>>>> 670947a49ff133b601f3e0132ad63ddec737f499
=======
}
>>>>>>> 11f7576d73de982abc352ce3b69677d31486c7b1
