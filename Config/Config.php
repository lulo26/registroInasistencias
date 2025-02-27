<?php

const BASE_URL = "http://localhost/registroInasistencias";


$modo = "LOCAL"; //LOCAL || REMOTO

/* --LOCAL */
const DB_HOST = "localhost";
const DB_NAME = "inasistencias";
const DB_USER = "root";
const DB_PASSWORD = "";
const DB_PORT = 3306;


const DB_CHARSET = "utf8";
//Zona horaria
date_default_timezone_set('America/Bogota');

//Datos de conexión a Base de Datos


//Delimitadores decimal y millar Ej. 24,1989.00
const SPD = ",";
const SPM = ".";

//Simbolo de moneda
const SMONEY = "$";
