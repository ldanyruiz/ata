<?php
if(isset($_REQUEST['op'])){
	require_once('config.php');
	require_once(RESOURCES.'general.php');
	require_once(ENTITIES.'reportes.php');
	$general = new general();
	$reporte = new reportes();
	
	$type ="";
	$ext = "";
	
	$border = "";
	
	switch($_REQUEST['type']){
		case 'excel':
			$type = "vnd.ms-excel";
			$ext = "xls";
			$border = '<style type="text/css">';
		break;
		case 'word':
			$type = "msword";
			$ext = "doc";
		break;
	}
	
	function pdf($datos, $titulo='Sistema EDO - Reporte'){
		$config = new config();
		require_once($config->RESOURCES.'html2pdf/html2pdf.class.php');	
		require_once($config->RESOURCES.'generalReporte.php');
		$generalReporte = new generalReporte();
		
		$html = '';
		//$html .= '<link rel="stylesheet" type="text/css" href="'.$config->CSS.'main.css" />';
		$html .= '<page backtop="40mm" backbottom="20mm" backleft="10mm" backright="10mm">';
		$html .= '<page_header>';	
		$html .= '<h1><img src="'.$config->images.'favicon.png" width="48" />'.$titulo.'</h1><hr>';
		$html .= '<table id="export">';
		$html .= '<tr>';
		$html .= '<td>Fecha:</td><td>'.date("d/m/Y").'</td>';	
		$html .= '</tr><tr>';
		$html .= '<td>Hora:</td><td>'.date("h:i:s A").'</td>';	
		$html .= '</tr><tr>';
		$html .= '<td>P&aacute;ginas:</td><td>[[page_cu]]/[[page_nb]]</td>';	
		$html .= '</tr></table>';
		$html .= '<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />';			
		$html .= '</page_header>';
		$html .= '<page_footer><p id="centrar">P&aacute;gina [[page_cu]] de [[page_nb]]';
		$html .= '<br />Todos los derechos reservados &copy; DHO CONSULTORES S.A.C.</p></page_footer>';
		$html .= $datos;
		$html .= '</page>';
		
		
		$html2pdf = new HTML2PDF('P','A4','es');
		$html2pdf->pdf->SetAuthor('DHO Consultores');
		$html2pdf->pdf->SetTitle($titulo);
		$html2pdf->pdf->SetSubject('Reporte');
		$html2pdf->pdf->SetKeywords('Reporte, EDO, DHO');
		$html2pdf->WriteHTML($html);
		$html2pdf->Output('reporte.pdf', 'D');
	}
	
	if($_REQUEST['type']<>'pdf'){
		header("Content-Type: application/".$type);
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");		
		header("Content-Disposition: attachment; filename=reporte.".$ext);
		header("Pragma: no-cache");
			
		$fp = fopen(CSS.'main.css',"r");
		$css = fread($fp, 900000);
		fclose($fp);
		
		$fp = fopen(CSS.'grilla.css',"r");
		$css .= fread($fp, 900000);
		fclose($fp);
		
		echo '<html><head>';
		echo $border;
		echo substr($css, 105);
		echo 'td{border: #000 thin solid;mso-style-parent:style0;
                         mso-number-format:"\@";}';
		echo 'body{background-color: #fff;}';
		echo '</style>';
		echo '</head><body>';
	}
	
	switch($_REQUEST['op']){
		case 'seg':
			require_once(RESOURCES.'Excel/PHPExcel.php');
			$excel = new PHPExcel();
			$objReader = PHPExcel_IOFactory::createReader('Excel2007');     
                        
			$excel->getProperties()
			->setCreator("DHO Consultores")
			->setLastModifiedBy("DHO Consultores")
			->setTitle("Matriz de Resultados - Ficha ATA")
			->setSubject("Matriz de Resultados")
			->setDescription("Matriz que contiene las respuestas al cuestionario de la Ficha ATA, de acuerdo a cada empresa.")
			->setKeywords("Ficha ATA Excel DHO Consultores")
			->setCategory("Ficha ATA");
			
			require_once(ENTITIES.'reportes.php');
			$reporte = new reportes();
			
                        $f = RESOURCES."formato/reporteFormato1.xlsx";
                        $excel = $objReader->load($f);                        
                        
//			//Pesta�a 'REPORTE DE SEGUIMIENTO COMPLETO'
//			$datosCompleto = $reporte->getSolved($_REQUEST['idCampana'], false);
//			$excel->setActiveSheetIndex(0)
//			->fromArray($datosCompleto)
//			->setTitle('REPORTE DE SEGUIMIENTO COMPLETO');
			
			//Pesta�a 'RESUMEN'
			$resumen = $reporte->getTracing($_REQUEST['idCampana'], false);
//			$excel->createSheet(1);
			$excel->setActiveSheetIndex(0);
//			->fromArray($resumen)
//			->setTitle('RESUMEN');
                        
                       // $general->iA("resumen", $resumen);
                        $letraColumnas = array("A","B","C","D","E","F","G","H","I","J","K");                        
                        $fila = 5;                
                        
                        //$excel->getActiveSheet()->mergeCells("B2:D2");
                        //$excel->getActiveSheet()->SetCellValue("B2:D2","STATUS FICHA - AL ".date("d-m-Y"));                                        
                        $i=0;
                        foreach($resumen as $key=>$value){                            
                            if($i>0){
                                $columna = 2;    
                                foreach($value as $value1){                                
                                    $celda = $letraColumnas[$columna-1].$fila;                                
                                    //echo "<br>celda: ".$celda." - Valor:".$value1;
                                    $excel->getActiveSheet()->SetCellValue($celda, $value1);   
                                    if($columna==5){
                                        
                                                $color = 'FFFFFF';
                                                if($value1=='Completado'){$color = 'B0E0E6';}
                                                if($value1=='En proceso'){$color = 'FFFF00';}
                                                if($value1=='Pendiente'){$color = 'FF0000';}                                                
                                                
                                                $excel->getActiveSheet()->getStyle($celda)->getFill()
                                                ->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                'startcolor' => array('rgb' => $color)
                                                ));
                                    }
                                    $columna++;
                                }
                                $fila++;
                            }
                            $i++;
                        }
                        
			$excel->setActiveSheetIndex(0);
			
			// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="reporte.xlsx"');
			header('Cache-Control: max-age=0');
			$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$writer->save('php://output');
			exit;
			break;
		case 'matres1':
			require_once(RESOURCES.'Excel/PHPExcel.php');
			$excel = new PHPExcel();
			
			$excel->getProperties()
			->setCreator("DHO Consultores")
			->setLastModifiedBy("DHO Consultores")
			->setTitle("Matriz de Resultados - Ficha ATA")
			->setSubject("Matriz de Resultados")
			->setDescription("Matriz que contiene las respuestas al cuestionario de la Ficha ATA, de acuerdo a cada empresa.")
			->setKeywords("Ficha ATA Excel DHO Consultores")
			->setCategory("Ficha ATA");
			
			require_once(ENTITIES.'reportes.php');
			$reporte = new reportes();
			
			//Pesta�a 'RESUMEN'
			$datosResumen = $reporte->getSolved($_REQUEST['idCampana'], false);
			$excel->setActiveSheetIndex(0)
			->fromArray($datosResumen)
			->setTitle('RESUMEN');
			
			
			//Pesta�a 'DATOS PERSONALES'
			$datosPersonales = $reporte->getPersonalData($_REQUEST['idCampana']);
			$excel->createSheet(1);
			$excel->setActiveSheetIndex(1)
			->fromArray($datosPersonales)
			->setTitle('DATOS PERSONALES');
			
			//Pesta�a 'FORMACI�N ACAD�MICA'
			$codGrupoPregunta='FORACAD';
			unset($codsPregunta);
			$codsPregunta = '';
			$formacionAcademica = $reporte->getReportByCods($_REQUEST['idCampana'], $codGrupoPregunta, $codsPregunta);
			$excel->createSheet(2);
			$excel->setActiveSheetIndex(2)
			->fromArray($formacionAcademica)
			->setTitle('FORMACION ACADEMICA');		
			
			//Pesta�a 'DATOS DEL PUESTO ACTUAL'
			$codGrupoPregunta='DATPUEACT';
			unset($codsPregunta);
			$codsPregunta = '';
			$datosPuestoActual = $reporte->getReportByCods($_REQUEST['idCampana'], $codGrupoPregunta, $codsPregunta);
			$excel->createSheet(3);
			$excel->setActiveSheetIndex(3)
			->fromArray($datosPuestoActual)
			->setTitle('DATOS DEL PUESTO ACTUAL');			
			
			//Pesta�a 'DATOS JER�RQUICOS'
			$codGrupoPregunta='DATJER';
			unset($codsPregunta);
			$codsPregunta = '';
			$datosJerarquicos = $reporte->getReportByCods($_REQUEST['idCampana'], $codGrupoPregunta, $codsPregunta);
			$excel->createSheet(4);
			$excel->setActiveSheetIndex(4)
			->fromArray($datosJerarquicos)
			->setTitle('DATOS JERARQUICOS');		
			
			//Pesta�a 'FUNCIONES DEL PUESTO ACTUAL'
			$codGrupoPregunta='FUNPUEACT';
			unset($codsPregunta);
			$codsPregunta = '';
			$funcionesPuestoActual = $reporte->getReportByCods($_REQUEST['idCampana'], $codGrupoPregunta, $codsPregunta);
			$excel->createSheet(5);
			$excel->setActiveSheetIndex(5)
			->fromArray($funcionesPuestoActual)
			->setTitle('FUNCIONES DEL PUESTO ACTUAL');		
			
			//Pesta�a 'DATOS DE PUESTOS�NTERIORES EN LA EMPRESA'
			$codGrupoPregunta='DATPUESANT';
			unset($codsPregunta);
			$codsPregunta = '';
			$puestosAnteriores = $reporte->getReportByCods($_REQUEST['idCampana'], $codGrupoPregunta, $codsPregunta);
			$excel->createSheet(6);
			$excel->setActiveSheetIndex(6)
			->fromArray($puestosAnteriores)
			->setTitle('DATOS DE PUESTOS ANTERIORES');		
			
			//Pesta�a 'EXPERIENCIA LABORAL PREVIA A LA EMPRESA'
			$codGrupoPregunta='EXPLAB';
			unset($codsPregunta);
			$codsPregunta = '';
			$experienciaLaboral = $reporte->getReportByCods($_REQUEST['idCampana'], $codGrupoPregunta, $codsPregunta);
			$excel->createSheet(7);
			$excel->setActiveSheetIndex(7)
			->fromArray($experienciaLaboral)
			->setTitle('EXPERIENCIA LABORAL');		
			
			//Pesta�a 'CULTURA'
			$codGrupoPregunta='CULT';
			unset($codsPregunta);
			$codsPregunta = '';
			$cultura = $reporte->getReportByCods($_REQUEST['idCampana'], $codGrupoPregunta, $codsPregunta);
			$excel->createSheet(8);
			$excel->setActiveSheetIndex(8)
			->fromArray($cultura)
			->setTitle('CULTURA');		
			
			//Pesta�a 'CAPACITACIONES'
			$codGrupoPregunta='CAP';
			unset($codsPregunta);
			$codsPregunta = '';
			$capacitaciones = $reporte->getReportByCods($_REQUEST['idCampana'], $codGrupoPregunta, $codsPregunta);
			$excel->createSheet(9);
			$excel->setActiveSheetIndex(9)
			->fromArray($capacitaciones)
			->setTitle('CAPACITACIONES');		
			
			//Pesta�a 'CLIMA'
			$codGrupoPregunta='CLIM';
			unset($codsPregunta);
			$codsPregunta = '';
			$clima = $reporte->getReportByCods($_REQUEST['idCampana'], $codGrupoPregunta, $codsPregunta);
			$excel->createSheet(10);
			$excel->setActiveSheetIndex(10)
			->fromArray($clima)
			->setTitle('CLIMA');		
			
			//Pesta�a 'SISTEMAS INFORM�TICOS'
			$codGrupoPregunta='SISTINF';
			unset($codsPregunta);
			$codsPregunta = '';
			$sistemasInformaticos = $reporte->getReportByCods($_REQUEST['idCampana'], $codGrupoPregunta, $codsPregunta);
			$excel->createSheet(11);
			$excel->setActiveSheetIndex(11)
			->fromArray($sistemasInformaticos)
			->setTitle('SISTEMAS INFORMATICOS');		
			
			//Pesta�a 'INFORMACI�N ADICIONAL'
			$codGrupoPregunta='INFADI';
			unset($codsPregunta);
			$codsPregunta = '';
			$informacionAdicional = $reporte->getReportByCods($_REQUEST['idCampana'], $codGrupoPregunta, $codsPregunta);
			$excel->createSheet(12);
			$excel->setActiveSheetIndex(12)
			->fromArray($informacionAdicional)
			->setTitle('INFORMACION ADICIONAL');		
			/*
			$excel->createSheet(1);
			$excel->setActiveSheetIndex(1)
			->setCellValue('A1', 'Valor 12')
			->setCellValue('B1', 'Valor 22')
			->setCellValue('C1', 'Total2')
			->setCellValue('A2', '102')
			->setCellValue('C2', '=sum(A2:B2)');
			$excel->getActiveSheet()->setTitle('Tecnologia Simple 2');*/
			
			// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
			$excel->setActiveSheetIndex(0);
			
			// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
                        
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="reporte.xlsx"');
			header('Cache-Control: max-age=0');
			$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$writer->save('php://output');
			exit;
			break;
		case 'matres2':
			require_once(RESOURCES.'Excel/PHPExcel.php');
			$excel = new PHPExcel();
			
			$excel->getProperties()
			->setCreator("DHO Consultores")
			->setLastModifiedBy("DHO Consultores")
			->setTitle("Matriz de Resultados - Ficha ATA")
			->setSubject("Matriz de Resultados")
			->setDescription("Matriz que contiene las respuestas al cuestionario de la Ficha ATA, de acuerdo a cada empresa.")
			->setKeywords("Ficha ATA Excel DHO Consultores")
			->setCategory("Ficha ATA");
			
			require_once(ENTITIES.'reportes.php');
			$reporte = new reportes();
			
			//Pesta�a 'RESUMEN'
			$datosResumen = $reporte->getSolved($_REQUEST['idCampana'], false);
			$excel->setActiveSheetIndex(0)
			->fromArray($datosResumen)
			->setTitle('RESUMEN');
			
			
			//Pesta�a 'DATOS PERSONALES'
			$datosPersonales = $reporte->getPersonalData($_REQUEST['idCampana']);
			$excel->createSheet(1);
			$excel->setActiveSheetIndex(1)
			->fromArray($datosPersonales)
			->setTitle('DATOS PERSONALES');
			
			//Pesta�a 'FODA'
			$codGrupoPregunta='';
			unset($codsPregunta);
			$codsPregunta[] = "CULT0009";
			$codsPregunta[] = "CULT0010";
			$codsPregunta[] = "CULT0011";
			$codsPregunta[] = "CULT0012";
			$foda = $reporte->getReportByCods($_REQUEST['idCampana'], $codGrupoPregunta, $codsPregunta);
			$excel->createSheet(2);
			$excel->setActiveSheetIndex(2)
			->fromArray($foda)
			->setTitle('FODA');
			
			//Pesta�a 'ORGANIGRAMA'
			$codGrupoPregunta='';
			unset($codsPregunta);
			$codsPregunta[] = "DATPUEACT0004";
			$codsPregunta[] = "DATJER0007";
			$codsPregunta[] = "DATJER0008";
			$codsPregunta[] = "DATJER0009";
			$codsPregunta[] = "DATJER0010";
			$codsPregunta[] = "DATJER0012";
			$codsPregunta[] = "DATJER0013";
			$codsPregunta[] = "DATJER0014";
			$organigrama = $reporte->getReportByCods($_REQUEST['idCampana'], $codGrupoPregunta, $codsPregunta);
			$excel->createSheet(3);
			$excel->setActiveSheetIndex(3)
			->fromArray($organigrama)
			->setTitle('ORGANIGRAMA');
			
			//Pesta�a 'MAPA DE RELACIONES'
			$codGrupoPregunta='';
			unset($codsPregunta);
			$codsPregunta[] = "FUNPUEACT0006";
			$codsPregunta[] = "FUNPUEACT00011";
			$codsPregunta[] = "FUNPUEACT00012";
			$relaciones = $reporte->getReportByCods($_REQUEST['idCampana'], $codGrupoPregunta, $codsPregunta);
			$excel->createSheet(4);
			$excel->setActiveSheetIndex(4)
			->fromArray($relaciones)
			->setTitle('MAPA DE RELACIONES');
			
			//Pesta�a 'MAPA DE PROCESOS'
			$codGrupoPregunta='';
			unset($codsPregunta);
			$codsPregunta[] = "DATPUEACT0008";
			$codsPregunta[] = "FUNPUEACT0001";
			$codsPregunta[] = "FUNPUEACT0003";
			$procesos = $reporte->getReportByCods($_REQUEST['idCampana'], $codGrupoPregunta, $codsPregunta);
			$excel->createSheet(5);
			$excel->setActiveSheetIndex(5)
			->fromArray($procesos)
			->setTitle('MAPA DE PROCESOS');
			
			//Pesta�a 'BRECHAS DE PLAN DE ACCION'
			$codGrupoPregunta='';
			unset($codsPregunta);
			$codsPregunta[] = "FUNPUEACT0016";
			$codsPregunta[] = "FUNPUEACT0017";
			$codsPregunta[] = "SISTINF0002";
			$codsPregunta[] = "SISTINF0005";
			$accion = $reporte->getReportByCods($_REQUEST['idCampana'], $codGrupoPregunta, $codsPregunta);
			$excel->createSheet(6);
			$excel->setActiveSheetIndex(6)
			->fromArray($accion)
			->setTitle('BRECHAS PLAN ACCION');
			
			//Pesta�a 'REDUNDANTES'
			$codGrupoPregunta='';
			unset($codsPregunta);
			$codsPregunta[] = "DATPUEACT0008";
			$codsPregunta[] = "FUNPUEACT0003";
			$codsPregunta[] = "FUNPUEACT0004";
			$codsPregunta[] = "FUNPUEACT0005";
			$codsPregunta[] = "FUNPUEACT0006";
			$redundantes = $reporte->getReportByCods($_REQUEST['idCampana'], $codGrupoPregunta, $codsPregunta);
			$excel->createSheet(7);
			$excel->setActiveSheetIndex(7)
			->fromArray($redundantes)
			->setTitle('REDUNDANTES');
			
			//Pesta�a 'LAYOUT'
			$codGrupoPregunta='';
			unset($codsPregunta);
			$codsPregunta[] = "FUNPUEACT0011";
			$codsPregunta[] = "FUNPUEACT0012";
			$codsPregunta[] = "FUNPUEACT0013";
			$codsPregunta[] = "FUNPUEACT0014";
			$codsPregunta[] = "FUNPUEACT0015";
			$layout = $reporte->getReportByCods($_REQUEST['idCampana'], $codGrupoPregunta, $codsPregunta);
			$excel->createSheet(8);
			$excel->setActiveSheetIndex(8)
			->fromArray($layout)
			->setTitle('LAYOUT');
			
			//Pesta�a 'MOF'
			$codGrupoPregunta='';
			unset($codsPregunta);
			$codsPregunta[] = "DATPUEACT0004";
			$codsPregunta[] = "DATPUEACT0008";
			$codsPregunta[] = "DATJER0002";
			$codsPregunta[] = "DATJER0003";
			$codsPregunta[] = "DATJER0004";
			$codsPregunta[] = "DATJER0005";
			$codsPregunta[] = "DATJER0006";
			$codsPregunta[] = "DATJER0007";
			$codsPregunta[] = "DATJER0008";
			$codsPregunta[] = "DATJER0009";
			$codsPregunta[] = "DATJER0010";
			$codsPregunta[] = "DATJER0011";
			$codsPregunta[] = "DATJER0012";
			$codsPregunta[] = "DATJER0013";
			$codsPregunta[] = "FUNPUEACT0001";
			$codsPregunta[] = "FUNPUEACT0003";
			$codsPregunta[] = "FUNPUEACT0004";
			$codsPregunta[] = "FUNPUEACT0005";
			$codsPregunta[] = "FUNPUEACT0006";
			$codsPregunta[] = "FUNPUEACT0016";
			$codsPregunta[] = "FUNPUEACT0020";
			$codsPregunta[] = "FUNPUEACT0021";
			$mof = $reporte->getReportByCods($_REQUEST['idCampana'], $codGrupoPregunta, $codsPregunta);
			$excel->createSheet(9);
			$excel->setActiveSheetIndex(9)
			->fromArray($mof)
			->setTitle('MOF');
			
			// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
			$excel->setActiveSheetIndex(0);
			
			// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="reporte.xlsx"');
			header('Cache-Control: max-age=0');
			$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$writer->save('php://output');
			exit;
			break;
		case 'matresgen':
			require_once(RESOURCES.'Excel/PHPExcel.php');
			$excel = new PHPExcel();
			
			$excel->getProperties()
			->setCreator("DHO Consultores")
			->setLastModifiedBy("DHO Consultores")
			->setTitle("Matriz de Resultados - Ficha ATA")
			->setSubject("Matriz de Resultados")
			->setDescription("Matriz que contiene las respuestas al cuestionario de la Ficha ATA, de acuerdo a cada empresa.")
			->setKeywords("Ficha ATA Excel DHO Consultores")
			->setCategory("Ficha ATA");
			
			require_once(ENTITIES.'reportes.php');
			require_once(ENTITIES.'reporte.php');
			$reporte = new reportes();
			$construido = new reporte();
			
