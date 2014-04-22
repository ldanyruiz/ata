<?php
require_once('config.php');
require_once(TEMPLATES.'header.php');

require_once(RESOURCES.'general.php');
require_once(ENTITIES.'usuario.php');
require_once(ENTITIES.'campana.php');
require_once(ENTITIES.'usuarioCampanaReporte.php');
$general = new general();
$usuario = new usuario();
$campana = new campana();
$usuarioCampanaReporte = new usuarioCampanaReporte();


//echo $general->iA("session", $_SESSION);

$mensaje = "";
if(!isset($_REQUEST['op'])){
?>
<form id="formGrilla" name="formGrilla" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <h1>
	    Usuarios del Sistema
		<img src="<?php echo images;?>icon_users.png" <?php echo sizeImg3;?> />
    </h1>
	<br /><br />
	<a href="usuarios.php?op=nu">
		<img src="<?php echo images;?>icon_add.png" <?php echo sizeImg;?> />
		Crear usuario
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
	
	$usuario->numRows($buscar);
	
	$paginacion = array("totalPag"=>$usuario->numRows, "actualPag"=>0, "cantPag"=>50, "colPag"=>"", "ascPag"=>1);
	foreach($paginacion as $key => $value){
		if(isset($_REQUEST[$key])){
			$paginacion[$key] = $_REQUEST[$key];
		}
	}	
	$paginacion["totalPag"] = $usuario->numRows;
	
	echo $general->grilla($usuario->show($buscar, $paginacion), 'Lista de usuarios del sistema', 'icon_users.png', 'usuarios.php', false, false, true, $paginacion);
	?>
</form>
<p class="loading"></p>
<?php
}else{
?>
<form id="formUsuarios" name="formUsuarios" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<script src="<?php echo SCRIPTS;?>constructor.js" language="javascript" type="text/javascript"></script>
<?php
	
	$idUsuario = NULL;
	if(isset($_REQUEST['id'])){
		$idUsuario = $_REQUEST['id'];
	}
	$titulo = "";
	
	$data = array(
		'idUsuario'=>$idUsuario,
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
		'fechCrea'=>NULL,
		'fechEdita'=>NULL
	);
	
	//Reconociendo los datos enviados
	foreach($data as $key=>$value){
		if(isset($_POST[$key])){
			$data[$key] = $_POST[$key];
		}
	}
	
	switch($_REQUEST['op']){
		case 'nu':
			$titulo = "Crear";
			if(isset($_POST)){
				if(isset($_POST['loginUsuario'])){
					$boolCorreo = $general->validarCorreo($data['emailUsuario']);
					if($_POST['loginUsuario']!="" and $_POST['nomUsuario']!="" 
					and $_POST['emailUsuario']!="" and $_POST['rolUsuario']!=""
					and $boolCorreo){
						$id = $usuario->getIDByLogin($data['loginUsuario']);
						$mensajeExtra = "";
						if($id){
							$usuario->get($id);
							$data = $usuario->setArray;
							
							$data['rolUsuario'] = $_POST['rolUsuario'];
							$data['nomUsuario'] = $_POST['nomUsuario'];
							$data['appatUsuario'] = $_POST['appatUsuario'];
							$data['apmatUsuario'] = $_POST['apmatUsuario'];
							$data['emailUsuario'] = $_POST['emailUsuario'];
							$data['estUsuario'] = $_POST['estUsuario'];
							$data['usuCrea'] = $_SESSION['usuario']['id'];
							$data['usuEdita'] = $_SESSION['usuario']['id'];
							$data['fechCrea'] = NULL;
							$data['fechEdita'] = NULL;
						
							$data['passUsuario'] = $general->generarClave();
							$usuario->set($data);
							$usuario->update();
							$usuario->updatePassword($id, $data['passUsuario']);
							$mensajeExtra = "El DNI ya estaba registrado, por tanto se han actualizado los datos principales.";
						}else{		
							$data['passUsuario'] = $general->generarClave();			
							$usuario->set($data);
							$id = $usuario->insert();
						}

                                                $usuarioCampanaReporte->delete($id);                                                
                                                if($_SESSION['usuario']['rol']=='A' || $_SESSION['usuario']['rol']=='S'){
                                                        $arr_campana = $campana->getAllCampanas();
                                                        foreach ($arr_campana as $value) {
                                                            $data['idCampana'] = $value['id'];
                                                            $data['idUsuario'] = $id;
                                                            $usuarioCampanaReporte->set($data);
                                                            $usuarioCampanaReporte->insert();
                                                        }
                                                }else{
                                                        for($i=0; $i<count($_REQUEST['usuario_campana']); $i++){
                                                            $data['idCampana'] = $_REQUEST['usuario_campana'][$i];
                                                            $data['idUsuario'] = $id;
                                                            $usuarioCampanaReporte->set($data);
                                                            $usuarioCampanaReporte->insert();
                                                        }
                                                }      
                                                
						if($id){
							
							$mensaje = "
							<p>Se te ha registrado como usuario en el Sistema Ficha ATA, tus datos son los siguientes:</p>
							<br />
							<table>
								<tr>
									<td><strong>Usuario:</strong></td>
									<td>{$data['loginUsuario']}</td>
								</tr>
								<tr>
									<td><strong>Contrase&ntilde;a:</strong></td>
									<td>{$data['passUsuario']}</td>
								</tr>
							</table>
							<br /><br />
							<p>Puedes cambiar tu contrase&ntilde;a desde el sistema haciendo click en tu nombre al lado 
							de la opci&oacute;n Salir del sistema.</p>
							<br />
							<p>Puedes ingresar al sistema haciendo click <a href='http://".baseURL."'>aqu&iacute;</a>
							";
							
							$asunto = "Has sido registrado como usuario en el Sistema Ficha ATA";
							
							$general->enviarMail($data['emailUsuario'], $asunto, $mensaje);
						
							$mensaje = "Usuario creado correctamente. ".$mensajeExtra;
								
							$data = array(
								'idUsuario'=>$idUsuario,
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
								'fechCrea'=>NULL,
								'fechEdita'=>NULL
							);
						}else{
							$mensaje = "No se ha podido generar el usuario.";
						}
					}else{
						$mensaje = "Debes llenar el rol, DNI, nombre y correo electr&oacute;nico correctamente.";
					}
				}
			}
			break;
		case 'li':
			$titulo = "Editar";
			$usuario->get($idUsuario);
			$data = $usuario->setArray;
			$_REQUEST['op'] = 'ed';
			break;
		case 'ed':
			$titulo = "Editar";
			if(isset($_POST)){
				if(isset($_POST['loginUsuario'])){
					$boolCorreo = $general->validarCorreo($data['emailUsuario']);
					if($_POST['loginUsuario']!="" and $_POST['nomUsuario']!="" 
					and $_POST['emailUsuario']!="" and $_POST['rolUsuario']!=""
					and $boolCorreo){
						$usuario->set($data);
                                                
                                                $usuarioCampanaReporte->delete($_POST['id']);                                                
                                                if($_SESSION['usuario']['rol']=='A' || $_SESSION['usuario']['rol']=='S'){
                                                        $arr_campana = $campana->getAllCampanas();
                                                        foreach ($arr_campana as $value) {
                                                            $data['idCampana'] = $value['id'];
                                                            $data['idUsuario'] = $_POST['id'];
                                                            $usuarioCampanaReporte->set($data);
                                                            $usuarioCampanaReporte->insert();
                                                        }
                                                }else{
                                                        for($i=0; $i<count($_REQUEST['usuario_campana']); $i++){
                                                            $data['idCampana'] = $_REQUEST['usuario_campana'][$i];
                                                            $data['idUsuario'] = $_POST['id'];
                                                            $usuarioCampanaReporte->set($data);
                                                            $usuarioCampanaReporte->insert();
                                                        }
                                                } 
                                                
						if($usuario->update()){
							$mensaje = "Registro guardado exitosamente.";
						}else{
							$mensaje = "No se han realizado cambios.";
						}
					}else{
						$mensaje = "Debes llenar todos los campos correctamente.";
					}
				}				
			}
			break;
		case 'el':
			if(isset($_REQUEST['id'])){
				if($usuario->updateStatus($_REQUEST['id'])){
					$mensaje = "Registro eliminado exitosamente.";
				}else{
					$mensaje = "No se pudo eliminar el registro.";
				}
			}
			break;
	}
	$roles = array(
		0=>array(
			'id'=>'R',
			'nombre'=>'Visualizador de reportes'
		),
		1=>array(
			'id'=>'A',
			'nombre'=>'Administrador del sistema'
		),
		2=>array(
			'id'=>'S',
			'nombre'=>'Superadministrador'
		)
	);
	
	$rolUsuario = $general->combo($roles, 'rolUsuario', false, '', $data['rolUsuario']);
	
	$estUsuario = array('A'=>'', 'I'=>'');
	$estUsuario[$data['estUsuario']] = "checked='CHECKED'";
?>
    <h1>
	    <?php echo $titulo;?> usuario
		<img src="<?php echo images;?>icon_users.png" <?php echo sizeImg3;?> />
    </h1>
	<br /><br />
   	<a href="usuarios.php"> << Volver</a>
    <br /><br />
	<p class="mensaje"><?php echo $mensaje;?></p>
    <input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo $data['idUsuario'];?>" />
    <table id="formulario">
    	<tbody>
        	<tr>
            	<td>
                	<label for="rolUsuario">Rol:</label>
                </td>
                <td>
                	<?php echo $rolUsuario;?>
				</td>
            </tr>
            
            <?php
                $display="none";
                if($data['idUsuario'] && $data['rolUsuario']=='R'){
                    $display="block";
                }
            ?>
            <tr id="usuario_campana_tr" style="display: <?php echo  $display?>">
            	<td>
                	<label for="nomUsuario">Campañas a Revisar:</label>
                </td>
                <td>
                    <?php
                            $arr_campana = $campana->getAllCampanas();
                            $x=0;
                            foreach($arr_campana as $value){
                                
                                $data['idCampana'] = $value['id'];
                                $data['idUsuario'] = $data['idUsuario'];
                                $usuarioCampanaReporte->set($data);
                                $checked = '';
                                if($usuarioCampanaReporte->getIdUsuarioCampana()){
                                    $checked = 'checked';    
                                }                                
                                
                                ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input class="usuario_campana<?php echo $x?>" type="checkbox" name="usuario_campana[]" id="usuario_campana<?php echo $x?>" 
                        value="<?php echo trim($value['id']);?>"  <?php echo $checked?> >                           
                        <label for="nomUsuario"><?php echo trim($value['nombre']);?></label>
                            <?php $x++;                            
                            }?>
        	</td>
            </tr>            
        	<tr>
            	<td>
                	<label for="nomUsuario">Nombre:</label>
                </td>
                <td>
                	<input type="text" id="nomUsuario" name="nomUsuario" size="30" value="<?php echo $data['nomUsuario'];?>" />
				</td>
            </tr>
        	<tr>
            	<td>
                	<label for="appatUsuario">Apellido paterno:</label>
                </td>
                <td>
                	<input type="text" id="appatUsuario" name="appatUsuario" size="30" value="<?php echo $data['appatUsuario'];?>" />
				</td>
            </tr>
        	<tr>
            	<td>
                	<label for="apmatUsuario">Apellido materno:</label>
                </td>
                <td>
                	<input type="text" id="apmatUsuario" name="apmatUsuario" size="30" value="<?php echo $data['apmatUsuario'];?>" />
				</td>
            </tr>
        	<tr>
            	<td>
                	<label for="loginUsuario">DNI:</label>
                </td>
                <td>
                    <input type="text" id="loginUsuario" name="loginUsuario" value="<?php echo $data['loginUsuario'];?>" maxlength="8" />
				</td>
            </tr>
        	<tr>
            	<td>
                	<label for="emailUsuario">Correo electr&oacute;nico:</label>
                </td>
                <td>
                	<input type="text" id="emailUsuario" name="emailUsuario" size="50" value="<?php echo $data['emailUsuario'];?>" />
				</td>
            </tr>
        	<tr>
            	<td>
                	<label for="estUsuario">Estado:</label>
                </td>
                <td>
                	<input type="radio" id="estUsuarioA" name="estUsuario" value="A" <?php echo $estUsuario['A'];?> />
                	<label for="estUsuarioA">Activo</label>
                    <br />
                	<input type="radio" id="estUsuarioI" name="estUsuario" value="I" <?php echo $estUsuario['I'];?> />
                	<label for="estUsuarioI">Inactivo</label>
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
	<input type="hidden" id="op" name="op" value="<?php echo $_REQUEST['op'];?>" />
	<input type="hidden" id="id" name="id" value="<?php echo $idUsuario;?>" />
</form>
<?php
}
require_once(TEMPLATES.'footer.php');
?>