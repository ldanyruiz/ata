<?php 
ob_start(); 
require_once('config.php');
require_once(RESOURCES.'pagina.php');
require_once(RESOURCES.'Logger.php');
$pagina = new pagina();
$pagina->comprobar();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="<?php echo images;?>favicon.ico">
<link href="<?php echo CSS;?>main.css" type="text/css" rel="stylesheet" />
<link href="<?php echo CSS;?>jquery-ui.css" type="text/css" rel="stylesheet" />
<script src="<?php echo SCRIPTS;?>jquery.js" language="javascript" type="text/javascript"></script>
<script src="<?php echo SCRIPTS;?>jquery-ui.js" language="javascript" type="text/javascript"></script>
<script src="<?php echo SCRIPTS;?>general.js" language="javascript" type="text/javascript"></script>
<title>Plataforma Ficha ATA</title>
<base href="http://<?php echo baseURL;?>" />
</head>

<body>
    <div id="cuerpo">
    <?php echo str_repeat("<br />", 10);?>