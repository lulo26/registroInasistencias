<?php

class Reportes extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function aprendiz()
    {

        $data['page_title'] = "reportes";
        $data['page_id_name'] = "reportes";
        $data['page_functions_js'] = "reportes/reportes.js";

        $this->views->getView($this, "reportes", $data);
    }


}
?>