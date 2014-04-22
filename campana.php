<?php
require_once('config.php');
require_once(TEMPLATES.'header.php');

require_once(RESOURCES.'general.php');
require_once(ENTITIES.'campana.php');
require_once(ENTITIES.'pregunta.php');
$general = new general();
$campana = new campana();
$pregunta = new pregunta();
$mensaje = "";
if(!isset($_REQUEST['op'])){
    
?>
<form id="formGrilla" name="formGrilla" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<script src="<?php echo SCRIPTS;?>campana.js" language="javascript" type="text/javascript"></script>
    <h1>
	    Campa&ntilde;as
		<img src="<?php echo images;?>icon_campaign.png" <?php echo sizeImg3;?> />
    </h1>
	<br /><br />
	<a href="campana.php?op=nu">
		<img src="<?php echo images;?>icon_add.png" <?php echo sizeImg;?> />
		Crear Campa&ntilde;a
	</a>
	  - 
	<a href="<?php echo RESOURCES;?>/formato/C0000_Formato_Carga_ATA.xls">
		<img src="<?php echo images;?>icon_excel.png" <?php echo sizeImg;?> />
        Descargar formato
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
	
	$campana->numRows($buscar);
	
	$paginacion = array("totalPag"=>$campana->numRows, "actualPag"=>0, "cantPag"=>50, "colPag"=>"", "ascPag"=>1);
	foreach($paginacion as $key => $value){
		if(isset($_REQUEST[$key])){
			$paginacion[$key] = $_REQUEST[$key];
		}
	}	
	$paginacion["totalPag"] = $campana->numRows;
	
	echo $general->grilla($campana->show($buscar, $paginacion), 'Lista de Campa&ntilde;as', 'icon_campaign.png', 'campana.php', false, false, true, $paginacion);
	?>
</form>
<p class="loading"></p>
<?php
}else{
?>
<form id="formCampana" name="formCampana" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<script src="<?php echo SCRIPTS;?>campana.js" language="javascript" type="text/javascript"></script>
	<input type="hidden" id="op" name="op" value="<?php echo $_REQUEST['op'];?>" />
<?php
	switch($_REQUEST['op']){
		case 'nu':
			require_once(ENTITIES.'empresa.php');
			$empresa = new empresa();
			
			$ord = 1;
			if(isset($_REQUEST['ord'])){
				$ord = $_REQUEST['ord'];
			}
			switch($ord){
				case 1:
					$ord = 2;
?>
    <h1>
	    Crear Campa&ntilde;a - Datos Generales
		<img src="<?php echo images;?>icon_campaign.png" <?php echo sizeImg3;?> />
    </h1>
    <br /><br />
   	<a href="campana.php"> << Volver</a>
    <br /><br />
    <table id="formulario">
    	<tbody>
        	<tr>
            	<td>
                	<label for="nomCampana">Nombre:</label>
                </td>
                <td>
                	<input type="text" id="nomCampana" name="nomCampana" />
                </td>
            </tr>
        	<tr>
            	<td>
                	<label for="inicioCampana">Fecha de inicio:</label>
                </td>
                <td>
                	<input type="text" id="inicioCampana" name="inicioCampana" />
                </td>
            </tr>
        	<tr>
            	<td>
                	<label for="finalCampana">Fecha de cierre:</label>
                </td>
                <td>
                	<input type="text" id="finalCampana" name="finalCampana" />
                </td>
            </tr>
        	<tr>
            	<td>
                	<label for="idEmpresa">Empresa:</label>
                </td>
                <td>
                	<?php echo $general->combo($empresa->getCombo(0, false), 'idEmpresa');?>
                    <br /><br />
                    <input type="checkbox" id="altOtroEmpresa" name="altOtroEmpresa" value="1" />
                    <label for="altOtroEmpresa">La empresa no se encuentra en la lista.</label>
                    <br /><br />
                    <label for="otroEmpresa">Otro:</label>
                    <input type="text" id="otroEmpresa" name="otroEmpresa" />
                </td>
            </tr>
        	<tr>
                <td colspan="2">
                	<button type="submit">Siguiente</button>
                </td>
            </tr>
        </tbody>
    </table>
	<input type="hidden" id="ord" name="ord" value="<?php echo $ord;?>" />
<?php
					break;
				case 2:
					$_REQUEST['ord'] = 3;
					foreach($_REQUEST as $key=>$value){
?>
	<input type="hidden" id="<?php echo $key;?>" name="<?php echo $key;?>" value="<?php echo $value;?>" />
<?php
					}
?>
	<h1>
	    Crear Campa&ntilde;a - Carga de formato
		<img src="<?php echo images;?>icon_campaign.png" <?php echo sizeImg3;?> />
    </h1>
    <br /><br />
   	<a href="campana.php"> << Volver</a>
    <br /><br />
	<a href="<?php echo RESOURCES;?>/formato/C0000_Formato_Carga_ATA.xls">
		<img src="<?php echo images;?>icon_excel.png" <?php echo sizeImg;?> />
        Descargar formato
	</a>
    <br /><br />
    <label for="archCampana">Subir formato:</label>
    <input type="file" id="archCampana" name="archCampana"  />
    <br /><br />
    <button type="submit">Siguiente</button>
<?php
					break;
				case 3:
					$_REQUEST['ord'] = 4;
					$excel = $general->leerExcel($_FILES['archCampana']['tmp_name'], 3);
					foreach($_REQUEST as $key=>$value){
?>
	<input type="hidden" id="<?php echo $key;?>" name="<?php echo $key;?>" value="<?php echo $value;?>" />
<?php
					}
?>
	<input type="hidden" id="cantNiveles" name="cantNiveles" value="<?php echo count($excel[0][1]);?>" />
<?php
					for($i=1; $i<=count($excel[0][1]); $i++){
?>
	<input type="hidden" id="nomNivel<?php echo $i;?>" name="nomNivel<?php echo $i;?>" value="<?php echo $excel[0][1][$i];?>" />
<?php
					}
					for($i=2; $i<=count($excel[0]); $i++){
						for($j=1; $j<=count($excel[0][$i]); $j++){
?>
	<input type="hidden" id="nivel<?php echo $j;?>" name="nivel<?php echo $j;?>[]" value="<?php echo $excel[0][$i][$j];?>" />
<?php
						}
					}
					
					for($i=2; $i<=count($excel[1]); $i++){
?>
	<input type="hidden" id="nombres" name="nombres[]" value="<?php echo $excel[1][$i][1];?>" />
	<input type="hidden" id="paterno" name="paterno[]" value="<?php echo $excel[1][$i][2];?>" />
	<input type="hidden" id="materno" name="materno[]" value="<?php echo $excel[1][$i][3];?>" />
	<input type="hidden" id="dni" name="dni[]" value="<?php echo $excel[1][$i][4];?>" />
	<input type="hidden" id="sexo" name="sexo[]" value="<?php echo $excel[1][$i][5];?>" />
	<input type="hidden" id="estciv" name="estciv[]" value="<?php echo $excel[1][$i][6];?>" />
	<input type="hidden" id="fechnac" name="fechnac[]" value="<?php echo $excel[1][$i][7];?>" />
	<input type="hidden" id="email" name="email[]" value="<?php echo $excel[1][$i][8];?>" />
<?php
					}
?>
	<h1>
	    Crear Campa&ntilde;a - Carga de formato
		<img src="<?php echo images;?>icon_campaign.png" <?php echo sizeImg3;?> />
    </h1>
    <br /><br />
   	<a href="campana.php"> << Volver</a>
    <br /><br />
    <h2>Niveles estructurales de Empresa</h2>
    <br />
    <table id="campana">
    	<thead>
        	<tr>
<?php
						for($i=1; $i<=count($excel[0][1]); $i++){
?>
				<td><?php echo $excel[0][1][$i];?></td>
<?php
						}
?>

            </tr>
        </thead>
        <tbody>
<?php
					for($i=2; $i<=count($excel[0]); $i++){
?>
			<tr>
<?php
						for($j=1; $j<=count($excel[0][$i]); $j++){
?>
				<td><?php echo $excel[0][$i][$j];?></td>
<?php
						}
?>
			</tr>
<?php
					}
?>
		</tbody>
	</table>
    <br /><br />
    <h2>Usuarios</h2>
    <br />
    <table id="campana">
    	<thead>
        	<tr>
            	<td>NOMBRES</td>
            	<td>APELLIDO PATERNO</td>
            	<td>APELLIDO MATERNO</td>
            	<td>DNI</td>
            	<td>SEXO</td>
            	<td>ESTADO CIVIL</td>
            	<td>FECHA DE NACIMIENTO</td>
            	<td>E-MAIL</td>
            </tr>
        </thead>
        <tbody>
<?php
					for($i=2; $i<=count($excel[1]); $i++){
?>
			<tr>
<?php
						for($j=1; $j<=count($excel[1][$i]); $j++){
?>
				<td><?php echo $excel[1][$i][$j];?></td>
<?php
						}
?>
			</tr>
<?php
					}
?>
		</tbody>
	</table>
    <br /><br />
    <h2>Preguntas que no ingresaran al cuestionario</h2>
    <br />
    <table id="campana">
    	<thead>
        	<tr>
				<td>GRUPO</td>
				<td>C&Oacute;DIGO</td>
				<td>PREGUNTA</td>
            </tr>
        </thead>
        <tbody>
<?php
					$excluidas = array();
					for($i=2; $i<=count($excel[2]); $i++){
						unset($info);
						$info = $pregunta->getInfoByCod($excel[2][$i][1]);
						if(is_array($info)){
							$excluidas[] = $info['id'];
?>
			<tr>
            	<td><?php echo $info['grupo'];?></td>
            	<td><?php echo $info['codigo'];?></td>
            	<td><?php echo utf8_encode($info['nombre']);?></td>
			</tr>
<?php
						}
					}
?>
		</tbody>
	</table>
    <br /><br />
    <p>En caso quiera volver a cargar el formato antes de continuar puede hacerlo:</p>
    <br />
	<a href="<?php echo RESOURCES;?>/formato/formato.xls">
		<img src="<?php echo images;?>icon_excel.png" <?php echo sizeImg;?> />
        Descargar formato
	</a>
    <br /><br />
    <label for="archCampana">Subir formato:</label>
    <input type="file" id="archCampana" name="archCampana"  />
    <br /><br />
    <button type="submit">Siguiente</button>
<?php
					for($i=0; $i<count($excluidas); $i++){
?>
	<input type="hidden" id="excluidas" name="excluidas[]" value="<?php echo $excluidas[$i];?>" />
<?php
					}
					break;
				case 4:
					$_REQUEST['ord'] = 5;
					
					$marcadas = array();
					if(isset($_REQUEST['excluidas'])){
						$excluidas = $_REQUEST['excluidas'];
						unset($_REQUEST['excluidas']);
						
						for($i=0; $i<count($excluidas); $i++){
							$marcadas[$excluidas[$i]] = 'CHECKED="CHECKED"';
						}
					}
					
					foreach($_REQUEST as $key=>$value){
						if(is_array($value)){
							foreach($value as $key2=>$value2){
?>
	<input type="hidden" id="<?php echo $key;?>" name="<?php echo $key;?>[]" value="<?php echo $value2;?>" />
<?php							
							}
						}else{
?>
	<input type="hidden" id="<?php echo $key;?>" name="<?php echo $key;?>" value="<?php echo $value;?>" />
<?php
						}
					}
?>
	<h1>
	    Crear Campa&ntilde;a - Preguntas Excluidas
		<img src="<?php echo images;?>icon_campaign.png" <?php echo sizeImg3;?> />
    </h1>
    <br /><br />
   	<a href="campana.php"> << Volver</a>
    <br /><br />
    <table id="cuestionario">
<?php
					$preguntas = $pregunta->getComplete();
					$i=1;
					$j=1;
                           
                     if(is_array($preguntas)){
                           
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
							$checked = $marcadas[$id];
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
    <input type="hidden" id="estCampana" name="estCampana" />
    <br /><br />
    <button type="submit" id="guardar" name="0">Guardar Campa&ntilde;a</button> 
    <button type="submit" id="lanza" name="1">Lanzar Campa&ntilde;a</button>
<?php
					break;
				case 5:				
					if(isset($_REQUEST['altOtroEmpresa'])){
						require_once(ENTITIES.'holding.php');
						require_once(ENTITIES.'empresa.php');
						$holding = new holding();
						$empresa = new empresa();
						
						$dataHolding = array(
							'idHolding'=>NULL,
							'nomHolding'=>$_REQUEST['otroEmpresa'],
						);
						
						$holding->set($dataHolding);
						
						$idHolding = $holding->getIDByName($_REQUEST['otroEmpresa']);
						
						if($idHolding==0){
							$idHolding = $holding->insert();
						}
						
						$dataEmpresa = array(
							'idEmpresa'=>NULL,
							'idHolding'=>$idHolding,
							'nomEmpresa'=>$_REQUEST['otroEmpresa'],
				        );
						$empresa->set($dataEmpresa);
												
						$idEmpresa = $empresa->getIDByNameAndHolding($_REQUEST['otroEmpresa'], $idHolding);
						
						if($idEmpresa==0){
							$idEmpresa = $empresa->insert();
						}
					}else{
						$idEmpresa = $_REQUEST['idEmpresa'];
					}
					
					$dataCampana = array(
						'idCampana'=>NULL,
						'idEmpresa'=>$idEmpresa,
						'nomCampana'=>$_REQUEST['nomCampana'],
						'inicioCampana'=>$_REQUEST['inicioCampana'],
						'finalCampana'=>$_REQUEST['finalCampana'],
						'estCampana'=>$_REQUEST['estCampana']
					);
					$campana->set($dataCampana);
					$idCampana = $campana->insert();
					
					require_once(ENTITIES.'oculto.php');
					$oculto = new oculto();
					
					$dataOculto = array(
						'idOculto' => NULL,
						'idPregunta' => NULL,
						'idCampana' => $idCampana
					);
					
					for($i=1; $i<=$_REQUEST['totalP']; $i++){
						if(isset($_REQUEST['p'.$i])){
							$dataOculto['idPregunta'] = $_REQUEST['p'.$i];
							$oculto->set($dataOculto);
							$oculto->insert();
						}
					}
					
					require_once(ENTITIES.'nivelTipo.php');
					require_once(ENTITIES.'nivel.php');
					$nivelTipo = new nivelTipo();
					$nivel = new nivel();
					
					$dataNivelTipo = array(
						'idNivelTipo'=>NULL,
						'idCampana'=>$idCampana,
						'nomNivelTipo'=>NULL,
						'depenNivelTipo'=>NULL
					);
		
					$depende = 0;
					for($i=1; $i<=$_REQUEST['cantNiveles']; $i++){
						$dataNivelTipo['nomNivelTipo'] = $_REQUEST['nomNivel'.$i];
						$dataNivelTipo['depenNivelTipo'] = $depende;
						$nivelTipo->set($dataNivelTipo);
						$depende = $nivelTipo->insert();
					}
			
					$dataNivel = array(
						'idNivel'=>NULL,
						'idNivelTipo'=>NULL,
						'nomNivel'=>NULL,
						'depenNivel'=>NULL
					);
					
					for($i=0; $i<count($_REQUEST['nivel'.$_REQUEST['cantNiveles']]); $i++){
						$depende = 0;
						for($j=1; $j<=$_REQUEST['cantNiveles']; $j++){
							$dataNivel['idNivelTipo'] = $nivelTipo->getIDByName($_REQUEST['nomNivel'.$j]);
							$dataNivel['nomNivel'] = $_REQUEST['nivel'.$j][$i];
							$dataNivel['depenNivel'] = $depende;
							
							$nivel->set($dataNivel);
							if($nivel->getIDByNameAndDepenAndIDType($dataNivel['nomNivel'], $dataNivel['depenNivel'], $dataNivel['idNivelTipo'])){
								$depende = $nivel->getIDByNameAndDepenAndIDType($dataNivel['nomNivel'], $dataNivel['depenNivel'], $dataNivel['idNivelTipo']);
							}else{
								$depende = $nivel->insert();
							}
						}
					}
					
					require_once(ENTITIES.'usuario.php');
					require_once(ENTITIES.'usuarioCampana.php');
					$usuario = new usuario();
					$usuarioCampana = new usuarioCampana();
					
					$dataUsuario = array(
						'idUsuario'=>NULL,
						'rolUsuario'=>'U',
						'nomUsuario'=>NULL,
						'appatUsuario'=>NULL,
						'apmatUsuario'=>NULL,
						'loginUsuario'=>NULL,
						'passUsuario'=>NULL,
						'sexUsuario'=>NULL,
						'estcivUsuario'=>NULL,
						'fechnacUsuario'=>NULL,
						'emailUsuario'=>NULL,
						'estUsuario'=>'A',
						'usuCrea'=>$_SESSION['usuario']['id'],
						'usuEdita'=>$_SESSION['usuario']['id'],
						'fechCrea'=>NULL,
						'fechEdita'=>NULL
					);
					
					require_once(ENTITIES.'empresa.php');
					$empresa = new empresa();
					$nomEmpresa = $empresa->getNameByID($idEmpresa);
					
					$excel = array();
					$cont = 1;
					
					for($i=0; $i<count($_REQUEST['nombres']); $i++){
						$idUsuario = 0;
						if($_REQUEST['dni'][$i]<>""){
							$dataUsuario['loginUsuario'] = $_REQUEST['dni'][$i];
							$idUsuario = $usuario->getIDByLogin($dataUsuario['loginUsuario']);
						}else{
							$nombre = explode(' ', $nomEmpresa);
							
							if(count($nombre)>=2){					
								$total = count($nombre);
								if($total>3){
									$total = 3;
								}
								$prefijo = "";
								for($j=0; $j<count($nombre); $j++){
									$prefijo .= strtolower(substr($nombre[$j], 0, 1));
								}
							}else{
								$prefijo = strtolower(substr($nombre[0], 0, 3));
							}
							
							$max = $usuario->getMaxByPrefix($prefijo) + 1;
							$dataUsuario['loginUsuario'] = $prefijo . str_pad($max, 4, "0", STR_PAD_LEFT);							
						}
						
						$clave = $general->generarClave(8);
						
						$dataUsuario['idUsuario'] = $idUsuario;
						$dataUsuario['nomUsuario'] = $_REQUEST['nombres'][$i];
						$dataUsuario['appatUsuario'] = $_REQUEST['paterno'][$i];
						$dataUsuario['apmatUsuario'] = $_REQUEST['materno'][$i];
						$dataUsuario['passUsuario'] = $clave;
						$dataUsuario['sexUsuario'] = $_REQUEST['sexo'][$i];
						$dataUsuario['estcivUsuario'] = $_REQUEST['estciv'][$i];
						$dataUsuario['fechnacUsuario'] = $_REQUEST['fechnac'][$i];
						$dataUsuario['emailUsuario'] = $_REQUEST['email'][$i];
						
						$excel[$cont]['nombres'] = $_REQUEST['nombres'][$i];
						$excel[$cont]['paterno'] = $_REQUEST['paterno'][$i];
						$excel[$cont]['materno'] = $_REQUEST['materno'][$i];
						$excel[$cont]['login'] = $dataUsuario['loginUsuario'];
						$excel[$cont]['clave'] = $clave;
						$excel[$cont]['email'] = $_REQUEST['email'][$i];
						
						$cont++;
						
						$usuario->set($dataUsuario);
						
						if($idUsuario){
							$usuario->update();
						}else{
							$idUsuario = $usuario->insert();
						}
						
						$dataUsuarioCampana = array(
							'idUsuarioCampana'=>NULL,
							'idCampana'=>$idCampana,
							'idUsuario'=>$idUsuario,
							'idNivel'=>NULL,
							'profesionUsuarioCampana'=>NULL,
							'nivocuUsuarioCampana'=>NULL,
							'puestoUsuarioCampana'=>NULL
						);
						
						$usuarioCampana->set($dataUsuarioCampana);
						$usuarioCampana->insert();
					}
					
					$estado = "Por lanzar";
					if($_REQUEST['estCampana']){
						$estado = "Lanzado";
					}
?>
	<h1>
	    Crear Campa&ntilde;a - Resumen
		<img src="<?php echo images;?>icon_campaign.png" <?php echo sizeImg3;?> />
    </h1>
    <br /><br />
    <table id="campana">
    	<thead>
        	<tr>
            	<td colspan="2">DATOS DE LA CAMPA&Ntilde;A</td>
            </tr>
        </thead>
        <tbody>
        	<tr>
            	<td>Nombre de la campa&ntilde;a:</td>
                <td><?php echo $_REQUEST['nomCampana'];?></td>
            </tr>
        	<tr>
            	<td>Empresa:</td>
                <td><?php echo $nomEmpresa;?></td>
            </tr>
        	<tr>
            	<td>Inicio de la campa&ntilde;a:</td>
                <td><?php echo $_REQUEST['inicioCampana'];?></td>
            </tr>
        	<tr>
            	<td>Final de la campa&ntilde;a:</td>
                <td><?php echo $_REQUEST['finalCampana'];?></td>
            </tr>
        	<tr>
            	<td>Estado:</td>
                <td><?php echo $estado;?></td>
            </tr>
        </tbody>
    </table>
    <br /><br />
	<table id="campana">
    	<thead>
        	<tr>
                <td>NOMBRES</td>
                <td>APELLIDO PATERNO</td>
                <td>APELLIDO MATERNO</td>
                <td>USUARIO</td>
                <td>CONTRASE&Ntilde;A</td>
                <td>CORREO ELECTR&Oacute;NICO</td>
            </tr>
        </thead>
        <tbody>
<?php
					for($i=1; $i<=count($excel); $i++){
?>
			<tr>
            	<td><?php echo $excel[$i]['nombres'];?></td>
            	<td><?php echo $excel[$i]['paterno'];?></td>
            	<td><?php echo $excel[$i]['materno'];?></td>
            	<td><?php echo $excel[$i]['login'];?></td>
            	<td><?php echo $excel[$i]['clave'];?></td>
            	<td><?php echo $excel[$i]['email'];?></td>
            </tr>
<?php
					}
?>
        </tbody>
    </table>
</form>
<form id="formExcel" name="formExcel" method="post" action="exportar.php">
	<input type="hidden" id="type" name="type" value="excel" />
	<input type="hidden" id="op" name="op" value="usu" />
    <br /><br />
    <button type="submit">Exportar</button>
    <a href="campana.php">
		<button type="button" id="finalizar">Finalizar</button>
    </a>
<?php
					for($i=1; $i<=count($excel); $i++){
?>
	<input type="hidden" id="nombres" name="nombres[]" value="<?php echo $excel[$i]['nombres'];?>" />
	<input type="hidden" id="paterno" name="paterno[]" value="<?php echo $excel[$i]['paterno'];?>" />
	<input type="hidden" id="materno" name="materno[]" value="<?php echo $excel[$i]['materno'];?>" />
	<input type="hidden" id="login" name="login[]" value="<?php echo $excel[$i]['login'];?>" />
	<input type="hidden" id="clave" name="clave[]" value="<?php echo $excel[$i]['clave'];?>" />
	<input type="hidden" id="email" name="email[]" value="<?php echo $excel[$i]['email'];?>" />
<?php
					}
					break;
			}			
			break;
		case 'li':
			$mensaje = "";
			if(isset($_REQUEST['id'])){
				$mant = "ini";
				if(isset($_REQUEST['mant'])){
					$mant = $_REQUEST['mant'];
				}
				switch($mant){
					case 'ini':
?> 
	<h1>
	    Editar Campa&ntilde;a
		<img src="<?php echo images;?>icon_campaign.png" <?php echo sizeImg3;?> />
    </h1>
    <br /><br />
   	<a href="campana.php"> << Volver</a>
    <br /><br />
    <ul id="lista">
    	<li>
        	<a href="campana.php?op=li&id=<?php echo $_REQUEST['id'];?>&mant=gen">
            	Edici&oacute;n de datos generales (Nombre, fecha inicial, fecha final y estado)
            </a>
        </li>
    	<li>
        	<a href="campana.php?op=li&id=<?php echo $_REQUEST['id'];?>&mant=usu">
            	Edici&oacute;n de usuarios
            </a>
        </li>
    	<li>
        	<a href="campana.php?op=li&id=<?php echo $_REQUEST['id'];?>&mant=niv">
            	Edici&oacute;n de niveles estructurales de empresa
            </a>
        </li>
    	<li>
        	<a href="campana.php?op=li&id=<?php echo $_REQUEST['id'];?>&mant=pre">
            	Edici&oacute;n de preguntas excluidas
			</a>
        </li>
    </ul>
<?php
						break;
					case 'gen':						
						if(isset($_POST['nomCampana'])){						
							if(isset($_REQUEST['altOtroEmpresa'])){
								if($_REQUEST['otroEmpresa']<>""){
									require_once(ENTITIES.'holding.php');
									require_once(ENTITIES.'empresa.php');
									$holding = new holding();
									$empresa = new empresa();
									
									$dataHolding = array(
										'idHolding'=>NULL,
										'nomHolding'=>$_REQUEST['otroEmpresa'],
									);
									
									$holding->set($dataHolding);
									
									$idHolding = $holding->getIDByName($_REQUEST['otroEmpresa']);
									
									if($idHolding==0){
										$idHolding = $holding->insert();
									}
									
									$dataEmpresa = array(
										'idEmpresa'=>NULL,
										'idHolding'=>$idHolding,
										'nomEmpresa'=>$_REQUEST['otroEmpresa'],
									);
									$empresa->set($dataEmpresa);
															
									$idEmpresa = $empresa->getIDByNameAndHolding($_REQUEST['otroEmpresa'], $idHolding);
									
									if($idEmpresa==0){
										$idEmpresa = $empresa->insert();
									}
								}else{
									$mensaje .= "En caso de una empresa no existente debes llenar el nombre de la misma. ";
								}
							}else{
								$idEmpresa = $_REQUEST['idEmpresa'];
							}
							
							if($_REQUEST['nomCampana'] and $_REQUEST['idEmpresa']<>"NULL" and $_REQUEST['inicioCampana'] and $_REQUEST['finalCampana']){
								$dataCampana = array(
									'idCampana'=>$_POST['id'],
									'idEmpresa'=>$idEmpresa,
									'nomCampana'=>$_POST['nomCampana'],
									'inicioCampana'=>$_POST['inicioCampana'],
									'finalCampana'=>$_POST['finalCampana'],
									'estCampana'=>$_POST['estCampana']
								);
								
								$campana->set($dataCampana);
								
								if($campana->update()){
									$mensaje = "Los cambios se guardaron exitosamente.";
								}else{
									$mensaje = "No se han hecho cambios.";
								}
							}else{
								$mensaje .= "Debe escribir un nombre, seleccionar una empresa y llenar las fechas inicial y final de la campa&ntilde;a.";
							}
						}
					
						require_once(ENTITIES.'empresa.php');
						$empresa = new empresa();
						
						$datosCampana = $campana->get($_REQUEST['id']);
						
						$estado = array(0=>'', 1=>'');
						$estado[$datosCampana['estCampana']] = "checked='CHECKED'";
?>
	<h1>
	    Editar Campa&ntilde;a - Datos Generales
		<img src="<?php echo images;?>icon_campaign.png" <?php echo sizeImg3;?> />
    </h1>
    <br /><br />
   	<a href="campana.php?op=li&id=<?php echo $_REQUEST['id'];?>"> << Volver</a>
    <br /><br />
    <p class="mensaje"><?php echo $mensaje;?></p>
    <br />
    <table id="campana">
    	<thead>
        	<tr>
            	<td colspan="2">DATOS DE LA CAMPA&Ntilde;A</td>
            </tr>
        </thead>
        <tbody>
        	<tr>
            	<td>Nombre de la campa&ntilde;a:</td>
                <td>
					<input type="text" id="nomCampana" name="nomCampana" value="<?php echo $datosCampana['nomCampana'];?>" />
                </td>
            </tr>
        	<tr>
            	<td>Empresa:</td>
                <td>
                	<?php echo $general->combo($empresa->getCombo(0, false), 'idEmpresa', false, '', $datosCampana['idEmpresa']);?>
                    <br /><br />
                    <input type="checkbox" id="altOtroEmpresa" name="altOtroEmpresa" value="1" />
                    <label for="altOtroEmpresa">La empresa no se encuentra en la lista.</label>
                    <br /><br />
                    <label for="otroEmpresa">Otro:</label>
                    <input type="text" id="otroEmpresa" name="otroEmpresa" />
                </td>
            </tr>
        	<tr>
            	<td>Inicio de la campa&ntilde;a:</td>
                <td>
					<input type="text" id="inicioCampana" name="inicioCampana" value="<?php echo $datosCampana['inicioCampana'];?>" />
                </td>
            </tr>
        	<tr>
            	<td>Final de la campa&ntilde;a:</td>
                <td>
					<input type="text" id="finalCampana" name="finalCampana" value="<?php echo $datosCampana['finalCampana'];?>" />
                </td>
            </tr>
        	<tr>
            	<td>Estado:</td>
                <td>
					<input type="radio" id="actEstCampana" name="estCampana" value="1" <?php echo $estado[1];?> />
                    <label for="actEstCampana">Activo</label> 
					<input type="radio" id="inaEstCampana" name="estCampana" value="0" <?php echo $estado[0];?> />
                    <label for="inaEstCampana">Inactivo</label>
                </td>
            </tr>
        </tbody>
    </table>
    <br />
	<button type="submit">Guardar</button>
<?php
						break;
					case 'usu':
						require_once(ENTITIES.'usuario.php');
						$usuario = new usuario();
						
						if(!isset($_REQUEST['opMant'])){
							if(isset($_REQUEST['esEliminado'])){
								if($_REQUEST['esEliminado']){
									$mensaje = 'No se pudo eliminar el usuario';
									if($usuario->updateStatus($_REQUEST['idUsuario'])){
										$mensaje = 'Usuario eliminado exitosamente.';
									}
								}
							}
							
							$usuarios = $usuario->getSimpleByCampaign($_REQUEST['id']);
?>
	<h1>
	    Editar Campa&ntilde;a - Usuarios
		<img src="<?php echo images;?>icon_campaign.png" <?php echo sizeImg3;?> />
    </h1>
    <br /><br />
   	<a href="campana.php?op=li&id=<?php echo $_REQUEST['id'];?>"> << Volver</a>
    <br /><br />
    <a href="campana.php?op=li&mant=usu&esNuevo=1&opMant=nu&id=<?php echo $_REQUEST['id'];?>">Crear usuario</a> - 
    <a href="campana.php?op=li&mant=usu&opMant=ca&id=<?php echo $_REQUEST['id'];?>">Cargar usuarios</a>
    <br /><br />
    <p class="mensaje"><?php echo $mensaje;?></p>
    <br />
    <table id="campana">
    	<thead>
        	<tr>
            	<td>Colaborador</td>
                <td>Usuario</td>
                <td>Opciones</td>
            </tr>
        </thead>
        <tbody>
<?php
							for($i=0; $i<count($usuarios); $i++){
?>
			<tr>
            	<td><?php echo $usuarios[$i]['paterno'].' '.$usuarios[$i]['materno'].', '.$usuarios[$i]['nombre'];?></td>
                <td><?php echo $usuarios[$i]['login'];?></td>
                <td>
                	<a href="campana.php?op=li&mant=usu&esNuevo=0&opMant=ed&id=<?php echo $_REQUEST['id'];?>&idUsuario=<?php echo $usuarios[$i]['id'];?>">Editar</a> - 
                	<a href="campana.php?op=li&mant=usu&opMant=co&id=<?php echo $_REQUEST['id'];?>&idUsuario=<?php echo $usuarios[$i]['id'];?>">Cambiar contrase&ntilde;a</a> - 
                	<a href="campana.php?op=li&mant=usu&esEliminado=1&id=<?php echo $_REQUEST['id'];?>&idUsuario=<?php echo $usuarios[$i]['id'];?>" id="eliminarUsuario">Eliminar</a>
                </td>
            </tr>
<?php
							}
?>
        </tbody>
    </table>
<?php
						}else{
?>
	<input type="hidden" id="opMant" name="opMant" value="<?php echo $_REQUEST['opMant'];?>" />
<?php
							$dataUsuario = array(
								'idUsuario'=>NULL,
								'rolUsuario'=>'U',
								'nomUsuario'=>NULL,
								'appatUsuario'=>NULL,
								'apmatUsuario'=>NULL,
								'loginUsuario'=>NULL,
								'passUsuario'=>NULL,
								'sexUsuario'=>NULL,
								'estcivUsuario'=>NULL,
								'fechnacUsuario'=>NULL,
								'emailUsuario'=>NULL,
								'estUsuario'=>NULL,
								'usuCrea'=>$_SESSION['usuario']['id'],
								'usuEdita'=>$_SESSION['usuario']['id'],
								'fechCrea'=>NULL,
								'fechEdita'=>NULL
							);
							
							switch($_REQUEST['opMant']){
								case 'nu':
								case 'ed':
									$readonly = "readonly='READONLY'";
									
									if($_REQUEST['esNuevo']){
										$readonly = "";
									}else{
										$usuario->get($_REQUEST['idUsuario']);
										$dataAuxUsuario = $usuario->setArray;
										foreach($dataAuxUsuario as $key=>$value){
											$dataUsuario[$key] = $dataAuxUsuario[$key];
										}
									}
									
									foreach($dataUsuario as $key=>$value){
										if(isset($_REQUEST[$key])){
											$dataUsuario[$key] = $_REQUEST[$key];
										}
									}
									
									$usuario->set($dataUsuario);
									
									$boolUpdate = false;
									
									if(isset($_POST['idUsuario'])){
										if($_POST['idUsuario']<>""){
											$boolUpdate = true;
										}
									}
									
									if($boolUpdate){
										$mensaje = "No se han registrado cambios.";
										if($usuario->update()){
											$mensaje = "El usuario ha sido editado exitosamente.";
										}
									}else{
										if(isset($_POST['nomUsuario'])){
											$idUsuario = 0;
											if(!isset($_REQUEST['noDni'])){
												$dataUsuario['loginUsuario'] = $_POST['loginUsuario'];
												$idUsuario = $usuario->getIDByLogin($dataUsuario['loginUsuario']);
											}else{
												$nombre = explode(' ', $campana->getCompanyNameByID($_REQUEST['id']));
												
												if(count($nombre)>=2){					
													$total = count($nombre);
													if($total>3){
														$total = 3;
													}
													$prefijo = "";
													for($j=0; $j<count($nombre); $j++){
														$prefijo .= strtolower(substr($nombre[$j], 0, 1));
													}
												}else{
													$prefijo = strtolower(substr($nombre[0], 0, 3));
												}
												
												$max = $usuario->getMaxByPrefix($prefijo) + 1;
												$dataUsuario['loginUsuario'] = $prefijo . str_pad($max, 4, "0", STR_PAD_LEFT);							
											}
											
											$dataUsuario['passUsuario'] = $general->generarClave(8);
											
											if($idUsuario){
												$mensaje = "El DNI ya se encuentra registrado.";
												$_REQUEST['esNuevo'] = 0;
											
											}else{
												$mensaje = "No se ha generado el usuario.";
												$usuario->set($dataUsuario);
												$idUsuario = $usuario->insert();
												if($idUsuario){
													$mensaje = "El usuario ha sido creado exitosamente. Sus datos de acceso son los siguientes:
																<br /><br />
																<table id='campana'>
																	<thead>
																		<tr>
																			<td>Usuario:</td>
																			<td>Contrase&ntilde;a</td>
																		</tr>
																	</thead>
																	<tbody>
																		<tr>
																			<td>{$dataUsuario['loginUsuario']}</td>
																			<td>{$dataUsuario['passUsuario']}</td>
																		</tr>
																	</tbody>
																</table>";
													$_REQUEST['esNuevo'] = 0;
													$dataUsuario['idUsuario'] = $idUsuario;
													
													require_once(ENTITIES.'usuarioCampana.php');
													$usuarioCampana = new usuarioCampana();
													
													$dataUsuarioCampana = array(
														'idUsuarioCampana'=>NULL,
														'idCampana'=>$_REQUEST['id'],
														'idUsuario'=>$idUsuario,
														'idNivel'=>NULL,
														'profesionUsuarioCampana'=>NULL,
														'nivocuUsuarioCampana'=>NULL,
														'puestoUsuarioCampana'=>NULL
													);
													
													$usuarioCampana->set($dataUsuarioCampana);
													$usuarioCampana->insert();
													$readonly = "readonly='READONLY'";
												}
											}
										}
									}
									
									$sexUsuario = array('M'=>'', 'F'=>'');
									$sexUsuario[$dataUsuario['sexUsuario']] = 'CHECKED';
									
									$estcivUsuario = array('S'=>'', 'C'=>'', 'V'=>'', 'D'=>'');
									$estcivUsuario[$dataUsuario['estcivUsuario']] = 'SELECTED';
									
									$estUsuario = array('A'=>'CHECKED', 'I'=>'');
									$estUsuario[$dataUsuario['estUsuario']] = 'CHECKED';
							
?>
	<input type="hidden" id="esNuevo" name="esNuevo" value="<?php echo $_REQUEST['esNuevo'];?>" />
	<h1>
	    Editar Campa&ntilde;a - Usuarios
		<img src="<?php echo images;?>icon_campaign.png" <?php echo sizeImg3;?> />
    </h1>
    <br /><br />
   	<a href="campana.php?op=li&mant=usu&id=<?php echo $_REQUEST['id'];?>"> << Volver</a>
    <br /><br />
    <p class="mensaje"><?php echo $mensaje;?></p>
    <br />
    <table id="cuestionario">
    	<tbody>
        	<tr>
            	<td>
                	<label for="dniUsuario">DNI:</label>
                </td>
            	<td>
                	<input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo $dataUsuario['idUsuario'];?>" />
                	<input type="text" id="loginUsuario" name="loginUsuario" value="<?php echo $dataUsuario['loginUsuario'];?>" <?php echo $readonly;?> />
<?php
							if($_REQUEST['esNuevo']){
?>
                    <input type="checkbox" id="noDni" name="noDni" value="1" />
                    <label for="noDni">No cuento con el n&uacute;mero de DNI.</label>
<?php
							}
?>
                </td>
            </tr>
        	<tr>
            	<td>
                	<label for="nomUsuario">Nombre:</label>
                </td>
            	<td>
                	<input type="text" id="nomUsuario" name="nomUsuario" value="<?php echo $dataUsuario['nomUsuario'];?>" />
                </td>
            </tr>
        	<tr>
            	<td>
                	<label for="appatUsuario">Apellido Paterno:</label>
                </td>
            	<td>
                	<input type="text" id="appatUsuario" name="appatUsuario" value="<?php echo $dataUsuario['appatUsuario'];?>" />
                </td>
            </tr>
        	<tr>
            	<td>
                	<label for="apmatUsuario">Apellido Materno:</label>
                </td>
            	<td>
                	<input type="text" id="apmatUsuario" name="apmatUsuario" value="<?php echo $dataUsuario['apmatUsuario'];?>" />
                </td>
            </tr>
            <tr>
                <td>
                    <label for="sexUsuario">Sexo:</label>
                </td>
                <td>
                    <label for="sexUsuarioM">Masculino</label>
                    <input type="radio" id="sexUsuarioM" name="sexUsuario" value="M" <?php echo $sexUsuario['M'];?> />
                    <label for="sexUsuarioF">Femenino</label>
                    <input type="radio" id="sexUsuarioF" name="sexUsuario" value="F" <?php echo $sexUsuario['F'];?> />
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
                    <label for="fechnacUsuario">Fecha de nacimiento:</label>
                </td>
                <td>
                    <input type="text" id="fechnacUsuario" name="fechnacUsuario" value="<?php echo $dataUsuario['fechnacUsuario']?>" />
                </td>
            </tr>
            <tr>
                <td>
                    <label for="emailUsuario">Correo electr&oacute;nico:</label>
                </td>
                <td>
                    <input type="text" id="emailUsuario" name="emailUsuario" value="<?php echo $dataUsuario['emailUsuario']?>" />
                </td>
            </tr>
        	<tr>
            	<td><label for="estUsuario">Estado:</label></td>
                <td>
					<input type="radio" id="actEstUsuario" name="estUsuario" value="A" <?php echo $estUsuario['A'];?> />
                    <label for="actEstUsuario">Activo</label> 
					<input type="radio" id="inaEstUsuario" name="estUsuario" value="I" <?php echo $estUsuario['I'];?> />
                    <label for="inaEstUsuario">Inactivo</label>
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
<?php
									break;
								case 'ca':
?>
	<h1>
	    Editar Campa&ntilde;a - Usuarios
		<img src="<?php echo images;?>icon_campaign.png" <?php echo sizeImg3;?> />
    </h1>
    <br /><br />
   	<a href="campana.php?op=li&mant=usu&id=<?php echo $_REQUEST['id'];?>"> << Volver</a>
    <br /><br />
    <p class="mensaje"><?php echo $mensaje;?></p>
    <br />
	<a href="<?php echo RESOURCES;?>/formato/C0000_Formato_Carga_ATA.xls">
		<img src="<?php echo images;?>icon_excel.png" <?php echo sizeImg;?> />
        Descargar formato
	</a>
    <br /><br />
    <label for="archCampana">Subir formato:</label>
    <input type="file" id="archCampana" name="archCampana"  />
    <br /><br />
    <button type="submit">Cargar datos</button>
    <br /><br />
<?php
								
									if(isset($_FILES['archCampana'])){
										$excel = $general->leerExcel($_FILES['archCampana']['tmp_name'], 3);

										for($i=2; $i<=count($excel[1]); $i++){
?>
	<input type="hidden" id="nombres" name="nombres[]" value="<?php echo $excel[1][$i][1];?>" />
	<input type="hidden" id="paterno" name="paterno[]" value="<?php echo $excel[1][$i][2];?>" />
	<input type="hidden" id="materno" name="materno[]" value="<?php echo $excel[1][$i][3];?>" />
	<input type="hidden" id="dni" name="dni[]" value="<?php echo $excel[1][$i][4];?>" />
	<input type="hidden" id="sexo" name="sexo[]" value="<?php echo $excel[1][$i][5];?>" />
	<input type="hidden" id="estciv" name="estciv[]" value="<?php echo $excel[1][$i][6];?>" />
	<input type="hidden" id="fechnac" name="fechnac[]" value="<?php echo $excel[1][$i][7];?>" />
	<input type="hidden" id="email" name="email[]" value="<?php echo $excel[1][$i][8];?>" />
<?php
										}
										if($_FILES['archCampana']['name']!=""){
?>
	<h2>Informaci&oacute;n a cargar</h2>
    <table id="campana">
    	<thead>
        	<tr>
            	<td>NOMBRES</td>
            	<td>APELLIDO PATERNO</td>
            	<td>APELLIDO MATERNO</td>
            	<td>DNI</td>
            	<td>SEXO</td>
            	<td>ESTADO CIVIL</td>
            	<td>FECHA DE NACIMIENTO</td>
            	<td>E-MAIL</td>
            </tr>
        </thead>
        <tbody>
<?php
										for($i=2; $i<=count($excel[1]); $i++){
?>
			<tr>
<?php
											for($j=1; $j<=count($excel[1][$i]); $j++){
?>
				<td><?php echo $excel[1][$i][$j];?></td>
<?php
											}
?>
			</tr>
<?php
										}
?>
		</tbody>
	</table>
    <br /><br />
    <button type="submit">Guardar</button>
<?php
										}
										if(isset($_POST['nombres']) and $_FILES['archCampana']['name']==""){
											$idCampana = $_REQUEST['id'];
											
											require_once(ENTITIES.'usuario.php');
											require_once(ENTITIES.'usuarioCampana.php');
											$usuario = new usuario();
											$usuarioCampana = new usuarioCampana();
											
											$dataUsuario = array(
												'idUsuario'=>NULL,
												'rolUsuario'=>'U',
												'nomUsuario'=>NULL,
												'appatUsuario'=>NULL,
												'apmatUsuario'=>NULL,
												'loginUsuario'=>NULL,
												'passUsuario'=>NULL,
												'sexUsuario'=>NULL,
												'estcivUsuario'=>NULL,
												'fechnacUsuario'=>NULL,
												'emailUsuario'=>NULL,
												'estUsuario'=>'A',
												'usuCrea'=>$_SESSION['usuario']['id'],
												'usuEdita'=>$_SESSION['usuario']['id'],
												'fechCrea'=>NULL,
												'fechEdita'=>NULL
											);
											
											require_once(ENTITIES.'empresa.php');
											$empresa = new empresa();
											$nomEmpresa = $empresa->getNameByIDCampaign($idCampana);
											
											$excel = array();
											$cont = 1;
											
											for($i=0; $i<count($_REQUEST['nombres']); $i++){
												$idUsuario = 0;
												if($_REQUEST['dni'][$i]<>""){
													$dataUsuario['loginUsuario'] = $_REQUEST['dni'][$i];
													$idUsuario = $usuario->getIDByLogin($dataUsuario['loginUsuario']);
												}else{
													$nombre = explode(' ', $nomEmpresa);
													if(count($nombre)>=2){					
														$total = count($nombre);
														if($total>3){
															$total = 3;
														}
														$prefijo = "";
														for($j=0; $j<count($nombre); $j++){
															$prefijo .= strtolower(substr($nombre[$j], 0, 1));
														}
													}else{
														$prefijo = strtolower(substr($nombre[0], 0, 3));
													}
													
													$max = $usuario->getMaxByPrefix($prefijo) + 1;
													$dataUsuario['loginUsuario'] = $prefijo . str_pad($max, 4, "0", STR_PAD_LEFT);							
												}
												
												$clave = $general->generarClave(8);
												
												$dataUsuario['idUsuario'] = $idUsuario;
												$dataUsuario['nomUsuario'] = $_REQUEST['nombres'][$i];
												$dataUsuario['appatUsuario'] = $_REQUEST['paterno'][$i];
												$dataUsuario['apmatUsuario'] = $_REQUEST['materno'][$i];
												$dataUsuario['passUsuario'] = $clave;
												$dataUsuario['sexUsuario'] = $_REQUEST['sexo'][$i];
												$dataUsuario['estcivUsuario'] = $_REQUEST['estciv'][$i];
												$dataUsuario['fechnacUsuario'] = $_REQUEST['fechnac'][$i];
												$dataUsuario['emailUsuario'] = $_REQUEST['email'][$i];
												
												$excel[$cont]['nombres'] = $_REQUEST['nombres'][$i];
												$excel[$cont]['paterno'] = $_REQUEST['paterno'][$i];
												$excel[$cont]['materno'] = $_REQUEST['materno'][$i];
												$excel[$cont]['login'] = $dataUsuario['loginUsuario'];
												$excel[$cont]['clave'] = $clave;
												$excel[$cont]['email'] = $_REQUEST['email'][$i];
												
												$cont++;
												
												$usuario->set($dataUsuario);
												
												if($idUsuario){
													$usuario->update();
												}else{
													$idUsuario = $usuario->insert();
												}
												
												$dataUsuarioCampana = array(
													'idUsuarioCampana'=>NULL,
													'idCampana'=>$idCampana,
													'idUsuario'=>$idUsuario,
													'idNivel'=>NULL,
													'profesionUsuarioCampana'=>NULL,
													'nivocuUsuarioCampana'=>NULL,
													'puestoUsuarioCampana'=>NULL
												);
												
												$usuarioCampana->set($dataUsuarioCampana);
												$usuarioCampana->insert();
											}
											
?>

<button type="submit">Exportar</button>
<br /><br />
<table id="campana">
    	<thead>
        	<tr>
                <td>NOMBRES</td>
                <td>APELLIDO PATERNO</td>
                <td>APELLIDO MATERNO</td>
                <td>USUARIO</td>
                <td>CONTRASE&Ntilde;A</td>
                <td>CORREO ELECTR&Oacute;NICO</td>
            </tr>
        </thead>
        <tbody>
<?php
										for($i=1; $i<=count($excel); $i++){
?>
			<tr>
            	<td><?php echo $excel[$i]['nombres'];?></td>
            	<td><?php echo $excel[$i]['paterno'];?></td>
            	<td><?php echo $excel[$i]['materno'];?></td>
            	<td><?php echo $excel[$i]['login'];?></td>
            	<td><?php echo $excel[$i]['clave'];?></td>
            	<td><?php echo $excel[$i]['email'];?></td>
            </tr>
<?php
										}
?>
        </tbody>
    </table>
</form>
<form id="formExcel" name="formExcel" method="post" action="exportar.php">
	<input type="hidden" id="type" name="type" value="excel" />
	<input type="hidden" id="op" name="op" value="usu" />
    <br /><br />
    <button type="submit">Exportar</button>
    <a href="campana.php">
		<button type="button" id="finalizar">Finalizar</button>
    </a>
<?php
										for($i=1; $i<=count($excel); $i++){
?>
	<input type="hidden" id="nombres" name="nombres[]" value="<?php echo $excel[$i]['nombres'];?>" />
	<input type="hidden" id="paterno" name="paterno[]" value="<?php echo $excel[$i]['paterno'];?>" />
	<input type="hidden" id="materno" name="materno[]" value="<?php echo $excel[$i]['materno'];?>" />
	<input type="hidden" id="login" name="login[]" value="<?php echo $excel[$i]['login'];?>" />
	<input type="hidden" id="clave" name="clave[]" value="<?php echo $excel[$i]['clave'];?>" />
	<input type="hidden" id="email" name="email[]" value="<?php echo $excel[$i]['email'];?>" />
<?php
											}
										}
									}
									break;
								case 'co':
									$usuario->get($_REQUEST['idUsuario']);
									$dataUsuario = $usuario->setArray;
									if(isset($_POST['idUsuario'])){
										if($_POST['passUsuario'] == $_POST['passUsuario2']){
											if($usuario->updatePassword($_POST['idUsuario'], $_POST['passUsuario'])){
												$mensaje = "La contrase&ntilde;a ha sido cambiada correctamente.";
											}else{
												$mensaje = "La contrase&ntilde;a no ha podido ser cambiada.";
											}
										}else{
											$mensaje = "Las contrase&ntilde;as no coinciden.";
										}
									}
?>
	<input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo $dataUsuario['idUsuario'];?>" />
	<h1>
	    Editar Campa&ntilde;a - Usuarios
		<img src="<?php echo images;?>icon_campaign.png" <?php echo sizeImg3;?> />
    </h1>
    <br /><br />
   	<a href="campana.php?op=li&mant=usu&id=<?php echo $_REQUEST['id'];?>"> << Volver</a>
    <br /><br />
    <p class="mensaje"><?php echo $mensaje;?></p>
    <br />
    <table id="cuestionario">
    	<tbody>
        	<tr id="titulo">
            	<td colspan="2">
                	<strong><?php echo $dataUsuario['nomUsuario']." ".$dataUsuario['appatUsuario'];?></strong>
                </td>
			</tr>
        	<tr id="subtitulo">
            	<td colspan="2">
                	<strong><?php echo $dataUsuario['loginUsuario'];?></strong>
                </td>
			</tr>
        	<tr>
            	<td>
                	<label for="passUsuario">Contrase&ntilde;a:</label>
                </td>
            	<td>
                	<input type="password" id="passUsuario" name="passUsuario" />
                </td>
			</tr>
        	<tr>
            	<td>
                	<label for="passUsuario2">Repetir contrase&ntilde;a:</label>
                </td>
            	<td>
                	<input type="password" id="passUsuario2" name="passUsuario2" />
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
<?php
									break;
							}
						}
						break;
					case 'niv':
						require_once(ENTITIES.'nivelTipo.php');
						require_once(ENTITIES.'nivel.php');
						$nivelTipo = new nivelTipo();
						$nivel = new nivel();
						
						$niveles = $nivel->getSimpleByCampaignID($_REQUEST['id']);
						$nivelesTipo = $nivelTipo->getForCampaign($_REQUEST['id']);
						
						if(!isset($_REQUEST['esNuevo'])){
?>              	
	<h1>
	    Editar Campa&ntilde;a - Niveles estructurales de empresa
		<img src="<?php echo images;?>icon_campaign.png" <?php echo sizeImg3;?> />
    </h1>
    <br /><br />
   	<a href="campana.php?op=li&id=<?php echo $_REQUEST['id'];?>"> << Volver</a>
    <br /><br />
    <a href="campana.php?op=li&mant=niv&esNuevo=1&id=<?php echo $_REQUEST['id'];?>">Crear nivel</a>
    <br />
    <p class="mensaje"><?php echo $mensaje;?></p>
    <br /><br />
    <table id="campana">
    	<thead>
        	<tr>
<?php
							for($i=0; $i<count($nivelesTipo); $i++){
?>
				<td><?php echo $nivelesTipo[$i]['nombre'];?></td>
<?php
							}
?>
            </tr>
        </thead>
        <tbody>
<?php
							for($i=1; $i<=count($niveles); $i++){
?>
			<tr>
<?php
								for($j=1; $j<=count($niveles[$i]); $j++){
?>
				<td>
					<?php echo $niveles[$i][$j]['nom'];?> 
                    <a href="campana.php?op=li&mant=niv&esNuevo=0&id=<?php echo $_REQUEST['id'];?>&idNivel=<?php echo $niveles[$i][$j]['id'];?>">(Editar)</a>
                </td>
<?php
								}
?>
            </tr>
<?php
							}
?>
        </tbody>
    </table>
<?php				
						}
						if(isset($_REQUEST['esNuevo'])){
?>
	<input type="hidden" id="esNuevo" name="esNuevo" value="<?php echo $_REQUEST['esNuevo'];?>" />
<?php
							if($_REQUEST['esNuevo']){
								if(isset($_POST['otroNivel'])){
									$dataNivel = array(
										'idNivel'=>NULL,
										'idNivelTipo'=>NULL,
										'nomNivel'=>NULL,
										'depenNivel'=>0
									);
									
									$bool = true;
									
									for($i=0; $i<count($_POST['otroNivel']); $i++){
										if($bool){
											if($_POST['otroNivel'][$i]<>""){
												$dataNivel['idNivelTipo'] = $_POST['idNivelTipo'][$i];
												$dataNivel['nomNivel'] = $_POST['otroNivel'][$i];
												$nivel->set($dataNivel);
												$dataNivel['depenNivel'] = $nivel->insert();
											}else{
												if($_POST['idNivel'][$i]<>'NULL'){
													$dataNivel['depenNivel'] = $_POST['idNivel'][$i];
												}else{
													$bool = false;
													break;
												}
											}
										}
									}
									
									if($bool){
										header("location: campana.php?op=li&mant=niv&id={$_REQUEST['id']}");
									}else{
										$mensaje = "Debe seleccionar un &iacute;tem de los campos seleccionables, de lo contrario debe especificar otro.";
									}
								}
?>
	<h1>
	    Editar Campa&ntilde;a - Niveles estructurales de empresa
		<img src="<?php echo images;?>icon_campaign.png" <?php echo sizeImg3;?> />
    </h1>
    <br /><br />
   	<a href="campana.php?op=li&mant=niv&id=<?php echo $_REQUEST['id'];?>"> << Volver</a>
    <br /><br />
    <p class="mensaje"><?php echo $mensaje;?></p>
    <br />
    <table id="cuestionario" name="<?php echo count($nivelesTipo);?>">
    	<tbody>
<?php
							$depenNivel = 0;
							$contador = 1;
							foreach($nivelesTipo as $value){
?>
			<tr>
                <td>
                    <label><?php echo $value['nombre'];?>:</label>
                </td>
                <td id="nivel<?php echo $contador;?>">
                	<input type="hidden" id="idNivelTipo" name="idNivelTipo[]" value="<?php echo $value['id'];?>" />
       				<?php echo $general->combo($nivel->getCombo($value['id'], $depenNivel), 'idNivel', true, '', 0, 1)?>
				</td>
                <td>
                    <label for="otro<?php echo $contador;?>">Otro</label>
                	<input type="checkbox" id="otro<?php echo $contador;?>" name="otro<?php echo $contador;?>" value="1" otro="1" />
                </td>
                <td>
                	<input type="text" id="otroNivel" name="otroNivel[]" />
                </td>
			</tr>
<?php
							$depenNivel = -1;
							$contador++;
						}
?>
			<tr>
            	<td></td>
                <td>
                	<button type="submit">Guardar</button>
                </td>
            </tr>
		</tbody>
    </table>
<?php
							}else{
								$dataNivel = array(
									'idNivel'=>NULL,
									'idNivelTipo'=>NULL,
									'nomNivel'=>NULL,
									'depenNivel'=>NULL
								);
								
								if(isset($_POST['nomNivel'])){
									foreach($dataNivel as $key=>$value){
										if(isset($_POST[$key])){
											$dataNivel[$key] = $_POST[$key];
										}
									}
									
									$nivel->set($dataNivel);
									
									if($nivel->update()){
										header("location: campana.php?op=li&mant=niv&id={$_REQUEST['id']}");
									}else{
										$mensaje = "No se ha modificado el registro.";
									}
								}
								
								$nivel->get($_REQUEST['idNivel']);
								$dataNivel = $nivel->setArray;
								
								$nomNivelTipo = $nivelTipo->getNameByID($dataNivel['idNivelTipo']);
								
?>
	<h1>
	    Editar Campa&ntilde;a - Niveles estructurales de empresa
		<img src="<?php echo images;?>icon_campaign.png" <?php echo sizeImg3;?> />
    </h1>
    <br /><br />
   	<a href="campana.php?op=li&mant=niv&id=<?php echo $_REQUEST['id'];?>"> << Volver</a>
    <br /><br />
    <p class="mensaje"><?php echo $mensaje;?></p>
    <br />
    <table id="cuestionario">
    	<tbody>
        	<tr>
            	<td>
                	<label for="nomNivel"><?php echo $nomNivelTipo;?>:</label>
                </td>
                <td>
                	<input type="hidden" id="idNivel" name="idNivel" value="<?php echo $dataNivel['idNivel'];?>" />
                	<input type="hidden" id="idNivelTipo" name="idNivelTipo" value="<?php echo $dataNivel['idNivelTipo'];?>" />
                	<input type="hidden" id="depenNivel" name="depenNivel" value="<?php echo $dataNivel['depenNivel'];?>" />
                	<input type="text" id="nomNivel" name="nomNivel" value="<?php echo $dataNivel['nomNivel'];?>" />
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
<?php
							}
						}
						break;
					case 'pre':
						require_once(ENTITIES.'oculto.php');
						$oculto = new oculto();
						
						$bool = true;
						
						if(isset($_POST['totalP'])){
							$dataOculto = array(
								'idOculto'=>NULL,
								'idPregunta'=>NULL,
								'idCampana'=>$_REQUEST['id']
							);
							
							$bool &= $oculto->deleteByCampaignID($_REQUEST['id']);
							
							for($i=1; $i<=$_POST['totalP']; $i++){
								if(isset($_POST['p'.$i])){
									$dataOculto['idPregunta'] = $_POST['p'.$i];
									$oculto->set($dataOculto);
									$bool &= $oculto->insert();
								}
							}
							
							if($bool){
								$mensaje = "Registros guardados exitosamente.";
							}else{
								$mensaje = "No se pudieron guardar los registros.";
							}
						}
						
						$marcadas = $oculto->getByCampaignID($_REQUEST['id']);
						
						if(is_array($marcadas)){
							$aux = $marcadas;
							unset($marcadas);
							$marcadas = array();
							foreach($aux as $key=>$value){
								$marcadas[$key] = "checked='CHECKED'";
							}
						}
?>
	<h1>
	    Editar Campa&ntilde;a - Preguntas excluidas
		<img src="<?php echo images;?>icon_campaign.png" <?php echo sizeImg3;?> />
    </h1>
    <br /><br />
   	<a href="campana.php?op=li&id=<?php echo $_REQUEST['id'];?>"> << Volver</a>
    <br /><br />
    <br />
    <p class="mensaje"><?php echo $mensaje;?></p>
    <br />
    <button type="submit">Guardar</button> 
    <br /><br />
    <table id="cuestionario">
<?php
					$preguntas = $pregunta->getComplete();
					$i=1;
					$j=1;
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
							$checked = $marcadas[$id];
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
?>
	</table>
    <input type="hidden" id="totalP" name="totalP" value="<?php echo $j-1;?>" />
    <br /><br />
    <button type="submit">Guardar</button> 
    
    
    
<?php						
						break;
				}
?>
    <input type="hidden" id="id" name="id" value="<?php echo $_REQUEST['id'];?>" />
    <input type="hidden" id="mant" name="mant" value="<?php echo $mant;?>" />
<?php
			}else{
				header("location: campana.php");
			}
			break;
		case 'el':
			$mensaje = "No se pudo eliminar la campa&ntilde;a.";
			if(isset($_REQUEST['id'])){
				if($campana->deleteCampaign($_REQUEST['id'])){
					$mensaje = "La campa&ntilde;a ha sido eliminada.";
				}
			}
?>
	<p class="mensaje"><?php echo $mensaje;?></p>
<?php
			break;
	}
?>
</form>
<?php
}
require_once(TEMPLATES.'footer.php');
?>