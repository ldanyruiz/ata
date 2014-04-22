<?php
class empresa{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idEmpresa'=>$data['idEmpresa'],
                'idHolding'=>$data['idHolding'],
                'nomEmpresa'=>$data['nomEmpresa'],
        );
        $this->setArray = $resultado;
    }
	
	public function insert(){
		$data = $this->setArray;
		$consulta = "	INSERT INTO empresa VALUES(
						NULL, {$data['idHolding']}, '{$data['nomEmpresa']}'
						);		
					";
		mysql_query($consulta) or die(mysql_error());
		return mysql_insert_id();
	}
	
	public function getNameByID($idEmpresa){
		$consulta = "	SELECT nom_empresa
						FROM empresa
						WHERE id_empresa = $idEmpresa
						;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$empresa = mysql_result($resultado, 0, 'nom_empresa');
		}else{
			$empresa = "";
		}
		mysql_free_result($resultado);
		return $empresa;
	}
	
	public function getNameByIDCampaign($idCampana){
		$consulta = "	SELECT e.nom_empresa
						FROM empresa e
						INNER JOIN campana c ON c.id_empresa = e.id_empresa
						WHERE c.id_campana = $idCampana
						;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$empresa = mysql_result($resultado, 0, 'nom_empresa');
		}else{
			$empresa = "";
		}
		mysql_free_result($resultado);
		return $empresa;
	}
	
	public function getIDByNameAndHolding($nomEmpresa, $idHolding){
		$consulta = "	SELECT id_empresa
						FROM empresa
						WHERE nom_empresa LIKE '$nomEmpresa'
						AND id_holding = $idHolding;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$empresa = mysql_result($resultado, 0, 'id_empresa');
		}else{
			$empresa = "";
		}
		mysql_free_result($resultado);
		return $empresa;
	}
	
	public function getCombo($idHolding=0, $filtrado=true){
		$where = "";
		if($filtrado){
			$where = "WHERE id_holding = $idHolding";
		}
		$consulta = "	SELECT id_empresa, nom_empresa
						FROM empresa
						$where
						;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			while($fila = mysql_fetch_array($resultado)){
				$empresa[] = array(
					'id'=>$fila['id_empresa'],
					'nombre'=>$fila['nom_empresa'],
				);
			}
		}else{
			$empresa = "";
		}
		mysql_free_result($resultado);
		return $empresa;
	}
}
?>