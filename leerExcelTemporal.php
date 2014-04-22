<?php
require_once('config.php');
require_once(TEMPLATES.'header.php');
require_once(RESOURCES.'general.php');
require_once(ENTITIES.'campana.php');
require_once(ENTITIES.'pregunta.php');
$general = new general();
?>
<form id="formCampana" name="formCampana" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<script src="<?php echo SCRIPTS;?>campana.js" language="javascript" type="text/javascript"></script>
	<input type="hidden" id="op" name="op" value="1" />
        <label for="archCampana">Subir formato:</label>
        <input type="file" id="archCampana" name="archCampana"  />
        <br /><br />
        <button type="submit">Siguiente</button>
</form>    
<?php
if(isset($_REQUEST['op'])){    
        $excel = $general->leerExcel($_FILES['archCampana']['tmp_name'], 3);
        
        //$general->iA("excel", $excel);
        
        
        
        $hoja = 0;
        foreach ($excel as $key => $value) {
            $fila=0;
            foreach ($value as $key1 => $value1) {
                $columna = 0;
                //echo "<br>valor:".$value;
                
                    foreach ($value1 as $valor) {
                        
                        if($fila>0){
                            
                            if($columna==2 && $fila>=2){
                                $id_usuario_campana = $valor;                        
                            }
                            if($fila==1){                                
                                $arr_id_pregunta[$columna] = $valor;
                            }                   
                            
                            if($fila>1 && $columna>3){
                                
                                if($valor!=''){                                    
                                    
                                    if($hoja==1 && ($arr_id_pregunta[$columna]==24 || 
                                            $arr_id_pregunta[$columna]==29 || $arr_id_pregunta[$columna]==30
                                            )
                                      )
                                    {
                                        $explode = explode("/",$valor);
                                        $valor = $explode[2]."-".$explode[1]."-".$explode[0];
                                    }                                    
                                    
                                    $valor = str_replace("'", "\'", $valor);
                                            
                                    if($arr_id_pregunta[$columna]!=''){
                                        $sql = "insert into respuesta values(null,".$arr_id_pregunta[$columna].",".$id_usuario_campana
                                                .",'".strtoupper($valor)."',0);";

                                        //echo "<br>Hoja: ".$hoja." - Fila: ".$fila." - Columna:".$columna." - Valor:".$valor;
                                        echo "<br>".$sql;
                                    }
                                }
                            }
                            //$general->iA("value1", $valor);                                                
                        }
                        
                        $columna++;
                    }

                $fila++;
                
            }
            unset($arr_id_pregunta);
            $hoja++;
            
        }
        
}
require_once(TEMPLATES.'footer.php');
?>