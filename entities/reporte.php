<?php
class reporte{

	var $setArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idReporte'=>$data['idReporte'],
                'idCampana'=>$data['idCampana'],
                'nomReporte'=>$data['nomReporte'],
                'descrReporte'=>$data['descrReporte'],
                'estReporte'=>$data['estReporte'],
                'usuCrea'=>$data['usuCrea'],
                'usuEdita'=>$data['usuEdita'],
                'fechCrea'=>$data['fechCrea'],
                'fechEdita'=>$data['fechEdita']
        );
        $this->setArray = $resultado;
    }
	
	public function insert(){
		$data = $this->setArray;
		$consulta = "	INSERT INTO reporte VALUES(
						NULL, {$data['idCampana']}, '{$data['nomReporte']}',
						'{$data['descrReporte']}', {$data['estReporte']}, 
						{$data['usuCrea']}, NULL, NOW(), NULL
						);		
					";
					//echo $consulta;
		mysql_query($consulta) or die(mysql_error());
		return mysql_insert_id();
	}
	
	public function update(){
		$data = $this->setArray;
		$consulta = "	UPDATE reporte SET
						id_campana={$data['idCampana']}, 
						nom_reporte='{$data['nomReporte']}',
						descr_reporte='{$data['descrReporte']}', 
						est_reporte={$data['estReporte']},
						usu_edita='{$data['usuEdita']}',
						fech_edita=NOW()
						WHERE id_reporte = {$data['idReporte']};		
					";
		mysql_query($consulta) or die(mysql_error());
		return mysql_affected_rows();
	}
	
	public function updateStatus($idReporte, $estReporte=-1){
		$consulta = "	UPDATE reporte SET est_reporte = {$estReporte} WHERE id_reporte = $idReporte;
					";
		mysql_query($consulta) or die(mysql_error());
		return mysql_affected_rows();
	}
	
	public function get($idReporte){
		$consulta = "	SELECT id_reporte, id_campana, nom_reporte, 
						descr_reporte, est_reporte
						FROM reporte
						WHERE id_reporte = $idReporte;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$reporte = array(
				'idReporte'=>mysql_result($resultado, 0, 'id_reporte'),
				'idCampana'=>mysql_result($resultado, 0, 'id_campana'),
				'nomReporte'=>mysql_result($resultado, 0, 'nom_reporte'),
				'descrReporte'=>mysql_result($resultado, 0, 'descr_reporte'),
				'estReporte'=>mysql_result($resultado, 0, 'est_reporte')
			);
		}else{
			$reporte = "";
		}
		mysql_free_result($resultado);
		return $reporte;
	}
	
	public function show($buscar="", $pag = ""){
		
		$sentido = "";
		$orden = "";
		$limite = "";
		
		if(is_array($pag)){
			if($pag['colPag']<>""){			
				if($pag['ascPag']){
					$sentido = "ASC";
				}else{
					$sentido = "DESC";
				}
				$orden = "ORDER BY {$pag['colPag']} $sentido";
			}
			
			$pag['actualPag'] *= $pag['cantPag'];
			
			$limite = "LIMIT {$pag['actualPag']}, {$pag['cantPag']}";
		}
		
		$condicion = "";
		if($buscar<>""){
			$condicion .= "	AND (r.nom_reporte LIKE '%$buscar%' OR r.nom_campana LIKE '%$buscar%')";
		}
				
		$consulta = " 	SELECT r.id_reporte AS 'ID', c.nom_campana AS 'Campa&ntilde;a', 
						r.nom_reporte AS 'Nombre del Reporte', 
						r.descr_reporte AS 'Descripci&oacute;n',
						CASE WHEN est_reporte=1 THEN 'Activo'
						WHEN est_reporte=0 THEN 'Inactivo' END AS 'Estado'
						FROM reporte r
						LEFT OUTER JOIN campana c ON r.id_campana = c.id_campana
						WHERE r.est_reporte >= 0
						$condicion
						$orden
						$limite
						; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			require_once(RESOURCES.'general.php');
			$general = new general();
			$reporte = $general->consulta($resultado);
		}else{
			$reporte = "";
		}
		mysql_free_result($resultado);
		return $reporte;
	}	
	
	public function numRows($buscar=''){
		$condicion = "";
		if($buscar<>""){
			$condicion .= "	AND (r.nom_reporte LIKE '%$buscar%' OR r.nom_campana LIKE '%$buscar%')";
		}
		$consulta = "	SELECT COUNT(r.id_reporte) AS 'total'
						FROM reporte r
						LEFT OUTER JOIN campana c ON r.id_campana = c.id_campana
						WHERE r.est_reporte >= 0
						$condicion;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$reporte = mysql_result($resultado, 0, "total");
		}else{
			$reporte = 0;
		}
		mysql_free_result($resultado);
		$this->numRows = $reporte;
	}
	
	public function getAllInfoCampaign($idCampana){
		if($idCampana==''){
			$idCampana = 0;
		}
		$consulta = "	SELECT c.id_campana, e.id_empresa, h.id_holding
						FROM reporte r
						INNER JOIN campana c ON r.id_campana = c.id_campana
						INNER JOIN empresa e ON c.id_empresa = e.id_empresa
						INNER JOIN holding h ON e.id_holding = h.id_holding
						WHERE r.id_campana = $idCampana;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		$reporte = array();
		if(mysql_num_rows($resultado)>0){
			$reporte['idCampana'] = mysql_result($resultado, 0, 'id_campana');
			$reporte['idEmpresa'] = mysql_result($resultado, 0, 'id_empresa');
			$reporte['idHolding'] = mysql_result($resultado, 0, 'id_holding');
		}else{
			$reporte['idCampana'] = 0;
			$reporte['idEmpresa'] = 0;
			$reporte['idHolding'] = 0;
		}
		mysql_free_result($resultado);
		return $reporte;
	}
	
	public function getByCampaignID($idCampana){
		if($idCampana==''){
			$idCampana = 0;
		}
		$consulta = "	SELECT id_reporte, nom_reporte, descr_reporte
						FROM reporte
						WHERE id_campana = $idCampana AND est_reporte>=0 
						OR id_campana IS NULL;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$reporte = array();
			while($fila = mysql_fetch_array($resultado)){
				$reporte[] = array(
					'id'=>$fila['id_reporte'],
					'nombre'=>$fila['nom_reporte'],
					'descripcion'=>$fila['descr_reporte']
				);
			}
		}else{
			$reporte = 0;
		}
		mysql_free_result($resultado);
		return $reporte;
	}
}
?>