//			//Pesta�a 'RESUMEN'
//			$datosResumen = $reporte->getSolved($_REQUEST['idCampana'], false);
//			$excel->setActiveSheetIndex(0)
//			->fromArray($datosResumen)
//			->setTitle('RESUMEN');
//			
//			
//			//Pesta�a 'DATOS PERSONALES'
//			$datosPersonales = $reporte->getPersonalData($_REQUEST['idCampana']);
//			$excel->createSheet(1);
//			$excel->setActiveSheetIndex(1)
//			->fromArray($datosPersonales)
//			->setTitle('DATOS PERSONALES');
			
			//Pesta�as por reporte construido
			require_once(ENTITIES.'seccion.php');
			$seccion = new seccion();
			$preguntas = $seccion->getQuestionsByReportID($_REQUEST['idReporte']);
			
//			$porReemplazar = array(
//				'inicial'=>array(
//					0=>'�',
//					1=>'�',
//					2=>'�',
//					3=>'�',
//					4=>'�',
//					5=>'�',
//					6=>'�',
//					7=>'�',
//					8=>'�',
//					9=>'�',
//					10=>'�',
//					11=>'�',
//					12=>' '
//				),
//				'final'=>array(
//					0=>'A',
//					1=>'E',
//					2=>'I',
//					3=>'O',
//					4=>'U',
//					5=>'N',
//					6=>'a',
//					7=>'e',
//					8=>'i',
//					9=>'o',
//					10=>'u',
//					11=>'n',
//					12=>'_'
//				)
//			);
                        
                        $letraColumnas = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X");                        
                        $cont = 0;
                        $columnaInicial = 1;
                        $filaInicial = 1;
                        
                        //$general->iA("preguntas", $preguntas);
                        foreach($preguntas as $key=>$value){

                                $repor = $reporte->getReportByIDs($_REQUEST['idCampana'], $value);
                                
                                //$general->iA("repor", $repor);
                                $excel->setActiveSheetIndex($cont);

                                $fila = $filaInicial;
                                $columna = $columnaInicial;
                                //$i =0;//Para evitar que se grabe la columna con las cabeceras
                                foreach ($repor as $value){

                                    foreach ($value as $value1){                                        

                                            $celda = $letraColumnas[$columna-1].$fila;                                            
                                            
                                            if($general->validateDate($value1, 'Y-m-d')){
                                                $explode = explode("-",$value1);
                                                $value1 = $explode[2]."/".$explode[1]."/".$explode[0];

                                                 $excel->getActiveSheet()->getStyle($celda)->getNumberFormat()
                                                       ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);                                                
                                            }elseif (is_numeric($value1)) {
                                                 $excel->getActiveSheet()->getStyle($celda)->getNumberFormat()
                                                       ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);                                                                            
                                            }
                                            
                                            $excel->getActiveSheet()->SetCellValue($celda, $value1); 
                                            //echo "<br>celda:".$celda." Es Fecha ".$esFecha." Valor:".$value1;

                                            $columna++;
                                    }                                    

                                    //$i++;
                                    $fila ++;
                                    $columna = $columnaInicial;
                                }


                                $cont++;
                        }			

			
