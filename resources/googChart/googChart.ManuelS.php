<?php
class googChartv2{
	public function graficar($datos, $tipo, $num='', $sizeW=0, $sizeH=600){
	
		//Inicializando variables para dimensionamiento automático.
		$totalCarac = 0;
		$totalPala = 0;
		$totalElem = 0;
		
		//Generando el tipo de gráfico
		$nomTipo = "";
		switch($tipo){
			case 'column':
				$nomTipo = "ColumnChart";
				break;
			case 'pie':
				$nomTipo = "PieChart";
				break;
			case 'bar':
				$nomTipo = "BarChart";
				break;
		}
		
		//Reordenando los datos.
		$data = $datos['datos'];
		$rows = "data.addRows([";
		foreach($data as $dato=>$values){
			$columns = "data.addColumn('string', 'General');";
			$rows .= "['$dato'";
			foreach($values as $key => $value){
				$tipo = "string";
				if(is_numeric($value)){
					$tipo = "number";
				}		
				$columns .= "data.addColumn('$tipo', '$key');";
				$rows .= ','.$value;
				
				$totalElem++;
			}
			$rows .= "],";
						
			$totalCarac += strlen($dato);
			$totalPala++;
		}
		$rows = substr($rows, 0, strlen($rows)-1);
		$rows .= "]);";

		$datosG = $columns . $rows;
		
		$promCarac = round($totalCarac / $totalPala);
		
		//Haremos arreglo para el dimensionamiento de la fuente de la zona horizontal.
		
		if($promCarac<10){
			$fSize = 15;
		}else if($promCarac<15){
			$fSize = 13;
		}else if($promCarac<20){
			$fSize = 11;
		}else{
			$fSize = 9;
		}
		
		//Ahora el arreglo para el dimensionamiento del gráfico de acuerdo a la cantidad de elementos.
		if($sizeW==0){
			$width = (($totalElem*40)+300)."px";
		}else{
			$width = $sizeW."px";
		}
		$height = $sizeH."px";
						
		$titulo = "";
		$colores = "";
		
		if(isset($datos['color'])){
			$clr = $datos['color'];
			for($i=0; $i<count($clr); $i++){
				$colores .= "'".$clr[$i]."',";
			}
			$colores = substr($colores, 0, strlen($colores));
		}
		
		if(isset($datos['titulo'])){
			$titulo = $datos['titulo'];
		}
		$opciones = "
			  title: '$titulo',
			  colors:[$colores],
			  hAxis: {title: 'Segmentacion', titleTextStyle: {color: 'black'}, textStyle: {fontSize:$fSize}},
			  vAxis: {title: 'Resultado (%)', titleTextStyle: {color: 'black'}},
			  axisTitlesPosition:['out'],
			  //chartArea:{left: '10%',top: 10,width: '110%',height:'75%'},
			  chartArea:{left: '5%'},
			  fontSize:[15],
			  tooltip: {textStyle: {color: 'black'}, showColorCode: false}
			  ";
			  
		$grafico = '';
		$grafico .= '<script type="text/javascript" src="https://www.google.com/jsapi"></script>';
		$grafico .= '<script type="text/javascript">';
		$grafico .= 'google.load("visualization", "1", {packages:["corechart"]});';
		$grafico .= 'google.setOnLoadCallback(drawChart);';
		$grafico .= 'function drawChart() {';
		$grafico .= 'var data = new google.visualization.DataTable();';
		$grafico .= $datosG;
		$grafico .= 'var options = {'.$opciones.'};';
		$grafico .= 'var chart = new google.visualization.'.$nomTipo.'(document.getElementById("chart_div'.$num.'"));';
		$grafico .= 'chart.draw(data, options);';
		$grafico .= '}';
		$grafico .= '</script>';
		$grafico .= '<div id="chart_div_cont"><div id="chart_div'.$num.'" style="width: '.$width.'; height: '.$height.';"></div></div>';
		
		return $grafico;
	}
}
?>