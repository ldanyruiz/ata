<?php
define('SERVER', 'localhost');
define('DB', 'dhocompe_ais');
//define('user', 'root');
//define('pass', '');
define('USER', 'dhocompe');
define('SCRIPTS', 'js/');
define('CSS', 'css/');
define('TEMPLATES', 'templates/');
define('sizeImg', ' height="24" width="24" '); 
define('sizeImg2', ' height="72" width="72" ');
define('sizeImg3', ' height="36" width="36" ');
define('sizeImg4', ' height="100" width="100" ');
//define('preURL', '/ais/');
define('preURL', '/////');
//define('baseURL', 'localhost'.preURL);
define('baseURL', 'ais.dho.com.pe'.preURL);
define('baseURL1', 'ais.dho.com.pe'.preURL);

ini_set("session.gc_maxlifetime","14500");
session_start();
require_once(RESOURCES.'conexion.php');

$conexion = new conexion();
echo 'zzzzzzzzzzzzzzz';
$conexion->conectarDB();
?>