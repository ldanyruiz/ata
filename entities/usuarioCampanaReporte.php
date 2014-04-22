<?php
class usuarioCampanaReporte{

    var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idCampana'=>$data['idCampana'],
                'idUsuario'=>$data['idUsuario']
        );
        $this->setArray = $resultado;
    }
    
    function insert() {
		$data = $this->setArray;
		$consulta = "	INSERT INTO usuario_campana_reporte VALUES(
						NULL, {$data['idUsuario']}, {$data['idCampana']}
						); ";
		mysql_query($consulta) or die(mysql_error());
		return mysql_insert_id();
    }
		
    function delete($id) {
		$consulta = "delete from usuario_campana_reporte where id_usuario = ".$id;
		mysql_query($consulta) or die(mysql_error());		
		return mysql_affected_rows();;
    }		
    
    public function getIdUsuarioCampana(){
            $data = $this->setArray;
            $consulta = " SELECT id_usuario_campana from usuario_campana_reporte "
                        . "where id_usuario= {$data['idUsuario']} and"
                        . " id_campana = {$data['idCampana']} ";    
            $resultado = mysql_query($consulta) or die(mysql_error());
            if(mysql_num_rows($resultado)>0){
                return 1;
            }
            mysql_free_result($resultado);
            return 0;
    }    

}
?>