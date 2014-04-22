// JavaScript Document
$(document).ready(initGrilla);

function initGrilla(){
	$("div#contenedorGrilla").on("click", "a#colPag", function(e){
		$("div#contenedorGrilla input#colPag").val($(this).attr("name"));
		if($("input#ascPag").val()==1){
			$("input#ascPag").val(0);
		}else{
			$("input#ascPag").val(1);
		}
		refrescarGrilla();
		e.preventDefault();
	});
	$("div#contenedorGrilla").on("click", "a#selPag", function(e){
		$("div#contenedorGrilla input#actualPag").val($(this).attr("name"));
		refrescarGrilla();
		e.preventDefault();
	});
	$("div#contenedorGrilla").on("change", "select#cantPag", function(e){
		$("div#contenedorGrilla input#actualPag").val("0");
		refrescarGrilla();
		e.preventDefault();
	});
}

function refrescarGrilla(){
	$.ajax({
		url: $("form#formGrilla").attr("action"), 
		type: "POST",
		data: $("form#formGrilla").serialize(), 
		success: function(datos){					
				$("div#contenedorGrilla").html($(datos).find("div#contenedorGrilla").html()).slideDown('slow');
				$("p.loading").html("");
			},			   
		error: function(){$("div#contenedorGrilla").html("<p id='loading'>No se pudieron enviar los datos.</p>");},
		beforeSend: function(){
			$("div#contenedorGrilla").hide();
			$("p.loading").html("<img src='img/bar_loading.gif' />");
		}
	});
}