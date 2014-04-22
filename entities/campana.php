<?php
class campana{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idCampana'=>$data['idCampana'],
                'idEmpresa'=>$data['idEmpresa'],
                'nomCampana'=>$data['nomCampana'],
                'inicioCampana'=>$data['inicioCampana'],
                'finalCampana'=>$data['finalCampana'],
                'estCampana'=>$data['estCampana']
        );
        $this->setArray = $resultado;
    }
	
	public function insert(){
		$data = $this->setArray;
		$consulta = "	INSERT INTO campana VALUES(
						NULL, {$data['idEmpresa']}, '{$data['nomCampana']}',
						'{$data['inicioCampana']}', '{$data['finalCampana']}',
						{$data['estCampana']}
						);		
					";
		mysql_query($consulta) or die(mysql_error());
		return mysql_insert_id();
	}
	
	public function update(){
		$data = $this->setArray;
		$consulta = "	UPDATE campana SET
						id_empresa={$data['idEmpresa']}, 
						nom_campana='{$data['nomCampana']}',
						inicio_campana='{$data['inicioCampana']}', 
						final_campana='{$data['finalCampana']}',
						est_campana={$data['estCampana']}
						WHERE id_campana = {$data['idCampana']};		
					";
		mysql_query($consulta) or die(mysql_error());
		return mysql_affected_rows();
	}
	
	public function deleteCampaign($idCampana){
		$consulta = "	UPDATE campana SET est_campana = -1 WHERE id_campana = $idCampana;		
					";
		mysql_query($consulta) or die(mysql_error());
		return mysql_affected_rows();
	}
	
	public function getAll($idUsuario){
		$consulta = "	SELECT c.id_campana, h.nom_holding, e.nom_empresa, c.nom_campana,
						c.inicio_campana, c.final_campana, (TO_DAYS(c.final_campana) - TO_DAYS(NOW())) AS 'dias_campana'
						FROM campana c
						INNER JOIN empresa e ON c.id_empresa = e.id_empresa
						INNER JOIN holding h ON e.id_holding = h.id_holding
						INNER JOIN usuario_campana uc ON c.id_campana = uc.id_campana
						WHERE uc.id_usuario = $idUsuario
						AND c.est_campana = 1;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			while($fila = mysql_fetch_array($resultado)){
				$campana[] = array(
					'id'=>$fila['id_campana'],
					'holding'=>$fila['nom_holding'],
					'empresa'=>$fila['nom_empresa'],
					'nombre'=>$fila['nom_campana'],
					'inicio'=>date('d/m/Y', strtotime($fila['inicio_campana'])),
					'final'=>date('d/m/Y', strtotime($fila['final_campana'])),
					'restante'=>$fila['dias_campana']
				);
			}
		}else{
			$campana = "";
		}
		mysql_free_result($resultado);
		return $campana;
	}
	
	public function getCombo($idEmpresa=0){
		$consulta = "	SELECT id_campana, nom_campana
						FROM campana
						WHERE est_campana>=0 and id_empresa = $idEmpresa;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			while($fila = mysql_fetch_array($resultado)){
				$campana[] = array(
					'id'=>$fila['id_campana'],
					'nombre'=>$fila['nom_campana'],
				);
			}
		}else{
			$campana = "";
		}
		mysql_free_result($resultado);
		return $campana;
	}

	public function getAllCampanas(){
		$consulta = "	SELECT id_campana, nom_campana
						FROM campana
						WHERE est_campana>=0;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			while($fila = mysql_fetch_array($resultado)){
				$campana[] = array(
					'id'=>$fila['id_campana'],
					'nombre'=>$fila['nom_campana'],
				);
			}
		}else{
			$campana = "";
		}
		mysql_free_result($resultado);
		return $campana;
	}
        
	
	public function get($idCampana){
		$consulta = "	SELECT id_campana, id_empresa, nom_campana, 
						inicio_campana, final_campana, est_campana
						FROM campana
						WHERE id_campana = $idCampana;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$campana = array(
				'idCampana'=>mysql_result($resultado, 0, 'id_campana'),
				'idEmpresa'=>mysql_result($resultado, 0, 'id_empresa'),
				'nomCampana'=>mysql_result($resultado, 0, 'nom_campana'),
				'inicioCampana'=>mysql_result($resultado, 0, 'inicio_campana'),
				'finalCampana'=>mysql_result($resultado, 0, 'final_campana'),
				'estCampana'=>mysql_result($resultado, 0, 'est_campana')
			);
		}else{
			$campana = "";
		}
		mysql_free_result($resultado);
		return $campana;
	}
	
	public function getIDByName($nomCampana){
		$consulta = "	SELECT id_campana
						FROM campana
						WHERE nom_campana LIKE '$nomCampana';
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$campana = mysql_result($resultado, 0, 'id_campana');
		}else{
			$campana = "";
		}
		mysql_free_result($resultado);
		return $campana;
	}
	
	public function getCompanyNameByID($idCampana){
		$consulta = "	SELECT e.nom_empresa
						FROM campana c
						INNER JOIN empresa e ON c.id_empresa = e.id_empresa
						WHERE c.id_campana = $idCampana;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$campana = mysql_result($resultado, 0, 'nom_empresa');
		}else{
			$campana = "";
		}
		mysql_free_result($resultado);
		return $campana;
	}
	
	public function show($buscar="", $pag = "", $adic = true){
		
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
			$condicion .= "	AND (c.nom_campana LIKE '%$buscar%' OR e.nom_empresa LIKE '%$buscar%')";
		}
		
		$adicional = "";
		if($adic){
			$adicional = ", CONCAT('<img src=".'"'."img/icon_contact.png".'"'." height=".'"'."24".'"'." width=".'"'."24".'"'." id=".'"'."showContact".'"'." title=".'"'."Contacto Principal".'"'." name=".'"'."contactos_mant.php?opMantDif=sh&id=', c.id_cliente, '".'"'." />') AS 'Contacto',
						CONCAT('<img src=".'"'."img/icon_address.png".'"'." height=".'"'."24".'"'." width=".'"'."24".'"'." id=".'"'."showAddress".'"'." title=".'"'."Contacto Principal".'"'." name=".'"'."direcciones_mant.php?opMantDif=sh&id=', c.id_cliente, '".'"'." />') AS 'Direcci&oacute;n',
						CONCAT('<img src=".'"'."img/icon_history.png".'"'." height=".'"'."24".'"'." width=".'"'."24".'"'." id=".'"'."showHistory".'"'." title=".'"'."Haga click para ver el historial".'"'." name=".'"'."cliente_historial.php?&id=', c.id_cliente, '".'"'." />') AS 'Historial'
						";
		}
		
		$consulta = " 	SELECT c.id_campana AS 'ID', e.nom_empresa AS 'Empresa', 
						c.nom_campana AS 'Nombre de Campa&ntilde;a', 
						c.inicio_campana AS 'Inicio', c.final_campana AS 'Final'
						/*$adicional*/
						FROM campana c
						INNER JOIN empresa e ON c.id_empresa = e.id_empresa
						WHERE c.est_campana >= 0
						$condicion
						$orden
						$limite
						; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			require_once(RESOURCES.'general.php');
			$general = new general();
			$campana = $general->consulta($resultado);
		}else{
			$campana = "";
		}
		mysql_free_result($resultado);
		return $campana;
	}	
	
	public function numRows($buscar=''){
		$condicion = "";
		if($buscar<>""){
			$condicion .= "	AND (c.nom_campana LIKE '$buscar' OR e.nom_empresa LIKE '%$buscar%')";
		}
		$consulta = "	SELECT COUNT(c.id_campana) AS 'total'
						FROM campana c
						INNER JOIN empresa e ON c.id_empresa = e.id_empresa
						WHERE c.est_campana = 1
						$condicion;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$campana = mysql_result($resultado, 0, "total");
		}else{
			$campana = 0;
		}
		mysql_free_result($resultado);
		$this->numRows = $campana;
	}
}
?>