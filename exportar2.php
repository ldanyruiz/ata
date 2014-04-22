<?php

	require_once('config.php');
	require_once(RESOURCES.'general.php');
	require_once(ENTITIES.'reportes.php');
        require_once(ENTITIES.'seccion.php');
        require_once(ENTITIES.'reporte.php');
        require_once(ENTITIES.'pregunta.php');
        require_once(RESOURCES.'Excel/PHPExcel.php');
        require_once(RESOURCES.'Excel/PHPExcel/IOFactory.php');    
        
	$general = new general();
	$reporte = new reportes();	
        $pregunta = new pregunta();	
        $construido = new reporte();  
        
        // Creamos un objeto PHPExcel
        $excel = new PHPExcel();
        // Leemos un archivo Excel 2007
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');     
        
        //En esta linea cargamos el archivo previamente formateado, la idea es solo 
        //grabar los datos de la consulta, y el formato ya esta pre-establecido
        $f = RESOURCES."formato/reporteFormato6.xlsx";
        $excel = $objReader->load($f);
        // Indicamos que se pare en la hoja uno del libro

        
        //Pesta�a 'RESUMEN'
        $datosResumen = $reporte->getSolved($_REQUEST['idCampana'], false);
        $excel->setActiveSheetIndex(0)
        ->fromArray($datosResumen)
        ->setTitle('RESUMEN');

        //Pesta�a 'DATOS PERSONALES'
        $datosPersonales = $reporte->getPersonalData($_REQUEST['idCampana']);
        $excel->setActiveSheetIndex(1)
        ->fromArray($datosPersonales)
        ->setTitle('DATOS PERSONALES');                
        
        //REcorremos sección por sección ya formateadas en el excel 
        //cargado anteriormente
        $seccion = new seccion();
        $preguntas = $seccion->getQuestionsByReportID2(1);

        //Empieza en dos, porque las dos primeras 0 y 1 son para los datos_resumen y datos_personales
        $inicioColumna = 2;
        $cont = $inicioColumna;
        
        //COlumnas letras del excel
        $letraColumnas = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X");                        
        
        foreach($preguntas as $key=>$value){

                $repor = $reporte->getReportByIDs2($_REQUEST['idCampana'], $value);
                $excel->setActiveSheetIndex($cont);

                $fila = 2;
                $columna = 1;
                $i =0;//Para evitar que se grabe la columna con las cabeceras
                foreach ($repor as $value){


                    foreach ($value as $value1){                                        

                        if($i>0){//Para evitar que se grabe la columna con las cabeceras

                            //solo para la columna de experiencia y fechas
                            //aumentamos la columna para que deje en blanco la formula
                            //en el excel ya formateado
                            if(($cont==($inicioColumna+1)) && ($columna==7 || $columna==13 )){
                                    $columna++;    
                            }
                            
                            $celda = $letraColumnas[$columna-1].$fila;                            
                            
                            //solo para la columna de experiencia y fechas
                            //damos formato a la fecha
                            if(($cont==($inicioColumna+1)) && ($columna==6 || $columna==11 || $columna==12)){
                                if($value1!=''){
                                    $explode = explode("-",$value1);
                                    $value1 = $explode[2]."/".$explode[1]."/".$explode[0];
                                    $excel->getActiveSheet()->getStyle($celda)->getNumberFormat()
                                           ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);                                                
                                }
                            }                                            

                            $excel->getActiveSheet()->SetCellValue($celda, $value1);                                        

                            $columna++;
                        }

                    }                                    

                    $i++;
                    $fila ++;
                    $columna = 1;
                }


                $cont++;
        }			

        // Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
        $excel->setActiveSheetIndex(0);        


header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="reporteFormateado.xlsx"');
header('Cache-Control: max-age=0');
$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
$writer->save('php://output');
?>
