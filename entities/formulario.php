<?php
class formulario{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idFormulario'=>$data['idFormulario'],
                'nomFormulario'=>$data['nomFormulario'],
                'linkFormulario'=>$data['linkFormulario'],
                'icoFormulario'=>$data['icoFormulario'],
                'rolFormulario'=>$data['rolFormulario']
        );
        $this->setArray = $resultado;
    }
	
	public function getAll($rol){
		$consulta = "	SELECT 	id_formulario, nom_formulario, link_formulario,
								ico_formulario, rol_formulario
						FROM formulario
						WHERE rol_formulario LIKE '$rol';
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$formulario = array();
			while($fila = mysql_fetch_array($resultado)){
				$formulario[] = array(
					'nombre'=>$fila['nom_formulario'],
					'link'=>$fila['link_formulario'],
					'icono'=>$fila['ico_formulario']
				);
			}
		}else{
			$formulario = "";
		}
		mysql_free_result($resultado);
		return $formulario;
	}
}
?>