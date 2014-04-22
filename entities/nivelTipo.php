<?php
class nivelTipo{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idNivelTipo'=>$data['idNivelTipo'],
                'idCampana'=>$data['idCampana'],
                'nomNivelTipo'=>$data['nomNivelTipo'],
                'depenNivelTipo'=>$data['depenNivelTipo']
        );
        $this->setArray = $resultado;
    }
	
	public function insert(){
		$data = $this->setArray;
		$consulta = "	INSERT INTO nivel_tipo VALUES(
						NULL, {$data['idCampana']}, '{$data['nomNivelTipo']}', {$data['depenNivelTipo']}
						);		
					";
		mysql_query($consulta) or die(mysql_error());
		return mysql_insert_id();
	}
	
	public function getIDByName($nomNivelTipo){
		$consulta = "	SELECT id_nivel_tipo
						FROM nivel_tipo
						WHERE nom_nivel_tipo LIKE '$nomNivelTipo';
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$nivelTipo = mysql_result($resultado, 0, 'id_nivel_tipo');
		}else{
			$nivelTipo = 0;
		}
		mysql_free_result($resultado);
		return $nivelTipo;
	}
	
	public function getNameByID($idNivelTipo){
		$consulta = "	SELECT nom_nivel_tipo
						FROM nivel_tipo
						WHERE id_nivel_tipo = $idNivelTipo;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$nivelTipo = mysql_result($resultado, 0, 'nom_nivel_tipo');
		}else{
			$nivelTipo = 0;
		}
		mysql_free_result($resultado);
		return $nivelTipo;
	}
	
	public function getForCampaign($idCampana){
		$consulta = "	SELECT id_nivel_tipo, nom_nivel_tipo, depen_nivel_tipo
						FROM nivel_tipo
						WHERE id_campana = $idCampana;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			while($fila = mysql_fetch_array($resultado)){
				$nivelTipo[] = array(
					'id'=>$fila['id_nivel_tipo'],
					'nombre'=>$fila['nom_nivel_tipo'],
					'depende'=>$fila['depen_nivel_tipo']
				);
			}
		}else{
			$nivelTipo = "";
		}
		mysql_free_result($resultado);
		return $nivelTipo;
	}
}
?>