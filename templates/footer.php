	<br /><br /><br /><br /><br />
    </div>
<!--    <div id="pie">
    	<div>
        <a href="http://www.dho-consultores.com" target="_blank">DHO Consultores</a> - Ficha ATA &copy; Todos los derechos reservados.
        </div>
    </div>-->
	<div id="cabecera">
    	<img src="<?php echo images;?>dho.png" height="100%" />
    	An&aacute;lisis de Inspectores Sunafil
    </div>
<?php	
	if(isset($_SESSION['usuario'])){
		$link = "";
		if($_SESSION['usuario']['rol']<>'U'){
			$link = "perfil.php";
		}
?>
    <div id="sesion">
    	<div class="izq">
			<a href="inicio.php"><img src="<?php echo images;?>icon_home.png" /></a>
            <a href="inicio.php">Inicio</a>
        </div>
    	<div>
            <a href="<?php echo $link;?>"><?php echo $_SESSION['usuario']['nombre'];?></a>
            <a href="<?php echo $link;?>"><img src="<?php echo images;?>icon_user.png" /></a>
            -
            <a href="<?php echo RESOURCES;?>salir.php">Salir</a>
            <a href="<?php echo RESOURCES;?>salir.php"><img src="<?php echo images;?>icon_lock.png" /></a>
        </div>
    </div>
	<img id="loading" src="<?php echo images;?>loading.gif" />
<?php	
	}
?>

</body>
</html>
<?php
ob_end_flush();
?>