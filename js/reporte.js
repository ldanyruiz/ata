$(document).ready(function(er){
	$("select").change(function(e){
		$("form").submit();
	});
	$("a button").click(function(){
		window.location = $(this).parent("a").attr("href");
	});
	$("p.mensaje").show().delay(5000).hide('slow', function(){
		$(this).html("").show();
	});
	$("div#cuerpo").on("click", "a#eliminarRespuestas", function(e){
		if(confirm("\xbfEst\xe1 seguro que desea eliminar las respuestas?")){
			$("input#idUsuarioCampana").val($(this).attr("name"));
			$("form").submit();
		}else{
			$("input#idUsuarioCampana").val("");	
		}
		e.preventDefault();
	});
	$("div#cuerpo").on("click", "a#eliminarPorCampana", function(e){
		if(confirm("\xbfEst\xe1 seguro que desea eliminar todas las respuestas?")){
			$("input#borrarTodo").val(1);
			$("form").submit();
		}else{
			$("input#borrarTodo").val(0);	
		}
		e.preventDefault();
	});
});