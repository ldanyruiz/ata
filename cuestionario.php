<?php
require_once('config.php');
require_once(RESOURCES.'general.php');
require_once(ENTITIES.'pregunta.php');
require_once(ENTITIES.'preguntaGrupo.php');
require_once(ENTITIES.'alternativa.php');
require_once(ENTITIES.'respuesta.php');
require_once(ENTITIES.'campana.php');
require_once(ENTITIES.'usuarioCampana.php');
require_once(ENTITIES.'usuario.php');
$general = new general();
$pregunta = new pregunta();
$preguntaGrupo = new preguntaGrupo();
$alternativa = new alternativa();
$respuesta = new respuesta();
$campana = new campana();
$usuarioCampana = new usuarioCampana();
$usuario = new usuario();

if(isset($_REQUEST['ajaxNivel'])){
	require_once(ENTITIES.'nivel.php');
	$nivel = new nivel();
?>
<div id="ajaxNivel">
	<?php echo $general->combo($nivel->getCombo('', $_REQUEST['ajaxNivel']), 'idNivel', true, '', 0, 1)?>
</div>
<?php
	die;
}



if(isset($_REQUEST['ajax'])){
	if($_REQUEST['ajax']){
		$preguntas = $pregunta->getByDepen($_REQUEST['id'], $_REQUEST['campana']);
		$totalSub = count($preguntas);
		$boolMultiSub = true;
		if(isset($_REQUEST['multi'])){
			if($_REQUEST['multi']){
				$boolMultiSub = !count($preguntas)>1;
			}
		}
                
                
?>
<div id="ajax">
		<?php	if(is_array($preguntas)){ ?>
    <table id="cuestionario">
		<?php 	if(!$boolMultiSub){	?>
            <tr>
        <?php	}	?>
        <?php
				$i=1;
				foreach($preguntas as $value){			
					unset($alternativas);
					$alternativas = $alternativa->getByQuestion($value['id']);
					
					$multiNombre = "";
					if($value['multiple']){
						$multiNombre = "[]";
					}
					
					$num = $_REQUEST['num'];
					
					$respuestas = "";
					switch($value['tipo']){
						case 'T':
							if($value['tamanio']>0){
								$maxlength = $value['tamanio'];
								$size = (int)$maxlength*2;                                
							}else{
								$size = 20;
								$maxlength = '';
							}  
                                                        $readonly = '';
                                                        if($value['valor']!=''){$readonly = "readOnly = 'true' style='background-color: #cccccc;'"; }    
							
                                                        $respuestas = "<input type='text' id='r{$num}s{$i}' name='r{$num}s{$i}{$multiNombre}' obli='{$value['obligatorio']}' num='{$value['numerico']}' size='{$size}' maxlength='{$maxlength}' value='{$value['valor']}' {$readonly}/>";
							break;
						case 'S':
							$respuestas = $general->selector($alternativas, 'r'.$num.'s'.$i, $value['multiple'], $value['obligatorio']);
							break;
						case 'D':
							$respuestas = "<textarea id='r{$num}s{$i}' name='r{$num}s{$i}{$multiNombre}' cols='60' rows='4' obli='{$value['obligatorio']}' ></textarea>";
							break;
						case 'C':
							break;
						case 'R':
							$respuestas = $general->radio($alternativas, 'r'.$num.'s'.$i, $value['multiple'], $value['obligatorio']);
							break;
						case 'F':
							$respuestas = "<input type='text' id='r{$num}s{$i}' name='r{$num}s{$i}{$multiNombre}' obli='{$value['obligatorio']}' esFecha='1' value='' readOnly='true'/>";
							break;
					}
        ?>
		<?php 	if($boolMultiSub){	?>
        <tr id="pregunta">
        <?php	}	?>
            <td>
            </td>
            <td>
            	<input type="hidden" id="totalSub<?php echo $num;?>" name="totalSub<?php echo $num;?>" value="<?php echo $totalSub;?>" />
                <input type="hidden" id="p<?php echo $num;?>s<?php echo $i;?>" name="p<?php echo $num;?>s<?php echo $i;?>" value="<?php echo $value['id'];?>" />
				<?php echo utf8_encode($value['nombre']);?> 
                <?php if($value['descripcion']!=''){?>
                <a id="help">
                	<img src="<?php echo images;?>icon_help.png" />
                    <div>
                        <img src="<?php echo images;?>icon_help.png" /> <?php echo $value['descripcion'];?>
                    </div>
                </a>
                <?php }?>
		<?php 	if($boolMultiSub){	?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
        <?php 	}	?>
            	<?php echo utf8_encode($respuestas);?>
            </td>
		<?php 	if($boolMultiSub){	?>
        </tr>
        <?php 	}	?>
        <?php
                $i++;
            }
        ?>
    </table>
</div>
<?php
		}
		die;
	}
}


