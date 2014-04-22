<?php
class usuarioCampana{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idUsuarioCampana'=>$data['idUsuarioCampana'],
                'idCampana'=>$data['idCampana'],
                'idUsuario'=>$data['idUsuario'],
                'idNivel'=>$data['idNivel'],
                'profesionUsuarioCampana'=>$data['profesionUsuarioCampana'],
                'nivocuUsuarioCampana'=>$data['nivocuUsuarioCampana'],
                'puestoUsuarioCampana'=>$data['puestoUsuarioCampana']
        );
        $this->setArray = $resultado;
    }
    
	function insert() {
		$data = $this->setArray;
		$consulta = "	INSERT INTO usuario_campana VALUES(
						NULL, {$data['idCampana']}, {$data['idUsuario']}, NULL, 
						NULL, NULL, NULL
						); ";
		mysql_query($consulta) or die(mysql_error());
		return mysql_insert_id();
    }
		
	function updateByUser() {
		$data = $this->setArray;
		$consulta = "	UPDATE usuario_campana SET
						id_nivel={$data['idNivel']},
						profesion_usuario_campana='{$data['profesionUsuarioCampana']}',
						nivocu_usuario_campana='{$data['nivocuUsuarioCampana']}',
						puesto_usuario_campana='{$data['puestoUsuarioCampana']}'
						WHERE id_usuario={$data['idUsuario']}
						AND id_campana={$data['idCampana']}; ";
		mysql_query($consulta) or die(mysql_error());		
		return mysql_affected_rows();;
    }
		
	function setUser($idUsuarioCampana) {
		$consulta = "	UPDATE usuario_campana SET
						id_nivel=NULL,
						profesion_usuario_campana=NULL,
						nivocu_usuario_campana=NULL,
						puesto_usuario_campana=NULL
						WHERE id_usuario_campana = $idUsuarioCampana; ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }
		
	function setUserByCampaign($idCampana) {
		$consulta = "	UPDATE usuario_campana SET
						id_nivel=NULL,
						profesion_usuario_campana=NULL,
						nivocu_usuario_campana=NULL,
						puesto_usuario_campana=NULL
						WHERE id_campana = $idCampana; ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }
	
	public function checkUser($idUsuario){
		$consulta = "	SELECT uc.id_usuario_campana
						FROM usuario_campana uc
						INNER JOIN campana c ON  uc.id_campana = c.id_campana
						WHERE id_usuario = $idUsuario
						AND NOW() BETWEEN c.inicio_campana AND c.final_campana;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			return true;
		}else{
			return false;
		}
	}
	
	public function getID($idUsuario, $idCampana){
		$consulta = "	SELECT id_usuario_campana
						FROM usuario_campana
						WHERE id_usuario = $idUsuario
						AND id_campana = $idCampana;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$usuarioCampana = mysql_result($resultado, 0, 'id_usuario_campana');
		}else{
			$usuarioCampana = "";
		}
		mysql_free_result($resultado);
		return $usuarioCampana;
	}
	
	public function getCampaignID($idUsuarioCampana){
		$consulta = "	SELECT id_campana
						FROM usuario_campana
						WHERE id_usuario_campana = $idUsuarioCampana;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$usuarioCampana = mysql_result($resultado, 0, 'id_campana');
		}else{
			$usuarioCampana = "";
		}
		mysql_free_result($resultado);
		return $usuarioCampana;
	}
	
	public function checkAnswer($idUsuario){
		$consulta = "	SELECT uc.id_usuario_campana
						FROM usuario_campana uc
						INNER JOIN campana c ON  uc.id_campana = c.id_campana
						WHERE id_usuario = $idUsuario
						AND profesion_usuario_campana IS NOT NULL;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			return true;
		}else{
			return false;
		}
	}
}
?>