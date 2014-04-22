<?php
class profesion{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idProfesion'=>$data['idProfesion'],
                'idProfesion'=>$data['nomProfesion']
        );
        $this->setArray = $resultado;
    }
	
	public function getCombo(){
		$consulta = "	SELECT id_profesion, nom_profesion
						FROM profesion;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			while($fila = mysql_fetch_array($resultado)){
				$profesion[] = array(
					'id'=>$fila['id_profesion'],
					'nombre'=>$fila['nom_profesion']
				);
			}
		}else{
			$profesion = "";
		}
		mysql_free_result($resultado);
		return $profesion;
	}
}
?>