require_once(TEMPLATES.'header.php');
?>
<h1>Cuestionario</h1>
<script src="<?php echo SCRIPTS;?>cuestionario.js" language="javascript" type="text/javascript"></script>
<br />
<?php
if(!isset($_REQUEST['idCampana']) and !isset($_REQUEST['edicion'])){
	$actual = $campana->getAll($_SESSION['usuario']['id']);
        
 	foreach($actual as $value){
		$idUsuarioCampana = $usuarioCampana->getID($_SESSION['usuario']['id'], $value['id']);
		$totalResueltas = $respuesta->checkCampana($idUsuarioCampana);
		
		$totalPregGrup = count($preguntaGrupo->getAll($value['id']));
		
		if($totalResueltas == $totalPregGrup){
			$claseEstado = "term";
			$estado = "Terminado<br />&iexcl;Muchas gracias por rellenar el cuestionario!";
		}else{
			$claseEstado = "pend";
			$estado = "Pendiente";
		}
?>
    <p>A continuaci&oacute;n se lista las campa&ntilde;as que tiene a la fecha:</p>
    <br /><br />
	<fieldset>
    	<legend>
        	<img src="<?php echo images;?>icon_campaign.png" height="20px" /> 
            Campa&ntilde;a: <?php echo $value['nombre'];?>
		</legend>
        <table>
        	<tr>
            	<td class="neg">Nombre de la campa&ntilde;a:</td>
                <td><?php echo $value['nombre'];?></td>
            </tr>
        	<tr>
            	<td class="neg">Holding:</td>
                <td><?php echo $value['holding'];?></td>
            </tr>
        	<tr>
            	<td class="neg">Empresa:</td>
                <td><?php echo $value['empresa'];?></td>
            </tr>
        	<tr>
            	<td class="neg">Fecha de inicio:</td>
                <td><?php echo $value['inicio'];?></td>
            </tr>
        	<tr>
            	<td class="neg">Fecha final:</td>
                <td><?php echo $value['final'];?></td>
            </tr>
        	<tr>
            	<td class="neg">D&iacute;as restantes:</td>
                <td><?php echo $value['restante'];?> d&iacute;as</td>
            </tr>
        	<tr>
            	<td class="neg">Estado:</td>
                <td class="<?php echo $claseEstado;?>"><?php echo $estado;?></td>
            </tr>
<?php
		if($totalResueltas == $totalPregGrup){
			$grupoPreguntas = $preguntaGrupo->getAll($value['id']);
?>	
			<tr>
            	<td class="neg">Edici&oacute;n de respuestas:</td>
                <td>
                	<br />
					<ul id="lista">
<?php
			foreach($grupoPreguntas as $key2=>$value2){
?>
					<li>
                    	<?php echo $value2['nombre'];?>
                    	[<a href="cuestionario.php?edicion=0&id=<?php echo $value2['id'];?>&campana=<?php echo $value['id'];?>&usucam=<?php echo $idUsuarioCampana;?>">Editar</a>]
                    </li>
<?php
			}
?>
					</ul>
                </td>
            </tr>
<?php
		}
?>
        </table>
        <?php 	if($totalResueltas <> $totalPregGrup){	?>
        <br /><br />
        <p>
        	<a href="cuestionario.php?idCampana=<?php echo $value['id'];?>">
                <button type="button" id="resolver" name="resolver">
                    Resolver
                    <img src="<?php echo images;?>icon_test.png" />                 
                </button>
            </a>
		</p>
        <?php	}?>
    </fieldset>
<?php
	}
}else if(isset($_REQUEST['idCampana'])){
    


?>
    <p>A continuaci&oacute;n se listan las pregunta a las cuales debe dar respuesta. Las preguntas marcadas con asterisco (*) son obligatorias:</p>
    <br /><br />
	<form id="formCuestionario" name="formCuestionario" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>?save=1">
<?php
	$pregGrup = $preguntaGrupo->getAll($_REQUEST['idCampana']);
        
	$actual = $respuesta->lastGroup($usuarioCampana->getID($_SESSION['usuario']['id'], $_REQUEST['idCampana']));
	
	$actualMascara = $respuesta->countGroup($usuarioCampana->getID($_SESSION['usuario']['id'], $_REQUEST['idCampana']));
	
        
	if(!$usuarioCampana->checkAnswer($_SESSION['usuario']['id'])){
		$actual = 0;
	}
	$total = count($pregGrup);
	$fecha = "input#fecha";
	$idCampana = 0;
	$totalPreg = 0;
	
	if(isset($_REQUEST['actual'])){
		$actual = $_REQUEST['actual'] + 1;
	}	
	if(isset($_REQUEST['idCampana'])){
		$idCampana = $_REQUEST['idCampana'];
	}
	if(isset($_REQUEST['totalPreg'])){
		$totalPreg = $_REQUEST['totalPreg'];
	}
	
	if($actual==0){
		require_once(ENTITIES.'usuario.php');
		$usuario = new usuario();
		$data = array(
                'idUsuario'=>$_SESSION['usuario']['id'],
                'rolUsuario'=>'',
                'nomUsuario'=>'',
                'appatUsuario'=>'',
                'apmatUsuario'=>'',
                'loginUsuario'=>'',
                'passUsuario'=>'',
                'sexUsuario'=>'',
                'estcivUsuario'=>'',
                'fechnacUsuario'=>'',
                'emailUsuario'=>'',
                'estUsuario'=>'',
                'usuCrea'=>$_SESSION['usuario']['id'],
                'usuEdita'=>$_SESSION['usuario']['id'],
                'fechCrea'=>'',
                'fechEdita'=>''
        );
		
		$fecha .= ",input#fechnacUsuario";
		
		$usuario->get($_SESSION['usuario']['id']);
		$data = $usuario->setArray;
		
		$sexUsuario = array('M'=>'', 'F'=>'');
		$sexUsuario[$data['sexUsuario']] = 'CHECKED';
		
		$estcivUsuario = array('S'=>'', 'C'=>'', 'V'=>'', 'D'=>'');
		$estcivUsuario[$data['estcivUsuario']] = 'SELECTED';
		
		$nivelesOcupacionales[0] = array("nombre"=>"Gerente", "id"=>"GER");
		$nivelesOcupacionales[1] = array("nombre"=>"Jefe", "id"=>"JEF");
		$nivelesOcupacionales[2] = array("nombre"=>"Supervisor", "id"=>"SUP");
		$nivelesOcupacionales[3] = array("nombre"=>"Coordinador", "id"=>"COO");
		$nivelesOcupacionales[4] = array("nombre"=>"Analista", "id"=>"ANA");
		$nivelesOcupacionales[5] = array("nombre"=>"Asistente", "id"=>"ASI");
		$nivelesOcupacionales[6] = array("nombre"=>"Auxiliar", "id"=>"AUX");
		$nivelesOcupacionales[7] = array("nombre"=>"Operario", "id"=>"OPE");
		$nivelesOcupacionales[8] = array("nombre"=>"Desconozco mi nivel ocupacional", "id"=>"NON");

		$nivocuUsuarioCampana = $general->combo($nivelesOcupacionales, 'nivocuUsuarioCampana', false, '', '', 1);
		
?>
	<table id="cuestionario">
    	<tr id="titulo">
        	<td colspan="2">DATOS PERSONALES</td>
        </tr>
        <tr>
        	<td>
            	<label for="nomUsuario">Nombre:</label>
			</td>
            <td>
            	<input type="text" id="nomUsuario" name="nomUsuario" value="<?php echo $data['nomUsuario']?>" readonly="readonly" />
            </td>
        </tr>
        <tr>
        	<td>
            	<label for="appatUsuario">Apellido Paterno:</label>
			</td>
            <td>
            	<input type="text" id="appatUsuario" name="appatUsuario" value="<?php echo $data['appatUsuario']?>" readonly="readonly" />
            </td>
        </tr>
        <tr>
        	<td>
            	<label for="apmatUsuario">Apellido Materno:</label>
			</td>
            <td>
            	<input type="text" id="apmatUsuario" name="apmatUsuario" value="<?php echo $data['apmatUsuario']?>" readonly="readonly" />
            </td>
        </tr>
        <tr>
        	<td>
            	<label for="loginUsuario">DNI:</label>
			</td>
            <td>
            	<input type="text" id="loginUsuario" name="loginUsuario" value="<?php echo $data['loginUsuario']?>" readonly="readonly" />
            </td>
        </tr>
        <tr>
        	<td>
            	<label for="sexUsuario">Sexo: *</label>
			</td>
            <td>
            	<label for="sexUsuarioM">Masculino</label>
            	<input type="radio" id="sexUsuarioM" name="sexUsuario" value="M" <?php echo $sexUsuario['M'];?> obli="1" />
            	<label for="sexUsuarioF">Femenino</label>
            	<input type="radio" id="sexUsuarioF" name="sexUsuario" value="F" <?php echo $sexUsuario['F'];?> obli="1" />
            </td>
        </tr>
        <tr>
        	<td>
            	<label for="estcivUsuario">Estado Civil:</label>
			</td>
            <td>
            	<select id="estcivUsuario" name="estcivUsuario" size="1">
                	<option value="S" <?php echo $estcivUsuario['S'];?>>Soltero</option>
                	<option value="C" <?php echo $estcivUsuario['C'];?>>Casado</option>
                	<option value="V" <?php echo $estcivUsuario['V'];?>>Viudo</option>
                	<option value="D" <?php echo $estcivUsuario['D'];?>>Divorciado</option>
                </select>
            </td>
        </tr>
        <tr>
        	<td>
            	<label for="fechnacUsuario">Fecha de nacimiento: *</label>
			</td>
            <td>
            	<input type="text" id="fechnacUsuario" name="fechnacUsuario" value="<?php echo $data['fechnacUsuario']?>" obli="1" />
            </td>
        </tr>
        <tr>
        	<td>
            	<label for="emailUsuario">Correo electr&oacute;nico:</label>
			</td>
            <td>
            	<input type="text" id="emailUsuario" name="emailUsuario" value="<?php echo $data['emailUsuario']?>" />
            </td>
        </tr>
        <tr>
        	<td>
            	<label for="profesionUsuarioCampana">Profesi&oacute;n: *</label>
			</td>
            <td>
            	<input type="text" id="profesionUsuarioCampana" name="profesionUsuarioCampana" obli='1' />
            </td>
        </tr>
        <tr>
        	<td>
            	<label for="puestoUsuarioCampana">Puesto actual: *</label>
			</td>
            <td>
            	<input type="text" id="puestoUsuarioCampana" name="puestoUsuarioCampana" obli='1' />
            </td>
        </tr>
        <tr>
        	<td>
            	<label for="nivocuUsuarioCampana">Nivel ocupacional: *</label>
			</td>
            <td>
            	<?php echo $nivocuUsuarioCampana;?>
            </td>
        </tr>
        <tr>
        	<td>
            	<label>Nivel estructural: *</label>
			</td>
            <td>
            	<?php
					require_once(ENTITIES.'nivelTipo.php');
					require_once(ENTITIES.'nivel.php');
					$nivelTipo = new nivelTipo();
					$nivel = new nivel();
					
					$nivtip = $nivelTipo->getForCampaign($idCampana);
					$depenNivel = 0;
					$contador = 1;
					foreach($nivtip as $value){
				?>
                	<p id="nivel<?php echo $contador;?>">
                    	<label><?php echo $value['nombre'];?>:</label>
                        <?php echo $general->combo($nivel->getCombo($value['id'], $depenNivel), 'idNivel', true, '', 0, 1)?>
					</p>
                    <br />
                <?php
						$depenNivel = -1;
						$contador++;
					}
                ?>
            </td>
        </tr>
    </table>
<?php

      
        

	}else{
            
		if($actual==1){
                    

			if(!$usuarioCampana->checkAnswer($_SESSION['usuario']['id'])){
                            
				$data = array(
						'idUsuario'=>$_SESSION['usuario']['id'],
						'rolUsuario'=>'',
						'nomUsuario'=>'',
						'appatUsuario'=>'',
						'apmatUsuario'=>'',
						'loginUsuario'=>'',
						'passUsuario'=>'',
						'sexUsuario'=>'',
						'estcivUsuario'=>'',
						'fechnacUsuario'=>'',
						'emailUsuario'=>'',
						'estUsuario'=>'A',
						'usuCrea'=>$_SESSION['usuario']['id'],
						'usuEdita'=>$_SESSION['usuario']['id'],
						'fechCrea'=>'',
						'fechEdita'=>''
				);
				foreach($data as $key=>$value){
					if(isset($_POST[$key])){
						$data[$key] = $_POST[$key];
					}
				}
                                



				$usuario->set($data);
				$usuario->updateByUser();
				
				unset($data);
				$data = array(
					'idUsuarioCampana'=>'',
					'idUsuario'=>$_SESSION['usuario']['id'],
					'idCampana'=>$idCampana,
					'idNivel'=>$_REQUEST['idNivel'][(count($_REQUEST['idNivel'])-1)],
					'profesionUsuarioCampana'=>$_REQUEST['profesionUsuarioCampana'],
					'nivocuUsuarioCampana'=>$_REQUEST['nivocuUsuarioCampana'],
					'puestoUsuarioCampana'=>$_REQUEST['puestoUsuarioCampana']
				);
				$usuarioCampana->set($data);
				$usuarioCampana->updateByUser();
			}

		}else if(($actualMascara-1)<=$total){
			$idUsuarioCampana = $usuarioCampana->getID($_SESSION['usuario']['id'], $idCampana);         
			

                        //Se realiza un control de la pagina para que en caso se actualize el navegador
                        //no se graben los datos constantemente                        
                        //********************************************************************//
                        if(isset($_REQUEST['actual'])){
                            $valorGuardado = $_SESSION['usuario']['id']."_".$_REQUEST['idCampana']."_".$_REQUEST['actual'];                        
                        }else{
                            $valorGuardado = $_SESSION['usuario']['id']."_".$_REQUEST['idCampana']."_".$actualMascara;                            
                        }                        
                        
                        if(!isset($_SESSION[$valorGuardado]) && isset($_REQUEST['save'])){                            
                        
                            $_SESSION[$valorGuardado] = 1;    
                        //********************************************************************//
                            
                            for($i=1; $i<=$totalPreg; $i++){
                                    if(isset($_REQUEST['r'.$i])){
                                            if(is_array($_REQUEST['r'.$i])){
                                                    for($j=0; $j<count($_REQUEST['r'.$i]); $j++){
                                                            if(isset($_REQUEST['r'.$i][$j])){
                                                                    $data = array(
                                                                                    'idRespuesta'=>'',
                                                                                    'idPregunta'=>$_REQUEST['p'.$i],
                                                                                    'idUsuarioCampana'=>$idUsuarioCampana,
                                                                                    'contRespuesta'=>$_REQUEST['r'.$i][$j],
                                                                                    'ordRespuesta'=>($j+1)
                                                                    );
                                                                    $respuesta->set($data);
                                                                    $respuesta->insert();
                                                            }
                                                    }	
                                            }else{
                                                    if(isset($_REQUEST['r'.$i])){
                                                            $data = array(
                                                                            'idRespuesta'=>'',
                                                                            'idPregunta'=>$_REQUEST['p'.$i],
                                                                            'idUsuarioCampana'=>$idUsuarioCampana,
                                                                            'contRespuesta'=>$_REQUEST['r'.$i],
                                                                            'ordRespuesta'=>0
                                                            );
                                                            $respuesta->set($data);
                                                            $respuesta->insert();
                                                    }
                                                    if(isset($_REQUEST['totalSub'.$i])){
                                                            for($j=1; $j<=$_REQUEST['totalSub'.$i]; $j++){
                                                                    if(is_array($_REQUEST['r'.$i.'s'.$j])){								
                                                                            for($k=0; $k<count($_REQUEST['r'.$i.'s'.$j]); $k++){	
                                                                                    if(isset($_REQUEST['r'.$i.'s'.$j][$k])){								
                                                                                            $data = array(
                                                                                                            'idRespuesta'=>'',
                                                                                                            'idPregunta'=>$_REQUEST['p'.$i.'s'.$j],
                                                                                                            'idUsuarioCampana'=>$idUsuarioCampana,
                                                                                                            'contRespuesta'=>$_REQUEST['r'.$i.'s'.$j][$k],
                                                                                                            'ordRespuesta'=>($k+1)
                                                                                            );
                                                                                            $respuesta->set($data);
                                                                                            $respuesta->insert();
                                                                                    }
                                                                            }
                                                                    }else{
                                                                            if(isset($_REQUEST['r'.$i.'s'.$j])){
                                                                                    $data = array(
                                                                                                    'idRespuesta'=>'',
                                                                                                    'idPregunta'=>$_REQUEST['p'.$i.'s'.$j],
                                                                                                    'idUsuarioCampana'=>$idUsuarioCampana,
                                                                                                    'contRespuesta'=>$_REQUEST['r'.$i.'s'.$j],
                                                                                                    'ordRespuesta'=>0
                                                                                    );
                                                                                    $respuesta->set($data);
                                                                                    $respuesta->insert();
                                                                            }
                                                                    }					
                                                            }
                                                    }
                                            }
                                    }else{
                                            if(isset($_REQUEST['totalSub'.$i])){
                                                    for($j=1; $j<=$_REQUEST['totalSub'.$i]; $j++){
                                                            if(is_array($_REQUEST['r'.$i.'s'.$j])){								
                                                                    for($k=0; $k<count($_REQUEST['r'.$i.'s'.$j]); $k++){
                                                                            if(isset($_REQUEST['r'.$i.'s'.$j][$k])){								
                                                                                    $data = array(
                                                                                                    'idRespuesta'=>'',
                                                                                                    'idPregunta'=>$_REQUEST['p'.$i.'s'.$j],
                                                                                                    'idUsuarioCampana'=>$idUsuarioCampana,
                                                                                                    'contRespuesta'=>$_REQUEST['r'.$i.'s'.$j][$k],
                                                                                                    'ordRespuesta'=>($k+1)
                                                                                    );
                                                                                    $respuesta->set($data);
                                                                                    $respuesta->insert();
                                                                            }
                                                                    }
                                                            }else{
                                                                    if(isset($_REQUEST['r'.$i.'s'.$j])){
                                                                            $data = array(
                                                                                            'idRespuesta'=>'',
                                                                                            'idPregunta'=>$_REQUEST['p'.$i.'s'.$j],
                                                                                            'idUsuarioCampana'=>$idUsuarioCampana,
                                                                                            'contRespuesta'=>$_REQUEST['r'.$i.'s'.$j],
                                                                                            'ordRespuesta'=>0
                                                                            );
                                                                            $respuesta->set($data);
                                                                            $respuesta->insert();
                                                                    }
                                                            }					
                                                    }
                                            }
                                    }

                            }//for($i=1; $i<=$totalPreg; $i++){
                        
                    }   //Fin del control de grabacion
                        
		}
		$actualMascara = $respuesta->countGroup($usuarioCampana->getID($_SESSION['usuario']['id'], $_REQUEST['idCampana']));
		if($actualMascara > $total){
			header('location: cuestionario.php');
		}
		
                

		$idPregGrupo = $preguntaGrupo->getIDByOrder($respuesta->lastGroup($usuarioCampana->getID($_SESSION['usuario']['id'], $_REQUEST['idCampana'])), $_REQUEST['idCampana']);
	
        if($idPregGrupo){	
                    $multiGrupo = "";

                    $boolMultiGrupo = !$preguntaGrupo->getMultiByID($idPregGrupo);
                    $cantMultiGrupo = 2;

                    $preguntas = $pregunta->getByGroup($idPregGrupo, $_REQUEST['idCampana']);
                    $totalPreg = count($preguntas);

                    if(!$boolMultiGrupo){			
                            $cantMultiGrupo = count($preguntas);
                    }

		
?>
	<table id="cuestionario">
    	<thead>
            <tr id="titulo">
                <td colspan="<?php echo ($cantMultiGrupo+1);?>"><?php echo $pregGrup[$idPregGrupo]['nombre'];?> (<?php echo $actualMascara;?> de <?php echo $total;?> Secciones)</td>
            </tr>
            <tr id="titulo">
            	<td colspan="<?php echo ($cantMultiGrupo+1);?>"><?php echo $pregGrup[$idPregGrupo]['descripcion'];?></td>
            </tr>
            <?php	if(!$boolMultiGrupo){	?>
            <tr>
	            <td colspan="<?php echo ($cantMultiGrupo+1);?>">
                	<a href='#' id='addGroup'>
                    	<img src='<?php echo images;?>icon_add.png' height='20px' />
                        Agregar respuesta
					</a>
				</td>
            </tr>
            <?php	}	?>
        </thead>
        <tbody>
        	<?php 	if($boolMultiGrupo){	?>
            	<tr>
            <?php	}else{	?>
            		<td></td>
            <?php	}	?>
			<?php
                $i=1;
                foreach($preguntas as $value){			
                    unset($alternativas);
                    $alternativas = $alternativa->getByQuestion($value['id']);
                    					
					$multiNombre = "";
					if(!$boolMultiGrupo or $value['multiple']){
						$multiNombre = "[]";
					}
					
                    $respuestas = "";
                    
                    switch($value['tipo']){
                        case 'T':
                            if($value['tamanio']>0){
                                $maxlength = $value['tamanio'];
                                $size = (int)$maxlength*2;                                
                            }else{
                                $size = 60;
                                $maxlength = '';
                            }
                            $readonly = '';
                            if($value['valor']!=''){$readonly = "readOnly = 'true' style='background-color: #cccccc;'"; }    
                            $respuestas = "<input type='text' id='r{$i}' name='r{$i}{$multiNombre}' obli='{$value['obligatorio']}' num='{$value['numerico']}'  size='{$size}' maxlength='{$maxlength}' value='{$value['valor']}' {$readonly}/>";
                            break;
                        case 'S':
                            $respuestas = $general->selector($alternativas, 'r'.$i, !$boolMultiGrupo, $value['obligatorio']);
                            break;
                        case 'D':
                            $respuestas = "<textarea id='r{$i}' name='r{$i}{$multiNombre}' cols='100' rows='8' obli='{$value['obligatorio']}'></textarea>";
                            break;
                        case 'C':
                            $respuestas = $general->checkboxs($alternativas, 'r'.$i ,null);
                            break;
                        case 'R':
                            $respuestas = $general->radio($alternativas, 'r'.$i, !$boolMultiGrupo, $value['obligatorio']);
                            break;
                        case 'F':
                            $respuestas = "<input type='text' id='r{$i}' name='r{$i}{$multiNombre}' obli='{$value['obligatorio']}' esFecha='1' readOnly='true'/>";
                            $fecha .= ", #r{$i}";
                            break;
                        case 'N':
                                $respuestas = "<input type='hidden' id='r{$i}' title='ajax' value='{$i}' obli='{$value['obligatorio']}' />";
                                break;
                    }
            ?>
        	<?php 	if($boolMultiGrupo){	?>
            <tr id="pregunta">
                <td>
                    <?php echo $i;?>. 
                </td>
            <?php	}	?>
                <td>
                    <input type="hidden" id="p<?php echo $i;?>" name="p<?php echo $i;?>" multi="<?php echo $value['multiple'];?>" value="<?php echo $value['id'];?>" />
					<?php echo utf8_encode($value['nombre']);?> 
					<?php if($value['descripcion']!=''){?>
                    <a id="help">
                        <img src="<?php echo images;?>icon_help.png" />
                        <div>
                            <img src="<?php echo images;?>icon_help.png" /> <?php echo $value['descripcion'];?>
                        </div>
                    </a>
                    <?php }?>
                    <?php 	if($value['multiple']){	?>                    	
                    <br />
                	<a href='#' id='addQuestion'>
                    	<img src='<?php echo images;?>icon_add.png' height='20px' />
                        Agregar respuesta
					</a>
                    <?php	}	?>
        	<?php 	if($boolMultiGrupo){	?>
				</td>
            </tr>
            <tr>
                <td></td>
                <td>
        	<?php 	}	?>
					<?php echo utf8_encode($respuestas);?>
				</td>
        	<?php 	if($boolMultiGrupo){	?>
            </tr>
        	<?php 	}	?>
            <?php
                    $i++;
                }
            ?>
        </tbody>
    </table>
<?php
        }else{
            echo "No hay preguntas disponibles";            
        }
      }  
?>
		
        <br /><br />
        <p>

            <button type="submit">
                Guardar y continuar
                <img src="<?php echo images;?>icon_save.png" />                 
            </button>

            
		</p>
		<input type="hidden" id="totalPreg" name="totalPreg" value="<?php echo $totalPreg;?>" />
		<input type="hidden" id="actual" name="actual" value="<?php echo $actual;?>" />
		<input type="hidden" id="total" name="total" value="<?php echo $total;?>" />
		<input type="hidden" id="fecha" name="fecha" value="<?php echo $fecha;?>" />
		<input type="hidden" id="idCampana" name="idCampana" value="<?php echo $idCampana;?>" />
		<input type="hidden" id="campana" name="campana" value="<?php echo $idCampana;?>" />
<?php
}

