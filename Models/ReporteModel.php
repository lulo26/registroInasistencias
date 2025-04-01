<?php


class ReporteModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function selectForAprendiz(string $fechaInicio, string $fechaFin, int $idAprendiz)
    {

        $fechaInicio = date('Y-m-d', strtotime($fechaInicio));
        $fechaFin = date('Y-m-d', strtotime($fechaFin));

        $sql = "SELECT 
            inasistencias.fecha_inasistencia,
            inasistencias.estado_inasistencia,
            inasistencias.hora_inasistencia,
            inasistencias.retardos_inasistencia,
            aprendices.nombre_aprendiz,
            aprendices.apellido_aprendiz
        FROM inasistencias
        INNER JOIN aprendices ON aprendices.idaprendiz = inasistencias.aprendices_idusuario
        WHERE inasistencias.aprendices_idusuario = ? 
        AND DATE(inasistencias.fecha_inasistencia) BETWEEN ? AND ?";

        $arrData = [$idAprendiz, $fechaInicio, $fechaFin];

        return $this->select_all2($sql, $arrData);
    }


    public function selectForFicha(string $fechaInicio, string $fechaFin, int $idficha)
    {
        $return = "";

        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->idficha = $idficha;

        $sql = "SELECT (inasistencias.fecha_inasistencia,inasistencias.estado_inasistencia,inasistencias.fecha_inasistencia,inasistencias.hora_inasistencia,inasistencias.retardos_inasistencia,aprendices.nombre_aprendiz,aprendices.apellido_aprendiz)
        JOIN aprendices ON aprendices.idaprendiz=inasistencias.aprendices_idusuario 
        WHERE inasistencias.fecha_inasistencia BETWEEN ? AND ?";
        $request = $this->select_all($sql, );
        return $request;
    }

    public function getAprendices()
    {
        $return = "";

        $sql = "SELECT aprendices.idaprendiz,aprendices.nombre_aprendiz,apellido_aprendiz FROM aprendices where estado_aprendiz=1";
        $request = $this->select_all($sql);
        return $request;
    }

    public function getFichas()
    {
        $return = "";

        $sql = "SELECT fichas.idficha,fichas.numero_ficha FROM fichas ";
        $request = $this->select_all($sql);
        return $request;
    }



}