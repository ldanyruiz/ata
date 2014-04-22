<?php
class preguntaGrupo{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idPreguntaGrupo'=>$data['idPreguntaGrupo'],
                'codPreguntaGrupo'=>$data['codPreguntaGrupo'],
                'nomPreguntaGrupo'=>$data['nomPreguntaGrupo'],
                'descrPreguntaGrupo'=>$data['descrPreguntaGrupo'],
                'multiPreguntaGrupo'=>$data['multiPreguntaGrupo'],
                'ordPreguntaGrupo'=>$data['ordPreguntaGrupo']
        );
        $this->setArray = $resultado;
    }
	
	public function getAll($idCampana){
	
		$consulta = "	SELECT DISTINCT pg.id_pregunta_grupo, pg.cod_pregunta_grupo, 
						pg.nom_pregunta_grupo, pg.descr_pregunta_grupo,
						pg.multi_pregunta_grupo, pg.ord_pregunta_grupo
						FROM pregunta p
						INNER JOIN pregunta_grupo pg ON p.id_pregunta_grupo = pg.id_pregunta_grupo
						WHERE p.id_pregunta NOT IN(
							SELECT id_pregunta FROM oculto WHERE id_campana = $idCampana
						)						
						ORDER BY pg.ord_pregunta_grupo;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			while($fila = mysql_fetch_array($resultado)){
				$preguntaGrupo[$fila['ord_pregunta_grupo']] = array(
					'id'=>$fila['id_pregunta_grupo'],
					'codigo'=>$fila['cod_pregunta_grupo'],
					'nombre'=>$fila['nom_pregunta_grupo'],
					'descripcion'=>$fila['descr_pregunta_grupo'],
					'multiple'=>$fila['multi_pregunta_grupo'],
					'orden'=>$fila['ord_pregunta_grupo'],
				);
			}
		}else{
			$preguntaGrupo = 0;
		}
		mysql_free_result($resultado);
		return $preguntaGrupo;
	}
	
	public function getIDByOrder($ord, $idCampana){
		$consulta = "	SELECT DISTINCT pg.id_pregunta_grupo
						FROM pregunta p
						INNER JOIN pregunta_grupo pg ON p.id_pregunta_grupo = pg.id_pregunta_grupo
						WHERE pg.ord_pregunta_grupo >= $ord
						AND p.id_pregunta NOT IN(
							SELECT id_pregunta FROM oculto WHERE id_campana = $idCampana
						)	
						ORDER BY pg.ord_pregunta_grupo;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$preguntaGrupo = mysql_result($resultado, 0, 'id_pregunta_grupo');
		}else{
			$preguntaGrupo = "";
		}
		mysql_free_result($resultado);
		return $preguntaGrupo;
	}	
	
	public function getMultiByID($idPreguntaGrupo){
		$consulta = "	SELECT pg.multi_pregunta_grupo
						FROM pregunta_grupo pg
						WHERE pg.id_pregunta_grupo = $idPreguntaGrupo;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$preguntaGrupo = mysql_result($resultado, 0, 'multi_pregunta_grupo');
		}else{
			$preguntaGrupo = "";
		}
		mysql_free_result($resultado);
		return $preguntaGrupo;
	}
	
	public function getNameByID($idPreguntaGrupo){
		$consulta = "	SELECT pg.nom_pregunta_grupo
						FROM pregunta_grupo pg
						WHERE pg.id_pregunta_grupo = $idPreguntaGrupo;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$preguntaGrupo = mysql_result($resultado, 0, 'nom_pregunta_grupo');
		}else{
			$preguntaGrupo = "";
		}
		mysql_free_result($resultado);
		return $preguntaGrupo;
	}
	
	public function getNameByCod($codPreguntaGrupo){
		$consulta = "	SELECT pg.nom_pregunta_grupo
						FROM pregunta_grupo pg
						WHERE pg.cod_pregunta_grupo LIKE '$codPreguntaGrupo';
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$preguntaGrupo = mysql_result($resultado, 0, 'nom_pregunta_grupo');
		}else{
			$preguntaGrupo = "";
		}
		mysql_free_result($resultado);
		return $preguntaGrupo;
	}
}
?>