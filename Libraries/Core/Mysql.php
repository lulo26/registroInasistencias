<?php

class Mysql extends Conexion
{
    private $conexion;
    private $strquery;
    private $arrValues;

    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->conect();
    }

    public function insert(string $query, array $arrValues)
    {
        $this->strquery = $query;
        $this->arrValues = $arrValues;

        $insert = $this->conexion->prepare($this->strquery);
        $resInsert = $insert->execute($this->arrValues);
        if ($resInsert) {
            $lastInsert = $this->conexion->lastInsertId();
        } else {
            $lastInsert = 0;
        }

        return $lastInsert;
    }
    public function select(string $query)
    {
        $this->strquery = $query;
        $result = $this->conexion->prepare($this->strquery);
        $result->execute();
        $data = $result->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function select_all(string $query)
    {
        $this->strquery = $query;
        $result = $this->conexion->prepare($this->strquery);
        $result->execute();
        $data = $result->fetchall(PDO::FETCH_ASSOC);
        return $data;
    }

    public function update(string $query, array $arrValues)
    {
        $this->strquery = $query;
        $this->arrValues = $arrValues;
        $update = $this->conexion->prepare($this->strquery);
        $resExecute = $update->execute($this->arrValues);
        return $resExecute;
    }
    public function efectuarConsulta($consulta, $parametros = [], $tipos = '')
    {
        try {
            $stmt = $this->conexion->prepare($consulta);
            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $this->conexion->errorInfo());
            }

            // Vincular parámetros (para PDO usamos bindValue o bindParam)
            if ($parametros) {
                // Si tienes parámetros, necesitas usar bindValue (PDO no usa bind_param)
                $i = 0;
                foreach ($parametros as $parametro) {
                    $stmt->bindValue(++$i, $parametro, PDO::PARAM_STR); // Puedes cambiar el tipo según sea necesario
                }
            }

            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC); // Para obtener todos los resultados en un array asociativo

            if ($resultado) {
                return $resultado;
            } else {
                return $stmt->rowCount(); // Para consultas que no devuelven un conjunto de resultados
            }
        } catch (Exception $e) {
            die("Excepción capturada: " . $e->getMessage());
        }
    }



    public function delete(string $query)
    {
        $this->strquery = $query;
        $result = $this->conexion->prepare($this->strquery);
        $del = $result->execute();
        return $del;
    }
}
