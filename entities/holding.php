<?php
class holding{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idHolding'=>$data['idHolding'],
                'nomHolding'=>$data['nomHolding'],
        );
        $this->setArray = $resultado;
    }
	
	public function insert(){
		$data = $this->setArray;
		$consulta = "	INSERT INTO holding VALUES(
						NULL, '{$data['nomHolding']}'
						);		
					";
		mysql_query($consulta) or die(mysql_error());
		return mysql_insert_id();
	}
	
	public function getIDByName($nomHolding){
		$consulta = "	SELECT id_holding
						FROM holding
						WHERE nom_holding LIKE '$nomHolding';
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$holding = mysql_result($resultado, 0, 'id_holding');
		}else{
			$holding = 0;
		}
		mysql_free_result($resultado);
		return $holding;
	}
	
	public function getCombo(){
            
		$consulta = "	SELECT h.id_holding, nom_holding FROM holding h
                                INNER JOIN empresa e ON h.id_holding = e.id_holding
                                INNER JOIN campana c ON e.id_empresa = c.id_empresa
                                INNER JOIN usuario_campana_reporte ucr ON c.id_campana = ucr.id_campana
                                WHERE est_campana>=0 AND ucr.id_usuario = ".$_SESSION['usuario']['id'];
                
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			while($fila = mysql_fetch_array($resultado)){
				$holding[] = array(
					'id'=>$fila['id_holding'],
					'nombre'=>$fila['nom_holding'],
				);
			}
		}else{
			$holding = "";
		}
		mysql_free_result($resultado);
		return $holding;
	}
}
?>