//			$cont = 1;
//			foreach($preguntas as $key=>$value){
//				$sec = utf8_decode($key);
//				for($i=0; $i<count($porReemplazar['inicial']); $i++){
//					$sec = str_replace($porReemplazar['inicial'][$i], $porReemplazar['final'][$i], $sec);
//				}
//				//$sec = strtoupper($key);
//				$cont++;
//			
//                                print_r($reporte->getReportByIDs($_REQUEST['idCampana'], $value));
//                                die();
//				$excel->createSheet($cont);
//				$excel->setActiveSheetIndex($cont)                                 
//				->fromArray($reporte->getReportByIDs($_REQUEST['idCampana'], $value))
//				->setTitle($sec);	
//			}			
			
			// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
			$excel->setActiveSheetIndex(0);
			
			// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="reporte.xlsx"');
			header('Cache-Control: max-age=0');
			$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$writer->save('php://output');
			exit;
			break;
		case 'usu':
?>

<table id="campana">
    	<thead>
        	<tr>
                <td>NOMBRES</td>
                <td>APELLIDO PATERNO</td>
                <td>APELLIDO MATERNO</td>
                <td>USUARIO</td>
                <td>CONTRASE&Ntilde;A</td>
                <td>CORREO ELECTR&Oacute;NICO</td>
            </tr>
        </thead>
        <tbody>
