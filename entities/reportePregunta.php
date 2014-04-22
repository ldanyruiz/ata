<?php
class reportePregunta{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idReportePregunta'=>$data['idReportePregunta'],
                'idSeccion'=>$data['idSeccion'],
                'idPregunta'=>$data['idPregunta']
        );
        $this->setArray = $resultado;
    }
	
	public function insert(){
		$data = $this->setArray;
		$consulta = "	INSERT INTO reporte_pregunta VALUES(
						NULL, {$data['idSeccion']}, '{$data['idPregunta']}'
						);		
					";
		mysql_query($consulta) or die(mysql_error());
		return mysql_insert_id();
	}
	
	public function deleteByIDSection($idSeccion){
		$consulta = "	DELETE FROM reporte_pregunta WHERE id_seccion = {$idSeccion};";
		mysql_query($consulta) or die(mysql_error());
		return mysql_affected_rows();
	}
	
	public function getBySectionID($idSeccion){
		$consulta = "	SELECT id_reporte_pregunta, id_seccion, id_pregunta
						FROM reporte_pregunta
						WHERE id_seccion = $idSeccion;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$seccion = array();
			while($fila = mysql_fetch_array($resultado)){
				$reportePregunta[$fila['id_pregunta']] = 1;
			}
		}else{
			$reportePregunta = array();
		}
		mysql_free_result($resultado);
		return $reportePregunta;
	}
}
?>