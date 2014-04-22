<?php
class usuario{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idUsuario'=>$data['idUsuario'],
                'rolUsuario'=>$data['rolUsuario'],
                'nomUsuario'=>$data['nomUsuario'],
                'appatUsuario'=>$data['appatUsuario'],
                'apmatUsuario'=>$data['apmatUsuario'],
                'loginUsuario'=>$data['loginUsuario'],
                'passUsuario'=>$data['passUsuario'],
                'sexUsuario'=>$data['sexUsuario'],
                'estcivUsuario'=>$data['estcivUsuario'],
                'fechnacUsuario'=>$data['fechnacUsuario'],
                'emailUsuario'=>$data['emailUsuario'],
                'estUsuario'=>$data['estUsuario'],
                'usuCrea'=>$data['usuCrea'],
                'usuEdita'=>$data['usuEdita'],
                'fechCrea'=>$data['fechCrea'],
                'fechEdita'=>$data['fechEdita']
        );
        $this->setArray = $resultado;
    }
    
	function insert() {
		$data = $this->setArray;
		$consulta = "	INSERT INTO usuario VALUES(
						NULL, '{$data['rolUsuario']}', '{$data['nomUsuario']}', '{$data['appatUsuario']}', 
						'{$data['apmatUsuario']}', '{$data['loginUsuario']}', MD5('{$data['passUsuario']}'), 
						'{$data['sexUsuario']}', '{$data['estcivUsuario']}', '{$data['fechnacUsuario']}', 
						'{$data['emailUsuario']}', '{$data['estUsuario']}', {$data['usuCrea']}, NULL, NOW(), NULL
						); ";
		mysql_query($consulta) or die(mysql_error());
		return mysql_insert_id();
    }
		
	function update() {
		$data = $this->setArray;
		$consulta = "	UPDATE usuario SET
						rol_usuario='{$data['rolUsuario']}', 
						nom_usuario='{$data['nomUsuario']}', 
						appat_usuario='{$data['appatUsuario']}', 
						apmat_usuario='{$data['apmatUsuario']}', 
						login_usuario='{$data['loginUsuario']}', 
						sex_usuario='{$data['sexUsuario']}', 
						estciv_usuario='{$data['estcivUsuario']}', 
						fechnac_usuario='{$data['fechnacUsuario']}', 
						email_usuario='{$data['emailUsuario']}',
						usu_edita={$data['usuEdita']}, 
						fech_edita=NOW()
						WHERE id_usuario={$data['idUsuario']}; ";
		mysql_query($consulta) or die(mysql_error());
		return mysql_affected_rows();
    }
		
	function updateByUser() {
		$data = $this->setArray;
		$consulta = "	UPDATE usuario SET
						sex_usuario='{$data['sexUsuario']}', 
						estciv_usuario='{$data['estcivUsuario']}', 
						fechnac_usuario='{$data['fechnacUsuario']}', 
						email_usuario='{$data['emailUsuario']}', 
						usu_edita={$data['usuEdita']}, 
						fech_edita=NOW()
						WHERE id_usuario={$data['idUsuario']}; ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return mysql_affected_rows();
    }
		
	function updateStatus($idUsuario, $estUsuario='E') {
		$consulta = "	UPDATE usuario SET
						est_usuario='{$estUsuario}',
						usu_edita={$_SESSION['usuario']['id']}, 
						fech_edita=NOW()
						WHERE id_usuario={$idUsuario}; ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return mysql_affected_rows();
    }
		
	function delete($id) {
		$consulta = "	DELETE FROM usuario WHERE id_usuario = $id; ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }
	
	function login($login, $pass){
		//Para eliminar los espacios en blanco.
		$login = trim($login, " \t\n\r\0\x0B".chr(0xC2).chr(0xA0));
		$pass = trim($pass, " \t\n\r\0\x0B".chr(0xC2).chr(0xA0));
		
		$consulta = " 	SELECT u.id_usuario, rol_usuario
						FROM usuario u 
						WHERE u.login_usuario LIKE '$login' 
						AND u.pass_usuario LIKE  MD5('$pass'); ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$idUsuario = mysql_result($resultado, 0, "id_usuario");
			$rolUsuario = mysql_result($resultado, 0, "rol_usuario");
			$usuario = $this->buscarSesion($idUsuario, $rolUsuario);
			if(is_array($usuario)){
				$_SESSION['usuario'] = $usuario;
				
				require_once(ENTITIES.'formulario.php');
				$formulario = new formulario();
				$_SESSION['usuario']['formulario'] = $formulario->getAll($rolUsuario);
			}
			return true;
		}else{
			return false;
		}
	}
	
	public function buscarSesion($idUsuario, $rolUsuario){
		$bool = true;
		if($rolUsuario=='U'){
			require_once(ENTITIES.'usuarioCampana.php');
			$usuarioCampana = new usuarioCampana();
			$bool = $usuarioCampana->checkUser($idUsuario);
		}
		if($bool){
			$consulta = " 	SELECT u.id_usuario, u.rol_usuario, u.nom_usuario, u.appat_usuario, u.apmat_usuario,
							u.sex_usuario, u.estciv_usuario, u.fechnac_usuario, u.email_usuario, u.est_usuario
							FROM usuario u 
							WHERE u.id_usuario = $idUsuario
							AND u.est_usuario='A'; ";
			$resultado = mysql_query($consulta) or die (mysql_error());	
			if(mysql_num_rows($resultado)>0){			
				$usuario['id'] = mysql_result($resultado, 0, "id_usuario");
				$usuario['rol'] = mysql_result($resultado, 0, "rol_usuario");
				$usuario['nombre'] = mysql_result($resultado, 0, "nom_usuario");
				$usuario['paterno'] = mysql_result($resultado, 0, "appat_usuario");
				$usuario['materno'] = mysql_result($resultado, 0, "apmat_usuario");
				$usuario['sexo'] = mysql_result($resultado, 0, "sex_usuario");
				$usuario['estadoCivil'] = mysql_result($resultado, 0, "estciv_usuario");
				$usuario['nacimiento'] = mysql_result($resultado, 0, "fechnac_usuario");
				$usuario['email'] = mysql_result($resultado, 0, "email_usuario");
				$usuario['estado'] = mysql_result($resultado, 0, "est_usuario");
			}else{
				$usuario = "";
			}
			mysql_free_result($resultado);
		}else{
			$usuario = "";
		}
		return $usuario;
	}	
	
	public function get($id){
		$consulta = "	SELECT id_usuario, rol_usuario, nom_usuario, appat_usuario, apmat_usuario,
						login_usuario, sex_usuario, estciv_usuario, fechnac_usuario, email_usuario, est_usuario
						FROM usuario 
						WHERE id_usuario = $id;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$usuario= array(
				"idUsuario" => mysql_result($resultado, 0, "id_usuario"),
				"rolUsuario" => mysql_result($resultado, 0, "rol_usuario"),
				"nomUsuario" => mysql_result($resultado, 0, "nom_usuario"),
				"appatUsuario" => mysql_result($resultado, 0, "appat_usuario"),
				"apmatUsuario" => mysql_result($resultado, 0, "apmat_usuario"),
				"loginUsuario" => mysql_result($resultado, 0, "login_usuario"),
				"sexUsuario" => mysql_result($resultado, 0, "sex_usuario"),
				"estcivUsuario" => mysql_result($resultado, 0, "estciv_usuario"),
				"fechnacUsuario" => mysql_result($resultado, 0, "fechnac_usuario"),
				"emailUsuario" => mysql_result($resultado, 0, "email_usuario"),
				"estUsuario" => mysql_result($resultado, 0, "est_usuario")
			);
		}else{
			$usuario = "";
		}
		mysql_free_result($resultado);
		$this->setArray = $usuario;
	}
	
	public function show($buscar="", $pag = ""){
		
		$sentido = "";
		$orden = "";
		$limite = "";
		
		if(is_array($pag)){
			if($pag['colPag']<>""){			
				if($pag['ascPag']){
					$sentido = "ASC";
				}else{
					$sentido = "DESC";
				}
				$orden = "ORDER BY {$pag['colPag']} $sentido";
			}
			
			$pag['actualPag'] *= $pag['cantPag'];
			
			$limite = "LIMIT {$pag['actualPag']}, {$pag['cantPag']}";
		}
		
		$condicion = "";
		if($buscar<>""){
			$condicion .= "	AND (u.nom_usuario LIKE '%$buscar%' OR u.appat_usuario LIKE '%$buscar%'
							OR u.apmat_usuario LIKE '%$buscar%' OR u.login_usuario LIKE '%$buscar%')";
		}
		
		$consulta = " 	SELECT u.id_usuario AS 'ID', u.rol_usuario  AS 'Rol',
						u.appat_usuario AS 'Apellido Paterno', u.apmat_usuario AS 'Apellido Materno',
						u.nom_usuario AS 'Nombre'
						FROM usuario u
						WHERE u.est_usuario <> 'E'
						AND u.rol_usuario <> 'U'
						$condicion
						$orden
						$limite
						; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			require_once(RESOURCES.'general.php');
			$general = new general();
			$usuario = $general->consulta($resultado);
		}else{
			$usuario = "";
		}
		mysql_free_result($resultado);
		return $usuario;
	}	
	
	public function numRows($buscar=''){
		$condicion = "";
		if($buscar<>""){
			$condicion .= "	AND (u.nom_usuario LIKE '%$buscar%' OR u.appat_usuario LIKE '%$buscar%'
							OR u.apmat_usuario LIKE '%$buscar%' OR u.login_usuario LIKE '%$buscar%')";
		}
		$consulta = "	SELECT COUNT(u.id_usuario) AS 'total'
						FROM usuario u
						WHERE u.est_usuario <> 'E'
						AND u.rol_usuario <> 'U'
						$condicion;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$usuario = mysql_result($resultado, 0, "total");
		}else{
			$usuario = 0;
		}
		mysql_free_result($resultado);
		$this->numRows = $usuario;
	}
	
	public function getSimpleByCampaign($idCampana){
		$consulta = "	SELECT u.id_usuario, u.login_usuario, u.nom_usuario,
						u.appat_usuario, u.apmat_usuario
						FROM usuario_campana uc
						INNER JOIN usuario u ON uc.id_usuario = u.id_usuario
						WHERE uc.id_campana =$idCampana
						AND u.est_usuario <> 'E'
						ORDER BY u.appat_usuario, u.apmat_usuario, u.nom_usuario;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$usuario = array();
			while($fila = mysql_fetch_array($resultado)){
				$usuario[] = array(
					'id'=>$fila['id_usuario'],
					'login'=>$fila['login_usuario'],
					'nombre'=>$fila['nom_usuario'],
					'paterno'=>$fila['appat_usuario'],
					'materno'=>$fila['apmat_usuario']
				);
			}
		}else{
			$usuario = 0;
		}
		mysql_free_result($resultado);
		return $usuario;
	}
	
	public function getIDByLogin($loginUsuario){
		$consulta = " 	SELECT u.id_usuario
						FROM usuario u 
						WHERE u.login_usuario LIKE '$loginUsuario'; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$usuario = mysql_result($resultado, 0, "id_usuario");
		}else{
			$usuario = 0;
		}
		mysql_free_result($resultado);
		return $usuario;
	}	
	
	public function getMaxByPrefix($prefijo){
		$total = strlen($prefijo) + 1;
		$consulta = " 	SELECT MAX(IFNULL(SUBSTRING(login_usuario, $total, (LENGTH(login_usuario)-".strlen($prefijo).")) + 0, 1)) AS 'max_login'
						FROM usuario u 
						WHERE u.login_usuario LIKE '{$prefijo}%'
						AND u.est_usuario <> 'E'; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$usuario = mysql_result($resultado, 0, "max_login");
		}else{
			$usuario = 0;
		}
		mysql_free_result($resultado);
		return $usuario;
	}	
	
	public function getNameByID($idUsuario){
		$consulta = " 	SELECT u.nom_usuario
						FROM usuario u 
						WHERE u.id_usuario = $idUsuario; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$usuario = mysql_result($resultado, 0, "nom_usuario");
		}else{
			$usuario = "";
		}
		mysql_free_result($resultado);
		return $usuario;
	}	
	
	public function getAgeByID($idUsuario){
		$consulta = " 	SELECT TRUNCATE(((TO_DAYS(NOW()) - TO_DAYS(u.fechnac_usuario))/365), 0) AS 'edad'
						FROM usuario u 
						WHERE u.id_usuario = $idUsuario; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$usuario = mysql_result($resultado, 0, "edad");
		}else{
			$usuario = "";
		}
		mysql_free_result($resultado);
		return $usuario;
	}
	
	public function checkPassword($idUsuario, $passUsuario){
		$consulta = " 	SELECT id_usuario
						FROM usuario u 
						WHERE id_usuario = $idUsuario 
						AND pass_usuario LIKE  MD5('$passUsuario'); ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			return true;
		}else{
			return false;
		}
	}
		
	function updatePassword($idUsuario, $passUsuario){
		$consulta = "	UPDATE usuario SET
						pass_usuario=MD5('{$passUsuario}'),
						usu_edita={$_SESSION['usuario']['id']}, 
						fech_edita=NOW()
						WHERE id_usuario={$idUsuario}; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		return mysql_affected_rows();
	}
	
	public function getCombo(){
		$consulta = " 	SELECT u.id_usuario, u.nom_usuario, u.ape_usuario
						FROM usuario u
						WHERE u.est_usuario = 'A'
						ORDER BY u.ape_usuario, u.nom_usuario ASC; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$i=0;
			while($fila = mysql_fetch_array($resultado)){
				$usuario[$i]['id'] = $fila['id_usuario'];
				$usuario[$i]['nombre'] = $fila['ape_usuario'] . ", " . $fila['nom_usuario'];
				$i++;
			}
		}else{
			$usuario = "";
		}
		mysql_free_result($resultado);
		return $usuario;
	}	
}
?>