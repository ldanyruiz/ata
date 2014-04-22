<?php
class reportes{
	
	public function getUsers($idCampana){
		$consulta = "	SELECT uc.id_usuario_campana, 
                                       UPPER(u.nom_usuario) as nom_usuario,
                                       UPPER(u.appat_usuario) as appat_usuario,
                                       UPPER(u.apmat_usuario) as apmat_usuario,
                                       UPPER(uc.puesto_usuario_campana) as puesto_usuario_campana,
                                       UPPER(nom_nivel) AS 'region' 
						FROM usuario u
						INNER JOIN usuario_campana uc ON u.id_usuario = uc.id_usuario
                                                LEFT JOIN nivel n ON uc.id_nivel=n.id_nivel 
						WHERE uc.id_campana = $idCampana
						AND u.est_usuario <> 'E'                                                 
						ORDER BY u.appat_usuario, u.apmat_usuario, u.nom_usuario;
					";
                //AND u.fech_edita LIKE '2014-04%' AND u.id_usuario NOT IN(628) AND est_usuario = 'A' 
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$reporte = array();
			while($fila = mysql_fetch_array($resultado)){
				$reporte['personas'][$fila['appat_usuario'] . ' ' . $fila['apmat_usuario'] . ' ' . $fila['nom_usuario']]=array();
				$reporte['puestos'][$fila['appat_usuario'] . ' ' . $fila['apmat_usuario'] . ' ' . $fila['nom_usuario']]=$fila['puesto_usuario_campana'];
				$reporte['id'][$fila['appat_usuario'] . ' ' . $fila['apmat_usuario'] . ' ' . $fila['nom_usuario']]=$fila['id_usuario_campana'];
                                $reporte['nombre_nivel'][$fila['appat_usuario'] . ' ' . $fila['apmat_usuario'] . ' ' . $fila['nom_usuario']]=$fila['region'];
			}
		}else{
			$reporte = null;
		}
		mysql_free_result($resultado);
		return $reporte;
	}
	
	public function getGroups($idCampana=""){
		$where = "";
		if($idCampana<>""){
			$where = "WHERE p.id_pregunta NOT IN(SELECT id_pregunta FROM oculto WHERE id_campana = $idCampana)";
		}
		$consulta = "	SELECT DISTINCT pg.nom_pregunta_grupo 
						FROM pregunta_grupo pg
						INNER JOIN pregunta p ON p.id_pregunta_grupo = pg.id_pregunta_grupo
						$where
						ORDER BY pg.ord_pregunta_grupo;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$reporte = array();
			while($fila = mysql_fetch_array($resultado)){
				$reporte[$fila['nom_pregunta_grupo']] = "No";
			}
		}else{
			$reporte = "";
		}
		mysql_free_result($resultado);
		return $reporte;
	}
	
	public function getSolved($idCampana, $simple=true){
		$consulta = "	SELECT 	u.nom_usuario, u.appat_usuario, u.apmat_usuario, pg.nom_pregunta_grupo
						FROM respuesta r
						INNER JOIN pregunta p ON r.id_pregunta = p.id_pregunta
						INNER JOIN pregunta_grupo pg ON p.id_pregunta_grupo = pg.id_pregunta_grupo
						INNER JOIN usuario_campana uc ON r.id_usuario_campana = uc.id_usuario_campana
						INNER JOIN usuario u ON uc.id_usuario = u.id_usuario 
						WHERE uc.id_campana = $idCampana 
						AND u.est_usuario <> 'E'                                                 
                                                ORDER BY u.appat_usuario, u.apmat_usuario, u.nom_usuario;
					";
                //AND u.fech_edita like '2014-04%' and u.id_usuario not in(628) and est_usuario = 'A' 
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$reporte = array();
			while($fila = mysql_fetch_array($resultado)){
				$reporte[$fila['appat_usuario'] . ' ' . $fila['apmat_usuario'] . ' ' . $fila['nom_usuario']][$fila['nom_pregunta_grupo']] = "";
			}
		}else{
			$reporte = "";
		}
		mysql_free_result($resultado);
		
		ini_set("display_errors", 0);
		
		$pregGrup = $this->getGroups();
		
		$usuarios = $this->getUsers($idCampana);
		
		$datos = array();
		
		foreach($usuarios['personas'] as $key => $value){
			$datos[$key] = $pregGrup;
		}
		
		foreach($reporte as $key=>$value){
			foreach($value as $key2=>$value2){
				$datos[$key][$key2] = "S&iacute;";
			}
		}
		
		unset($reporte);
		$reporte = array();		
		
		if($simple){
			$reporte[0] = array('ID', 'NOMBRE COMPLETO', 'SECCI&Oacute;N', 'LLENADO');
			
			$i=1;
			foreach($datos as $key=>$value){
				foreach($value as $key2=>$value2){
					$reporte[$i] = array(
						'ID'=>$i,
						'NOMBRE COMPLETO'=>$key,
						'SECCI&Oacute;N'=>$key2,
						'LLENADO'=>$value2
					);
					$i++;
				}
			}
		}else{
			require_once(RESOURCES.'general.php');
			$general = new general();
		
			$reporte[0] = array('COLABORADOR', 'PUESTO', 'DATOS PERSONALES');
			foreach($pregGrup as $key=>$value){
				$reporte[0][] = $general->reemplazarTildes($key, 'h-n');
			}
			
			$i=1;
			foreach($datos as $key=>$value){
				$reporte[$i] = array(
					'NOMBRE COMPLETO'=>$key,
					'PUESTO'=>strtoupper($usuarios['puestos'][$key]),
					'DATOS PERSONALES'=>'No'
				);
				if($usuarios['puestos'][$key]<>''){
					$reporte[$i]['DATOS PERSONALES'] = 'Si';
				}
				foreach($value as $key2=>$value2){
					$reporte[$i][$key2]=$general->reemplazarTildes($value2, 'h-n');
				}
				$i++;
			}	
		}
		
		return $reporte;
	}
	
	public function getTracing($idCampana, $boolID = true, $returnGraph=false){
		$consulta = "	SELECT DISTINCT CONCAT(IFNULL(u.appat_usuario, ''), ' ', IFNULL(u.apmat_usuario, ''), ' ', IFNULL(u.nom_usuario, '')) AS 'usuario',
						pg.nom_pregunta_grupo
						FROM usuario_campana uc
						INNER JOIN usuario u ON uc.id_usuario = u.id_usuario
						INNER JOIN respuesta r ON r.id_usuario_campana = uc.id_usuario_campana
						INNER JOIN pregunta p ON r.id_pregunta = p.id_pregunta
						INNER JOIN pregunta_grupo pg ON p.id_pregunta_grupo = pg.id_pregunta_grupo
						WHERE id_campana = $idCampana
						AND u.est_usuario <> 'E'
						AND p.id_pregunta NOT IN(
							SELECT id_pregunta FROM oculto WHERE id_campana = $idCampana
						)
						ORDER BY u.appat_usuario;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$reporte = array();
			while($fila = mysql_fetch_array($resultado)){
				$reporte[$fila['usuario']][] = $fila['nom_pregunta_grupo'];
			}
		}else{
			$reporte = "";
		}
		mysql_free_result($resultado);
		
		$total = count($this->getGroups($idCampana));
		$datosPersonas = $this->getUsers($idCampana);
                
                if($datosPersonas!=null){
                    $personas = $datosPersonas['personas'];

                    $ids = $datosPersonas['id'];

                    $nivel = $datosPersonas['nombre_nivel'];

                    $datos = $reporte;
                    unset($reporte);

                    if($boolID){
                            $reporte[0][] = 'ID';
                    }
                    $reporte[0][] = 'Colaborador';
                    $reporte[0][] = 'Nivel';
                    $reporte[0][] = 'Avance por secciones';
                    $reporte[0][] = 'Estado';
                    $i = 1;

                    $datosGrafico = array('Completado'=>0, 'Pendiente'=>0, 'En proceso'=>0);

                    foreach($personas as $key=>$value){
                            if($boolID){
                                    $reporte[$i]['ID'] = $ids[$key];

                            }
                            $reporte[$i]['Colaborador'] = $key;
                            $reporte[$i]['Nivel'] = $nivel[$key];

                            $actual = 0;
                            if(isset($datos[$key])){
                                    $actual = count($datos[$key]);
                            }
                            $reporte[$i]['Avance por secciones'] = $actual . ' de ' . $total;
                            if($actual==$total){
                                    $reporte[$i]['Estado'] = 'Completado';
                                    $datosGrafico['Completado']++;
                            }else if($actual==0){
                                    $reporte[$i]['Estado'] = 'Pendiente';
                                    $datosGrafico['Pendiente']++;
                            }else{
                                    $reporte[$i]['Estado'] = 'En proceso';
                                    $datosGrafico['En proceso']++;
                            }
                            $i++;
                    }	
                    
                    if($returnGraph){
                            return $datosGrafico;
                    }else{
                            return $reporte;
                    }                    
                }
                return $reporte;
		
	}
	
	public function getPersonalData($idCampana){
		$consulta = "	SELECT CONCAT(u.appat_usuario, ' ', u.apmat_usuario, ' ', u.nom_usuario) AS 'Colaborador', 
						UPPER(u.email_usuario) AS 'Correo Electronico', CONCAT(u.login_usuario, ' ') AS 'DNI', 
						u.sex_usuario AS 'Sexo', DATE_FORMAT(u.fechnac_usuario,'%d-%m-%Y') AS 'Fecha de nacimiento', 
						u.estciv_usuario AS 'Estado Civil', UPPER(uc.profesion_usuario_campana) AS 'Profesion',
                                                CASE uc.nivocu_usuario_campana
                                                    WHEN 'NON' THEN 'DESCONOCE'
                                                    WHEN 'AUX' THEN 'AUXILIAR'
                                                    WHEN 'GER' THEN 'GERENTE'
                                                    WHEN 'JEF' THEN 'JEFE'
                                                    WHEN 'SUP' THEN 'SUPERVISOR'
                                                    WHEN 'COO' THEN 'COORDINADOR'
                                                    WHEN 'ANA' THEN 'ANALISTA'
                                                    WHEN 'ASI' THEN 'ASISTENTE'
                                                    WHEN 'OPE' THEN 'OPERARIO'
                                                    ELSE ''
                                                END 						
						 AS 'Nivel Ocupacional'
						FROM usuario_campana uc
						INNER JOIN usuario u ON uc.id_usuario = u.id_usuario
						WHERE uc.id_campana = $idCampana
						AND u.est_usuario <> 'E'                                                 
                                                ORDER BY u.appat_usuario, u.apmat_usuario, u.nom_usuario;
					";
                
                //AND u.fech_edita like '2014-04%' and u.id_usuario not in(628) and est_usuario = 'A' 
                //echo $consulta;
		$resultado = mysql_query($consulta) or die(mysql_error());
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
	
	public function getQuestionsByCod($codPreguntaGrupo, $codsPreguntas=''){
		$where = "";
		if($codPreguntaGrupo<>''){
			$where = " OR pg.cod_pregunta_grupo LIKE '$codPreguntaGrupo' ";
		}
		if(is_array($codsPreguntas)){
			foreach($codsPreguntas as $key=>$value){
				$where .= " OR p.cod_pregunta LIKE '$value' ";
			}
		}
		$consulta = "	SELECT DISTINCT p.id_pregunta, 
						CONCAT(p.nom_pregunta, ' (', p.cod_pregunta, ')') AS 'nom_pregunta'
						FROM pregunta p
						INNER JOIN pregunta_grupo pg ON p.id_pregunta_grupo = pg.id_pregunta_grupo
						WHERE FALSE
						$where
						ORDER BY p.id_pregunta
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$reporte = array();
			while($fila = mysql_fetch_array($resultado)){
				$reporte[] = array(
					'id'=>$fila['id_pregunta'],
					'nombre'=>$fila['nom_pregunta']
				);
			}
		}else{
			$reporte = "";
		}
		mysql_free_result($resultado);
		return $reporte;
	}
	
	public function getAnswers($idsPregunta, $idUsuarioCampana){
		$consulta = "	SELECT CONCAT(p.nom_pregunta, ' (', p.cod_pregunta, ')') AS 'nom_pregunta', 
						UPPER(r.cont_respuesta) as cont_respuesta 
						FROM respuesta r
						INNER JOIN pregunta p ON r.id_pregunta = p.id_pregunta
						WHERE r.id_pregunta IN($idsPregunta)
						AND r.id_usuario_campana = $idUsuarioCampana
						ORDER BY r.id_pregunta, r.ord_respuesta;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$reporte = array();
			while($fila = mysql_fetch_array($resultado)){
				$reporte[$fila['nom_pregunta']][] = $fila['cont_respuesta'];
			}
		}else{
			$reporte = "";
		}
		mysql_free_result($resultado);
		return $reporte;
	}
        
	public function getAnswers2($idsPregunta, $idUsuarioCampana){
		$consulta = "	SELECT CONCAT(p.nom_pregunta, ' (', p.cod_pregunta, ')') AS 'nom_pregunta',  
						UPPER(r.cont_respuesta) as cont_respuesta 
						FROM respuesta r
						INNER JOIN pregunta p ON r.id_pregunta = p.id_pregunta
						WHERE r.id_pregunta IN($idsPregunta) and tipo_pregunta<>'N' 
						AND r.id_usuario_campana = $idUsuarioCampana
						ORDER BY r.id_pregunta, r.ord_respuesta;
					";
//                echo $consulta;
//                die();
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$reporte = array();
			while($fila = mysql_fetch_array($resultado)){
				$reporte[$fila['nom_pregunta']][] = $fila['cont_respuesta'];
			}
		}else{
			$reporte = "";
		}
		mysql_free_result($resultado);
		return $reporte;
	}

        
	public function getAnswersToReports($idsPregunta, $idUsuarioCampana,$z=null){
		$consulta = "	SELECT CONCAT(p.nom_pregunta, ' (', p.cod_pregunta, ')') AS 'nom_pregunta', 
						r.cont_respuesta,r.ord_respuesta
						FROM respuesta r
						INNER JOIN pregunta p ON r.id_pregunta = p.id_pregunta
						WHERE r.id_pregunta IN($idsPregunta)
						AND r.id_usuario_campana = $idUsuarioCampana
						ORDER BY r.ord_respuesta,p.ord_pregunta,r.id_pregunta;
					";
                if($z==1)  {echo '<br><br>'.$consulta;}
                //die();
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$reporte = array();
			while($fila = mysql_fetch_array($resultado)){
				$reporte[$fila['ord_respuesta']][] = $fila['cont_respuesta'];
			}
		}else{
			$reporte = "";
		}
		mysql_free_result($resultado);
		return $reporte;
	}
	
	public function getReportByCods($idCampana, $codPreguntaGrupo, $codsPregunta){
		require_once(RESOURCES.'general.php');
		$general = new general();
	
		$preguntas = $this->getQuestionsByCod($codPreguntaGrupo, $codsPregunta);
		$usuarios = $this->getUsers($idCampana);
		
		$idsPreguntas = "0";
		foreach($preguntas as $key=>$value){
			$idsPreguntas .= ",".$value['id'];
		}
			
		$reporte = array();
		$reporte[0] = array('COLABORADOR', 'PUESTO');
		
		foreach($preguntas as $key=>$value){
			$reporte[0][] = $general->reemplazarTildes($value['nombre'], 'h-n');
		}
		
		$i = 1;
		foreach($usuarios['id'] as $key=>$value){
			unset($respuestas);
			$respuestas = $this->getAnswers($idsPreguntas, $value);
			
			if(is_array($respuestas)){
				$mayor=1;
				foreach($respuestas as $key2=>$value2){
					if(count($value2)>$mayor){
						$mayor = count($value2);
					}
				}
				for($j=0; $j<($mayor); $j++){
					$reporte[$i] = array(
						'COLABORADOR'=>$key,
						'PUESTO'=>$usuarios['puestos'][$key]
					);					
					foreach($preguntas as $key2=>$value2){
						$respuesta = "";
						if(isset($respuestas[$value2['nombre']][$j])){
							$respuesta = $general->reemplazarTildes($respuestas[$value2['nombre']][$j], 'h-n');
						}
						$reporte[$i][$value2['nombre']] = $respuesta;
					}
					$i++;
				}
			}
		}
		
		return $reporte;
		
	}
	
	public function getReportByIDs($idCampana, $preguntas){
		require_once(RESOURCES.'general.php');
		$general = new general();
		
		$usuarios = $this->getUsers($idCampana);
		
		$idsPreguntas = "0";
		foreach($preguntas as $key=>$value){
			$idsPreguntas .= ",".$value['id'];
		}
		
		$reporte = array();
		$reporte[0] = array('COLABORADOR', 'PUESTO');
		
		foreach($preguntas as $key=>$value){
			$reporte[0][] = $general->reemplazarTildes($value['nombre'], 'h-n');
		}
		
		$i = 1;
		foreach($usuarios['id'] as $key=>$value){
			unset($respuestas);
			$respuestas = $this->getAnswers($idsPreguntas, $value);
			
			if(is_array($respuestas)){
				$mayor=1;
				foreach($respuestas as $key2=>$value2){
					if(count($value2)>$mayor){
						$mayor = count($value2);
					}
				}
				for($j=0; $j<($mayor); $j++){
					$reporte[$i] = array(
						'COLABORADOR'=>$key,
						'PUESTO'=>$usuarios['puestos'][$key]
					);					
					foreach($preguntas as $key2=>$value2){
						$respuesta = "";
						if(isset($respuestas[$value2['nombre']][$j])){
							$respuesta = $general->reemplazarTildes($respuestas[$value2['nombre']][$j], 'h-n');
						}
						$reporte[$i][$value2['nombre']] = $respuesta;
					}
					$i++;
				}
			}
		}
		
		return $reporte;
		
	}
        
	public function getReportByIDs2($idCampana, $preguntas){
		require_once(RESOURCES.'general.php');
		$general = new general();
		
		$usuarios = $this->getUsers($idCampana);
		
		$idsPreguntas = "0";
		foreach($preguntas as $key=>$value){
			$idsPreguntas .= ",".$value['id'];
		}
		
		$reporte = array();
		$reporte[0] = array('COLABORADOR', 'PUESTO');
		
		foreach($preguntas as $key=>$value){
			$reporte[0][] = $general->reemplazarTildes($value['nombre'], 'h-n');
		}
		
		$i = 1;
		foreach($usuarios['id'] as $key=>$value){
			unset($respuestas);
			$respuestas = $this->getAnswers2($idsPreguntas, $value);
			
			if(is_array($respuestas)){
				$mayor=1;
				foreach($respuestas as $key2=>$value2){
					if(count($value2)>$mayor){
						$mayor = count($value2);
					}
				}
				for($j=0; $j<($mayor); $j++){
					$reporte[$i] = array(
						'COLABORADOR'=>$key,
						'PUESTO'=>$usuarios['puestos'][$key]
					);					
					foreach($preguntas as $key2=>$value2){
						$respuesta = "";
						if(isset($respuestas[$value2['nombre']][$j])){
							$respuesta = $general->reemplazarTildes($respuestas[$value2['nombre']][$j], 'h-n');
						}
						$reporte[$i][$value2['nombre']] = $respuesta;
					}
					$i++;
				}
			}
		}
		
		return $reporte;
		
	}        
	
	public function getIndividualInfo($idUsuarioCampana){
		
		$consulta = "	SELECT u.nom_usuario AS 'Nombre', u.appat_usuario AS 'Apellido Paterno', 
						u.apmat_usuario AS 'Apellido Materno', u.login_usuario AS 'DNI', u.sex_usuario AS 'Sexo',
						u.estciv_usuario AS 'Estado civil', u.fechnac_usuario AS 'Fecha de nacimiento',
						u.email_usuario AS 'Correo electr&oacute;nico', uc.profesion_usuario_campana AS 'Profesi&oacute;n',
						uc.puesto_usuario_campana AS 'Puesto Actual', uc.nivocu_usuario_campana AS 'Nivel ocupacional',
						n.nom_nivel AS 'Nivel estructural'
						FROM usuario_campana uc
						INNER JOIN usuario u ON uc.id_usuario = u.id_usuario
						LEFT OUTER JOIN nivel n ON uc.id_nivel = n.id_nivel
						WHERE id_usuario_campana = $idUsuarioCampana
						AND u.est_usuario <> 'E';		
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			require_once(RESOURCES.'general.php');
			$general = new general();
			$reporte = $general->consulta($resultado);
		}else{
			$reporte = 0;
		}
		mysql_free_result($resultado);
		return $reporte;
	}
	
	public function getGroupsAndQuestions($idCampana){
		
		$consulta = "	SELECT pg.nom_pregunta_grupo, pg.multi_pregunta_grupo,
						p.id_pregunta, p.nom_pregunta, p.cod_pregunta, p.multi_pregunta, p.tipo_pregunta 
						FROM pregunta_grupo pg
						INNER JOIN pregunta p ON p.id_pregunta_grupo = pg.id_pregunta_grupo
						WHERE id_pregunta NOT IN (
							SELECT id_pregunta FROM oculto WHERE id_campana = $idCampana
						)
						AND p.depen_pregunta = 0
						ORDER BY pg.ord_pregunta_grupo;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$reporte = array();
			while($fila = mysql_fetch_array($resultado)){
				$reporte[$fila['nom_pregunta_grupo']][$fila['multi_pregunta_grupo']][$fila['nom_pregunta']] = array(
					'id'=>$fila['id_pregunta'],
					'codigo'=>$fila['cod_pregunta'],
					'multiple'=>$fila['multi_pregunta'],
                                        'tipo'=>$fila['tipo_pregunta']
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