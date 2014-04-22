<?php
define('SERVER', 'localhost');
define('DB', 'dhocompe_ais_final');
define('USER', 'root');
define('PASS', '');
//define('user', 'dhocompe');
//define('pass', '_-C0nSu1t0r32-D40_2013_@Dm1NdH02o1l_2013');
define('images', 'img/');
define('RESOURCES', 'resources/');
define('ENTITIES', 'entities/');
define('SCRIPTS', 'js/');
define('CSS', 'css/');
define('TEMPLATES', 'templates/');
define('sizeImg', ' height="24" width="24" ');
define('sizeImg2', ' height="72" width="72" ');
define('sizeImg3', ' height="36" width="36" ');
define('sizeImg4', ' height="100" width="100" ');
define('preURL', '/ata/');
//define('preURL', '/');
define('baseURL', 'localhost'.preURL);
//define('baseURL', 'ais.dho.com.pe'.preURL);

ini_set("session.gc_maxlifetime","14400");

session_start();
require_once(RESOURCES.'conexion.php');
$conexion = new conexion();
$conexion->conectarDB();
?>