if(isset($_REQUEST['edicion'])){
	require_once(ENTITIES.'reportes.php');
	$reporte = new reportes();
	
	if($_REQUEST['edicion']){
	
		$totalPreg = $_REQUEST['totalPreg'];
		$idUsuarioCampana = $usuarioCampana->getID($_SESSION['usuario']['id'], $_REQUEST['campana']);
		
		$respuesta->deleteByGroupID($_REQUEST['id'], $idUsuarioCampana);
		
		for($i=1; $i<=$totalPreg; $i++){
			if(isset($_REQUEST['r'.$i])){
				if(is_array($_REQUEST['r'.$i])){
					for($j=0; $j<count($_REQUEST['r'.$i]); $j++){
						if(isset($_REQUEST['r'.$i][$j])){
							$data = array(
									'idRespuesta'=>'',
									'idPregunta'=>$_REQUEST['p'.$i],
									'idUsuarioCampana'=>$idUsuarioCampana,
									'contRespuesta'=>$_REQUEST['r'.$i][$j],
									'ordRespuesta'=>($j+1)
							);
							$respuesta->set($data);
							$respuesta->insert();
						}
					}	
				}else{
					if(isset($_REQUEST['r'.$i])){
						$data = array(
								'idRespuesta'=>'',
								'idPregunta'=>$_REQUEST['p'.$i],
								'idUsuarioCampana'=>$idUsuarioCampana,
								'contRespuesta'=>$_REQUEST['r'.$i],
								'ordRespuesta'=>0
						);
						$respuesta->set($data);
						$respuesta->insert();
					}
					if(isset($_REQUEST['totalSub'.$i])){
						for($j=1; $j<=$_REQUEST['totalSub'.$i]; $j++){
							if(is_array($_REQUEST['r'.$i.'s'.$j])){								
								for($k=0; $k<count($_REQUEST['r'.$i.'s'.$j]); $k++){	
									if(isset($_REQUEST['r'.$i.'s'.$j][$k])){								
										$data = array(
												'idRespuesta'=>'',
												'idPregunta'=>$_REQUEST['p'.$i.'s'.$j],
												'idUsuarioCampana'=>$idUsuarioCampana,
												'contRespuesta'=>$_REQUEST['r'.$i.'s'.$j][$k],
												'ordRespuesta'=>($k+1)
										);
										$respuesta->set($data);
										$respuesta->insert();
									}
								}
							}else{
								if(isset($_REQUEST['r'.$i.'s'.$j])){
									$data = array(
											'idRespuesta'=>'',
											'idPregunta'=>$_REQUEST['p'.$i.'s'.$j],
											'idUsuarioCampana'=>$idUsuarioCampana,
											'contRespuesta'=>$_REQUEST['r'.$i.'s'.$j],
											'ordRespuesta'=>0
									);
									$respuesta->set($data);
									$respuesta->insert();
								}
							}					
						}
					}
				}
			}else{
				if(isset($_REQUEST['totalSub'.$i])){
					for($j=1; $j<=$_REQUEST['totalSub'.$i]; $j++){
						if(is_array($_REQUEST['r'.$i.'s'.$j])){								
							for($k=0; $k<count($_REQUEST['r'.$i.'s'.$j]); $k++){
								if(isset($_REQUEST['r'.$i.'s'.$j][$k])){
									$data = array(
											'idRespuesta'=>'',
											'idPregunta'=>$_REQUEST['p'.$i.'s'.$j],
											'idUsuarioCampana'=>$idUsuarioCampana,
											'contRespuesta'=>$_REQUEST['r'.$i.'s'.$j][$k],
											'ordRespuesta'=>($k+1)
									);
									$respuesta->set($data);
									$respuesta->insert();
								}
							}
						}else{
							if(isset($_REQUEST['r'.$i.'s'.$j])){
								$data = array(
										'idRespuesta'=>'',
										'idPregunta'=>$_REQUEST['p'.$i.'s'.$j],
										'idUsuarioCampana'=>$idUsuarioCampana,
										'contRespuesta'=>$_REQUEST['r'.$i.'s'.$j],
										'ordRespuesta'=>0
								);
								$respuesta->set($data);
								$respuesta->insert();
							}
						}					
					}
				}
			}
		}
		header("location: cuestionario.php");
	}

	$fecha = "input#fecha";
	$idCampana = $_REQUEST['campana'];
	$idPregGrupo = $_REQUEST['id'];
	$idUsuarioCampana = $_REQUEST['usucam'];
		
	$boolMultiGrupo = !$preguntaGrupo->getMultiByID($idPregGrupo);
	$cantMultiGrupo = 2;
	
	$nomPreguntaGrupo = $preguntaGrupo->getNameByID($idPregGrupo);
	
	$preguntas = $pregunta->getByGroup($idPregGrupo, $_REQUEST['campana']);
	$totalPreg = count($preguntas);
	
	if(!$boolMultiGrupo){			
		$cantMultiGrupo = count($preguntas);
	}
?>
<form id="formCuestionario" name="formCuestionario" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<br />
<p>
    <a href="cuestionario.php">
        <button type="button">
            Volver
        </button>
    </a>
</p>
<br />
<table id="cuestionario">
    	<thead>
            <tr id="titulo">
                <td colspan="<?php echo ($cantMultiGrupo+1);?>"><?php echo $nomPreguntaGrupo;?></td>
            </tr>
            <?php	if(!$boolMultiGrupo){	?>
            <tr>
	            <td colspan="<?php echo ($cantMultiGrupo+1);?>">
                	<a href='#' id='addGroup'>
                    	<img src='<?php echo images;?>icon_add.png' height='20px' />
                        Agregar respuesta
					</a>
				</td>
            </tr>
            <?php	}	?>
        </thead>
        <tbody>
<?php
	if(!$boolMultiGrupo){
		$idsResueltas = "0";
		foreach($preguntas as $value){
			$idsResueltas .= ",".$value['id'];
		}
		$resueltas = $reporte->getAnswers($idsResueltas, $idUsuarioCampana);
		
		$mayor=1;
		foreach($resueltas as $key=>$value){
			if(count($value)>$mayor){
				$mayor = count($value);
			}
		}
		
		for($j=0; $j<$mayor; $j++){	
?>
				<tr>
                	<td>
<?php
			if($j>0){
?>
						<a id="delQuestionGroup" href="#">Quitar</a>
<?php
			}
?>
                    </td>
<?php		
			$i=1;
			foreach($preguntas as $value){	
				unset($alternativas);
				$alternativas = $alternativa->getByQuestion($value['id']);
									
				$multiNombre = "";
				if(!$boolMultiGrupo or $value['multiple']){
					$multiNombre = "[]";
				}
				
				$respuestas = "";
				switch($value['tipo']){
					case 'T':
						if($value['tamanio']>0){
							$maxlength = $value['tamanio'];
							$size = (int)$maxlength*2;                                
						}else{
							$size = 60;
							$maxlength = '';
						}  
						$respuestas = "<input type='text' id='r{$i}' name='r{$i}{$multiNombre}' obli='{$value['obligatorio']}' value='".utf8_decode($resueltas[$value['nombre'].' ('.$value['codigo'].')'][$j])."' num='{$value['numerico']}' size='{$size}' maxlength='{$maxlength}' />";
						break;
					case 'S':
						$respuestas = $general->selector($alternativas, 'r'.$i, !$boolMultiGrupo, $value['obligatorio'], $resueltas[$value['nombre'].' ('.$value['codigo'].')'][$j]);
						break;
					case 'D':
						$respuestas = "<textarea id='r{$i}' name='r{$i}{$multiNombre}' cols='100' rows='8' obli='{$value['obligatorio']}'>".utf8_decode($resueltas[$value['nombre'].' ('.$value['codigo'].')'][$j])."</textarea>";
						break;
					case 'C':       
                                                echo '<pre>';
                                                print_r($resueltas);
                                                echo '</pre>';
                                                $respuestas = $general->checkboxs($alternativas, 'r'.$i ,$resueltas);
						break;
					case 'R':
						$respuestas = $general->radio($alternativas, 'r'.$i, !$boolMultiGrupo, $value['obligatorio'], $resueltas[$value['nombre'].' ('.$value['codigo'].')'][0]);
						break;
					case 'F':
						$respuestas = "<input type='text' id='r{$i}' name='r{$i}{$multiNombre}' obli='{$value['obligatorio']}' value='{$resueltas[$value['nombre'].' ('.$value['codigo'].')'][$j]}' esFecha='1' readOnly='true'/>";
						$fecha .= ", #r{$i}";
						break;
					case 'N':
						$respuestas = "";
						break;
				}
?>
                <td>
                    <input type="hidden" id="p<?php echo $i;?>" name="p<?php echo $i;?>" multi="<?php echo $value['multiple'];?>" value="<?php echo $value['id'];?>" />
					<?php echo utf8_encode($value['nombre']);?>
					<?php if($value['descripcion']!=''){?>
                    <a id="help">
                        <img src="<?php echo images;?>icon_help.png" />
                        <div>
                            <img src="<?php echo images;?>icon_help.png" /> <?php echo $value['descripcion'];?>
                        </div>
                    </a>
                    <?php }?>
                    <br />
					<?php echo utf8_encode($respuestas);?>
				</td>
            <?php
				$i++;
			}
		}
?>	
			</tr>
<?php
	}else{
?>
            	<tr>
<?php
		$i=1;
		foreach($preguntas as $value){
?>
            <tr id="pregunta">
                <td>
                    <?php echo $i;?>. 
                </td>
                <td>
                    <input type="hidden" id="p<?php echo $i;?>" name="p<?php echo $i;?>" multi="<?php echo $value['multiple'];?>" value="<?php echo $value['id'];?>" />
					<?php echo utf8_encode($value['nombre']);?> 
					<?php if($value['descripcion']!=''){?>
                    <a id="help">
                        <img src="<?php echo images;?>icon_help.png" />
                        <div>
                            <img src="<?php echo images;?>icon_help.png" /> <?php echo $value['descripcion'];?>
                        </div>
                    </a>
                    <?php }?>
                    <?php 	if($value['multiple']){	?>                    	
                    <br />
                	<a href='#' id='addQuestion'>
                    	<img src='<?php echo images;?>icon_add.png' height='20px' />
                        Agregar respuesta
					</a>
                    <?php	}	?>
				</td>
            </tr>
<?php
		
			unset($alternativas);
			$alternativas = $alternativa->getByQuestion($value['id']);
			
			$resueltas = $reporte->getAnswers($value['id'], $idUsuarioCampana);
                        
			$multiNombre = "";
			if(!$boolMultiGrupo or $value['multiple']){
				$multiNombre = "[]";
			}
			
			$respuestas = "";
			if(is_array($resueltas)){
				for($j=0; $j<count($resueltas[$value['nombre'].' ('.$value['codigo'].')']); $j++){
					if($j>0){
						$respuestas .= "<br />";
					}
					switch($value['tipo']){
						case 'T':
							if($value['tamanio']>0){
								$maxlength = $value['tamanio'];
								$size = (int)$maxlength*2;                                
							}else{
								$size = 60;
								$maxlength = '';
							}                                                    
							$respuestas .= "<input type='text' id='r{$i}' name='r{$i}{$multiNombre}' obli='{$value['obligatorio']}' value='".utf8_decode($resueltas[$value['nombre'].' ('.$value['codigo'].')'][$j])."' num='{$value['numerico']}' size='{$size}' maxlength='{$maxlength}'/>";
							break;
						case 'S':
							$respuestas .= $general->selector($alternativas, 'r'.$i, !$boolMultiGrupo, $value['obligatorio'], $resueltas[$value['nombre'].' ('.$value['codigo'].')'][$j]);
							break;
						case 'D':
							$respuestas .= "<textarea id='r{$i}' name='r{$i}{$multiNombre}' cols='100' rows='8' obli='{$value['obligatorio']}'>".utf8_decode($resueltas[$value['nombre'].' ('.$value['codigo'].')'][$j])."</textarea>";
							break;
						case 'C':
                                                        $respuestas = $general->checkboxs($alternativas, 'r'.$i , $resueltas);
							break;
						case 'R':
							$respuestas .= $general->radio($alternativas, 'r'.$i, !$boolMultiGrupo, $value['obligatorio'], $resueltas[$value['nombre'].' ('.$value['codigo'].')'][$j]);
							break;
						case 'F':
							$respuestas .= "<input type='text' id='r{$i}' name='r{$i}{$multiNombre}' obli='{$value['obligatorio']}' value='{$resueltas[$value['nombre'].' ('.$value['codigo'].')'][$j]}' esFecha='1' readOnly='true'/>";
							$fecha .= ", #r{$i}";
							break;
						case 'N':
							$respuestas .= "";
							break;
					}
					if($j>0 && $value['tipo']!='C'){
						$respuestas .= "<a id='delQuestion' href='#'>Quitar</a>";
					}
				}
			}else{
				switch($value['tipo']){
					case 'T':
						if($value['tamanio']>0){
							$maxlength = $value['tamanio'];
							$size = (int)$maxlength*2;                                
						}else{
							$size = 60;
							$maxlength = '';
						}  
						$respuestas = "<input type='text' id='r{$i}' name='r{$i}{$multiNombre}' obli='{$value['obligatorio']}' num='{$value['numerico']}' size='{$size}' maxlength='{$maxlength}'/>";
						break;
					case 'S':
						$respuestas = $general->selector($alternativas, 'r'.$i, !$boolMultiGrupo, $value['obligatorio']);
						break;
					case 'D':
						$respuestas = "<textarea id='r{$i}' name='r{$i}{$multiNombre}' cols='100' rows='8' obli='{$value['obligatorio']}'></textarea>";
						break;
					case 'C':
						break;
					case 'R':
						$respuestas = $general->radio($alternativas, 'r'.$i, !$boolMultiGrupo, $value['obligatorio']);
						break;
					case 'F':
						$respuestas = "<input type='text' id='r{$i}' name='r{$i}{$multiNombre}' obli='{$value['obligatorio']}' esFecha='1' readOnly='true'/>";
						$fecha .= ", #r{$i}";
						break;
					case 'N':
						//$respuestas = "<input type='hidden' id='r{$i}' title='ajax' value='{$i}' obli='{$value['obligatorio']}' />";
						$respuestas .= "";
						break;
				}
			}
?>
            <tr>
                <td></td>
                <td>
<?php 
			echo utf8_encode($respuestas);
	
			$dependientes = $pregunta->getByDepen($value['id'], $idCampana);
                        
			if(is_array($dependientes)){
				$idsDepen = "0";
				$totalSub = 0;
				foreach($dependientes as $keyDepen=>$valueDepen){
					$idsDepen .= ",".$valueDepen['id'];
					$totalSub++;
				}
				$resueltasDepen = $reporte->getAnswers($idsDepen, $idUsuarioCampana);
				if(is_array($resueltasDepen)){
				$mayor=1;
				foreach($resueltasDepen as $key=>$value){
					if(count($value)>$mayor){
						$mayor = count($value);
					}
				}
?>
                    <table id="cuestionario">
                    	<tr id="pregunta">
                        	<td></td>
<?php
				$k = 1;
				foreach($dependientes as $keyDepen=>$valueDepen){					
?>
							<td>
                            	<input type="hidden" id="totalSub<?php echo $i;?>" name="totalSub<?php echo $i;?>" value="<?php echo $totalSub;?>" />
				                <input type="hidden" id="p<?php echo $i;?>s<?php echo $k;?>" name="p<?php echo $i;?>s<?php echo $k;?>" value="<?php echo $valueDepen['id'];?>" />
								<?php echo $valueDepen['nombre'];?> 
								<?php if($valueDepen['descripcion']!=''){?>
                                <a id="help">
                                    <img src="<?php echo images;?>icon_help.png" />
                                    <div>
                                        <img src="<?php echo images;?>icon_help.png" /> <?php echo $value['descripcion'];?>
                                    </div>
                                </a>
                                <?php }?>
							</td>
<?php
					$k++;
				}
?>
						</tr>
<?php
				for($j=0; $j<$mayor;$j++){
?>
						<tr>
                        	<td>
<?php
					if($j>0){
?>
								<a id="delQuestionGroup" href="#">Quitar</a>
<?php
					}
?>
                            </td>
<?php
					$k=1;
                                 
                                        
					foreach($dependientes as $keyDepen=>$valueDepen){
						unset($alternativas);
						$alternativas = $alternativa->getByQuestion($valueDepen['id']);                                                

						$multiNombre = "";
						if($valueDepen['multiple']){
							$multiNombre = "[]";
						}
						
						switch($valueDepen['tipo']){
							case 'T':
								if($valueDepen['tamanio']>0){
									$maxlength = $valueDepen['tamanio'];
									$size = (int)$maxlength*2;                                
								}else{
									$size = 20;
									$maxlength = '';
								}  
								$respuestas = "<input type='text' id='r{$i}s{$k}' name='r{$i}s{$k}{$multiNombre}' obli='{$valueDepen['obligatorio']}' value='".$resueltasDepen[$valueDepen['nombre'].' ('.$valueDepen['codigo'].')'][$j]."' num='{$valueDepen['numerico']}' size='{$size}' maxlength='{$maxlength}'/>";
								break;
							case 'S':
								$respuestas = $general->selector($alternativas, 'r'.$i.'s'.$k, $valueDepen['multiple'], $valueDepen['obligatorio'], $resueltasDepen[$valueDepen['nombre'].' ('.$valueDepen['codigo'].')'][$j]);
								break;
							case 'D':
								$respuestas = "<textarea id='r{$i}s{$k}' name='r{$i}s{$k}{$multiNombre}' cols='60' rows='4' obli='{$valueDepen['obligatorio']}'>".$resueltasDepen[$valueDepen['nombre'].' ('.$valueDepen['codigo'].')'][$j]."</textarea>";
								break;
							case 'C':
								break;
							case 'R':
								$respuestas = $general->radio($alternativas, 'r'.$i.'s'.$k, $valueDepen['multiple'], $valueDepen['obligatorio'], $resueltasDepen[$valueDepen['nombre'].' ('.$valueDepen['codigo'].')'][$j]);
								break;
							case 'F':
								$respuestas = "<input type='text' id='r{$i}s{$k}' name='r{$i}s{$k}{$multiNombre}' obli='{$valueDepen['obligatorio']}' value='{$resueltasDepen[$valueDepen['nombre'].' ('.$valueDepen['codigo'].')'][$j]}' esFecha='1' readOnly='true'/>";
								$fecha .= ", #r{$i}";
								break;
							case 'N':
								$respuestas = "<input type='hidden' id='r{$i}s{$k}' title='ajax' value='{$i}' obli='{$value['obligatorio']}' />";
								break;
						}
?>
						<td><?php echo $respuestas;?></td>
<?php
						$k++;
					}
?>
						</tr>
<?php
				}
?>
                    </table>
<?php
				}				
			}
?>
				</td>
            </tr>
<?php
			$i++;
		}
	}
?>
        </tbody>
    </table>		
    <br /><br />
    <p>
        <a href="cuestionario.php">
            <button type="button">
                Volver
            </button>
        </a>
        <button type="submit">
            Guardar
            <img src="<?php echo images;?>icon_save.png" />                 
        </button>
    </p>
    <input type="hidden" id="edicion" name="edicion" value="1" />
    <input type="hidden" id="id" name="id" value="<?php echo $_REQUEST['id'];?>" />
    <input type="hidden" id="totalPreg" name="totalPreg" value="<?php echo $totalPreg;?>" />
    <input type="hidden" id="fecha" name="fecha" value="<?php echo $fecha;?>" />
    <input type="hidden" id="campana" name="campana" value="<?php echo $idCampana;?>" />
</form>
<?php	
}
require_once(TEMPLATES.'footer.php');
?>