<?php
			for($i=0; $i<count($_REQUEST['nombres']); $i++){
?>
			<tr>
            	<td><?php echo $_REQUEST['nombres'][$i];?></td>
            	<td><?php echo $_REQUEST['paterno'][$i];?></td>
            	<td><?php echo $_REQUEST['materno'][$i];?></td>
            	<!--<td>&nbsp;<?php //echo $_REQUEST['login'][$i];?></td>-->
            	<td class="xlsString"><?php echo $_REQUEST['login'][$i];?></td>
            	<td><?php echo $_REQUEST['clave'][$i];?></td>
            	<td><?php echo $_REQUEST['email'][$i];?></td>
            </tr>
<?php
			}
?>
        </tbody>
    </table>
<?php
			break;
		case 'ind':		
			if(isset($_REQUEST['id'])){
				require_once(ENTITIES.'usuarioCampana.php');
				require_once(ENTITIES.'preguntaGrupo.php');
				require_once(ENTITIES.'pregunta.php');
				require_once(ENTITIES.'respuesta.php');
				$usuarioCampana = new usuarioCampana();
				$preguntaGrupo = new preguntaGrupo();
				$pregunta = new pregunta();
				$respuesta = new respuesta();
				$idCampana = $usuarioCampana->getCampaignID($_REQUEST['id']);
						
				$datosPersonales = $reporte->getIndividualInfo($_REQUEST['id']);
?>

<table id="individual">
	<tr id="titulo">
    	<td colspan="2">FICHA DE AN&Aacute;LISIS DE INSPECTORES SUNAFIL</td>
    </tr>
	<tr>
    	<td colspan="2" id="nada"><br /></td>
    </tr>
	<tr id="seccion">
    	<td colspan="2">DATOS PERSONALES</td>
    </tr>
<?php
    $contPregunta = 0;
    foreach($datosPersonales[1] as $key=>$value){
?>
    <tr>
    	<td id="pregunta1"><?php echo $key;?></td>
    	<td id="respuesta" style="text-align: left"><?php echo $value;?></td>
    </tr>
<?php
    }
				
			$cuestionario = $reporte->getGroupsAndQuestions($idCampana);
                        
                        $left = '; mso-element-left:left';
			foreach($cuestionario as $key=>$value){
                            
?>
    <tr>
    	<td colspan="2" id="nada"><br /></td>
    </tr>
    <tr id="seccion">
    	<td colspan="2"><?php echo $key;?></td>
    </tr>
<?php
				foreach($value as $key2=>$value2){
                                            
					foreach($value2 as $key3=>$value3){                                                                                        
                                            
                                           echo '<tr>'; 
                                           echo '<td colspan="2" style="background-color:#FF9900 '.$left.'" >'.$key3.'</td>';
                                           echo '</tr>';                                            
                                            
                                            $dependientes = $pregunta->getByDepen($value3['id'], $idCampana);                                            

                                            if(is_array($dependientes)){//Si hay preguntas dependientes
                                                
                                                //obtenemos por si la misma pregunta tiene respuesta
                                                //para el caso de opciones si o no, etc
                                                $respuestas = $reporte->getAnswersToReports($value3['id'], $_REQUEST['id']);
                                                
                                                if($respuestas){
                                                    if(is_array($respuestas)){
                                                        foreach($respuestas as $unvalor){ 
                                                            echo '<tr>';                                                            
                                                            echo '<td style="background-color:#FFFFFF '.$left.'">'.$unvalor[0].'</td>';
                                                            echo '<td>&nbsp;</td>';
                                                            echo '</tr>';   
                                                        }
                                                     }                                                    
                                                }
                                                
                                                //Obtenemos todas las respuestas de las preguntas dependientes
                                                $idsPreguntas = "0";
                                                unset($nombreDependiente);
                                                foreach($dependientes as $value5){ 
                                                    $idsPreguntas .= ",".$value5['id']; 
                                                    $nombreDependiente[] = $value5['nombre'];
                                                }                                                           
                                                    $respuestas = $reporte->getAnswersToReports($idsPreguntas, $_REQUEST['id']);
                                            
                                                    if(is_array($respuestas)){
                                                        foreach($respuestas as $respuestasMultiples){ 

                                                                $i = 0;
                                                                foreach($respuestasMultiples as $value11){ 

                                                                    echo '<tr>';
                                                                    echo '<td style="background-color:#FFCC66'.$left.'">'.$nombreDependiente[$i].'</td>';
                                                                    echo '<td>'.utf8_decode($value11).'</td>';
                                                                    echo '</tr>';
                                                                    $i++;
                                                                }



                                                        }
                                                    }
                                                
                                                
                                            }else{//si no hay dependientes
                                                
                                                    $respuestas = $reporte->getAnswersToReports($value3['id'], $_REQUEST['id']);
                                                
                                                    if(is_array($respuestas)){
                                                        foreach($respuestas as $k1=>$val1){                                                                      
                                                            foreach($val1 as $val2){     
                                                                        echo '<tr>';                                                                        
                                                                        echo '<td colspan="2" style="background-color:#FFFFFF'.$left.'">'.utf8_decode($val2).'</td>';
                                                                        echo '</tr>';                                                            

                                                            }
                                                        }                                                
                                                    }
                                                
                                            }//fin de si no hay dependientes

        				}
//                                        
                                }//foreach($value as $key2=>$value2){
                                
                        }//fin de foreach($cuestionario as $key=>$value){
?>                                        

</table>
<?php
			}
			break;
	}
	
	if($_REQUEST['type']<>'pdf'){
		echo '</body></html>';	
	}
	
}
?>