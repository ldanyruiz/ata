<?php
require_once('config.php');
require_once(TEMPLATES.'header.php');
require_once(RESOURCES.'general.php');
require_once(ENTITIES.'reportes.php');
$general = new general();
$reporte = new reportes();

$rep = "";
$titulo = "";
if(isset($_REQUEST['rep'])){
	$rep = $_REQUEST['rep'];
	switch($_REQUEST['rep']){
		case 'e':
			$titulo = " - Seguimiento de Campa&ntilde;a";
			break;
		case 'mr':
			//$titulo = " - Matriz de Resultados";
			break;
	}
}else if(isset($_REQUEST['individual'])){
	$titulo = " - Datos ingresados";
}
?>
<h1>
	Reportes<?php echo $titulo;?>
	<img src="<?php echo images;?>icon_report.png" <?php echo sizeImg3;?> />
</h1>
<br /><br />
<form id="formReportes" name="formReportes" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<script src="<?php echo SCRIPTS;?>reporte.js" language="javascript" type="text/javascript"></script>
    <input type="hidden" id="rep" name="rep" value="<?php echo $rep;?>" />
<?php	
if(!isset($_REQUEST['rep'])){
	if(!isset($_REQUEST['individual'])){
?>
    <p>A continuaci&oacute;n se muestra una lista de reportes, seleccione uno de ellos para visualizarlo:</p>
    <br /><br />
    
    <ul id="lista">
        <li><a href="reporte.php?rep=e">Seguimiento de llenado</a></li>
        <li><a href="reporte.php?rep=mr">Reportes</a></li>
    </ul>
<?php
	}else{
		if(isset($_REQUEST['id'])){
			require_once(ENTITIES.'usuarioCampana.php');
			require_once(ENTITIES.'preguntaGrupo.php');
			require_once(ENTITIES.'pregunta.php');
			require_once(ENTITIES.'respuesta.php');
			$usuarioCampana = new usuarioCampana();
			$preguntaGrupo = new preguntaGrupo();
			$pregunta = new pregunta();
			$respuesta = new respuesta();
			$idCampana = $usuarioCampana->getCampaignID($_REQUEST['id']);
					
			$datosPersonales = $reporte->getIndividualInfo($_REQUEST['id']);
?>
<p>
	<a href="reporte.php">
    	<button type="button">Volver</button>
	</a>
</p>
<br /><br />
<p>
    <a href="exportar.php?type=excel&op=ind&id=<?php echo $_REQUEST['id'];?>">
    	<button type="button">
        	Exportar
            <img src="<?php echo images;?>icon_excel.png" />
        </button>
	</a>
</p>
<br /><br />
<table id="individual">
	<tr id="titulo">
    	<td colspan="2">FICHA DE AN&Aacute;LISIS DE INSPECTORES SUNAFIL</td>
    </tr>
	<tr>
    	<td colspan="2" id="nada"><br /></td>
    </tr>
	<tr id="seccion">
    	<td colspan="2">DATOS PERSONALES</td>
    </tr>
<?php
    $contPregunta = 0;
    foreach($datosPersonales[1] as $key=>$value){
?>
    <tr>
    	<td id="pregunta1"><?php echo $key;?></td>
        <td id="respuesta"  style="text-align: left"><?php echo $value;?></td>
    </tr>
<?php
    }
				
			$cuestionario = $reporte->getGroupsAndQuestions($idCampana);
                        
			foreach($cuestionario as $key=>$value){
                            
?>
    <tr>
    	<td colspan="2" id="nada"><br /></td>
    </tr>
    <tr id="seccion">
    	<td colspan="2"><?php echo $key;?></td>
    </tr>
<?php
				foreach($value as $key2=>$value2){
                                            
					foreach($value2 as $key3=>$value3){                                                                                        
                                            
                                           echo '<tr>'; 
                                           echo '<td colspan="2" style="background-color:#FF9900;text-align: left">'.$key3.'</td>';
                                           echo '</tr>';                                            
                                            
                                            $dependientes = $pregunta->getByDepen($value3['id'], $idCampana);                                            

                                            if(is_array($dependientes)){//Si hay preguntas dependientes
                                                
                                                //obtenemos por si la misma pregunta tiene respuesta
                                                //para el caso de opciones si o no, etc
                                                $respuestas = $reporte->getAnswersToReports($value3['id'], $_REQUEST['id']);
                                                
                                                if($respuestas){
                                                    if(is_array($respuestas)){
                                                        foreach($respuestas as $unvalor){ 
                                                            echo '<tr>';                                                            
                                                            echo '<td style="background-color:#FFFFFF;text-align: left">'.$unvalor[0].'</td>';
                                                            echo '<td>&nbsp;</td>';
                                                            echo '</tr>';   
                                                        }
                                                     }                                                    
                                                }
                                                
                                                //Obtenemos todas las respuestas de las preguntas dependientes
                                                $idsPreguntas = "0";
                                                unset($nombreDependiente);
                                                foreach($dependientes as $value5){ 
                                                    $idsPreguntas .= ",".$value5['id']; 
                                                    $nombreDependiente[] = $value5['nombre'];
                                                }                                                           
                                                    $respuestas = $reporte->getAnswersToReports($idsPreguntas, $_REQUEST['id']);
                                            
                                                    if(is_array($respuestas)){
                                                        foreach($respuestas as $respuestasMultiples){ 

                                                                $i = 0;
                                                                foreach($respuestasMultiples as $value11){ 

                                                                    echo '<tr>';
                                                                    echo '<td style="background-color:#FFCC66;text-align: left">'.$nombreDependiente[$i].'</td>';
                                                                    echo '<td>'.$value11.'</td>';
                                                                    echo '</tr>';
                                                                    $i++;
                                                                }



                                                        }
                                                    }
                                                
                                                
                                            }else{//si no hay dependientes
                                                
                                                    $respuestas = $reporte->getAnswersToReports($value3['id'], $_REQUEST['id']);
                                                
                                                    if(is_array($respuestas)){
                                                        foreach($respuestas as $k1=>$val1){                                                                      
                                                            foreach($val1 as $val2){     
                                                                        echo '<tr>';                                                                        
                                                                        echo '<td colspan="2" style="background-color:#FFFFFF;text-align: left">'.$val2.'</td>';
                                                                        echo '</tr>';                                                            

                                                            }
                                                        }                                                
                                                    }
                                                
                                            }//fin de si no hay dependientes

        				}
//                                        
                                }//foreach($value as $key2=>$value2){
                                
                        }//fin de foreach($cuestionario as $key=>$value){
?>                                        

</table>
<br /><br />    
<p>
    
    
    <a href="exportar.php?type=excel&op=ind&id=<?php echo $_REQUEST['id'];?>">
    	<button type="button">
        	Exportar
            <img src="<?php echo images;?>icon_excel.png" />
        </button>
	</a>
</p>
<br /><br />
<p>
	<a href="reporte.php">
    	<button type="button">Volver</button>
	</a>
</p>
<?php
		}else{
			header('location: reporte.php');
		}
	}
}else{
		require_once(ENTITIES.'holding.php');
		require_once(ENTITIES.'empresa.php');
		require_once(ENTITIES.'campana.php');
		$holding = new holding();
		$empresa = new empresa();
		$campana = new campana();
		
		$idHolding = 0;
		$idEmpresa = 0;
		$idCampana = 0;
		
		
		/*Opciones generadas para cliente en espec�fico*/
		$boolLock = false;
		
		if($_SESSION['usuario']['rol']=='D'){
			$idHolding = 2;
			$idEmpresa = 2;
			$idCampana = 2;
			$boolLock = true;
		}
		/*Opciones generadas para cliente en espec�fico*/
		
		if(isset($_REQUEST['idHolding'])){
			$idHolding = $_REQUEST['idHolding'];
		}
		
		if(isset($_REQUEST['idEmpresa'])){
			$idEmpresa = $_REQUEST['idEmpresa'];
		}
		
		if(isset($_REQUEST['idCampana'])){
			$idCampana = $_REQUEST['idCampana'];
		}
?>
    <p>
        <a href="reporte.php"> << Volver</a>
    </p>
    <br />
    <table id="cuestionario">
        <tr>
            <td>
                <label for="idHolding">Holding:</label>
            </td>
            <td>
                <?php echo $general->combo($holding->getCombo(), 'idHolding', false, '', $idHolding, 0, $boolLock);?>
            </td>
        </tr>
<?php
		if($idHolding){
?>
        <tr>
            <td>
                <label for="idEmpresa">Empresa:</label>
            </td>
            <td>
                <?php echo $general->combo($empresa->getCombo($idHolding), 'idEmpresa', false, '', $idEmpresa, 0, $boolLock);?>
            </td>
        </tr>
<?php
		}
		if($idEmpresa){
?>
        <tr>
            <td>
                <label for="idCampana">Campa&ntilde;a:</label>
            </td>
            <td>
                <?php echo $general->combo($campana->getCombo($idEmpresa), 'idCampana', false, '', $idCampana, 0, $boolLock);?>
            </td>
        </tr>
<?php
		}
?>
    </table>
    <br /><br />
<?php
		if($idCampana){
			switch($_REQUEST['rep']){
				case 'e':
?>
		<p>
			<a href="exportar.php?type=pdf&op=seg&idCampana=<?php echo $idCampana;?>">
                <button type="button" id="exportar" name="exportar">
                        Exportar
                        <img src="<?php echo images;?>icon_excel.png" />
                </button>
            </a>
		</p>
        <br /><br />
<?php
	$mensaje = "";
	if(isset($_REQUEST['borrarTodo'])){
		if($_REQUEST['borrarTodo']){
			require_once(ENTITIES.'respuesta.php');
			require_once(ENTITIES.'usuarioCampana.php');
			$respuesta = new respuesta();
			$usuarioCampana = new usuarioCampana();
			
			$mensaje = "No se pudieron borrar las respuestas";
			
			if($respuesta->deleteAllByCampaign($_REQUEST['idCampana']) and $usuarioCampana->setUserByCampaign($_REQUEST['idCampana'])){
				$mensaje = "Las respuestas se borraron correctamente.";
			}
		}
	}
	
	if(isset($_REQUEST['idUsuarioCampana'])){
		if($_REQUEST['idUsuarioCampana']<>""){
			require_once(ENTITIES.'respuesta.php');
			require_once(ENTITIES.'usuarioCampana.php');
			$respuesta = new respuesta();
			$usuarioCampana = new usuarioCampana();
			
			$mensaje = "No se pudieron borrar las respuestas";
			
			if($respuesta->deleteAll($_REQUEST['idUsuarioCampana']) and $usuarioCampana->setUser($_REQUEST['idUsuarioCampana'])){
				$mensaje = "Las respuestas se borraron correctamente.";
			}
		}
	}
	
	require_once(RESOURCES.'googChart/googChart.ManuelS.php');
	$chartv2 = new googChartv2();
	$color = array('#999933', '#FF3333', '#FFCC33');

	$title = "";
	
	$datos = $reporte->getTracing($idCampana, false, true);
	$aux = $datos;
	unset($datos);
	
        if(is_array($aux)){
            foreach($aux as $key=>$value){
                    $datos[$key] = array($value);
            }
        
	
	$datosG = array(
		'titulo' => $title,
		'datos' => $datos,
		'color' => $color
	);
        
        
	
	echo $chartv2->graficar($datosG, 'pie', $idReporte='', 1000, 600);
	
	unset($datos);
	$datos = $reporte->getTracing($idCampana);
        
        
?>
		
       	<?php if($_SESSION['usuario']['rol']=='A'){ ?>
        <a href="#" id="eliminarPorCampana">
        	Borrar todas las respuestas
			<img src="<?php echo images;?>icon_delete.png" height="24" />
        </a>
        <br />
        <?php } ?>
        <center>
        	<p class="mensaje"><?php echo $mensaje;?></p>
        </center>
        <br /><br />
        <input type="hidden" id="idUsuarioCampana" name="idUsuarioCampana" />
        <input type="hidden" id="borrarTodo" name="borrarTodo" value="0" />
		<link href="<?php echo CSS;?>grilla.css" type="text/css" rel="stylesheet" />
        <table id="grilla">
        	<thead>
            	<tr>
                <?php
					foreach($datos[0] as $value){
						if($value<>'ID'){
				?>
                	<td><?php echo $value;?></td>
                <?php
						}
					}
				?>
                	<td>Ver</td>
                	<td>Exportar</td>
                   	<?php if($_SESSION['usuario']['rol']=='A'){ ?>
                	<td>Respuestas</td>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php
					for($i=1; $i<=(count($datos)-1); $i++){
						$class = "";
						if($i%2==0){
							$class = "class='alt'";
						}
				?>
                <tr <?php echo $class;?>>
                <?php
						foreach($datos[0] as $value){
							if($value<>'ID'){
								$color = "";
								switch($datos[$i][$value]){
									case 'Pendiente':
										$color = "class='pendi'";
										break;
									case 'En proceso':
										$color = "class='proce'";
										break;
									case 'Completado':
										$color = "class='compl'";
										break;
								}
				?>
                	<td <?php echo $color;?>><?php echo $datos[$i][$value];?></td>
                <?php
							}
						}
				?>
                	<td>
                    	<a href="reporte.php?individual&id=<?php echo $datos[$i]['ID'];?>" target="_blank">
                    		Ver Ficha
                            <img src="<?php echo images;?>icon_look.png" height="24" />
						</a>
					</td>
                	<td>
                    	<a href="exportar.php?type=excel&op=ind&id=<?php echo $datos[$i]['ID'];?>" target="_blank">
                    		Exportar Ficha
                            <img src="<?php echo images;?>icon_excel.png" height="24" />
						</a>
					</td>
                   	<?php if($_SESSION['usuario']['rol']=='A'){ ?>
                	<td>
                    	<a id="eliminarRespuestas" name="<?php echo $datos[$i]['ID'];?>" href="#">
                    		Borrar respuestas
                            <img src="<?php echo images;?>icon_delete.png" height="24" />
						</a>
					</td>
                    <?php } ?>
                </tr>
                <?php
					}
				?>            	
            </tbody>
        </table>
        <?php   }
					break;
				case 'mr':
					//Ponemos como tipo PDF en el link para que no nos incluya todo el c�digo HTML
					//ya que el documento se generar� a partir de la librear�a PHPExcel.
?>
<!--		<h2>
			<img src="<?php echo images;?>icon_excel.png" height="20" />
        	Reportes Principales
		</h2>
        <br />-->
<!--		<p>
			<a href="exportar.php?type=pdf&op=matres1&idCampana=<?php echo $idCampana;?>">
                <button type="button" id="exportar" name="exportar">
                        Exportar Reporte General
                </button>
            </a> 
		</p>
        <p>            
			<a href="exportar.php?type=pdf&op=matres2&idCampana=<?php echo $idCampana;?>">
                <button type="button" id="exportar" name="exportar">
                        Exportar Reporte Procesos
                </button>
            </a>
		</p>-->
<?php
					require_once(ENTITIES.'reporte.php');
					$reporte = new reporte();
					
					$reportes = $reporte->getByCampaignID($idCampana);
					if(is_array($reportes)){
?>
        <br /><br />
		<h2>
			<img src="<?php echo images;?>icon_excel.png" height="20" />
        	Reporte Total de datos
		</h2>
        <br />
<?php
                if($_SESSION['usuario']['rol']=='A' || $_SESSION['usuario']['rol']=='S'){					
                      foreach($reportes as $key=>$value){
?>          
		<p>
        	<a href="exportar.php?type=pdf&op=matresgen&idCampana=<?php echo $idCampana;?>&idReporte=<?php echo $value['id'];?>">
                <button type="button" id="exportar" name="exportar" title="<?php echo $value['descripcion'];?>">
                        Exportar Reporte <?php echo $value['nombre'];?>
                </button>
                </a>
		</p>
<?php
			} 
                }?>
          
<?php                                                
                                                
                                                
					}
?>
                
                                
     		<p>
			<a href="exportar2.php?idCampana=<?php echo $idCampana;?>">
                <button type="button" id="exportar2" name="exportar2" title="">
                        Exportar Reporte con todo los datos
                </button>
            </a>
		</p> 
        <br /><br />
<?php
					break;
		}
	}		
}
?>
</form>
<?php
require_once(TEMPLATES.'footer.php');
?>