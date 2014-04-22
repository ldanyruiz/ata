<?php
class nivel{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idNivel'=>$data['idNivel'],
                'idNivelTipo'=>$data['idNivelTipo'],
                'nomNivel'=>$data['nomNivel'],
                'depenNivel'=>$data['depenNivel']
        );
        $this->setArray = $resultado;
    }
	
	public function insert(){
		$data = $this->setArray;
		$consulta = "	INSERT INTO nivel VALUES(
						NULL, {$data['idNivelTipo']}, '{$data['nomNivel']}', {$data['depenNivel']}
						);		
					";
		mysql_query($consulta) or die(mysql_error());
		return mysql_insert_id();
	}
	
	public function update(){
		$data = $this->setArray;
		$consulta = "	UPDATE nivel SET
						id_nivel_tipo={$data['idNivelTipo']}, 
						nom_nivel='{$data['nomNivel']}', 
						depen_nivel={$data['depenNivel']}
						WHERE id_nivel = {$data['idNivel']};
					";
		mysql_query($consulta) or die(mysql_error());
		return mysql_affected_rows();
	}
	
	public function get($idNivel){
		$consulta = "	SELECT id_nivel, id_nivel_tipo, nom_nivel, depen_nivel
						FROM nivel
						WHERE id_nivel = $idNivel;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$nivel = array(
				'idNivel' => mysql_result($resultado, 0, 'id_nivel'),
				'idNivelTipo' => mysql_result($resultado, 0, 'id_nivel_tipo'),
				'nomNivel' => mysql_result($resultado, 0, 'nom_nivel'),
				'depenNivel' => mysql_result($resultado, 0, 'depen_nivel')
			);
		}else{
			$nivel = 0;
		}
		mysql_free_result($resultado);
		$this->setArray = $nivel;
	}
	
	public function getIDByNameAndDepenAndIDType($nomNivel, $depenNivel, $idNivelTipo){
		$consulta = "	SELECT id_nivel
						FROM nivel
						WHERE nom_nivel LIKE '$nomNivel'
						AND depen_nivel = $depenNivel
						AND id_nivel_tipo = $idNivelTipo;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$nivel = mysql_result($resultado, 0, 'id_nivel');
		}else{
			$nivel = 0;
		}
		mysql_free_result($resultado);
		return $nivel;
	}
	
	public function getSimpleByCampaignID($idCampana){
		require_once(ENTITIES.'nivelTipo.php');
		$nivelTipo = new nivelTipo();
		
		$total = count($nivelTipo->getForCampaign($idCampana));
		
		$campo = "";
		$join = "";
		if($total>1){
			for($i=2; $i<=$total; $i++){
				$campo .= ", n{$i}.id_nivel AS 'id{$i}', n{$i}.nom_nivel AS 'nom{$i}' ";
				$join .= " INNER JOIN nivel n{$i} ON n{$i}.depen_nivel = n".($i-1).".id_nivel ";
			}
		}
		
		
		$consulta = "	SELECT DISTINCT n1.id_nivel AS 'id1', n1.nom_nivel AS 'nom1'
						$campo , 1
						FROM nivel n1
						INNER JOIN nivel_tipo nt ON n1.id_nivel_tipo
						$join
						WHERE nt.id_campana = $idCampana
						AND n1.depen_nivel = 0;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$nivel = array();
			$j = 1;
			while($fila = mysql_fetch_array($resultado)){
				for($i=1; $i<=$total; $i++){
					$nivel[$j][$i]['id'] = $fila['id'.$i];
					$nivel[$j][$i]['nom'] = $fila['nom'.$i];
				}
				$j++;
			}
		}else{
			$nivel = 0;
		}
		mysql_free_result($resultado);
		return $nivel;
	}
	
	public function getCombo($idNivelTipo='', $depenNivel=''){
		$where = "";
		if($idNivelTipo<>''){
			$where .= " AND id_nivel_tipo = $idNivelTipo ";
		}
		
		if($depenNivel<>''){
			$where .= " AND depen_nivel = $depenNivel ";
		}
		$consulta = "	SELECT id_nivel, nom_nivel
						FROM nivel
						WHERE TRUE
						$where;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			while($fila = mysql_fetch_array($resultado)){
				$nivel[] = array(
					'id'=>$fila['id_nivel'],
					'nombre'=>$fila['nom_nivel']
				);
			}
		}else{
			$nivel = "";
		}
		mysql_free_result($resultado);
		return $nivel;
	}
}
?>