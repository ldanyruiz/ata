<?php
require_once('config.php');
require_once(TEMPLATES.'header.php');

require_once(ENTITIES.'usuario.php');
$usuario = new usuario();

$yo = $_SESSION['usuario'];

$usuario->get($yo['id']);
$completo = $usuario->setArray;

$roles = array(
	'R'=>'Visualizador de reportes',
	'A'=>'Administrador del sistema',
	'S'=>'Superadministrador'
);

if(!isset($_REQUEST['clave'])){
?>
<link href="<?php echo CSS;?>grilla.CSS" type="text/CSS" rel="stylesheet" />
<h1>
	<img src="<?php echo images;?>icon_user.png" <?php echo sizeImg3;?> />
	<?php echo $yo['nombre'].' '.$yo['paterno'].' '.$yo['materno'];?>
</h1>
<br />
<p>A continuaci&oacute;n podr&aacute;s ver la informaci&oacute;n principal de tu cuenta:</p>
<br /><br /><br /><br />
<table id="grilla" class="marginado">
	<thead>
		<tr>
			<td colspan="2"><center>INFORMACI&Oacute;N DEL USUARIO</center></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="alt">Apellido paterno:</td>
			<td><?php echo $yo['paterno'];?></td>
		</tr>
		<tr>
			<td class="alt">Apellido materno:</td>
			<td><?php echo $yo['materno'];?></td>
		</tr>
		<tr>
			<td class="alt">Nombres:</td>
			<td><?php echo $yo['nombre'];?></td>
		</tr>
		<tr>
			<td class="alt">E-mail:</td>
			<td><?php echo $completo['emailUsuario'];?></td>
		</tr>
		<tr>
			<td class="alt">Tipo de usuario:</td>
			<td><?php echo $roles[$yo['rol']];?></td>
		</tr>
		<tr>
			<td class="alt">DNI:</td>
			<td><?php echo $completo['loginUsuario'];?></td>
		</tr>
		<tr>
			<td class="alt">Contrase&ntilde;a:</td>
			<td>
				******** 
				<a href="perfil.php?clave"><img src="<?php echo images;?>icon_edit.png" <?php echo sizeImg;?> /></a>
			</td>
		</tr>
	</tbody>
</table>
<?php
}else{
	$mensaje = "";
	if(isset($_POST['passUsuario'])){
		if($_POST['passUsuario']==$_POST['passUsuario2'] and $_POST['passUsuario']<>"" and $_POST['passUsuario2']<>""){
			if($usuario->updatePassword($_SESSION['usuario']['id'], $_POST['passUsuario'])){
				$mensaje = "La contrase&ntilde;a ha sido cambiada correctamente.";
			}else{
				$mensaje = "No se han realizado cambios.";
			}
		}else{
			$mensaje = "Las contrase&ntilde;as deben coincidar y no pueden estar en blanco.";
		}
	}
?>
<h1>
	<img src="<?php echo images;?>icon_user.png" <?php echo sizeImg3;?> />
	Cambiar contrase&ntilde;a
</h1>
<br /><br />
<a href="perfil.php"> << Volver</a>
<br /><br />
<br />
<p>Puede usar el siguiente formulario para cambiar su contrase&ntilde;a:</p>
<br /><br />
<p class="mensaje"><?php echo $mensaje;?></p>
<br /><br />
<form id="formClave" name="formClave" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<input type="hidden" id="clave" name="clave" value="<?php echo $_REQUEST['clave'];?>" />
	<table>
    	<tbody>
        	<tr>
            	<td>
                	<label for="passUSuario">Contrase&ntilde;a:</label>
                </td>
                <td>
                	<input type="password" id="passUsuario" name="passUsuario" />
                </td>
            </tr>
        	<tr>
            	<td>
                	<label for="passUSuario2">Repetir contrase&ntilde;a:</label>
                </td>
                <td>
                	<input type="password" id="passUsuario2" name="passUsuario2" />
                </td>
            </tr>
        	<tr>
            	<td></td>
                <td>
                	<button type="submit">Cambiar</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>
<?php
}
require_once(TEMPLATES.'footer.php');
?>