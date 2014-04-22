<?php
class seccion{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idSeccion'=>$data['idSeccion'],
                'idReporte'=>$data['idReporte'],
                'nomSeccion'=>$data['nomSeccion']
        );
        $this->setArray = $resultado;
    }
	
	public function insert(){
		$data = $this->setArray;
		$consulta = "	INSERT INTO seccion VALUES(
						NULL, {$data['idReporte']}, '{$data['nomSeccion']}'
						);		
					";
		mysql_query($consulta) or die(mysql_error());
		return mysql_insert_id();
	}
	
	public function update(){
		$data = $this->setArray;
		$consulta = "	UPDATE seccion SET
						id_reporte={$data['idReporte']}, 
						nom_seccion='{$data['nomSeccion']}'
						WHERE id_seccion = {$data['idSeccion']};
					";
		mysql_query($consulta) or die(mysql_error());
		return mysql_affected_rows();
	}
	
	public function delete($idSeccion){
		$consulta = "	DELETE FROM seccion WHERE id_seccion = {$idSeccion};";
		mysql_query($consulta) or die(mysql_error());
		return mysql_affected_rows();
	}
	
	public function get($idSeccion){
		$consulta = "	SELECT id_seccion, id_reporte, nom_seccion
						FROM seccion
						WHERE id_seccion = $idSeccion;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$seccion = array(
				'idSeccion' => mysql_result($resultado, 0, 'id_seccion'),
				'idReporte' => mysql_result($resultado, 0, 'id_reporte'),
				'nomSeccion' => mysql_result($resultado, 0, 'nom_seccion')
			);
		}else{
			$seccion = 0;
		}
		mysql_free_result($resultado);
		$this->setArray = $seccion;
	}
	
	public function getByReportID($idReporte){
		$consulta = "	SELECT id_seccion, id_reporte, nom_seccion
						FROM seccion
						WHERE id_reporte = $idReporte;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$seccion = array();
			while($fila = mysql_fetch_array($resultado)){
				$seccion[] = array(
					'id'=>$fila['id_seccion'],
					'reporte'=>$fila['id_reporte'],
					'seccion'=>$fila['nom_seccion']
				);
			}
		}else{
			$seccion = 0;
		}
		mysql_free_result($resultado);
		return $seccion;
	}
	
	public function getQuestionsByReportID($idReporte){
		$consulta = "	SELECT s.nom_seccion, rp.id_pregunta, 
						CONCAT(p.nom_pregunta, ' (', p.cod_pregunta, ')') AS 'nom_pregunta'
						FROM seccion s
						INNER JOIN reporte_pregunta rp ON rp.id_seccion = s.id_seccion
						INNER JOIN pregunta p ON rp.id_pregunta = p.id_pregunta
						WHERE s.id_reporte= $idReporte ORDER BY id_pregunta ;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$seccion = array();
			while($fila = mysql_fetch_array($resultado)){
				$seccion[$fila['nom_seccion']][] = array(
					'id' => $fila['id_pregunta'],
					'nombre' => $fila['nom_pregunta']
				);
			}
		}else{
			$seccion = 0;
		}
		mysql_free_result($resultado);
		return $seccion;
	}

	public function getQuestionsByReportID2($idReporte){
		$consulta = "	SELECT s.nom_seccion, rp.id_pregunta, 
						CONCAT(p.nom_pregunta, ' (', p.cod_pregunta, ')') AS 'nom_pregunta'
						FROM seccion s
						INNER JOIN reporte_pregunta rp ON rp.id_seccion = s.id_seccion
						INNER JOIN pregunta p ON rp.id_pregunta = p.id_pregunta
						WHERE tipo_pregunta<>'N' and s.id_reporte= $idReporte ORDER BY id_pregunta ;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$seccion = array();
			while($fila = mysql_fetch_array($resultado)){
				$seccion[$fila['nom_seccion']][] = array(
					'id' => $fila['id_pregunta'],
					'nombre' => $fila['nom_pregunta']
				);
			}
		}else{
			$seccion = 0;
		}
		mysql_free_result($resultado);
		return $seccion;
	}        
        
}
?>