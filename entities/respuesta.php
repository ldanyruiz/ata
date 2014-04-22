<?php
class respuesta{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idRespuesta'=>$data['idRespuesta'],
                'idPregunta'=>$data['idPregunta'],
                'idUsuarioCampana'=>$data['idUsuarioCampana'],
                'contRespuesta'=>$data['contRespuesta'],
                'ordRespuesta'=>$data['ordRespuesta']
        );
        $this->setArray = $resultado;
    }
    
	function insert() {
		$data = $this->setArray;
		$consulta = "	INSERT INTO respuesta VALUES(
						NULL, {$data['idPregunta']}, {$data['idUsuarioCampana']}, 
						'{$data['contRespuesta']}', {$data['ordRespuesta']}
						); ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		$id = mysql_insert_id();
		return $id;
    }
    
	function deleteAll($idUsuarioCampana) {
		$consulta = "	DELETE FROM respuesta WHERE id_usuario_campana = $idUsuarioCampana; ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }
    
	function deleteAllByCampaign($idCampana) {
		$consulta = "	DELETE FROM respuesta WHERE id_usuario_campana IN 
						(SELECT id_usuario_campana FROM usuario_campana WHERE id_campana = $idCampana)
					; ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }
    
	function delete($idPregunta, $idUsuarioCampana) {
		$consulta = "	DELETE FROM respuesta WHERE id_pregunta = $idPregunta 
						AND id_usuario_campana = $idUsuarioCampana; ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }
    
	function deleteByGroupID($idPreguntaGrupo, $idUsuarioCampana) {
		$consulta = "	DELETE FROM  respuesta WHERE id_usuario_campana = $idUsuarioCampana
						AND id_pregunta IN(SELECT id_pregunta FROM pregunta WHERE id_pregunta_grupo=$idPreguntaGrupo); ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }
	
	function checkCampana($idUsuarioCampana){
		$consulta = "	SELECT COUNT(DISTINCT pg.id_pregunta_grupo) AS 'respondidas'
						FROM respuesta r
						INNER JOIN pregunta p ON r.id_pregunta = p.id_pregunta
						INNER JOIN pregunta_grupo pg ON p.id_pregunta_grupo = pg.id_pregunta_grupo
						WHERE r.id_usuario_campana = $idUsuarioCampana;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$respuesta = mysql_result($resultado, 0, 'respondidas');
		}else{
			$respuesta = 0;
		}
		mysql_free_result($resultado);
		return $respuesta;
	}
	
	function lastGroup($idUsuarioCampana){
		$consulta = "	SELECT (IFNULL(MAX(DISTINCT pg.id_pregunta_grupo), 0) + 1) AS 'ultimo'
						FROM respuesta r
						INNER JOIN pregunta p ON r.id_pregunta = p.id_pregunta
						INNER JOIN pregunta_grupo pg ON p.id_pregunta_grupo = pg.id_pregunta_grupo
						WHERE r.id_usuario_campana = $idUsuarioCampana;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$respuesta = mysql_result($resultado, 0, 'ultimo');
		}else{
			$respuesta = 0;
		}
		mysql_free_result($resultado);
		return $respuesta;
	}
	
	function countGroup($idUsuarioCampana){
		$consulta = "	SELECT (IFNULL(COUNT(DISTINCT pg.id_pregunta_grupo), 0) + 1) AS 'ultimo'
						FROM respuesta r
						INNER JOIN pregunta p ON r.id_pregunta = p.id_pregunta
						INNER JOIN pregunta_grupo pg ON pg.id_pregunta_grupo = p.id_pregunta_grupo
						WHERE id_usuario_campana=$idUsuarioCampana;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$respuesta = mysql_result($resultado, 0, 'ultimo');
		}else{
			$respuesta = 0;
		}
		mysql_free_result($resultado);
		return $respuesta;
	}
}
?>