<?php
require_once('config.php');
class conexion{	
	public function conectarDB(){
		$link = mysql_connect(SERVER, USER, PASS) or die("No se puede conectar al servidor.");
		mysql_select_db(DB, $link) or die ("No se puede conectar a la base de datos");
                mysql_query("SET NAMES utf8;");
                mysql_query("SET COLLATION_CONNECTION = latin1_spanish_ci;");                
		return $link;
	}
	public function transaction($op){
		$link = $this->conectarDB();
		switch($op){
			case 1:
				$bool = mysql_query("START TRANSACTION", $link);
			break;
			case 2:
				$bool = mysql_query("COMMIT;", $link);
			break;
			case 3:
				$bool = mysql_query("ROLLBACK;", $link);
			break;
		}
		return $bool;
	}
}
?>