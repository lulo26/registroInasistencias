<?php


class ReporteModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function selectForAprendiz(string $fechaInicio, string $fechaFin, int $idAprendiz)
    {
        $return = "";

        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->idAprendiz = $idAprendiz;

        $sql = "SELECT (inasistencias.fecha_inasistencia,inasistencias.estado_inasistencia,inasistencias.fecha_inasistencia,inasistencias.hora_inasistencia,inasistencias.retardos_inasistencia,aprendices.nombre_aprendiz,aprendices.apellido_aprendiz)
        JOIN aprendices ON aprendices.idaprendiz=inasistencias.aprendices_idusuario 
        WHERE idaprendiz=? and inasistencias.fecha_inasistencia BETWEEN ? AND ?";
        $arrData = array($this->idAprendiz, $this->fechaInicio, $this->fechaFin);
        $request = $this->select_all($sql, $arrData);
        return $request;
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

        $sql = "SELECT * FROM aprendices where estado_aprendiz=1";
        $request = $this->select_all($sql);
        return $request;
    }


}