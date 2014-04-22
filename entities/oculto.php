<?php
class oculto{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idOculto'=>$data['idOculto'],
                'idPregunta'=>$data['idPregunta'],
                'idCampana'=>$data['idCampana']
        );
        $this->setArray = $resultado;
    }
	
	public function insert(){
		$data = $this->setArray;
		$consulta = "	INSERT INTO oculto VALUES(
						NULL, {$data['idPregunta']}, {$data['idCampana']}
						);		
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
	}
	
	public function deleteByCampaignID($idCampana){
		$data = $this->setArray;
		$consulta = "	DELETE FROM oculto WHERE id_campana = $idCampana;";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
	}
	
	public function getByCampaignID($idCampana){
		$data = $this->setArray;
		$consulta = "	SELECT id_pregunta
						FROM oculto
						WHERE id_campana = $idCampana;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$oculto = array();
			while($fila=mysql_fetch_array($resultado)){
				$oculto[] = $fila['id_pregunta'];
			}
		}else{
			$oculto = 0;
		}
		mysql_free_result($resultado);
		return $oculto;
	}
}
?>