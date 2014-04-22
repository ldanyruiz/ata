<?php
require_once('config.php');
require_once(TEMPLATES.'header.php');

require_once(RESOURCES.'general.php');
require_once(ENTITIES.'reporte.php');
require_once(ENTITIES.'seccion.php');
require_once(ENTITIES.'reportePregunta.php');
require_once(ENTITIES.'pregunta.php');
$general = new general();
$reporte = new reporte();
$seccion = new seccion();
$reportePregunta = new reportePregunta();
$pregunta = new pregunta();

require_once(ENTITIES.'holding.php');
require_once(ENTITIES.'empresa.php');
require_once(ENTITIES.'campana.php');
$holding = new holding();
$empresa = new empresa();
$campana = new campana();

$mensaje = "";
if(!isset($_REQUEST['op'])){
?>
<form id="formGrilla" name="formGrilla" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <h1>
	    Constructor de Reportes
		<img src="<?php echo images;?>icon_constructor.png" <?php echo sizeImg3;?> />
    </h1>
	<br /><br />
	<a href="constructor.php?op=nu">
		<img src="<?php echo images;?>icon_add.png" <?php echo sizeImg;?> />
		Construir reporte
	</a>
	<br /><br />
	<label for="txtBuscar">Buscar:</label>
	<input type="text" id="txtBuscar" name="txtBuscar" size="100" />
	<button type="button" id="buscarGrilla" name="buscarGrilla">
		<img src="<?php echo images;?>icon_look.png" />
		BUSCAR
	</button>
	<br /><br /><br />
	<center><p class="mensaje"><?php echo $mensaje;?></p></center>
	<br /><br />
	<?php
	
	$buscar = "";
	if(isset($_REQUEST['txtBuscar'])){
		$buscar = $_REQUEST['txtBuscar'];
	}
	
	$reporte->numRows($buscar);
	
	$paginacion = array("totalPag"=>$reporte->numRows, "actualPag"=>0, "cantPag"=>50, "colPag"=>"", "ascPag"=>1);
	foreach($paginacion as $key => $value){
		if(isset($_REQUEST[$key])){
			$paginacion[$key] = $_REQUEST[$key];
		}
	}	
	$paginacion["totalPag"] = $reporte->numRows;
	
	echo $general->grilla($reporte->show($buscar, $paginacion), 'Lista de reportes construidos', 'icon_report.png', 'constructor.php', false, false, true, $paginacion);
	?>
</form>
<p class="loading"></p>
<?php
}else{
?>
<form id="formConstructor" name="formConstructor" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<script src="<?php echo SCRIPTS;?>constructor.js" language="javascript" type="text/javascript"></script>
<?php
	
	$idReporte = 0;
	if(isset($_REQUEST['id'])){
		$idReporte = $_REQUEST['id'];
	}
	$titulo = "";
	$mensajeSeccion = "";
	$opcionPestana = "Crear";
	$checkedTodos = "";
			
	$idHolding = 0;
	$idEmpresa = 0;
	$idCampana = 0;
				
	if(!isset($_POST['idSeccionPes'])){
		$_POST['idSeccionPes'] = 0;
	}
	
	$data = array(
			'idReporte'=>$idReporte,
			'idCampana'=>'NULL',
			'nomReporte'=>'',
			'descrReporte'=>'',
			'estReporte'=>1,
			'usuCrea'=>$_SESSION['usuario']['id'],
			'usuEdita'=>$_SESSION['usuario']['id'],
			'fechCrea'=>'',
			'fechEdita'=>''
	);
	
	$dataSeccion = array(
		'idSeccion'=>NULL,
		'idReporte'=>'NULL',
		'nomSeccion'=>''
	);
	
	if(isset($_POST['todosReporte'])){
		$checkedTodos = "checked='CHECKED'";
	}
	//Reconociendo los datos enviados
	foreach($data as $key=>$value){
		if(isset($_POST[$key])){
			$data[$key] = $_POST[$key];
		}
	}
	foreach($dataSeccion as $key=>$value){
		if(isset($_POST[$key])){
			$dataSeccion[$key] = $_POST[$key];
		}
	}
	
	switch($_REQUEST['op']){
		case 'nu':
			$titulo = "Crear";
			if(isset($_POST)){
				if(isset($_POST['idCampana']) or isset($_POST['todosReporte'])){
					if($_POST['nomReporte']!="" and (isset($_POST['todosReporte']) or $_POST['idCampana']!="NULL")){
						$reporte->set($data);
						$idReporte = $reporte->insert();
						if($idReporte){
							header('location: constructor.php?op=li&m&id='.$idReporte);
						}else{
							$mensaje = "Debes llenar todos los campos correctamente.";
						}
					}else{
						$mensaje = "Debes llenar todos los campos correctamente.";
					}
				}
			}
			break;
		case 'li':
			$titulo = "Editar";
			$idReporte = $_REQUEST['id'];
			$data = $reporte->get($idReporte);
			
			if(isset($_REQUEST['m'])){
				$mensaje = "Registro guardado exitosamente.";
			}
	
			if(is_numeric($data['idCampana'])){
				$checkedTodos = "checked='CHECKED'";
			}
			
			$dataAux = $reporte->getAllInfoCampaign($data['idCampana']);
			$idCampana = $dataAux['idCampana'];
			$idEmpresa = $dataAux['idEmpresa'];
			$idHolding = $dataAux['idHolding'];
			
			$_REQUEST['op'] = 'ed';
			
			$_POST['opSeccion'] = "";
			break;
		case 'ed':
			$titulo = "Editar";
			if(isset($_POST)){
				if(isset($_POST['idCampana']) or isset($_POST['todosReporte'])){
					if($_POST['nomReporte']!="" and (isset($_POST['todosReporte']) or $_POST['idCampana']!="NULL")){
						$reporte->set($data);
						if($reporte->update()){
							$mensaje = "Registro guardado exitosamente.";
						}else{
							$mensaje = "No se han realizado cambios.";
						}
					}else{
						$mensaje = "Debes llenar todos los campos correctamente.";
					}
				}
				$seccion->set($dataSeccion);
				
				if(isset($_POST['opSeccion'])){
					switch($_POST['opSeccion']){
						case 'nu':
							if(isset($_POST['nomSeccion'])){
								if($_POST['nomSeccion']<>""){
									$_POST['idSeccionPes'] = $seccion->insert();
									if($_POST['idSeccionPes']){
										$mensajeSeccion = "Pesta&ntilde;a generada correctamente.";
										
										$dataSeccion['nomSeccion'] = "";
										$_POST['opSeccion'] = "pesEd";
									}else{
										$mensajeSeccion = "La pesta&ntilde;a no ha podido ser generada.";
									}
								}else{
									$mensajeSeccion = "Debes escribir un nombre para generar la pesta&ntilde;a.";
									$_POST['opSeccion'] = "";
									$_POST['idSeccionPes'] = "";
								}
							}
							break;
						case 'ed':
							$dataSeccion['nomSeccion'] = $_POST['seccion'.$_POST['idSeccion']];
							$seccion->set($dataSeccion);
							if($seccion->update()){
								$mensajeSeccion = "Pesta&ntilde;a editada correctamente.";
							}else{
								$mensajeSeccion = "No se han realizado cambios en la pesta&ntilde;a.";
							}
							break;
						case 'el':
							if($dataSeccion['idSeccion']==$_POST['idSeccionPes']){
								$_POST['idSeccionPes'] = "";
							}
							$reportePregunta->deleteByIDSection($dataSeccion['idSeccion']);
							if($seccion->delete($dataSeccion['idSeccion'])){
								$mensajeSeccion = "Pesta&ntilde;a eliminada correctamente.";
							}else{
								$mensajeSeccion = "No se ha eliminado la pesta&ntilde;a.";
							}
							$_POST['opSeccion'] = "";
							break;
						case 'pes':
							$_POST['opSeccion'] = "pesEd";
							$marcadas = $reportePregunta->getBySectionID($_POST['idSeccionPes']);
							break;
						case 'pesEd':
							$dataReportePregunta = array(
								'idReportePregunta'=>NULL,
								'idSeccion'=>$_POST['idSeccionPes'],
								'idPregunta'=>NULL
							);
							$reportePregunta->deleteByIDSection($_POST['idSeccionPes']);
							$marcadas = array();
							for($i=1; $i<=$_POST['totalP']; $i++){
								if(isset($_POST['p'.$i])){
									$dataReportePregunta['idPregunta'] = $_POST['p'.$i];
									$reportePregunta->set($dataReportePregunta);
									$reportePregunta->insert();
									$marcadas[$_POST['p'.$i]] = 1;
								}
							}
							break;
					}
				}else{
					$_POST['opSeccion'] = "";
				}
			}
			break;
		case 'el':
			if(isset($_REQUEST['id'])){
				if($reporte->updateStatus($_REQUEST['id'])){
					$mensaje = "Registro eliminado exitosamente.";
				}else{
					$mensaje = "No se pudo eliminar el registro.";
				}
			}
			break;
	}
	
	
	//Validación de recepción de variables de Holding, Empresa y Campaña
	if(isset($_REQUEST['idHolding'])){
		$idHolding = $_REQUEST['idHolding'];
	}
	
	if(isset($_REQUEST['idEmpresa'])){
		$idEmpresa = $_REQUEST['idEmpresa'];
	}
	
	if(isset($_REQUEST['idCampana'])){
		$idCampana = $_REQUEST['idCampana'];
	}
	
	$estReporte = array(0=>'', 1=>'');
	$estReporte[$data['estReporte']] = "checked='CHECKED'";
				
	$pestanas = $seccion->getByReportID($idReporte);
?>
    <h1>
	    <?php echo $titulo;?> reporte
		<img src="<?php echo images;?>icon_constructor.png" <?php echo sizeImg3;?> />
    </h1>
	<br /><br />
   	<a href="constructor.php"> << Volver</a>
    <br /><br />
	<p class="mensaje"><?php echo $mensaje;?></p>
    <input type="hidden" id="idReporte" name="idReporte" value="<?php echo $data['idReporte'];?>" />
    <table id="formulario">
    	<tbody>
            <tr>
                <td>
                    <label for="idHolding">Holding:</label>
                </td>
                <td>
                    <?php echo $general->combo($holding->getCombo(), 'idHolding', false, '', $idHolding);?>
                </td>
            </tr>
<?php
		if($idHolding and $idHolding<>'NULL'){
?>
            <tr>
                <td>
                    <label for="idEmpresa">Empresa:</label>
                </td>
                <td>
                    <?php echo $general->combo($empresa->getCombo($idHolding), 'idEmpresa', false, '', $idEmpresa);?>
                </td>
            </tr>
<?php
		}
		if($idEmpresa and $idEmpresa<>'NULL'){
?>
            <tr>
                <td>
                    <label for="idCampana">Campa&ntilde;a:</label>
                </td>
                <td>
                    <?php echo $general->combo($campana->getCombo($idEmpresa), 'idCampana', false, '', $idCampana);?>
                </td>
            </tr>
<?php
		}
?>
        	<tr>
            	<td>
                	<label for="todosReporte">Todos:</label>
                </td>
                <td>
                	<input type="checkbox" id="todosReporte" name="todosReporte" value="1" <?php echo $checkedTodos;?> />
				</td>
            </tr>
        	<tr>
            	<td>
                	<label for="nomReporte">Nombre:</label>
                </td>
                <td>
                	<input type="text" id="nomReporte" name="nomReporte" size="50" value="<?php echo $data['nomReporte'];?>" />
				</td>
            </tr>
        	<tr>
            	<td>
                	<label for="descrReporte">Descripci&oacute;n:</label>
                </td>
                <td>
                	<textarea id="descrReporte" name="descrReporte" rows="5" cols="52"><?php echo $data['descrReporte'];?></textarea>
				</td>
            </tr>
        	<tr>
            	<td>
                	<label for="estReporte">Estado:</label>
                </td>
                <td>
                	<input type="radio" id="estReporteA" name="estReporte" value="1" <?php echo $estReporte[1];?> />
                	<label for="estReporteA">Activo</label>
                    <br />
                	<input type="radio" id="estReporteI" name="estReporte" value="0" <?php echo $estReporte[0];?> />
                	<label for="estReporteI">Inactivo</label>
				</td>
            </tr>
            <tr>
            	<td></td>
            	<td>
                	<button type="submit">Guardar</button>
                </td>
            </tr>
        </tbody>
    </table>
<?php	if($_REQUEST['op']!='nu'){ ?>
    <br /><br />
    <h2>Pesta&ntilde;as del reporte</h2>
    <p>Puede agregar nuevas pesta&ntilde;as al reporte, editar las creadas o eliminarlas.</p>
    <br />
    <a href="#" id="crearSec">(+) Agregar</a>
    <br /><br />
	<p class="mensaje"><?php echo $mensajeSeccion;?></p>
    <br />
    <table id="formulario" name="segundo">
    	<tbody>
        	<tr>
            	<td>
                	<label for="nomSeccion">Nombre de la pesta&ntilde;a:</label>
                </td>
                <td>
                	<input type="hidden" id="idSeccion" name="idSeccion" value="<?php echo $dataSeccion['idSeccion'];?>" />
                	<input type="text" id="nomSeccion" name="nomSeccion" size="50" value="<?php echo $dataSeccion['nomSeccion'];?>" />
                </td>
                <td>
                	<button type="submit"><?php echo $opcionPestana;?></button>
                </td>
            </tr>
        </tbody>
    </table>
<?php
	if(is_array($pestanas)){
?>
    <br />
    <table id="campana">
    	<thead>
        	<tr>
            	<td>Pesta&ntilde;a</td>
            	<td>Preguntas</td>
            </tr>
        </thead>
    	<tbody>
        	<tr>
            	<td class="up">
                	<ul id="pestana">
<?php
		for($i=0; $i<count($pestanas); $i++){
			$sel = "";
			if($pestanas[$i]['id']==$_POST['idSeccionPes']){
				$sel = "class='sel'";	
			}
?>
                    	<li id="<?php echo $pestanas[$i]['id'];?>" <?php echo $sel;?>>
                        	<a href="#" id="seccion"><?php echo $pestanas[$i]['seccion'];?></a>
                            <input type="text" id="seccion<?php echo $pestanas[$i]['id'];?>" name="seccion<?php echo $pestanas[$i]['id'];?>" value="<?php echo $pestanas[$i]['seccion'];?>" />
                            <div>
                                <a href="#" id="editarSec">Editar</a> - 
                                <a href="#" id="eliminarSec">Eliminar</a>
                            </div>
                        </li>					
<?php
		}
?>
                    </ul>
                	<button type="submit">Guardar</button>
                </td>
            	<td>                	
    				<table id="lista">
<?php
		$preguntas = $pregunta->getComplete();
		$i=1;
		$j=1;
		if($_POST['idSeccionPes']){
			foreach($preguntas as $idG=>$G){
?>
                        <tr>
                            <td colspan="2">
                                <input type="checkbox" id="gp<?php echo $i;?>" name="gp<?php echo $i;?>" value="<?php echo $idG;?>" total="<?php echo count($preguntas);?>" todos="0" esGrupo="1" />
                                <label for="gp<?php echo $i;?>"><?php echo $i.'. '.$G['nombre'];?></label>
                            </td>
                        </tr>
<?php
			$h = 1;
			foreach($G['preguntas'] as $id => $nombre){
			$checked = "";
			if(isset($marcadas[$id])){
				$checked = "checked='CHECKED'";
			}
?>
                        <tr>
                            <td></td>
                            <td>
            	<input type="checkbox" id="p<?php echo $j;?>" name="p<?php echo $j;?>" value="<?php echo $id;?>" esGrupo="0" grupo="gp<?php echo $i;?>" <?php echo $checked;?> />
				<label for="p<?php echo $j;?>"><?php echo $i.'.'.$h.'. '.utf8_encode($nombre);?></label>
                            </td>
                        </tr>
<?php
					$j++;
					$h++;
				}
				$i++;
			}
		}
?>
					</table>
    				<input type="hidden" id="totalP" name="totalP" value="<?php echo $j-1;?>" />
                </td>
            </tr>
        </tbody>
    </table>
<?php	
		} 
?>

	<input type="hidden" id="opSeccion" name="opSeccion" value="<?php echo $_POST['opSeccion'];?>" />
	<input type="hidden" id="idSeccionPes" name="idSeccionPes" value="<?php echo $_POST['idSeccionPes'];?>" />
<?php
	}
?>
	<input type="hidden" id="op" name="op" value="<?php echo $_REQUEST['op'];?>" />
	<input type="hidden" id="id" name="id" value="<?php echo $idReporte;?>" />
</form>
<?php
}
require_once(TEMPLATES.'footer.php');
?>