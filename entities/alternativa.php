<?php
class alternativa{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idAlternativa'=>$data['idAlternativa'],
                'idPregunta'=>$data['idPregunta'],
                'valAlternativa'=>$data['valAlternativa'],
                'textAlternativa'=>$data['textAlternativa'],
                'pregAlternativa'=>$data['pregAlternativa']
        );
        $this->setArray = $resultado;
    }
	
	public function getByQuestion($idPregunta){
		$consulta = "	SELECT id_alternativa, id_pregunta, val_alternativa, text_alternativa, preg_alternativa
						FROM alternativa
						WHERE id_pregunta = $idPregunta;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			while($fila = mysql_fetch_array($resultado)){
				$alternativa[] = array(
					'id'=>$fila['id_alternativa'],
					'pregunta'=>$fila['id_pregunta'],
					'valor'=>$fila['val_alternativa'],
					'texto'=>$fila['text_alternativa'],
					'depende'=>$fila['preg_alternativa']
				);
			}
		}else{
			$alternativa = "";
		}
		mysql_free_result($resultado);
		return $alternativa;
	}
}
?>