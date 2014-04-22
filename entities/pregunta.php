<?php
class pregunta{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idPregunta'=>$data['idPregunta'],
                'idPreguntaGrupo'=>$data['idPreguntaGrupo'],
                'codPregunta'=>$data['codPregunta'],
                'nomPregunta'=>$data['nomPregunta'],
                'descrPregunta'=>$data['descrPregunta'],
                'tipoPregunta'=>$data['tipoPregunta'],
                'multiPregunta'=>$data['multiPregunta'],
                'obliPregunta'=>$data['obliPregunta'],
                'ordPregunta'=>$data['ordPregunta'],
                'numPregunta'=>$data['numPregunta'],
                'depenPregunta'=>$data['depenPregunta'],
                'usuCrea'=>$data['usuCrea'],
                'usuEdita'=>$data['usuEdita'],
                'fechCrea'=>$data['fechCrea'],
                'fechEdita'=>$data['fechEdita'],
                'tamano_texto'=>$data['tamanoTexto'],
                'valor_defecto'=>$data['valorDefecto']
        );
        $this->setArray = $resultado;
    }
	
	public function getByGroup($idPreguntaGrupo, $idCampana){
		$consulta = "	SELECT id_pregunta, id_pregunta_grupo, cod_pregunta, nom_pregunta, descr_pregunta,
						tipo_pregunta, multi_pregunta, obli_pregunta, ord_pregunta, num_pregunta,
                                                tamano_texto, valor_defecto
						FROM pregunta
						WHERE id_pregunta_grupo = $idPreguntaGrupo
						AND id_pregunta NOT IN(
							SELECT id_pregunta FROM oculto WHERE id_campana = $idCampana
						)
						AND depen_pregunta=0
						ORDER BY ord_pregunta;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			while($fila = mysql_fetch_array($resultado)){
				$pregunta[] = array(
					'id'=>$fila['id_pregunta'],
					'grupo'=>$fila['id_pregunta_grupo'],
					'codigo'=>$fila['cod_pregunta'],
					'nombre'=>$fila['nom_pregunta'],
					'descripcion'=>$fila['descr_pregunta'],
					'tipo'=>$fila['tipo_pregunta'],
					'multiple'=>$fila['multi_pregunta'],
					'obligatorio'=>$fila['obli_pregunta'],
					'orden'=>$fila['ord_pregunta'],
					'numerico'=>$fila['num_pregunta'],
                                        'tamanio'=>$fila['tamano_texto'],
                                        'valor'=>$fila['valor_defecto']
				);
			}
		}else{
			$pregunta = "";
		}
		mysql_free_result($resultado);
		return $pregunta;
	}
	
	public function getByDepen($idDepen, $idCampana){
		$consulta = "	SELECT id_pregunta, id_pregunta_grupo, cod_pregunta, nom_pregunta, descr_pregunta, 
						tipo_pregunta, multi_pregunta, obli_pregunta, ord_pregunta, num_pregunta,
                                                tamano_texto, valor_defecto
						FROM pregunta
						WHERE depen_pregunta=$idDepen
						AND id_pregunta NOT IN (
							SELECT id_pregunta FROM oculto WHERE id_campana = $idCampana
						)
						ORDER BY ord_pregunta;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			while($fila = mysql_fetch_array($resultado)){
				$pregunta[] = array(
					'id'=>$fila['id_pregunta'],
					'grupo'=>$fila['id_pregunta_grupo'],
					'codigo'=>$fila['cod_pregunta'],
					'nombre'=>$fila['nom_pregunta'],
					'descripcion'=>$fila['descr_pregunta'],
					'tipo'=>$fila['tipo_pregunta'],
					'multiple'=>$fila['multi_pregunta'],
					'obligatorio'=>$fila['obli_pregunta'],
					'orden'=>$fila['ord_pregunta'],
					'numerico'=>$fila['num_pregunta'],
					'tamanio'=>$fila['tamano_texto'],
                                        'valor'=>$fila['valor_defecto']
                                    
				);
			}
		}else{
			$pregunta = "";
		}
		mysql_free_result($resultado);
		return $pregunta;
	}
	
	public function getByIDs($idsPregunta){
		$consulta = "	SELECT p.nom_pregunta, cod_pregunta, descr_pregunta
						FROM pregunta p
						WHERE p.id_pregunta IN($idsPregunta)
						ORDER BY p.id_pregunta;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$pregunta = array();
			while($fila = mysql_fetch_array($resultado)){
				$pregunta[] = array(
					'nombre'=>$fila['nom_pregunta'], 
					'codigo'=>$fila['cod_pregunta'], 
					'descripcion'=>$fila['descr_pregunta']
				);
			}
		}else{
			$pregunta = "";
		}
		mysql_free_result($resultado);
		return $pregunta;
	}
	
	public function getComplete(){
		$consulta = "	SELECT pg.id_pregunta_grupo, pg.nom_pregunta_grupo,
						p.id_pregunta, p.nom_pregunta, p.descr_pregunta
						FROM pregunta p
						INNER JOIN  pregunta_grupo pg ON p.id_pregunta_grupo = pg.id_pregunta_grupo
						ORDER BY pg.id_pregunta_grupo, p.cod_pregunta;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$pregunta = array();
			while($fila = mysql_fetch_array($resultado)){
				$pregunta[$fila['id_pregunta_grupo']]['nombre'] =$fila['nom_pregunta_grupo'];
				$pregunta[$fila['id_pregunta_grupo']]['descripciones'][$fila['id_pregunta']] =$fila['descr_pregunta'];
				$pregunta[$fila['id_pregunta_grupo']]['preguntas'][$fila['id_pregunta']] = $fila['nom_pregunta'];
			}
		}else{
			$pregunta = "";
		}
		mysql_free_result($resultado);
		return $pregunta;
	}
	
	public function getInfoByCod($codPregunta){
		$consulta = "	SELECT p.id_pregunta, p.cod_pregunta, p.nom_pregunta,
						p.descr_pregunta, pg.nom_pregunta_grupo
						FROM pregunta p
						INNER JOIN pregunta_grupo pg ON p.id_pregunta_grupo = pg.id_pregunta_grupo
						WHERE p.cod_pregunta LIKE '$codPregunta';
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$pregunta['id'] = mysql_result($resultado, 0, 'id_pregunta');
			$pregunta['codigo'] = mysql_result($resultado, 0, 'cod_pregunta');
			$pregunta['nombre'] = mysql_result($resultado, 0, 'nom_pregunta');
			$pregunta['descripcion'] = mysql_result($resultado, 0, 'descr_pregunta');
			$pregunta['grupo'] = mysql_result($resultado, 0, 'nom_pregunta_grupo');
		}else{
			$pregunta = "";
		}
		mysql_free_result($resultado);
		return $pregunta;
	}
}
?>