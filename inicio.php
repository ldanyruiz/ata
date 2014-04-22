<?php
require_once('config.php');
require_once(TEMPLATES.'header.php');
?>
<h1>Inicio del Sistema</h1>
<br />
<p>Bienvenido, <?php echo $_SESSION['usuario']['nombre'];?>.</p>
<br /><br /><br /><br />
<?php
echo $pagina->menu();
require_once(TEMPLATES.'footer.php');
?>