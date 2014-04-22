<?php
class pagina{
	public function comprobar(){
		if(isset($_SESSION['usuario'])){
			$bool = true;
			$permisos = $_SESSION['usuario']['formulario'];
			if($_SERVER['PHP_SELF'] != preURL.'inicio.php' and $_SERVER['PHP_SELF'] != preURL.'perfil.php'){
				foreach($permisos as $key=>$value){
					if($_SERVER['PHP_SELF'] == preURL.$permisos[$key]['link']){
						$bool = false;
					}				
				}
				
				if($bool){
					header('location: inicio.php');
				}
			}
		}else{
			if($_SERVER["PHP_SELF"]<>preURL.'index.php'){
				header('location: index.php');
			}
		}
	}
	public function menu(){
	
		$menu = "";
		
		if(isset($_SESSION['usuario'])){			
			$formularios = $_SESSION['usuario']['formulario'];
			if(is_array($formularios)){
				
				$menu = "<table id='menu'>";
				$menu .= "<tr>";
				
				$actual = $_SERVER['PHP_SELF'];
				
				foreach($formularios as $key=>$value){
						
						$menu .= "<td>";
						$menu .= "<a href='{$formularios[$key]['link']}'>";
						$menu .= "<img src='".images."{$formularios[$key]['icono']}' />";
						$menu .= "<br />{$formularios[$key]['nombre']}</a>";
						$menu .= "</td>";
					
				}
				$menu .= "</tr>";
				$menu .= "</table>";
			}else{
				if($_SERVER["PHP_SELF"]<>preURL.'index.php'){
					header('location: '.RESOURCES.'salir.php');
				}
			}
		}
		
		return $menu;
	}
}
?>